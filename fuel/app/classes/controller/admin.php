<?php

class Controller_Admin extends Controller_Base {

    public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);

        $this->template->template_css = 'admin/template.css';
        if(!Auth::member(5)) {
            Response::redirect();
        }
    }

    public function action_index($alphabet=null, $page=null) {
        $view = View::forge('admin/users');
        $alphabet = isset($alphabet) ? $alphabet : "A";
        $page =  isset($page) ? $page : 1;

        $users_list = Model_User::query()->where('group_id', 3);
        $view->total_users = $users_list->count();

        $users_list = $users_list->where('username', 'like', $alphabet . '%');
        $view->category_count = $users_list->count();

        $users_list = $users_list->where('username', 'like', $alphabet . '%')->limit(40*$page)->get();

        $view->alphabet = $alphabet;
        $view->page = $page+1;

        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Admin")
            )
        ));
        $view->notification = $notification;

        $view->users = $users_list;
        $view->current_user = $this->current_user;
        $view->set_global('page_css', 'admin/users.css');
        $view->set_global('page_js', 'admin/users.js');

        $this->template->title = 'Hip Hop Raw &raquo; Users';
        $this->template->content = $view;
    }

    public function action_videokes($page=null) {
        $view = View::forge('admin/videokes');
        $page =  isset($page) ? $page : 1;

        $videokes = Model_Videoke::query();
        $view->total_videos = $videokes->count();

        $videokes = $videokes->limit(40*$page)->get();

        $view->page = $page+1;
        $view->current_user = $this->current_user;
        $view->videokes = $videokes;

        $featured_videos_home = Model_Featuredvideo::query()
            ->where('page', 'home')->limit(8)->get();
        $view->featured_videos_home = $featured_videos_home;


        $featured_videos_models = Model_Featuredvideo::query()
            ->where('page', 'models')->limit(8)->get();
        $view->featured_videos_models = $featured_videos_models;


        $featured_videos_news = Model_Featuredvideo::query()
            ->where('page', 'hhrnews')->limit(8)->get();
        $view->featured_videos_news = $featured_videos_news;


        $view->set_global('page_css', 'admin/videokes.css');
        $view->set_global('page_js', 'admin/videokes.js');

        $this->template->title = 'Hip Hop Raw &raquo; Videokes';
        $this->template->content = $view;
    }

    public function action_admin_new()
    {
        $view = View::forge('videokes/new_admin');
        $view->route = Uri::segments();

        $categories = array();
        foreach (Model_Category::find("all") as $category) {
            $categories["$category->id"] = $category->name;
        }
        $view->categories = $categories;

        $view->set_global('page_css', 'videokes/new.css');
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








    function endsWith($haystack, $needle) {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public function action_contests() {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }

//        if (preg_match("/contests\/add/", $_SERVER['PATH_INFO'])) {
//            ///$this->endsWith($_SERVER['PATH_INFO'], 'contests/add')) {
//
//            $this->action_contests_add();
//
//            return;
//        }
//
//        if (preg_match("/contests\/history/", $_SERVER['PATH_INFO'])) {
//            ///$this->endsWith($_SERVER['PATH_INFO'], 'contests/add')) {
//
//            $catid = intval($_REQUEST['category_id']);
//
//            $this->action_contests_history($catid);
//
//            return;
//        }



        ## DELETE CONTEST
        if (isset($_REQUEST['delete_contest']) && ($delid = intval($_REQUEST['delete_contest'])) > 0) {


//         	print_r($_REQUEST);exit;

            DB::update('contests')
                    ->value("status", "deleted")
                    ->where('id', '=', $delid)
                    ->execute();


            Response::redirect("admin/contests/");
            exit;
        }


        $view = View::forge('admin/contests');



        $view->current_user = $this->current_user;

// This line was doing absolutely nothing, because it was being overwritten a few lines below.
//         $view->categories = Model_Category::categories();
        ## LOAD CONTESTS
        $view->model_contest = new Model_Contest();

        $view->categories = Model_Category::getCategories(false);
        $all_contest = $view->model_contest->getAllContests();

        // print_r($all_contest);
        // die;

        ## GET ACTIVE/JOINABLE CONTESTS AND SORT
        $view->contests = $view->model_contest->getContests(0, "active", -1)->as_array();
        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);
        $view->all_contest = $all_contest;
        $view->pastcontests = $view->model_contest->getPastContests(0, "active", -1)->as_array();

        $view->past_contests_by_category = $view->model_contest->arrangeByCategory($view->pastcontests);

        $view->set_global('page_css', 'admin/contests.css');
        $view->set_global('page_js', 'admin/contests.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contests';
        $this->template->content = $view;
    }

    /**
     * Add a new contest
     */
     public function action_contests_add_new() {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }


        $view = View::forge('admin/contests_add');

        $view->current_user = $this->current_user;

        $catid = intval($_REQUEST['category_id']);



        if (Input::post()) {
            $post = Input::post();

            //print_r($post);exit;

            $dat = array();

            $dat['status'] = 'active';
            $dat['category_id'] = $catid;
            $dat['current_round'] = 1;
            $dat['winner'] = 0;
            $dat['name'] = $post['name'];


            $dat['start_time'] = strtotime($post['start_date']);
            // $dat['start_time'] = time();
            // 28 days = 4 weeks
            $dat['end_time'] = $dat['start_time'] + (28 * 86400) + (86400);
           
            //$dat['end_time'] = $dat['start_time'] + 2400;
            
            Model_Contest::forge($dat)->save();

            Response::redirect("admin/contests/");
            exit;
        }

        //$cres = $this->getContests(0, 'active')->as_array();



      
        $model_contest = new Model_Contest();

        //$model_contest->computeEndofRounds();

        $view->model_contest = $model_contest;

        ## GET ACTIVE/JOINABLE CONTESTS AND SORT
        $view->contests = $view->model_contest->getContests(0, "active", -1)->as_array();
        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);
        $all_contest = $view->model_contest->getAllContests();
        $view->all_contest = $all_contest;



        $view->categories = Model_Category::getCategories(false);
        ## print_r($view->categories);exit;
