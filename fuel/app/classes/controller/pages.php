<?php
session_start();

class Controller_Pages extends Controller_Base
{

    public $template = 'layout/template';
  

    public function before()
    {
        parent::before();

        $login_exception = array("*");

        parent::check_permission($login_exception);
    }

    public function action_show_profile($user_id)
    {
        //$this->template = 'layout/user-template';
        /*   if($this->current_user->id == $user_id){
         $view = View::forge('users/show');
        $view->set_global('page_css', 'users/show.css');
        }
        else{ */
        $view = View::forge('users/show-other-profile');
        $view->set_global('page_css', 'users/show-other-profile.css');
        /* }  */
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        $view->friends = $visitor->friends();
        // Get Profile Videokes
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0)
            ->get();

        $view->followers_count = count($visitor->followers());
        //$view->comments_counter = $comments_query->count();
        $view->videokes_count = count($videokes_query);
        $view->videokes = $videokes_query;
        /* ->order_by('created_at', 'desc')
         ->limit(Model_User::PROFILE_VIDEOKES_LIMIT)
        ->get();
        */
        // Get Profile Comments
        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->limit(5);

            $view->comments_counter = $comments->count();
            $view->comments = $comments
                ->order_by('created_at', 'desc')
                ->limit(Model_User::PROFILE_COMMENTS_LIMIT)
                ->get();
        } else {
            $view->comments = array();
            $view->comments_counter = 0;
        }


        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);

        $view->set_global('page_js', 'pages/show.js');

        $this->template->title = "Hip Hop Raw &raquo; Profile";
        $this->template->content = $view;
    }

