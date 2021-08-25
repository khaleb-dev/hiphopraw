<?php

class Controller_Videos extends Controller_Base
{

    public $template = 'layout/user-template';
      

    public function before()
    {
        parent::before();

        $login_exception = array("browse", "index", "update_count");

        parent::check_permission($login_exception);
    }

    public function action_generate_thumbs()
    {
        $log_file = APPPATH . "logs/ffmpeg.log";
        foreach (Model_Videoke::find("all") as $videoke) {
            $file_path = DOCROOT . "uploads" . DS . Model_User::clean_name($videoke->user->username) . DS . "videokes" . DS;
            $input_file = $file_path . $videoke->video . ".mp4";
            foreach (Model_Videoke::get_thumbnail_sizes() as $size) {
                $output_file = $file_path . "thumb_" . $size . "_" . $videoke->video . ".jpg";
                if (!file_exists($output_file)) {
                    exec("FUEL_ENV=production ffmpeg -y -i " . $input_file . " -ss 00:00:01 -f image2 -vframes 1 -s $size " . $output_file . " </dev/null >/dev/null 2> " . $log_file . " &");
                }
            }
        }
        Response::redirect(Router::get("home"));
    }

    public function action_index($user_id = 0)
    {
    	if(!$this->current_user){
    		Response::redirect(Router::get("login"));
    	}
    	
    	
        if($user_id!=$this->current_user->id){
            Response::redirect(Router::get("_404_"));
        }

        $view = View::forge('videokes/index');

        if ($user = Model_User::find($user_id)) {
            $videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->get();

            $view->user = $user;
            $view->count = sizeof($videokes);
            $view->videokes=$videokes;
            // Configure the pagination
//            $pagination = \Pagination::forge('pagination', array(
//                'pagination_url' => \Uri::base(false) . 'videokes/index/' . $user->id,
//                'total_items' => $view->count,
//                'per_page' => 12,
//                'uri_segment' => 4,
//                'num_links' => 5,
//            ));
            $visitor = Model_User::find($this->current_user->id);
            $view->friends = $visitor->friends();
            $visitor1 = Model_User::find($this->current_user->id);
            $view->followers = $visitor1->followers();
            $view->friends_count = count($visitor->friends());
            $view->followers_count = count($visitor->followers());
//            $view->pagination = $pagination;
//            $view->videokes = $videokes
//                ->order_by('created_at', 'desc')
//                ->offset($pagination->offset)
//                ->limit($pagination->per_page)
//                ->get();
        } else {
            Response::redirect(Router::get("browse"));
        }

        $view->set_global('page_css', 'videokes/index.css');
        $view->set_global('page_js', 'videokes/index.js');

        $this->template->title = 'Hip Hop Raw &raquo; Videos';
        $this->template->content = $view;
    }