//         $view->categories_wo_contests = array();
//         foreach($view->categories as $idx=>$val){
//          if( ! isset($view->contests_by_category[$idx]) ){
//              $view->categories_wo_contests[$idx] = $val;
//          }
//         }
        ## print_r($view->categories_wo_contests);exit;



        $view->set_global('page_css', 'admin/contests.css');
        $view->set_global('page_js', 'admin/contests.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contests';
        $this->template->content = $view;
    }
    public function action_contests_add() {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }


        $view = View::forge('admin/contests_add');

        $view->current_user = $this->current_user;

       



        if (Input::post()) {
            $post = Input::post();

            //print_r($post);exit;

            $dat = array();
            $catid = intval($_REQUEST['category_id']);

            $dat['status'] = 'active';
            $dat['category_id'] = $catid;
            $dat['current_round'] = 1;
            $dat['winner'] = 0;
            $dat['name'] = $post['name'];


            $dat['start_time'] = strtotime($post['start_date']);
             $dat['start_time'] = time();
            // 28 days = 4 weeks
            //$dat['end_time'] = $dat['start_time'] + (28 * 86400) + (86400);
           
            $dat['end_time'] = $dat['start_time'] + 2400;
            
            Model_Contest::forge($dat)->save();

            Response::redirect("admin/contests/");
            exit;
        }

        //$cres = $this->getContests(0, 'active')->as_array();



      
        $model_contest = new Model_Contest();

        //$model_contest->computeEndofRounds();

        $view->model_contest = $model_contest;

        ## GET ACTIVE/JOINABLE CONTESTS AND SORT
        $view->contests = $view->model_contest->getContests(0, "active", -1)->as_array();
        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);
        $all_contest = $view->model_contest->getAllContests();
        $view->all_contest = $all_contest;
    


        $view->categories = Model_Category::getCategories(false);
        ## print_r($view->categories);exit;
         $view->categories_wo_contests = array();
        foreach($view->categories as $idx=>$val){
       	if(  isset($view->contests_by_category[$idx]) ){
         		$view->categories_wo_contests[$idx] = $val;
         	}
        }
        ## print_r($view->categories_wo_contests);exit;



        $view->set_global('page_css', 'admin/contests.css');
        $view->set_global('page_js', 'admin/contests.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contests';
        $this->template->content = $view;
    }

    public function action_contests_history($category_id = false) {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }
        if($category_id === false){
            $category_id = intval($_REQUEST['category_id']);

        }

        $view = View::forge('admin/contests_history');



        $view->current_user = $this->current_user;

        // This line was doing absolutely nothing, because it was being overwritten a few lines below.
        //         $view->categories = Model_Category::categories();
        ## LOAD CONTESTS
        $view->model_contest = new Model_Contest();

        $view->categories = Model_Category::getCategories(false);

        $view->category_id = $category_id;

        ## GET COMPLETED CONTESTS AND SORT
        $view->contests = $view->model_contest->getPastContests($category_id, "active", -1)->as_array();


        ##### $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);


        $view->set_global('page_css', 'admin/contests.css');
        $view->set_global('page_js', 'admin/contests.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contests History';
        $this->template->content = $view;
    }
     public function action_contests_remove() {

         $response = Response::forge();

         if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
            }

                 $contest_id = Input::post('cid');
                 $contest = Model_contest::find($contest_id);      
                 $contest->delete();
       
                 $response->body(json_encode(array(
                         'status' => true,
                         'message' => "Contest Deleted",
                     )));
        
        return $response;

     }

    public function action_sponsors() {
        $view = View::forge('admin/sponsors');
        $view->current_user = $this->current_user;
        $search_text = '';


        if (Input::post()) {
            $post = Input::post();
            // if (isset($post['btnSearch'])) {
            //     $search_text = $post['search'];
            // } else {
               // $post['search'] = null;
                $upload_file = Input::file("sponsor_image");
                $post['sponsor'] =  $post['sponsor']; 

             if ($upload_file["size"] > 0) {
                $config = array(
                    'path' => DOCROOT . "uploads/sponsor_image",
                    'auto_rename' => false,
                    'overwrite' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );
                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $post["contact_info1"] = "not entered";
                    $post["contact_info2"] = "not entered";
                    $post["joined_date"] = time();

                    // Update banner image information
                    $post["image"] = $file['saved_as'];
                    Model_Sponsor::forge($post)->save();

                    Session::set_flash("success", "Sponsor successfully added");
                }
                // and process any errors
                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['message']);
                }
            } else {
                Session::set_flash("error", "Image should be selected");
            }

                //use date('Y-m-d H:i:s', strtotime(Input::post('start_time'))) in order to convert to
                //human readable time
                // $joined_date = $post['joined_date'];
                // $post['joined_date'] = strtotime($joined_date);

                

                
            //}
        }

        if ($search_text != '') {
            $sponsors = Model_Sponsor::find('all', array(
                        "where" => array(
                            array("sponsor", 'like', '%' . $search_text . '%')
                        )
                    ));
        } else {
            $sponsors = Model_Sponsor::find('all');
        }

        $view->sponsors = $sponsors;
        $view->set_global('page_css', 'admin/sponsors.css');
        $view->set_global('page_js', 'admin/sponsors.js');

        $this->template->title = 'Hip Hop Raw &raquo; Sponsors';
        $this->template->content = $view;
    }

    public function action_bannerAds() {
        $view = View::forge('admin/banner_ads');

        $view->current_user = $this->current_user;

        if (Input::post('btnPublishBanner')) {
            $post = Input::post();

            $post['btnPublishBanner'] = null;

            $upload_file = Input::file("banner_image");

            if ($upload_file["size"] > 0) {
                $config = array(
                    'path' => DOCROOT . "uploads/banner_image",
                    'auto_rename' => false,
                    'overwrite' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );
                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);

                    // Update banner image information
                    $post["image"] = $file['saved_as'];
                    Model_Banner::forge($post)->save();

                    Session::set_flash("success", "Banner successfully created");
                }
                // and process any errors
                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['message']);
                }
            } else {
                Session::set_flash("error", "Banner should be selected");
            }
        }

        if (Input::post('btnPublishNotification')) {
            $post = Input::post();

            $post['btnPublishNotification'] = null;
            Model_Notification::forge($post)->save();
            Session::set_flash("success", "Notification successfully created");
        }

        $view->bannerAds = Model_Banner::find('all');
        $view->notifications = Model_Notification::find('all');

        $view->set_global('page_css', 'admin/banner_ads.css');
        $view->set_global('page_js', 'admin/banner_ads.js');

        $this->template->title = 'Hip Hop Raw &raquo; Baner Ads';
        $this->template->content = $view;
    }

    public function action_manage_users() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $user_id = Input::post("user_id");
        $action = Input::post("action");

        $user = Model_User::find($user_id);

        if ($user) {
            // Update user status to blocked
            if ($action == "Block") {
                $user->is_blocked = 1;
                $user->save();
                $response_message = "User blocked successfully.";
            } else if ($action == "Unblock") {
                $user->is_blocked = 0;
                $user->save();
                $response_message = "User unblocked successfully.";
            }

            $response->body(json_encode(array(
                        'status' => true,
                        'message' => $response_message,
                    )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }

    public function action_manage_videos() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $video_id = Input::post("video_id");
        $action = Input::post("action");

        $video = Model_Videoke::find($video_id);

        if ($video) {

            if ($action == "Block") {
                $video->is_blocked = 1;
                $video->save();
                $response_message = "Video blocked successfully.";
                $status = "blocked";
            } else if ($action == "Unblock") {
                $video->is_blocked = 0;
                $video->save();
                $response_message = "Video unblocked successfully.";
                $status = "unblocked";
            } else if ($action == "Delete") {

                $user = Model_User::find($video->user_id);
                if ($user) {
                    // Get path to files
                    $file_path = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($user->username) . DIRECTORY_SEPARATOR . "videokes/";
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
                }
                $featured= Model_Featuredvideo::find($video->id);
                 if($featured){
                    $featured->delete();
                 }

                $video->delete();

                $response_message = "Video deleted successfully.";
                $status = "deleted";
            }

            $message = Model_Message::forge(array(
                "from_user_id" => $this->current_user->id,
                "to_user_id" => $video->user_id,
                "title" => "Videoke " . $action,
                "parent_message_id"=>0,
                "detail" => "The videoke '" . $video->title . "' you uploaded has been " . $status,
                "status" => Model_Message::SENT,
                "read_status" => Model_Message::UNREAD
            ));
            $message->save();

            $response->body(json_encode(array(
                        'status' => true,
                        'message' => $response_message,
                    )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }

    public function action_manage_featured_videos() {

        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $selected_videos = json_decode(Input::post("selected_videos")) ;
        foreach($selected_videos as $selected_video) {
            $feature_video = Model_Featuredvideo::find('first', array(
                "where" => array(
                    array("video_id", $selected_video->video_id),
                    array("page", $selected_video->page_name)
                )
            ));
            if (!isset($feature_video)) {
                $new_featured_video = Model_Featuredvideo::forge();
                $new_featured_video->page = $selected_video->page_name;
                $new_featured_video->video_id = $selected_video->video_id;
                $new_featured_video->save();
            }
        }
        $response->body(json_encode(array(
            'status' => true,
            'message' => "Feature Videos saved successfully",
        )));

        return $response;
    }

    public function action_delete_featured_videos() {

        $response = Response::forge();

        
        $selected_videos = json_decode(Input::post("delete_videos")) ;

        foreach($selected_videos as $selected_video) {
            $feature_id=$selected_video->feature_id;                            
            
            DB::delete('featuredvideos')
                    ->where('id', '=',$feature_id)
                    ->execute();
        }

        $response->body(json_encode(array(
            'status' => true,
            'message' => "Videos have been removed from featured list",
        )));

        return $response;
    }
    public function action_delete_sponsors() {

        $response = Response::forge();

        
        $selected_videos = json_decode(Input::post("delete_videos")) ;

        foreach($selected_videos as $selected_video) {
            $feature_id=$selected_video->feature_id;                            
            
            DB::delete('featuredvideos')
                    ->where('id', '=',$feature_id)
                    ->execute();
        }

        $response->body(json_encode(array(
            'status' => true,
            'message' => "Videos have been removed from featured list",
        )));

        return $response;
    }



    public function action_manage_banners() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $banner_id = Input::post("banner_id");
        $banner = Model_Banner::find($banner_id);

        if ($banner) {
            $banner->delete();
            $response_message = "Banner deleted successfully.";

            $response->body(json_encode(array(
                        'status' => true,
                        'message' => $response_message,
                    )));
        }

        return $response;
    }
    public function action_manage_sponsors() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $sponsor_id = Input::post("sponsor_id");
        $sponsor = Model_Sponsor::find($sponsor_id);

        if ($sponsor) {
            $sponsor->delete();
            $response_message = "Sponsor deleted successfully.";

            $response->body(json_encode(array(
                        'status' => true,
                        'message' => $response_message,
                    )));
        }

        return $response;
    }


    public function action_manage_notifications() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $notification_id = Input::post("notification_id");
        $notification = Model_Notification::find($notification_id);

        if ($notification) {
            $notification->delete();
            $response_message = "Notification deleted successfully.";

            $response->body(json_encode(array(
                        'status' => true,
                        'message' => $response_message,
                    )));
        }

        return $response;
    }

}