public function action_get_video_info(){
        

        $response = Response::forge();
        $video_id = $_POST['video_id'];
        $videoke = Model_Videoke::find($video_id);
        $video_user = Model_User::find($videoke->user_id);

        if($videoke->youtube_link == 1){
            $youtube = 1;
            $parts = preg_split('/\s+/', $videoke->video);

            $ulink = "<iframe width='650' height='400' ".$parts[3]." frameborder='0' allowfullscreen></iframe>";


        }else{
            $youtube = 0;
            $ulink =" ";
        }



        $response->body(json_encode(array(
                    'status' => true,
                    'user_name' => $video_user->username,
                    'video' =>$videoke->video,
                    'ulink' =>$ulink,
                    'youtube' => $youtube,
                    'video_title' =>$videoke->title
            )));

            

        return $response;

    
    }
  public function action_sign_up_model() {
        $response = array();
        $this->template = '';
        
       

        if (Input::post()) {
            $post = Input::post();
            
            $val = Validation::forge();


            $val->add('first_name', 'First Name')->add_rule('required')->add_rule('max_length', 255);

            $val->add('last_name', 'Last Name')->add_rule('required')->add_rule('max_length', 255);

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);

            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255);

            $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');

            $val->add('city', 'City')->add_rule('required')->add_rule('max_length', 255);

            $fan = 0;

            if ($val->run($post)) {
                try {
                    $activation_code = Crypt::encode($post["username"]);
                    Auth::create_user(
                        $post["username"], $post["password"], $post["email"], $post["stage_name"], $fan, 3, array(
                        "first_name" => $post["first_name"],
                        "last_name" => $post["last_name"],
                        "is_active" => false,
                        "is_blocked" => false,
                        "activation_code" => $activation_code,
                        "profile_picture" => "",
                        "about_you" => "",
                        "city" => $post["city"],
                        "state" => $post["state"],
                        "category" => 2,
                        "birthday" => "",
                        "gender_id" => 0,
                        "mobile" => '',)
                    );

                    try {
                        Email::forge()->to($post["email"])->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        $response["sign_up_status"] = 'success';
                        $response["error"] = 'NO_ERROR';
                        $response["activation"] = $activation_code;
                    } catch (EmailSendingFailedException $e) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'CANNOT_SEND_EMAIL';
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    // $view->error = $e->getMessage();
                    if (strpos($e->getMessage(), 'Email') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER';
                    }
                    if (strpos($e->getMessage(), 'Username') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'USER_NAME_ALREADY_TAKEN';
                    }
                } catch (\Fuel\Core\PhpErrorException $e) {
                    $response["sign_up_status"] = 'failed';
                    $response["error"] = 'INPUT_VALIDATION_ERROR';
                }
            } else {
                $response["sign_up_status"] = 'failed';
                $response["error"] = 'INPUT_VALIDATION_ERROR';
            }
        } else {
            $response["sign_up_status"] = 'failed';
            $response["error"] = 'INPUT_VALIDATION_ERROR';
        }
        echo json_encode($response);
    }

    public function action_sign_up_artist() {
        $response = array();
        $this->template = '';
        
       

        if (Input::post()) {
            $post = Input::post();
            
            $val = Validation::forge();


            $val->add('first_name', 'First Name')->add_rule('required')->add_rule('max_length', 255);

            $val->add('last_name', 'Last Name')->add_rule('required')->add_rule('max_length', 255);

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);

            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255);

            $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');

            $val->add('city', 'City')->add_rule('required')->add_rule('max_length', 255);

            $fan = 0;

            if ($val->run($post)) {
                try {
                    $activation_code = Crypt::encode($post["username"]);
                    Auth::create_user(
                        $post["username"], $post["password"], $post["email"], $post["stage_name"], $fan, 3, array(
                        "first_name" => $post["first_name"],
                        "last_name" => $post["last_name"],
                        "is_active" => false,
                        "is_blocked" => false,
                        "activation_code" => $activation_code,
                        "profile_picture" => "",
                        "about_you" => "",
                        "city" => $post["city"],
                        "state" => $post["state"],
                        "category" => 1,
                        "birthday" => "",
                        "gender_id" => 0,
                        "mobile" => '',)
                    );

                   /* $new_user = Model_User::find('first', array(
                                    "where" => array(
                                    array("username", $post["username"])
                                    )
                             ));

                    DB::update('users')
                            ->value("category_id", 1)
                             ->where('id', '=',  $new_user->id); */
                            


                    try {
                        Email::forge()->to($post["email"])->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        $response["sign_up_status"] = 'success';
                        $response["error"] = 'NO_ERROR';
                        $response["activation"] = $activation_code;
                    } catch (EmailSendingFailedException $e) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'CANNOT_SEND_EMAIL';
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    // $view->error = $e->getMessage();
                    if (strpos($e->getMessage(), 'Email') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER';
                    }
                    if (strpos($e->getMessage(), 'Username') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = 'USER_NAME_ALREADY_TAKEN';
                    }
                } catch (\Fuel\Core\PhpErrorException $e) {
                    $response["sign_up_status"] = 'failed';
                    $response["error"] = 'INPUT_VALIDATION_ERROR';
                }
            } else {
                $response["sign_up_status"] = 'failed';
                $response["error"] = 'INPUT_VALIDATION_ERROR';
            }
        } else {
            $response["sign_up_status"] = 'failed';
            $response["error"] = 'INPUT_VALIDATION_ERROR';
        }
        echo json_encode($response);
    }

  public function action_404 (){

        $view = View::forge('pages/404');

        $view->set_global("active_page", "404");
        $view->set_global('page_css', 'pages/home.css');
        $view->set_global('page_js', 'pages/home.js');

        $this->template->title = 'Hiphopraw &raquo; Home';
        $this->template->content = $view;

  }

    public function action_home()
    {
       
        $view = View::forge('pages/home');

        $view->set_global("active_page", "home");
        $view->set_global('page_css', 'pages/home.css');
        $view->set_global('page_js', 'pages/home.js');


        $view->latest_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->order_by('created_at', 'desc')
            ->limit(6)->get();
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $random_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->where('created_at', "<", $ten_minutes_ago)
            ->order_by(DB::expr('RAND()'))->get();
     
        // $videos_to_delete = Model_Featuredvideo::find("all");
        // foreach($videos_to_delete as $f_delete){

        //         $f_delete->delete();

        // }
        $featured_videos = Model_Featuredvideo::query()
            ->where('page', 'home')->order_by('created_at', 'desc')->limit(4)->get();

        // print_r($featured_videos);
        // die();
        $view->featured_videos = $featured_videos;
        $view->random_videokes = $random_videokes;


        $_SESSION['home_videos'] = $random_videokes;
        $_SESSION['first_round'] = 1;
        $_SESSION['home_video_counter'] = 16;
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Home")
            )
        ));

        //Get the first left and right banner
        $first_left_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Home"),
                array("position", "Left")
            )
        ));
        $first_right_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Home"),
                array("position", "Right")
            )
        ));
        
        $banners = Model_Banner::query()
        ->where('page', 'Home')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;

        $sponsors = Model_Sponsor::query()
        ->get();

            // print_r($sponsors);
            // die;
        
        $view->sponsors = $sponsors;

        // $ads = Model_Banner::query()
        // ->where('page', 'Home')
        // ->where('position', 'Bottom')
        // ->get();
        // $view->ads = $ads;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; Home';
        $this->template->content = $view;
    }



    public function action_model_landing()
    {
        $this->template="";
        $view = View::forge('pages/model_landing');

        $view->set_global("active_page", "model_landing");
        $view->set_global('page_css', 'pages/model_landing.css');
        $view->set_global('page_js', 'pages/model_landing.js');
        $this->template = $view;
    }
    public function action_artist_landing()
    {
        $this->template="";
        $view = View::forge('pages/artist_landing');

        $view->set_global("active_page", "artist_landing");
        $view->set_global('page_css', 'pages/artist_landing.css');
        $view->set_global('page_js', 'pages/artist_landing.js');
        $this->template = $view;
    }

    public function action_videos()
    {
        $view = View::forge('pages/videos');

        $view->set_global("active_page", "Videos");
        $view->set_global('page_css', 'pages/videos.css');
        $view->set_global('page_js', 'pages/videos.js');

        $view->latest_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->order_by('created_at', 'desc')
            ->limit(6)->get();

        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $random_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->where('category_id', 1)
            ->where('created_at', "<", $ten_minutes_ago)
            ->order_by(DB::expr('RAND()'))->get(); 

        

        $view->random_videokes = $random_videokes;
        $_SESSION['videos_videos'] = $random_videokes;
        $_SESSION['videos_first_round'] = 1;
        $_SESSION['videokes_video_counter'] = 16;
        //Check notification for this page
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Videos")
            )
        ));

        //Get the first left and right banner
        $first_left_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Videos"),
                array("position", "Left")
            )
        ));
        $first_right_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Videos"),
                array("position", "Right")
            )
        ));

        $banners = Model_Banner::query()
        ->where('page', 'Videos')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;

        $sponsors = Model_Sponsor::query()
        ->get();

        $view->sponsors = $sponsors;


        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; Videos';
        $this->template->content = $view;
    }


    public function action_models()
    {
        $view = View::forge('pages/models');

        $view->set_global("active_page", "Models");
        $view->set_global('page_css', 'pages/models.css');
        $view->set_global('page_js', 'pages/models.js');
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $view->latest_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->order_by('created_at', 'desc')
            ->limit(6)->get();

        $random_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->where('category_id', 2)
            ->where('created_at', "<", $ten_minutes_ago)
            ->order_by(DB::expr('RAND()'))->get(); 

        $featured_videos = Model_Featuredvideo::query()
            ->where('page', 'models')->order_by('created_at', 'desc')->limit(4)->get();

           

        
        $view->featured_videos = $featured_videos;
        $view->random_videokes = $random_videokes;
        $_SESSION['model_videos'] = $random_videokes;
        $_SESSION['models_first_round'] = 1;
        $_SESSION['model_video_counter'] = 16;

        //Check notification for this page
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Models")
            )
        ));

        //Get the first left and right banner
        $first_left_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Models"),
                array("position", "Left")
            )
        ));
        $first_right_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "Models"),
                array("position", "Right")
            )
        ));


        $banners = Model_Banner::query()
        ->where('page', 'Models')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;

         $sponsors = Model_Sponsor::query()
        ->get();

            // print_r($sponsors);
            // die;
        
        $view->sponsors = $sponsors;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; Models';
        $this->template->content = $view;
    }


    public function action_about_us()
    {
        $view = View::forge('pages/about_us');

        $view->set_global('active_page', 'about-us');
        $view->set_global('page_css', 'pages/about_us.css');
        $view->set_global('page_js', 'pages/about_us.js');

        $this->template->title = 'Hip Hop Raw &raquo; About Us';
        $this->template->content = $view;
    }

    public function action_members()
    {
        $view = View::forge('pages/members');

        $view->set_global('active_page', 'members');
        $view->set_global('page_css', 'pages/members.css');
        $view->set_global('page_js', 'pages/members.js');

        $this->template->title = 'Hip Hop Raw &raquo; Members';
        $this->template->content = $view;
    }

    function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public function action_my_contests()
    {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }

        $this->template = View::forge("layout/user-template");
        $view = View::forge('pages/my_contests');


        $view->model_contest = new Model_Contest();
        $view->model_videokes = new Model_Videoke();


        $view->categories = Model_Category::getCategories(false);

        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        $view->friends = $visitor->friends();

        ## GET ACTIVE/JOINABLE CONTESTS AND SORT
        $view->contests = $view->model_contest->getContests(0, "active", 0)->as_array();
        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);

        $view->my_contest_videos = $view->model_contest->getUserVideoRelations($this->current_user->id, false);
        $view->my_completed_contest_videos = $view->model_contest->getUserVideoRelations($this->current_user->id, true);


        $view->page_mode = "contests";

        $contestid = intval($this->param('contest_id'));

        if ($contestid > 0) {

            $view->contest = $view->model_contest->getByID($contestid);


            $post = Input::post();


            if (isset($post['joining_contest']) && $post['joining_contest'] > 0) {

                #print_r($post);
                //Array ( [joining_contest] => 12 [video_id] => Array ( [0] => 15 ) )

                foreach ($post['video_id'] as $vid) {
                    // SAVE REQUEST
                    // ADD THEM TO ROUND 0
                    $newrow = array();
                    $newrow['contest_id'] = $post['joining_contest'];
                    $newrow['video_id'] = $vid;
                    $newrow['round_id'] = 0;
                    $newrow['paired_with'] = 0;
                    $newrow['winner'] = 'undetermined';
                    list($insert_id, $rows_affected) = DB::insert('contests_videos')->set($newrow)->execute();
                }

                // KICK TO SIGNUP COMPLETE PAGE
                Response::redirect('my_contests/joined');
                return;
            }


            $view->contest_videos = $view->model_contest->getVideoRelations($contestid);


            $view->page_mode = "join";

            if ($user = Model_User::find($this->current_user->id)) {
                $videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->where('category_id', $view->contest['category_id']);

// 				$config = array(
// 						"pagination_url" => "my_contests/join/".$view->contest['id'],
// 						"total_items" => $videokes->count(),
// 						"per_page" => 2
// 				);
// 				$pagination = Pagination::forge("paginated_vids", $config);
// 				$view->pagination = $pagination->render();
// 				$view->user = $user;
// 				$view->count = $videokes->count();
                //->limit($pagination->per_page)->offset($pagination->offset)


                $view->videokes = $videokes->order_by("id", "desc")->get();
            } else {
                Response::redirect(Router::get("browse"));
            }
        }


        if ($this->endsWith(Uri::current(), 'my_contests/joined')) {

            $view->page_mode = "joined";
        }


        ## GET MY VIDEOKES
        //$view->videokes = $view->model_videokes->getVideokes($this->current_user->id, 0);
        //$view->my_videokes = Model_Videoke::query()->where('user_id', $this->current_user->id)->order_by("id", "desc")->get();
        //$videokes->limit($pagination->per_page)->offset($pagination->offset)
        ##print_r($view->my_videokes);
        ##echo $view->my_videokes->id;
        ## GET CATEGORIES
        $view->categories = Model_Category::getCategories(false);


        $view->set_global('active_page', 'my_contests');        
        $view->set_global('page_css', 'pages/my_contests.css');
        $view->set_global('page_css', 'users/my_contest.css');
        $view->set_global('page_js', 'pages/my_contests.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contests';
        $this->template->content = $view;
    }

    public function action_contest()
    {


        ##echo "CONTEST ID = ".$this->param('contest_id');


        if (intval($this->param('contest_id')) > 0) {


            $this->action_contest_view();

            return;
        }


        $view = View::forge('pages/contest');


        $view->model_contest = new Model_Contest();

        ## LOAD THE CONTESTS INTO MEMORY FOR THE PAGE TO ACCESS
        $view->all_contests = $view->model_contest->getAllContests()->as_array();
        $view->contests = $view->model_contest->getContests(0, "active")->as_array();

        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);

        //$contest->computeEndofRounds();


        $view->set_global('active_page', 'contest');
        $view->set_global('page_css', 'pages/contest.css');
        $view->set_global('page_js', 'pages/contest.js');

        //Get all banners for this page
        $left_banners = Model_Banner::query()
            ->where('page', 'Contest')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Contest')
            ->where('position', 'Right')
            ->get();

        $banners = Model_Banner::query()
        ->where('page', 'Top 100 videos')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;
        
        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;

        $this->template->title = 'Hip Hop Raw &raquo; Contest';
        $this->template->content = $view;
    }

    public function action_contest_winner1()
    {


        ##echo "CONTEST ID = ".$this->param('contest_id');


        if (intval($this->param('contest_id')) > 0) {


            $this->action_contest_view();

            return;
        }


        $view = View::forge('pages/contest1');

        $view->model_contest = new Model_Contest();

        ## LOAD THE CONTESTS INTO MEMORY FOR THE PAGE TO ACCESS
        $view->all_contests = $view->model_contest->getAllContests()->as_array();
        $view->contests = $view->model_contest->getContests(0, "active")->as_array();

        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);

        //$contest->computeEndofRounds();


        $view->set_global('active_page', 'contest');
        $view->set_global('page_css', 'pages/contest1.css');
        $view->set_global('page_js', 'pages/contest.js');

        //Get all banners for this page
        $left_banners = Model_Banner::query()
            ->where('page', 'Contest')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Contest')
            ->where('position', 'Right')
            ->get();

        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;

        $this->template->title = 'Hip Hop Raw &raquo; Contest';
        $this->template->content = $view;
    }

    public function action_contest_view()
    {

        // NOT LOGGED IN
        if (!$this->current_user) {

            Response::redirect('login');
            return;
        }


        $contest_id = intval($this->param('contest_id'));


        $view = View::forge('pages/contest_view');

        $view->model_contest = new Model_Contest();
        $view->model_videokes = new Model_Videoke();

        // LOAD THE CONTESTS INTO MEMORY FOR THE PAGE TO ACCESS
        $view->contests = $view->model_contest->getAllContests()->as_array();

        $view->contest = $view->model_contest->getByID($contest_id);

        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);

        //$contest->computeEndofRounds();
        // GET CONTEST VIDEOS (RELATIONS)
        //getVideoRelations($contest_id = 0, $round_id = -1, $winner = null)
        $view->contest_videos = $view->model_contest->getVideoRelations($contest_id); //, $view->contest['current_round']);
        $view->videos = array();

        foreach ($view->contest_videos as $idx => $rel) {


            $view->contest_videos[$idx]['video'] = Model_Videoke::query()->where('id', $rel['video_id'])->get();


// 			$view->contest_videos[$idx]['video'] = DB::query("SELECT * FROM videokes WHERE id='".$rel['video_id']."'")
// 												->as_object('Model_Videoke')
// 												->execute();
// 			// LOAD THE VIDEO RECORD AS WELL
// 			$view->videos[$rel['video_id']] = DB::query("SELECT * FROM videokes WHERE id='".$rel['video_id']."'")
// 												->as_object('Model_Videoke')
// 												->execute();
            //
            ///$view->videos[$rel['video_id']] = $view->model_contest->getVideo($rel['video_id']);
        }


        $view->round = array();

        for ($round = 1; $round <= $view->contest['current_round']; $round++) {

            $view->round[$round] = $view->model_contest->pairVideos($view->contest_videos, $round);
        }


        //print_r($view->contest_videos);


        $view->set_global('active_page', 'contest');
        $view->set_global('page_css', 'pages/contest-view.css');
        $view->set_global('page_js', 'pages/contest.js');
        $view->set_global('page_js', 'pages/contest-view.js');

        $this->template->title = 'Hip Hop Raw &raquo; View a Contest';
        $this->template->content = $view;
    }

    public function action_contest_winners()
    {
        $view = View::forge('pages/contest_winners');

        $view->set_global('active_page', 'contest-winners');
        $view->set_global('page_css', 'pages/contest_winners.css');
        $view->set_global('page_js', 'pages/contest_winners.js');

        $contest_months = DB::query("select distinct concat_ws('/',month(FROM_UNIXTIME(end_time)), year(FROM_UNIXTIME(end_time))) as month from contests where status = 'completed' and winner > 0 order by month DESC")->execute()->as_array();
        $categories = Model_Category::query()->get();
        $model_contest = New Model_Contest();

        $completed_contests_hiphop = $model_contest->getContests('1','completed','5')->as_array();
        $completed_contests_model = $model_contest->getContests('2','completed','5')->as_array();

        $not_completed = $model_contest->getContests('1','active', '-1')->as_array();

        $videokes_hiphop = array();
        $videokes_hiphop_month = array();
        $videokes_model = array();
        $videokes_model_month = array();
        foreach ($completed_contests_hiphop as $hiphop_winner){

            $videokes_hiphop[] = $hiphop_winner['winner'];
            $videokes_hiphop_month []= $hiphop_winner['start_time'];
        }

        foreach ($completed_contests_model as $model_winner){

            $videokes_model[] = $model_winner['winner'];
             $videokes_model_month []= $model_winner['start_time'];
        }

        $banners = Model_Banner::query()
        ->where('page', 'Home')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;
        
        $view->none_completed_contests=$not_completed;

        $view->videokes_hiphop = $videokes_hiphop;
        $view->videokes_model = $videokes_model;
        $view->videokes_hiphop_month = $videokes_hiphop_month;
        $view->videokes_model_month = $videokes_model_month;

        $view->completed_contests_hiphop = $completed_contests_hiphop;
        $view->completed_contests_model= $completed_contests_model;

        $view->contest_months = $contest_months;
        $view->categories = $categories;
        $this->template->title = 'Hiphopraw &raquo; Contest Winners';
        $this->template->content = $view;
    }

    public function action_contest_how_to()
    {
        $view = View::forge('pages/contest_how_to');

        $view->set_global('page_css', 'pages/contest_how_to.css');
        $view->set_global('page_js', 'pages/contest_how_to.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contest How To';
        $this->template->content = $view;
    }

    public function action_contest_battle()
    {
        $view = View::forge('pages/contest_battle');

        $view->set_global('page_css', 'pages/contest_battle.css');
        $view->set_global('page_js', 'pages/contest_battle.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contest Battle';
        $this->template->content = $view;
    }

    public function action_contact_us()
    {
        $view = View::forge('pages/contact_us');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('name', 'Name')
                ->add_rule('required')
                ->add_rule('max_length', 255);

            $val->add('email', 'Email')
                ->add_rule('required')
                ->add_rule('max_length', 255)
                ->add_rule('valid_email');

            $val->add('comments', 'Comments')
                ->add_rule('required');

            if ($val->run()) {
                try {
                    $contact_info = array(
                        "sender_name" => Input::post("name"),
                        "sender_email" => Input::post("email"),
                        "sender_comments" => Input::post("comments")
                    );
                    Email::forge()
                        ->to("noreply.ads.dev@gmail.com")
                        ->from("noreply@hiphopraw.com", "Hip Hop Raw")
                        ->subject("Message from Contact Us Page")
                        ->html_body(View::forge('email/contact_us', $contact_info))
                        ->send();

                    Session::set_flash("success", "Your email is successfully sent. We will get back to you immediately.");
                } catch (EmailSendingFailedException $e) {
                    Session::set_flash("error", "Your email could not be sent, please contact the Administrator for further instructions.");
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'pages/contact_us.css');
        $view->set_global('page_js', 'pages/contact_us.js');

        $this->template->title = 'Hip Hop Raw &raquo; Contact Us';
        $this->template->content = $view;
    }

    public function action_profile()
    {
        $view = View::forge('pages/profile');

        $view->set_global('page_css', 'pages/profile.css');
        $view->set_global('page_js', 'pages/profile.js');

        $this->template->title = 'Hip Hop Raw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_comments()
    {
        $view = View::forge('pages/comments');

        $view->set_global('page_css', 'pages/comments.css');
        $view->set_global('page_js', 'pages/comments.js');

        $this->template->title = 'Hip Hop Raw &raquo; Comments';
        $this->template->content = $view;
    }

    /*  public function action_friends() {
         $view = View::forge('pages/friends');

         // assign global variable
         $view->set_global('page_css', 'pages/friends.css');
         $view->set_global('page_js', 'pages/friends.js');

         $this->template->title = 'Hip Hop Raw &raquo; Friends';
         $this->template->content = $view;
     } */

    public function action_my_profile()
    {
        $view = View::forge('pages/my_profile');

        $view->set_global('page_css', 'pages/my_profile.css');
        $view->set_global('page_js', 'pages/my_profile.js');

        $this->template->title = 'Hip Hop Raw &raquo; My Profile';
        $this->template->content = $view;
    }

    public function action_my_friends()
    {
        $view = View::forge('pages/my_friends');

        $view->set_global('page_css', 'pages/my_friends.css');
        $view->set_global('page_js', 'pages/my_friends.js');
        $view->set_global('active_link', 'friends-link');

        $this->template->title = 'Hip Hop Raw &raquo; My Friends';
        $this->template->content = $view;
    }

    public function action_my_videokes()
    {
        $view = View::forge('pages/my_videokes');

        $view->set_global('page_css', 'pages/my_videokes.css');
        $view->set_global('page_js', 'pages/my_videokes.js');
        $view->set_global('active_link', 'videokes-link');

        $this->template->title = 'Hip Hop Raw &raquo; My Videos';
        $this->template->content = $view;
    }

    public function action_my_comments()
    {
        $view = View::forge('pages/my_comments');

        $view->set_global('page_css', 'pages/my_comments.css');
        $view->set_global('page_js', 'pages/my_comments.js');
        $view->set_global('active_link', 'comments-link');

        $this->template->title = 'Hip Hop Raw &raquo; My Comments';
        $this->template->content = $view;
    }

    public function action_my_messages()
    {
        // create the layout view
        $view = View::forge('pages/my_messages');

        // assign global variable
        $view->set_global('page_css', 'pages/my_messages.css');
        $view->set_global('page_js', 'pages/my_messages.js');
        $view->set_global('active_link', 'messages-link');
        $view->set_global('active_message_link', 'inbox');

        $this->template->title = 'Hip Hop Raw &raquo; My Messages';
        $this->template->content = $view;
    }

    public function action_my_message()
    {
        $view = View::forge('pages/my_message');

        $view->set_global('page_css', 'pages/my_message.css');
        $view->set_global('page_js', 'pages/my_message.js');
        $view->set_global('active_link', 'messages-link');
        $view->set_global('active_message_link', 'inbox');

        $this->template->title = 'Hip Hop Raw &raquo; My Message';
        $this->template->content = $view;
    }

    public function action_settings($current_password_not_correct = false)
    {
        //TODO: if the user is not logged in, redirect to login page

        $this->template = View::forge("layout/user-template");
        $view = View::forge('pages/settings');
        $view->current_password_not_correct = $current_password_not_correct;

        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        $view->friends = $visitor->friends();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());
        $view->set_global('page_css', 'pages/settings.css');
        $view->set_global('page_js', 'pages/settings.js');
        $view->set_global('active_link', 'settings-link');

        $this->template->title = 'Hip Hop Raw &raquo; Settings';
        $this->template->content = $view;
    }

    public function action_upload_videoke()
    {
        $view = View::forge('pages/upload_videoke');

        $view->set_global('page_css', 'pages/upload_videoke.css');
        $view->set_global('page_js', 'pages/upload_videoke.js');
        $view->set_global('active_link', 'upload-videoke-link');

        $this->template->title = 'Hip Hop Raw &raquo; Upload Video';
        $this->template->content = $view;
    }

    public function action_invite_friend()
    {
        $view = View::forge('pages/invite_friend');

        // assign global variable
        $view->set_global('page_css', 'pages/invite_friend.css');
        $view->set_global('page_js', 'pages/invite_friend.js');
        $view->set_global('active_link', 'invite-friend-link');

        $this->template->title = 'Hip Hop Raw &raquo; Invite Friend';
        $this->template->content = $view;
    }

    public function action_build_profile()
    {

        $view = View::forge('pages/build_profile');

        $view->set_global('page_css', 'pages/build_profile.css');
        $view->set_global('page_js', 'pages/build_profile.js');
        $view->set_global('active_link', 'build-profilie-link');

        $this->template->title = 'Hip Hop Raw &raquo; Build Profile';
        $this->template->content = $view;
    }

    public function action_hide_banner()
    {
        $response = Response::forge();
        Session::set('banner_visibility', 'hide');
        return $response;
    }

    public function action_hhrnews()
    {
        $view = View::forge('pages/hhrnews');

        $view->set_global("active_page", "Models");
        $view->set_global('page_css', 'pages/hhrnews.css');
        $view->set_global('page_js', 'pages/hhrnews.js');

        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;

        $random_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->where('category_id', 3)
            ->where('created_at', "<", $ten_minutes_ago)
            ->order_by(DB::expr('RAND()'))->get();
          
       /*foreach ($random_videokes as $r){
       print_r($r['title']);
       print_r("  ");
       }
       die;*/
       

        $featured_videos = Model_Featuredvideo::query()
            ->where('page', 'hhrnews')->order_by('created_at', 'desc')->limit(4)->get();

        $view->featured_videos = $featured_videos;
        $view->random_videokes = $random_videokes;
        $_SESSION['hhr_videos'] = $random_videokes;
        $_SESSION['news_first_round'] = 1;
        $_SESSION['hhrnews_video_counter'] = 16;
        $view->latest_videokes = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->order_by('created_at', 'desc')
            ->limit(6)->get();
        //Check notification for this page
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "News")
            )
        ));

        //Get the first left and right banner
        $first_left_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "News"),
                array("position", "Left")
            )
        ));

       


        $first_right_banner = Model_Banner::find('last', array(
            "where" => array(
                array("page", "News"),
                array("position", "Right")
            )
        ));

        $banners = Model_Banner::query()
        ->where('page', 'News')
        ->where('position', 'Top')
        ->get();

        $sponsors = Model_Sponsor::query()
        ->get();

        $view->banners = $banners;
        $view->sponsors = $sponsors;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; HHR NEWS';
        $this->template->content = $view;
    }

    public function action_show($videoke_id)
    {
        if($this->current_user){
            Response::redirect("videos/show/$videoke_id");
        }
        $this->template = View::forge("layout/template");

        if (!$videoke_id) {

            Response::redirect(Router::get("_404_"));
        }

        $view = View::forge('videokes/show');

        if (!$videoke = Model_Videoke::find($videoke_id)) {
            Response::redirect(Router::get("_404_"));
        }

        $user = \Model\Auth_User::find($videoke->user_id);
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $view->suggestions = Model_Videoke::query()
            ->where('is_blocked', 0)
            ->where('user_id', '!=', $user->id)
            ->where('created_at', "<", $ten_minutes_ago)
            ->order_by(DB::expr('RAND()'))
            ->limit(6)->get();

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

        $view->comments = Model_Comment::query()

            ->where(array('videoke_id', $videoke->id))
            ->limit(10)->get();


        $view->set_global('page_css', 'videokes/show_public.css');
        $view->set_global('page_js', 'videokes/show.js');

        $this->template->title = 'Hip Hop Raw &raquo; Video';
        $this->template->content = $view;
    }

    public function action_friends($user_id = null)
    {
        $view = View::forge('users/friends');

        /* }  */
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->friends = $visitor->friends();
        // Get Profile Videokes
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0);
        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->limit(5);

            $view->comments_counter = $comments->count();
            $view->comments = $comments
                ->order_by('created_at', 'desc')
                ->limit(Model_User::PROFILE_COMMENTS_LIMIT)
                ->get();
        } else {
            $view->comments = array();
            $view->comments_counter = 0;
        }
        $view->followers_count = count($visitor->followers());
        $view->videokes_count = $videokes_query->count();

        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/friends.css');
        $view->set_global('page_js', 'pages/show.js');
        $this->template->title = 'Hiphopraw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_followers($user_id = null)
    {
        $view = View::forge('users/followers');

        /* }  */
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        // Get Profile Videokes
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0);

        $view->followers_count = count($visitor->followers());
        $view->videokes_count = $videokes_query->count();
        $view->videokes = $videokes_query
            ->order_by('created_at', 'desc')
            ->limit(Model_User::PROFILE_VIDEOKES_LIMIT)
            ->get();

        // Get Profile Comments
        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->limit(5);

            $view->comments_counter = $comments->count();
            $view->comments = $comments
                ->order_by('created_at', 'desc')
                ->limit(Model_User::PROFILE_COMMENTS_LIMIT)
                ->get();
        } else {
            $view->comments = array();
            $view->comments_counter = 0;
        }


        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/followers.css');
        $view->set_global('page_js', 'pages/show.js');
        $this->template->title = 'Hiphopraw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_comment($user_id = null)
    {
        $view = View::forge('users/comment');

        /* }  */
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->friends = $visitor->friends();
        // Get Profile Videokes
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0);

        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->limit(5);

            $view->comments_counter = $comments->count();
            $view->comments = $comments
                ->order_by('created_at', 'desc')
                ->limit(Model_User::PROFILE_COMMENTS_LIMIT)
                ->get();
        } else {
            $view->comments = array();
            $view->comments_counter = 0;
        }


        $view->followers_count = count($visitor->followers());
        $view->videokes_count = $videokes_query->count();

        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/comment.css');
        $view->set_global('page_js', 'users/home_login.js');
        $this->template->title = 'Hiphopraw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_home_show_more()
    {
       $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
        //$random_videokes = $_SESSION['random_videokes']->limit($_SESSION['counter'])->get();
        
        if( $_SESSION['first_round'] == 1){

                $random_videokes_orginals = $_SESSION['home_videos'];
                  $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                      unset($random_videokes_orginals[$key]);
                     $counter_remove++;
                    if ($counter_remove == 16) {
                         break;
                         }
                 }
                 $_SESSION['home_videos'] = $random_videokes_orginals;
                 $random_videokes = array();
                 $counter_display = 0;
                 foreach ($random_videokes_orginals as $random_videokes_orginal) {
                     array_push($random_videokes, $random_videokes_orginal);
                    $counter_display++;
                  if ($counter_display == 8) {
                            break;
                    }
                 }


           $_SESSION['first_round'] = 0; 
        }else{

                $random_videokes_orginals = $_SESSION['home_videos'];
                $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                    unset($random_videokes_orginals[$key]);
                         $counter_remove++;
                    if ($counter_remove == 8) {
                         break;
                    }
                }
                $_SESSION['home_videos'] = $random_videokes_orginals;
                $random_videokes = array();
                $counter_display = 0;
                foreach ($random_videokes_orginals as $random_videokes_orginal) {
                        array_push($random_videokes, $random_videokes_orginal);
                        $counter_display++;
                if ($counter_display == 8) {
                    break;
                }
            }



        }


        if (count($random_videokes) < 8) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }

        
        if ($random_videokes) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'pageNo' => Input::post("page_no"),
                'html' => View::forge('pages/partials/home_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
            )));
        } else {
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => 1,
                //'html' => View::forge('users/partials/top_video_single_view_more', array("top_100_videos" => $top_100_videos,'counter'=>$_SESSION['top_video_counter']))->render(),
            )));
        }

        return $response;

    }

    public function action_videos_show_more()
    {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }


        if( $_SESSION['videos_first_round'] == 1){

                $random_videokes_orginals = $_SESSION['videos_videos'];
                  $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                      unset($random_videokes_orginals[$key]);
                     $counter_remove++;
                    if ($counter_remove == 16) {
                         break;
                         }
                 }
                 $_SESSION['videos_videos'] = $random_videokes_orginals;
                 $random_videokes = array();
                 $counter_display = 0;
                 foreach ($random_videokes_orginals as $random_videokes_orginal) {
                     array_push($random_videokes, $random_videokes_orginal);
                    $counter_display++;
                  if ($counter_display == 8) {
                            break;
                    }
                 }


           $_SESSION['videos_first_round'] = 0; 
        }else{

                $random_videokes_orginals = $_SESSION['videos_videos'];
                $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                    unset($random_videokes_orginals[$key]);
                         $counter_remove++;
                    if ($counter_remove == 8) {
                         break;
                    }
                }
                $_SESSION['videos_videos'] = $random_videokes_orginals;
                $random_videokes = array();
                $counter_display = 0;
                foreach ($random_videokes_orginals as $random_videokes_orginal) {
                        array_push($random_videokes, $random_videokes_orginal);
                        $counter_display++;
                if ($counter_display == 8) {
                    break;
                }
            }



        }

        



        if (count($random_videokes) < 8) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }

        
        if ($random_videokes) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'pageNo' => Input::post("page_no"),
                'html' => View::forge('pages/partials/videos_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
            )));
        } else {
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => 1,
                //'html' => View::forge('users/partials/top_video_single_view_more', array("top_100_videos" => $top_100_videos,'counter'=>$_SESSION['top_video_counter']))->render(),
            )));
        }

        return $response;
    }

    public function action_models_show_more()
    {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }


       if( $_SESSION['models_first_round'] == 1){

                $random_videokes_orginals = $_SESSION['model_videos'];
                  $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                      unset($random_videokes_orginals[$key]);
                     $counter_remove++;
                    if ($counter_remove == 16) {
                         break;
                         }
                 }
                 $_SESSION['model_videos'] = $random_videokes_orginals;
                 $random_videokes = array();
                 $counter_display = 0;
                 foreach ($random_videokes_orginals as $random_videokes_orginal) {
                     array_push($random_videokes, $random_videokes_orginal);
                    $counter_display++;
                  if ($counter_display == 8) {
                            break;
                    }
                 }


           $_SESSION['models_first_round'] = 0; 
        }else{

                $random_videokes_orginals = $_SESSION['model_videos'];
                $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                    unset($random_videokes_orginals[$key]);
                         $counter_remove++;
                    if ($counter_remove == 8) {
                         break;
                    }
                }
                $_SESSION['model_videos'] = $random_videokes_orginals;
                $random_videokes = array();
                $counter_display = 0;
                foreach ($random_videokes_orginals as $random_videokes_orginal) {
                        array_push($random_videokes, $random_videokes_orginal);
                        $counter_display++;
                if ($counter_display == 8) {
                    break;
                }
            }



        }





        if (count($random_videokes) < 8) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }


        
        if ($random_videokes) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'pageNo' => Input::post("page_no"),
                'html' => View::forge('pages/partials/models_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
            )));
        } else {
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => 1,
                //'html' => View::forge('users/partials/top_video_single_view_more', array("top_100_videos" => $top_100_videos,'counter'=>$_SESSION['top_video_counter']))->render(),
            )));
        }

        return $response;
    }
    public function action_hhr_show_more()
    {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }
       
        if( $_SESSION['news_first_round'] == 1){

                $random_videokes_orginals = $_SESSION['hhr_videos'];
                  $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                      unset($random_videokes_orginals[$key]);
                     $counter_remove++;
                    if ($counter_remove == 16) {
                         break;
                         }
                 }
                 $_SESSION['hhr_videos'] = $random_videokes_orginals;
                 $random_videokes = array();
                 $counter_display = 0;
                 foreach ($random_videokes_orginals as $random_videokes_orginal) {
                     array_push($random_videokes, $random_videokes_orginal);
                    $counter_display++;
                  if ($counter_display == 8) {
                            break;
                    }
                 }


           $_SESSION['news_first_round'] = 0; 
        }else{

                $random_videokes_orginals = $_SESSION['hhr_videos'];
                $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                    unset($random_videokes_orginals[$key]);
                         $counter_remove++;
                    if ($counter_remove == 8) {
                         break;
                    }
                }
                $_SESSION['hhr_videos'] = $random_videokes_orginals;
                $random_videokes = array();
                $counter_display = 0;
                foreach ($random_videokes_orginals as $random_videokes_orginal) {
                        array_push($random_videokes, $random_videokes_orginal);
                        $counter_display++;
                if ($counter_display == 8) {
                    break;
                }
            }



        }



        if (count($random_videokes) < 8) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }




        if ($random_videokes) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'pageNo' => Input::post("page_no"),
                'html' => View::forge('pages/partials/hhr_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
            )));
        } else {
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => 1,
                //'html' => View::forge('users/partials/top_video_single_view_more', array("top_100_videos" => $top_100_videos,'counter'=>$_SESSION['top_video_counter']))->render(),
            )));
        }

        return $response;
    }

    public function action_privacy()
    {
        $view = View::forge('pages/privacy');

        $view->set_global("active_page", "home");
        $view->set_global('page_css', 'pages/privacy.css');
        $view->set_global('page_js', 'pages/home.js');
        $this->template->title = 'Hiphopraw &raquo; Privacy';

        $left_banners = Model_Banner::query()
            ->where('page', 'Home')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Home')
            ->where('position', 'Right')
            ->get();

        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;

        $this->template->content = $view;
    }

    public function action_term()
    {
        $view = View::forge('pages/term');

        $view->set_global("active_page", "term");
        $view->set_global('page_css', 'pages/term.css');
        $view->set_global('page_js', 'pages/home.js');
        $this->template->title = 'Hiphopraw &raquo; term';

        $left_banners = Model_Banner::query()
            ->where('page', 'Home')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Home')
            ->where('position', 'Right')
            ->get();

        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;


        $this->template->content = $view;
    }

    public function action_sponsor()
    {
        $view = View::forge('pages/sponser');

        $view->set_global("active_page", "sponsor");
        $view->set_global('page_css', 'pages/sponsor.css');
        $view->set_global('page_js', 'pages/home.js');
        $this->template->title = 'Hiphopraw &raquo; Sponsors';
        $this->template->content = $view;
    }

}