    public function action_browse($page = 1)
    {
        $view = View::forge('videokes/browse');

        $view->set_global('active_page', 'browse');
        $view->set_global('page_css', 'videokes/browse.css');
        $view->set_global('page_js', 'videokes/browse.js');

        $view->categories = Model_Category::categories();
        $videokes_query = Model_Videoke::query()->where('is_blocked', 0);

        //Check notification for this page
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Browse")
            )
        ));
        $contest_winners = null;

        if (Input::get("category_id") > 0) {
            $videokes_query->where('category_id', Input::get("category_id"));

            $category = Model_Category::find(Input::get("category_id"));
            $notification = Model_Notification::find('last', array(
                "where" => array(
                    array("page", $category->name)
                )
            ));

            $contest_winners = Model_Contest::query()
                ->where('status', 'completed')
                ->where('winner', '>', 0)
                ->where('category_id', Input::get("category_id"))
                ->order_by('end_time', 'DESC')
                ->limit(1)
                ->get();
        }
        if (Input::get("search_term") != '') {
            $videokes_query->and_where_open()
                ->where('title', 'like', "%" . Input::get("search_term") . "%")
                ->or_where('key_words', 'like', "%" . Input::get("search_term") . "%")
                ->and_where_close();
        }

        //Get all banners for this page
        $left_banners = Model_Banner::query()
            ->where('page', 'Browse')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Browse')
            ->where('position', 'Right')
            ->get();

        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;

        $view->notification = $notification;
        $view->contest_winners = $contest_winners;
        $view->title = Input::get("category_id") ? Model_Category::find(Input::get("category_id"))->name : "Videokes";
        $view->search_term = Input::get("search_term");
        $view->category_id = Input::get("category_id") ? Input::get("category_id") : 0;

        // Configure the pagination
        $pagination = \Pagination::forge('pagination', array(
            'pagination_url' => \Uri::base(false) . 'browse/?search_term=' . $view->search_term . '&category_id=' . $view->category_id,
            'total_items' => $videokes_query->count(),
            'per_page' => 20,
            'uri_segment' => 'page',
            'num_links' => 5,
        ));

        $view->pagination = $pagination;
        $view->videokes = $videokes_query
            ->order_by("created_at", "desc")
            ->offset($pagination->offset)
            ->limit($pagination->per_page)
            ->get();

        $this->template->title = 'Hip Hop Raw &raquo; Browse';
        $this->template->content = $view;
    }

    public function action_new()
    {
        $view = View::forge('videokes/new');
        $view->route = Uri::segments();

        $categories = array();
        $ncategory = array();
        $user_id = $this->current_user->id;
        foreach (Model_Category::find("all") as $category) {
            if( $category->id == 3){
                continue;
            }
            $categories["$category->id"] = $category->name;
        }

        foreach (Model_Category::find("all") as $category) {
            if( $category->id == 3){
               $ncategory[3] = $category->name;
            }else{
                continue;
            }
        }
        
            

        $view->categories = $categories;
        $view->ncategory = $ncategory;
        $view->user_id = $user_id;
        // $view->set_global('page_css', 'videokes/new.css');
        $view->set_global('page_css', 'pages/settings.css');
        $view->set_global('page_js', 'videokes/new.js');
        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());

        $this->template->title = 'Hip Hop Raw &raquo; Upload Your Video';
        $this->template->content = $view;
    }
    
    public function action_create()
    {
        if (empty($_POST) && empty($_FILES)) {
            Session::set_flash("error", "The size of the data your trying to upload exceeds the maximum limit, " . ini_get('post_max_size') . ". Please reduce the size and try again!");
            Response::redirect("videos/new");
        }

        $view = View::forge('videokes/new');
        $view->route = Uri::segments();

        if (Input::post()) {


            $val = Validation::forge();

            $val->add('title', 'Title')
                ->add_rule('required')
                ->add_rule('max_length', 255);

            $val->add('description', 'Description')
                ->add_rule('required');

            $val->add('key_words', 'Key Words')
                ->add_rule('required')
                ->add_rule('max_length', 255);

            if ($val->run()) {
                $post = Input::post();

                if (isset($post['redirect'])) {
                    $redirect = $post['redirect'];
                } else {
                    $redirect = Router::get('invite');
                }

                $user = $this->current_user;

                if (isset($post['redirect'])) {
                    $redirect = $post['redirect'];
                } else {
                    $redirect = "videos/index/" . $user->id;
                }

                // Custom configuration for this upload
                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($user->username) . DIRECTORY_SEPARATOR . "videokes",
                    'auto_rename' => true,
                    'randomize' => true,
                    //'ext_whitelist' => array('webm', 'ogg', 'mov', 'wmv', 'mp4'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                    'change_case' => 'lower',
                );

                // process the uploaded files in $_FILES
                Upload::process($config);

                // if there are any valid files
                if (Upload::is_valid()) {
                    // save them according to the config
                    echo "<pre>";
                    print_r($config);
                    echo "</pre>";
                    Upload::save();

                    $file = Upload::get_files(0);


                    // Set the name of the video uploaded
                    $post["user_id"] = $user->id;
                    $post["views"] = 0;
                    $post["likes"] = 0;
                    $post["dislikes"] = 0;
                    $post["is_blocked"] = false;

                    // Convert Video to html5 formats
                    $file_extension = strtolower($file["extension"]);
                    $file_name = str_replace("." . $file_extension, "", $file["saved_as"]);


                    $tmp_file = $file["saved_to"] . $file_name . ".upload." . $file_extension;

                    $log_file = APPPATH . "logs/ffmpeg.log";
                    $input_file = $file["saved_to"] . $file["saved_as"];

                    // MOVE FILE TO TEMP LOCATION
                    File::rename($input_file, $tmp_file);
                    // USE TEMP LOCATION FOR CONVERSIONS
                    $input_file = $tmp_file;

                    echo "about to convert to mp4";
                    foreach (Model_Videoke::get_html5_video_formats() as $format) {


                        $output_file = $file["saved_to"] . $file_name . $format;

                        if ($format == ".webm") { //  && "." . $file_extension != ".webm" 
                            exec("FUEL_ENV=production ffmpeg -y -i " . $input_file . " -b:v 250k -vcodec libvpx -acodec libvorbis " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".webm &");
                        } else if ($format == ".ogg") { //&& "." . $file_extension != ".ogg" 
                            exec("FUEL_ENV=production  ffmpeg -y -i " . $input_file . " -b:v 250k -vcodec libtheora -acodec libvorbis " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".ogg &");
                        } else if ($format == ".mp4") { // && "." . $file_extension != ".mp4"  
                            ///exec("FUEL_ENV=production  ffmpeg -y -i " . $input_file . " -b:v 3072000 -vcodec libx264 -c:v mpeg4 -c:a libfdk_aac -vbr 3 " . $output_file . " </dev/null >/dev/null 2> " . $log_file . " &");
                            ///						ffmpeg -y -i VID_20111111_153248.m4v -vcodec libx264 -b:a 250k -bt 50k -acodec libfdk_aac -ab 56k -ac 2 output.mp4
                            echo "converting to mp4";
                            echo "output_file=".$output_file."<br/>";
                            echo "input_file=".$input_file."<br />";
                            echo "log_file=".$log_file."<br /> <pre> ";
                            passthru("FUEL_ENV=production  ffmpeg -y -i " . $input_file . " -vcodec libx264 -acodec aac -strict -2 " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".mp4 &");
                        }
                    }

                    // Generate thumbnail/poster
                    foreach (Model_Videoke::get_thumbnail_sizes() as $size) {
                        exec("FUEL_ENV=production ffmpeg -i " . $input_file . " -ss 00:00:01 -f image2 -vframes 1 -s $size " . $file["saved_to"] . "thumb_" . $size . "_" . $file_name . ".jpg </dev/null >/dev/null 2>> " . $log_file . " &");
                    }

                    // Delete temp file
                    try {
                        File::delete($file["saved_to"] . $file_name . "_1." . $file["extension"]);
                    } catch (Exception $e) {

                    }


                    // Add the name for the file that has been uploaded
                    $post["video"] = $file_name;

                    Model_Videoke::forge($post)->save();
                    Session::set_flash("success", "Video successfully uploaded s!");
                    Response::redirect($redirect);
                }

                // and process any errors
                foreach (Upload::get_errors() as $file) {
                    // $file is an array with all file information,
                    // $file['errors'] contains an array of all error occurred
                    // each array element is an an array containing 'error' and 'message'
                    Session::set_flash("error", $file['errors'][0]['message']);
                }


                // POST ERROR
            } else {
                Session::set_flash("error", "Errors on your form, please check values and try again.");
            }

            $view->val = $val;
        }

        $categories = array();
        foreach (Model_Category::find("all") as $category) {
            $categories["$category->id"] = $category->name;
        }
        $view->categories = $categories;

        $view->set_global('page_css', 'videokes/new.css');
        $view->set_global('page_js', 'videokes/new.js');

        $this->template->title = 'Hip Hop Raw &raquo; Upload Your Videoke';
        $this->template->content = $view;
    }

    public function action_ajax_create()
    {

        
        $response=array();
        $response["just_entered_ajax_create"]=time();
        $this->template="";

        // if (Input::method() !== 'POST' or !Input::is_ajax()) {
        //     return Response::forge("The request had bad syntax or was inherently impossible to be satisfied.", 400);
        // }
         
        if (empty($_POST) && empty($_FILES)) {
            return Response::forge("The size of the data your trying to upload exceeds the maximum limit, " . ini_get('post_max_size') . ". Please reduce the size and try again!", 400);
        }

        //$view = View::forge('videokes/new');
        //$view->route = Uri::segments();


        $post = Input::post();
        $user = $this->current_user;


        // Custom configuration for this upload
        $config = array(
            'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($user->username) . DIRECTORY_SEPARATOR . "videokes",
            'auto_rename' => true,
            'randomize' => true,
            'create_path' => true,
            'path_chmod' => 0777,
            'file_chmod' => 0777,
            'change_case' => 'lower',
        );

        // process the uploaded files in $_FILES
        Upload::process($config);

        // if there are any valid files
        if (Upload::is_valid()) {
            // save them according to the config
//            echo "<pre>";
//            print_r($config);
//            echo "</pre>";
//            die();
            $response["before_upload_save"]=time();
            Upload::save();
            $response["after_upload_save"]=time();
            $file = Upload::get_files(0);

            // Set the name of the video uploaded
            $post["user_id"] = $user->id;
            $post["views"] = 0;
            $post["likes"] = 0;
            $post["dislikes"] = 0;
            $post["is_blocked"] = false;
            $post['youtube_link']= 0;

            // Convert Video to html5 formats
            $file_extension = strtolower($file["extension"]);
            $file_name = str_replace("." . $file_extension, "", $file["saved_as"]);


            $tmp_file = $file["saved_to"] . $file_name . ".upload." . $file_extension;

            $log_file = APPPATH . "logs\\ffmpeg.log";

            $response["log_path"] = $log_file;
            $input_file = $file["saved_to"] . $file["saved_as"];

            // MOVE FILE TO TEMP LOCATION
           // echo "input_file" . $input_file . "<br />";
           // echo "tmp_file" . $tmp_file . "<br />";
            File::rename($input_file, $tmp_file);
            // USE TEMP LOCATION FOR CONVERSIONS
            $input_file = $tmp_file;



            //echo "about to convert to mp4";


            foreach (Model_Videoke::get_html5_video_formats() as $format) {

                $output_file = $file["saved_to"] . $file_name . $format;
                //echo "$output_file" . $output_file;
                if ($format == ".webm") { //  && "." . $file_extension != ".webm"
                    $response["before_webm_exec"]=time();
                    exec("FUEL_ENV=production ffmpeg -y -i " . $input_file . " -vcodec libvpx -acodec libvorbis " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".webm &");
                    $response["after_webm_exec"]=time();
                } else if ($format == ".ogg") { //&& "." . $file_extension != ".ogg"
                    $response["before_ogg_exec"]=time();
                    exec("FUEL_ENV=production  ffmpeg -y -i " . $input_file . " -vcodec libtheora -acodec libvorbis  " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".ogg &");
                    $response["after_ogg_exec"]=time();
                } else if ($format == ".mp4") {
                    $response["before_mp4_exec"]=time();
                    exec("FUEL_ENV=production  ffmpeg -y -i " . $input_file . " -vcodec libx264 -b:v 250k -bt 50k -s 640x360 -acodec aac  -ab 56k -ac 2  -strict -2 " . $output_file . " </dev/null >/dev/null 2>> " . $log_file . ".mp4 &");
                    $response["after_mp4_exec"]=time();
                }
            }
            //exec("ls > log.log");
            //echo "about to create thumbnail";
            // Generate thumbnail/poster

         
          /* $cmd = sprintf('%sffmpeg -i %s 2>&1 |grep Duration ', $ffmpeg_path, $input_file);
            $duration_cmd_result = array ();
            exec($cmd, $duration_cmd_result);

            $get_all_size = Model_Videoke::generate_thumbnails_of_four_size();

        $count = 0 ;
        foreach ( $get_all_size as $size=>$element) {

            $video_name = explode(".", $this->postFileName);

            $thumb_output_file = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($user->username) . DIRECTORY_SEPARATOR . "videokes". "thumb_" . ++$count . "_" . base64_encode($video_name[0]) . ".jpg";

            if(count($duration_cmd_result)) {
                $duration = explode(':', trim(str_replace('Duration:', NULL, current(explode(',', current($duration_cmd_result))))));
                list($hour, $min, $sec) = $duration;
                $sec = sprintf("%02d:%02d:%02d", rand(0, $hour), rand(0, $min), rand(0, $sec));
            } else {
                $sec = "00:00:12"; //12sec it's ok :)
            }
            $response["just_before_thumbnail_$size"]=$size;
            $cmd = sprintf('%sffmpeg -i %s %s -an -ss '.$sec.' -r 1 -vframes 1 -s %s %s %s', $ffmpeg_path, null, $input_file, $element['size'], $thumb_output_file, $log_settings);

           

                exec($cmd, $output, $retval);

            
            $response["thumbnail_generation_command_$size"]= "FUEL_ENV=production ffmpeg -i " . $input_file . " -ss 00:00:01 -f image2 -vframes 1 -s $size " . $file["saved_to"] . "thumb_" . $size . "_" . $file_name . ".jpg </dev/null >/dev/null 2>> " . $log_file . " &";

            $response["just_after_thumbnail_$size"]=$size;
        } */

            $count = 0;
            //$ffmpeg_path ='C:\\ffmpeg\\bin\\' ;
            $ffmpeg_path='';
            $the_file =DOCROOT. "uploads/" . Model_User::clean_name($user->username). "/videokes/".$file_name.".upload.mp4";
            //$ffmpeg_path ='';
            $cmd = sprintf('%sffmpeg -i %s 2>&1 |grep Duration ', $ffmpeg_path, $the_file);
            $response["cmd"]=$cmd;
            $duration_cmd_result = array ();
            exec($cmd, $duration_cmd_result);
            $response["duration_cmd_result"]=$duration_cmd_result;

             $log_settings = " </dev/null >/dev/null 2> " . $log_file . " &";

             $get_all_size = Model_Videoke::generate_thumbnails_of_four_size();

           foreach ( $get_all_size as $size=>$element) {

            
                    if(count($duration_cmd_result)) {
                         $duration = explode(':', trim(str_replace('Duration:', NULL, current(explode(',', current($duration_cmd_result))))));
                            list($hour, $min, $sec) = $duration;
                             $sec = sprintf("%02d:%02d:%02d", rand(0, $hour), rand(0, $min), rand(0, $sec));
                     } else {
                             $sec = "00:00:12"; //12sec it's ok :)
                    }
            foreach(Model_Videoke::get_thumbnail_sizes() as $zsize){
               
                $thumb_output_file =DOCROOT."uploads/" . Model_User::clean_name($user->username). "/videokes/thumb_".$size."_".$zsize."_".$file_name.".jpg";
                $the_file =DOCROOT. "uploads/" . Model_User::clean_name($user->username). "/videokes/".$file_name.".upload.mp4";
                $response["output file"]=$thumb_output_file;
                $response["the file"]=$the_file;
                $end = "2>&1";

                $response["just_before_thumbnail_$size"]=$size;
                $cmd = sprintf('%sffmpeg -i %s -ss %s -f image2 -vframes 1 -s %s %s %s', $ffmpeg_path, $the_file,$sec, $zsize, $thumb_output_file, $end);
                
                $response["cmd last"]=$cmd;
                //exec(" ffmpeg -i " . $the_file . " -ss 00:00:01 -f image2 -vframes 1 -s $size " . $file["saved_to"] . "thumb_" . $size . "_" . $thumb_output_file."</dev/null >/dev/null 2>> " . $log_file . " &");
                $response["thumbnail_generation_command_$size"]= "FUEL_ENV=production ffmpeg -i " . $the_file . " -ss 00:00:01 -f image2 -vframes 1 -s $size " . $file["saved_to"] . "thumb_" . $size . "_" . $thumb_output_file."</dev/null >/dev/null 2>> " . $log_file . " &";
              


                exec($cmd, $output,$retval);
                    
                $response["cmd output"]=$output;
                $response["cmd return value"]=$retval;



               // echo "created thumbnail for".$size;
               // exec("ls > log.log");
                $response["just_after_thumbnail_$size"]=$size;
            } 

        }
            // Delete temp file
            try {
                File::delete($file["saved_to"] . $file_name . "_1." . $file["extension"]);
            } catch (Exception $e) {

            }

            // Add the name for the file that has been uploaded
            $post["video"] = $file_name;

            Model_Videoke::forge($post)->save();

            $response["status"]= "success";
            $response["description"]="Video successfully uploaded!";
            $response["redirect"]=Uri::create("videos/index/".$this->current_user->id);
            $response["just_before_return"]=time();


        
            $result=DB::select('id')->from('videokes')->where('video','=',$post["video"])->execute();
            foreach($result as $item)
                    {
                        $id = $item['id'];
    
                    }
             $response["theid"]=$id;

            $video=Model_Videoke::find($id);
            $theuser=$video->user_id;
            $user = Model_User::find($theuser);
            $response["thevideo"]=$video->video;
            $response["username"]= str_replace(' ', '', Model_User::clean_name($user->username));

            echo json_encode($response);
        

        } else {

            $error_messages = array();
            // and process any errors
            foreach (Upload::get_errors() as $file) {
                // $file is an array with all file information,
                // $file['errors'] contains an array of all error occurred
                // each array element is an an array containing 'error' and 'message'
                array_push($error_messages, $file['errors'][0]['message']);
            }
            $response=array();
            $response["status"]= "failed";
            $response["description"]=$error_messages;
            
            echo json_encode($response);
        }
    }

    public function action_save_youtube_video(){

        $response=array();
        $response["just_entered_ajax_create"]=time();
        $this->template="";

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return Response::forge("The request had bad syntax or was inherently impossible to be satisfied.", 400);
        }

        if (empty($_POST) && empty($_FILES)) {
            return Response::forge("The size of the data your trying to upload exceeds the maximum limit, " . ini_get('post_max_size') . ". Please reduce the size and try again!", 400);
        }

        //$view = View::forge('videokes/new');
        //$view->route = Uri::segments();


        $post = Input::post();
        $user = $this->current_user;

        $post["user_id"] = $user->id;
        $post["views"] = 0;
        $post["likes"] = 0;
        $post["dislikes"] = 0;
        $post["is_blocked"] = false;
        $post['category_id']= 3;
        $post['youtube_link']= 1;
        $post["video"] = $post['youtube_video'];

        $thumb_string = explode(" ", $post["video"]);
        $thumb_1 = explode('"',substr($thumb_string[3], 35));

        $post['thumb_name'] =  $thumb_1[0];
        





        Model_Videoke::forge($post)->save();

         $response["status"]= "success";
            $response["description"]="Video successfully uploaded!";
            $response["redirect"]=Uri::create("videos/index/".$this->current_user->id);
            $response["just_before_return"]=time();


        
            $result=DB::select('id')->from('videokes')->where('video','=',$post["video"])->execute();
            foreach($result as $item)
                    {
                        $id = $item['id'];
    
                    }
             $response["theid"]=$id;

            $video=Model_Videoke::find($id);
            $theuser=$video->user_id;
            $user = Model_User::find($theuser);
            $response["thevideo"]=$video->video;
            $response["username"]=$user->username;

            echo json_encode($response);

    


    }
    public function action_manage_thumbnails($zvideo, $thumb){

            $response = Response::forge();

            $video=Model_Videoke::find($zvideo);
            $user_id = $video->user_id;
            $user = Model_User::find($user_id);
            $username=str_replace(' ', '', Model_User::clean_name($user->username));    
            $video_name=$video->video;

           if($thumb == 0){
                
             foreach(Model_Videoke::get_thumbnail_sizes() as $zsize){
                     $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_0_".$zsize."_".$video_name.".jpg";
                     $newname = DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$zsize."_".$video_name.".jpg";
                     rename($file, $newname);
                         for ($i=1; $i<=3; $i++){
                            $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$i."_".$zsize."_".$video_name.".jpg";
                            unlink($file);
                            }
                    }
                

             }
           else if ($thumb == 1){
                foreach(Model_Videoke::get_thumbnail_sizes() as $zsize){
                     $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_1_".$zsize."_".$video_name.".jpg";
                     $newname = DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$zsize."_".$video_name.".jpg";
                     rename($file, $newname);

                        for ($i=0; $i<=3; $i++){
                            if($i == 1){
                            continue;
                            }
                             $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$i."_".$zsize."_".$video_name.".jpg";
                             unlink($file);
                             }
                        }
                

                }
           else if ($thumb == 2){
                foreach(Model_Videoke::get_thumbnail_sizes() as $zsize){
                     $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_2_".$zsize."_".$video_name.".jpg";
                     $newname = DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$zsize."_".$video_name.".jpg";
                     rename($file, $newname);
                        for ($i=0; $i<=3; $i++){
                            if($i == 2){
                            continue;
                            }
                            $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$i."_".$zsize."_".$video_name.".jpg";
                            unlink($file);
                     }


                }
                

            }
           else if ($thumb == 3){
             foreach(Model_Videoke::get_thumbnail_sizes() as $zsize){
                     $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_3_".$zsize."_".$video_name.".jpg";
                     $newname = DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$zsize."_".$video_name.".jpg";
                     rename($file, $newname);
                        for ($i=0; $i<=3; $i++){
                             if($i == 3){
                            continue;
                             }
                             $file =  DOCROOT . "uploads" . DIRECTORY_SEPARATOR .$username. DIRECTORY_SEPARATOR . "videokes". DIRECTORY_SEPARATOR."thumb_".$i."_".$zsize."_".$video_name.".jpg";
                             unlink($file);
                         }

                }
                
           }

           $response->body(json_encode(array(
                    'status' => true,
                    'thetitle'=>$video->title,
                    'thevideo'=> $video_name,
                    'theid' => $zvideo,
                    'username'=>$username,
                    'message' => "Thumb saved successfully",
                )));

        return $response;

    }



    public function action_show($videoke_id)
    {
    	
        if (!$videoke_id) {

            Response::redirect("videos");
        } 

        $view = View::forge('videokes/show');

         if (!$videoke = Model_Videoke::find($videoke_id)) {
            Response::redirect("videos");
        }

        

        $user = \Model\Auth_User::find($videoke->user_id);
        $category_id = $videoke->category_id;
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $view->suggestions = Model_Videoke::query()
        ->where('is_blocked', 0)
        ->where('user_id', '!=', $user->id)
        //->where('category_id', '=', $category_id)
        ->where('created_at', "<", $ten_minutes_ago)
        ->order_by(DB::expr('RAND()'))
        ->limit(6)->get();

        // print_r( $view->suggestions);
        // die;

        $view->othervideos = Model_Videoke::query()
        ->where('is_blocked', 0)
        ->where('user_id', '=', $user->id)
        ->where('id', '!=', $videoke_id)
        ->where('created_at', "<", $ten_minutes_ago)
        ->order_by(DB::expr('RAND()'))
        ->limit(20)->get();
        
        $view->videoke = $videoke;
        
        $view->user = \Model\Auth_User::find($videoke->user_id);
        $view->videokes_count = Model_Videoke::query()->where(array('user_id', $videoke->user_id))->where('is_blocked', 0)->count();

        $view->category_videokes = Model_Videoke::query()
            ->where(array('category_id', $videoke->category_id))
            ->where(array('id', "!=", $videoke->id))
            ->where('is_blocked', 0)
            ->limit(10)->get();
        
        if(false !== Model_Comment::get_comments_by_receiver($videoke_id)){
        	$comments = Model_Comment::get_comments_by_receiver($videoke_id);
        	$view->set_global('comments', $comments);
        	$view->comments_counter = count($comments);
        }
        else {
        	$view->comments = array();
        	$view->comments_counter = 0;
        }

       /*  $view->comments = Model_Comment::query()

                        ->where(array('videoke_id', $videoke->id))
                        ->limit(10)->get();  */


        $view->set_global('page_css', 'videokes/show.css');
        $view->set_global('page_js', 'videokes/show.js');

        $this->template->title = 'hiphopraw &raquo; Videos';
        $this->template->content = $view;
    }

    public function action_edit()
    {
    	$this->template="";
    	$response = Response::forge();
    	if (Input::method() !== 'POST' or !Input::is_ajax()) {
    		return $response->set_status(400);
    	}
    	$id = $_POST['videoke_id'];
    	$videoke = Model_Videoke::find($id);
    	$categories = array();
    	foreach (Model_Category::find("all") as $category) {
    		$categories["$category->id"] = $category->name;
    	}

    		$response->body(json_encode(array(
    				'status' => true,
    				'html' => View::forge('videokes/partials/edit', array("categories" => $categories,"videoke" => $videoke))->render(),
    		)));

    	
    	return $response;
    }

    public function action_update()
    {
    	
    	$response = Response::forge();
    	 /*  if (Input::method() !== 'POST' or !Input::is_ajax()) {
    		return $response->set_status(400);
    	}  */ 
    	$id = $_POST['videoke_id'];
    	$title = $_POST['title'];
    	$description = $_POST['description'];
    	$category = $_POST['category_id'];
    	$key_word = $_POST['key_words'];
    	 if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['key_words'])){
    		$response->body(json_encode(array(
    				'status' => false,
    				'heading' => 'notification',
    				'message' =>'please fill all the fields',
    		)));
    		Session::set_flash("error", 'The video is not updated, please fill all fields.');
    		Response::redirect(Uri::create('videos/index/'.$this->current_user->id));
    	} 
    	
    	
    	if($category == 'Hip Hop Artist'){
    		$category_id = 1;
    	}
    	else{
    		$category_id = 2;
    	}
    	
    	$videoke = Model_Videoke::find($id);
    	$videoke->title = $title ;
    	$videoke->description = $description ;
    	$videoke->category_id = $category_id ;
    	$videoke->key_words = $key_word ;
    	if($videoke->save()) { 	
    	$response->body(json_encode(array(
    			'status' => true,
    			'heading' => 'success',
    			'message' =>'the video is successfully updated',
    	)));
    }
    
     Session::set_flash("success", 'The video is successfully updated');
     Response::redirect(Uri::create('videos/index/'.$this->current_user->id));

    }

    public function action_rate()
    {
    	$this->template="";    	
    	$id = $_POST['videoke_id'];
    	
    	//$request=json_encode($testResponse);
    	//echo $request;
    	
    	
         // $id = Input::post('id');

        $videoke = Model_Videoke::find_by_id($id);

        if (!$videoke) {
            //Session::set_flash("error", "Could not find requested videoke");
            //Response::redirect('videokes/index');
            $response=array();
            $response["status"]= "error";
            $response["description"]="Could not find requested video";
           // $response["redirect"]=Uri::create("videokes/index");
            
        }

        try {
            $rating = $_POST['rating'];
        } catch (Exception $e) {
           // Session::set_flash("error", "Submitted rating is invalid!");
            //Response::redirect('videokes/show/' . $id);
            $response=array();
            $response["status"]= "error";
            $response["description"]="Submitted rating is invalid!";
            //$response["redirect"]=Uri::create("videokes/show/".$id);
        }

        if ($rating < -2 || $rating > 1) {
            //Session::set_flash("error", "Submitted rating is invalid!");
            //Response::redirect('videokes/show/' . $id);
            $response=array();
            $response["status"]= "error";
            $response["description"]="Submitted rating is invalid!";
            //$response["redirect"] = Uri::create("videokes/show/".$id);
        }

        if ($videoke->user_id == $this->current_user->id) {
           // Session::set_flash("error", "You have attempted to submit a rating for your own videoke!");
           // Response::redirect('videokes/show/' . $id);
            $response=array();
            $response["status"]= "error";
            $response["description"]="You have attempted to submit a rating for your own video!";
           // $response["redirect"] = Uri::create("videokes/show/".$id);
        }

        $votes = Model_Rating::find('all', array('where' => array(array('videoke_id', $id), array('user_id', $this->current_user->id))));
        if (!empty($votes)) {
           // Session::set_flash("error", "You have already rated this videoke!");
           // Response::redirect('videokes/show/' . $id);
            $response=array();
            $response["status"]= "error";
            $response["description"]="You have already rated this video!";
            //$response["redirect"]=Uri::create("videokes/show/".$id);
        }
      if($videoke && $rating <= 1 && $rating >= -1 && $videoke->user_id != $this->current_user->id && empty($votes)) {
        Model_Rating::forge(array(
            'videoke_id' => $id
        , 'user_id' => $this->current_user->id
        , 'timestamp' => Date::forge()->get_timestamp()
        , 'rating' => (string)$rating //cast as string because FuelPHP takes int to be a reference to an index of the enum
        ))->save(); 
        
        $videoke = Model_Videoke::find($id); 
        if($rating > 0){      
        $videoke->likes = (string)$rating + $videoke->likes ; 
        }  
        if($rating < 0){
        	$videoke->dislikes = (string)$rating + $videoke->dislikes ;
        } 
        $videoke->save();
       // Session::set_flash("success", "Rating submitted successfully!");
        //Response::redirect('videokes/show/' . $_POST['videoke_id']); 
        $response=array();
        $response["status"]= "success";
        $response["description"]="Rating submitted successfully!";
        //$response["redirect"]=Uri::create("videokes/show/".$id);
    }
    echo json_encode($response);
   }

    public function action_delete()
    {
        $response = Response::forge();
        $id = Input::post('id');
        $videoke = Model_Videoke::find_by_id($id);

        if (!$videoke)
            return $response->set_status(404);

        if ($videoke->user_id !== $this->current_user->id) {
            return $response->set_status(500);
        }

        // Get path to files        
        $file_path = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($this->current_user->username) . DIRECTORY_SEPARATOR . "videokes/";
        // Delete all the different sized thumbnails
        foreach (Model_Videoke::get_thumbnail_sizes() as $size) {
            try {
                File::delete($file_path . "thumb_" . $size . "_" . $videoke->video . ".jpg");
            } catch (Exception $e) {

            }
        }
        // Delete all video files
        foreach (Model_Videoke::get_html5_video_formats() as $format) {
            try {
                File::delete($file_path . $videoke->video . $format);
            } catch (Exception $e) {

            }
        }

        $videoke->delete();

        return $response->set_status(200);
    }

    public function action_update_count()
    {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $videoke = Model_Videoke::find(Input::post("id"));

        if ($videoke) {
            $count = 0;
            if (Input::post("attr") === "views") {
                $videoke->views += 1;
                $count = $videoke->views;
            } else if (Input::post("attr") === "likes") {
                $videoke->likes += 1;
                $count = $videoke->likes;
            } else if (Input::post("attr") === "dislikes") {
                $videoke->dislikes += 1;
                $count = $videoke->dislikes;
            }
            $videoke->save();

            $count_str="";
            if ($count < 1000) {
                $count_str=$count;
            } else if ($count >= 1000 && $count < 1000000) {
                $count_str= $count / 1000 . 'K';
            } else {
                $count_str= $count / 1000000 . 'M';
            }
            $response->body(json_encode(array(
                'status' => true,
                'count' => $count_str,
            )));
        } else {
            return $response->set_status(500);
        }


        return $response;
    }

    public function action_destroy()
    {

    }

    public function action_debug_exec(){
        $this->template="";
        echo "<pre>";
        echo exec("printenv");
    }
}
