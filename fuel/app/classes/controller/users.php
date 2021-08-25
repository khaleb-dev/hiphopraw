<?php

define("NO_ERROR", "NO_ERROR");
define("UNKNOWN_ERROR", "UNKNOWN_ERROR");
define("INPUT_VALIDATION_ERROR", "INPUT_VALIDATION_ERROR");
define("CANNOT_SEND_EMAIL", "CANNOT_SEND_EMAIL");
define("USER_NAME_ALREADY_TAKEN", "USER_NAME_ALREADY_TAKEN");
define("EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER", "EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER");
define("WRONG_CREDENTIALS", "WRONG_CREDENTIALS");
define("ADMIN", 5);
define("USER_BLOCKED", "USER_BLOCKED");
define("USER_INACTIVE", "USER_INACTIVE");
session_start();

class Controller_Users extends Controller_Base {

    public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array("login", "sign_up", "activate", "forgot_password", "reset_password", "reset", "index", "show");

        parent::check_permission($login_exception);
    }

    public function action_login() {
        $this->template = \View::forge('layout/template');
        $view = View::forge("users/login");

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);

            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255);

            if ($val->run()) {

                $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")), 'or' => array(array('email', Input::post("username")),),)));
                $profile = Model_User::find('first', array("where" => array(array("user_id", $user->id))));

                if (!isset($user->is_active) || !$user->is_active) {
                    $view->account_inactive = true;
                } elseif (isset($user) && isset($user->is_blocked) && $user->is_blocked == 1) {
                    $view->account_blocked = true;
                } elseif (Auth::login()) {
                    if ($user->group_id == ADMIN) {
                        $profile->is_logged_in = 1;
                        $profile->save();
                        Response::redirect("admin/");
                    } else {
                        $profile->is_logged_in = 1;
                        $profile->save();
                        Response::redirect(Uri::create('users/home_login') . '/' . $user->id);
                    }
                } else {
                    $view->wrong_credentials = true;
                }
            }

            $view->val = $val;
        }

        $view->set_global('page_css', 'users/login.css');
        $view->set_global('page_js', 'users/login.js');

        $this->template->title = "Hip Hop Raw &raquo; Login";
        $this->template->content = $view;
    }

    public function action_logout() {
        $this->current_user->is_logged_in = 0;
        $this->current_user->save();
        Auth::logout();
       
        Response::redirect('pages/home');
    }

    public function action_sign_up() {
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
            if (isset($post["fan"])) {
                $fan = 1;
            } else {
                $fan = 0;
            }

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
                        "birthday" => "",
                        "gender_id" => 0,
                        "mobile" => '',)
                    );

                    try {
                        Email::forge()->to($post["email"])->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        $response["sign_up_status"] = 'success';
                        $response["error"] = NO_ERROR;
                        $response["activation"] = $activation_code;
                    } catch (EmailSendingFailedException $e) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = CANNOT_SEND_EMAIL;
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    // $view->error = $e->getMessage();
                    if (strpos($e->getMessage(), 'Email') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER;
                    }
                    if (strpos($e->getMessage(), 'Username') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = USER_NAME_ALREADY_TAKEN;
                    }
                } catch (\Fuel\Core\PhpErrorException $e) {
                    $response["sign_up_status"] = 'failed';
                    $response["error"] = INPUT_VALIDATION_ERROR;
                }
            } else {
                $response["sign_up_status"] = 'failed';
                $response["error"] = INPUT_VALIDATION_ERROR;
            }
        } else {
            $response["sign_up_status"] = 'failed';
            $response["error"] = INPUT_VALIDATION_ERROR;
        }
        echo json_encode($response);
    }
    
public function action_sign_up_model() {
        $response = array();
        $this->template = '';
        
       

        if (Input::post()) {
            $post = Input::post();

            var_dump($post);
            die;
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
                        "birthday" => "",
                        "gender_id" => 0,
                        "mobile" => '',)
                    );

                    try {
                        Email::forge()->to($post["email"])->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        $response["sign_up_status"] = 'success';
                        $response["error"] = NO_ERROR;
                        $response["activation"] = $activation_code;
                    } catch (EmailSendingFailedException $e) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = CANNOT_SEND_EMAIL;
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    // $view->error = $e->getMessage();
                    if (strpos($e->getMessage(), 'Email') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER;
                    }
                    if (strpos($e->getMessage(), 'Username') !== false) {
                        $response["sign_up_status"] = 'failed';
                        $response["error"] = USER_NAME_ALREADY_TAKEN;
                    }
                } catch (\Fuel\Core\PhpErrorException $e) {
                    $response["sign_up_status"] = 'failed';
                    $response["error"] = INPUT_VALIDATION_ERROR;
                }
            } else {
                $response["sign_up_status"] = 'failed';
                $response["error"] = INPUT_VALIDATION_ERROR;
            }
        } else {
            $response["sign_up_status"] = 'failed';
            $response["error"] = INPUT_VALIDATION_ERROR;
        }
        echo json_encode($response);
    }



public function action_chat_login() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_User::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_to_chat = 1;
                    $profile->save();
                    $response->body(json_encode(array(
                        'status' => true,
                        'message' => "The user successfully logged in",
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'message' => "The profile does not exist",
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user does not exist ",
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_chat_logout() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_User::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_to_chat = 0;
                    $profile->save();
                    $response->body(json_encode(array(
                        'status' => true,
                        'message' => "The user successfully logged out",
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'message' => "The profile does not exist",
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user does not exist " . Input::post("username"),
                )));
            }
            return $response;
        }
        else {
            return $response->body(json_encode(array(
                'status' => false,
                'message' => "Invalid request.",
            )));
            //return $response->set_status(400);
        }
    }

    public function action_save_chat(){
        $response = Response::forge();
        $post = Input::post();
          if (Input::post()) {

            $chat_room_id = $post['chat_room_id'];
            $chat_sender = $post['chat_sender'];
            $chat_reciever = $post['chat_reciever'];
            $chat_line =$post['chat_line'];

            $query = DB::insert('chat');

            $query->set(array(
                'chat_room_id' =>  $chat_room_id,
                'chat_sender' =>  $chat_sender,
                'chat_reciever' => $chat_reciever,
                'chat_line' =>  $chat_line,
                ));

            $query->execute();

            $response->body(json_encode(array(
                        "message" =>"data saved",
                        "success"=>true,
                        
                    ))); 

             return $response;
              

          }

    }
    public function action_get_chat(){
        $response = Response::forge();
        $post = Input::post();
        $chat_history = array();
          if (Input::post()) {

                $chat_room_id = $post['chat_room_id'];

                // $query = DB::select('id')->from('chat');
                // $query->where('id',1);
                // $chat = $query->execute(); 

                 $chat = DB::select('*')                   
                        ->from('chat')  
                        ->where('chat_room_id',$chat_room_id)
                        ->execute(); 
                
                foreach($chat as $key => $single_chat){
                    $chat_history[$key] = $single_chat;

                }
                //$chat = DB::query("select * from chat where chat_room_id = $chat_room_id")->as_assoc()->execute();

                $response->body(json_encode(array(
                        "chat" => $chat_history,
                        "room" => $chat_room_id,
                        "success"=>true,
                        
                    ))); 

             return $response;

          }



    }

    public function action_remove_chat(){
        $response = Response::forge();
        $post = Input::post();
        
          if (Input::post()) {

                $chat_room_id = $post['chat_room_id'];

                 $chat = DB::delete('chat')  
                        ->where('chat_room_id',$chat_room_id)
                        ->execute();

                $response->body(json_encode(array(
                        "room" => $chat_room_id,
                        "success"=>true,
                        
                    ))); 

             return $response;

          }



    }


    public function action_activate($code) {

        if ($this->current_user) {
            Response::redirect("users/show/" . $this->current_user->id);
        }

        $view = View::forge("users/activate");

        if ($code) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Crypt::decode($code)))));
            if ($user) {
                if (Auth::force_login($user)) {
                    Auth::update_user(array("is_active" => 1,));

                    $view->success = true;
                    Session::set_flash("success", "Account activated! Please use the form below to build your profile.");
                    Response::redirect("users/edit");
                }
            }
        }

        $this->template->title = "Hip Hop Raw &raquo;  Sign Up";
        $this->template->content = $view;
    }

    public function action_forgot_password() {
        if ($this->current_user) {
            Response::redirect("users/show/" . $this->current_user->id);
        }
        $this->template = \View::forge('layout/template');

        $view = View::forge('users/forgot_password');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if ($val->run()) {
                $user = \Model\Auth_User::find('first', array("where" => array(array("email", Input::post("email")))));
                if ($user) {

                    $reset_code = Crypt::encode($user->username);
                    try {
                        echo $reset_code;
                        Email::forge()->to(Input::post("email"))->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject("Account Password Reset Information")->html_body(View::forge('email/forgot_password', array("reset_code" => $reset_code)))->send();

                        Session::set_flash("success", "Your password reset email is successfully sent. Please use the link provided in the email to reset your password.");
                        Response::redirect("login");
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error2", "Your password recovery email could not be sent, please contact the Administrator for further instructions.");
                    }
                } else {
                    $view->email_not_registered = true;
                    $view->email = Input::post("email");
                    Session::set_flash("error2", "Your email is not registered. Please Sign Up to get a new account!");
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'users/forgot_password.css');
        $view->set_global('page_js', 'users/forgot_password.js');

        //var_dump($this->template);
        //die();

        $this->template->title = "Hip Hop Raw &raquo; Login";
        $this->template->content = $view;
    }

    public function action_reset_password($code) {
        $this->template = View::forge("layout/template");
        $view = View::forge("users/reset_password");

        if ($code) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Crypt::decode($code)))));
            if ($user) {
                if (Auth::force_login($user)) {
                    $view->username = $user->username;
                    Session::set_flash("info", "Please use the form below to reset your password.");
                }
            } else {
                Session::set_flash("error", "Please use the link provided in your the email to reset your password.");
                Response::redirect("login");
            }
        } else {
            Session::set_flash("error", "Please use the link provided in your the email to reset your password.");
            Response::redirect("login");
        }

        $this->template->title = "Hip Hop Raw &raquo;  Reset Password";
        $this->template->content = $view;
    }

    public function action_reset() {

        if (Input::post("password")) {
            echo Input::post("username");
            $old_password = Auth::reset_password(Input::post("username"));
            Auth::change_password($old_password, Input::post("password"), Input::post("username"));

            Session::set_flash("success", "Your password has been successfully reset!");

            Response::redirect(Router::get("profile"));
        }
        Response::redirect("users/reset_password/wrong");
    }

    public function action_index($page = 1) {

        $view = View::forge('users/index');

        $users_query = Model_User::query()->order_by("created_at", "desc");

        // Configure the pagination
        $pagination = \Pagination::forge('pagination', array(
                'pagination_url' => \Uri::base(false) . 'members/',
                'total_items' => $users_query->count(),
                'per_page' => 20,
                'uri_segment' => 2,
                'num_links' => 5,
        ));

        $view->pagination = $pagination;
        $view->users = $users_query
            ->offset($pagination->offset)
            ->limit($pagination->per_page)
            ->get();

        $view->set_global('active_page', 'members');
        $view->set_global('page_css', 'users/index.css');
        $view->set_global('page_js', 'users/index.js');

        //Get all banners for this page
        $left_banners = Model_Banner::query()
            ->where('page', 'Members')
            ->where('position', 'Left')
            ->get();
        $right_banners = Model_Banner::query()
            ->where('page', 'Members')
            ->where('position', 'Right')
            ->get();

        $this->template->left_banners = $left_banners;
        $this->template->right_banners = $right_banners;

        $this->template->title = "Hip Hop Raw &raquo; Members";
        $this->template->content = $view;
    }


public function action_global_search($latestQuery) {
     
        $response = Response::forge();
       // $latestQuery =Input::post("latestQuery"); 
        
        $latestQueryLength =strlen($latestQuery);

        $search_result = array();

        $words= array();
            $videos = DB::select('id')                   
                    ->from('videokes')  
                    ->execute();

           $users =  DB::select('id')                   
                    ->from('users') 
                    ->execute();
    
            foreach ($users as $key => $value) {
                    $user = Model_User::find($value['id']);
                    $stage_name=$user->stage_name;
                    if (substr(strtolower($user->stage_name),0,$latestQueryLength) == strtolower($latestQuery)){
                        $words[Html::anchor("users/show/$user->id", $user->stage_name)]=$stage_name;
                        $search_result[Html::anchor("users/show/$user->id", $user->stage_name)]= Html::anchor('users/show/' . $user->id, Html::img(Model_User::get_picture($user, "message"), array("width" => "35", "height" => "30")));
                    }
             } 

            foreach ($videos as $key => $value) {
                    $video = Model_Videoke::find($value['id']);
                    $user = Model_User::find($video->user_id);
                    $title = $video->title;
                    if (substr(strtolower($video->title),0,$latestQueryLength) == strtolower($latestQuery)){
                        $words[Html::anchor("videos/show/$video->id", $video->title)]=$title;
                        $search_result[Html::anchor("videos/show/$video->id", $video->title)]=Html::anchor("videos/show/" . $video->id, Html::img($video->get_picture($video->user, Model_Videoke::THUMB_HOME), array("width" => "35", "height" => "30"))); 
                    }
                    
             }
            

             $response->body(json_encode(array(
                        'status' => true,
                        'result' => $search_result,
                        'word' => $words,
                        
                    ))); 

        return $response;
       
    }

 
    public function action_show($user_id) {
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
        // $view->comments_counter = $comments_query->count();
        $view->videokes_count = count($videokes_query);
        $view->videokes = $videokes_query;
        $_SESSION['profile_videos'] = $videokes_query;
        $_SESSION['first_round'] = 1;
        $_SESSION['profile_video_counter'] = 9;
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


        $view->followers_count = count($visitor->followers());


        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);

        $view->set_global('page_js', 'users/show.js');

        $this->template->title = "Hip Hop Raw &raquo; Profile";
        $this->template->content = $view;
    }

public function action_show_more_videos() {

          $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
        //$random_videokes = $_SESSION['random_videokes']->limit($_SESSION['counter'])->get();
        
        

                $random_videokes_orginals = $_SESSION['profile_videos'];
                $counter_remove = 0;
                foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
                    unset($random_videokes_orginals[$key]);
                         $counter_remove++;
                    if ($counter_remove == 9) {
                         break;
                    }
                }
                $_SESSION['profile_videos'] = $random_videokes_orginals;
                $random_videokes = array();
                $counter_display = 0;
                foreach ($random_videokes_orginals as $random_videokes_orginal) {
                        array_push($random_videokes, $random_videokes_orginal);
                        $counter_display++;
                if ($counter_display == 9) {
                    break;
                }
            }


        if (count($random_videokes) < 9) {
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
                'html' => View::forge('users/partials/profile_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
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
    public function action_edit() {

        //Response::redirect("videokes/index/" . $this->current_user->id);

        $view = View::forge('users/edit');
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        $view->friends = $visitor->friends();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());

        $view->route = Uri::segments();

        $gender_list = array('0' => "Please Select");
        foreach (Model_Gender::find("all") as $gender) {
            $gender_list["$gender->id"] = $gender->name;
        }
        $view->gender_list = $gender_list;

        $categories = array();
        foreach (Model_Category::find("all") as $category) {
            $categories["$category->id"] = $category->name;
        }
        $view->categories = $categories;


        $view->set_global('page_css', 'users/edit.css');
        $view->set_global('page_css', 'pages/settings.css');
        $view->set_global('page_js', 'users/edit.js');

        $this->template->title = "Hip Hop Raw &raquo; Build Your Profile";
        $this->template->content = $view;
    }

    public function action_update() {
        if (Input::post()) {

            $post = Input::post();
            $user = $this->current_user;

            $upload_file = Input::file("profile_picture");

            if ($upload_file["size"] > 0) {
                // Custom configuration for this upload
                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_User::clean_name($user->username),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                // process the uploaded files in $_FILES
                Upload::process($config);

                // if there are any valid files
                if (Upload::is_valid()) {
                    // save them according to the config
                    Upload::save();

                    $file = Upload::get_files(0);

                    //Resize image
                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_User::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }

                    // Update user profile information
                    $post["profile_picture"] = $file['saved_as'];
                }

                // and process any errors
                foreach (Upload::get_errors() as $file) {
                    // $file is an array with all file information,
                    // $file['errors'] contains an array of all error occurred
                    // each array element is an an array containing 'error' and 'message'
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            }

            if (isset($post['redirect'])) {
                $redirect = $post['redirect'];
                if ($redirect == "Save") {
                    $redirect = "users/show/" . $this->current_user->id;
                } else if ($redirect == "Upload a Video") {
                    $redirect = 'videos/new';
                }
                unset($post['redirect']);
            } else {
                $redirect = "users/show/" . $this->current_user->id;
            }

            Auth::update_user($post);
            $current_password_not_correct = false;
            if (isset($post["old_password"]) && $post["old_password"] != "") {
                $old_password = $post["old_password"];
                $new_password = $post["new_password"];
                if (!Auth::change_password($old_password, $new_password)) {
                    $current_password_not_correct = true;
                }
            }
            if ($current_password_not_correct) {
                //redirect to settings page with error message
                $redirect = "pages/settings/" . $current_password_not_correct;
                Response::redirect($redirect);
            } else {
                Session::set_flash("success", "Your profile information is successfully updated!");
                Response::redirect($redirect);
            }
        }

        Response::redirect("users/edit");
    }

    public function action_hhrnews() {
        $this->template = \View::forge('layout/user-template');
        $view = View::forge('users/hhrnews');
        $view->set_global("active_page", "HHR News");
        $view->set_global('page_css', 'pages/hhrnews.css');
        $view->set_global('page_js', 'users/hhrnews.js');

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
        $_SESSION['hhrnews_logged_video_count'] = 8;

        $view->latest_videokes = Model_Videoke::query()
                ->where('is_blocked', 0)
                ->order_by('created_at', 'desc')
                ->limit(6)->get();
        //Check notification for this page
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
        $view->banners = $banners;

         $sponsors = Model_Sponsor::query()
        ->get();
        
        $view->sponsors = $sponsors;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; HHR NEWS';
        $this->template->content = $view;
    }

    public function action_home() {
        $CATEGORY_HIP_HOP_VIDEO = 1;
        $view = View::forge('users/home');

        $view->set_global("active_page", "home");
        $view->set_global('page_css', 'users/home.css');
        $view->set_global('page_js', 'users/home.js');
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $random_videokes = Model_Videoke::query()
                ->where('is_blocked', 0)
                ->where('created_at', "<", $ten_minutes_ago)
                ->order_by(DB::expr('RAND()'))->get();


        $view->random_videokes = $random_videokes;
        // $videos_to_delete = Model_Featuredvideo::find("all");
        // foreach($videos_to_delete as $f_delete){

        //         $f_delete->delete();

        // }
        $featured_videos = Model_Featuredvideo::query()
            ->where('page', 'home')->order_by('created_at', 'desc')->limit(4)->get();
        $view->featured_videos = $featured_videos;
        $_SESSION['loggedin_home_videos'] = $random_videokes;
        $_SESSION['home_loggedin_videos'] = 8;
        //Check notification for this page
        $notification = Model_Notification::find('last', array(
            "where" => array(
                array("page", "Videos")
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


        // $ads = Model_Banner::query()
        // ->where('page', 'Home')
        // ->where('position', 'Bottom')
        // ->get();
        // $view->ads = $ads;

         $view->sponsors = $sponsors;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;

        $this->template->title = 'Hiphopraw &raquo; Home';
        $this->template->content = $view;
    }

    public function action_top_video() {

        $view = View::forge('users/top_video');
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->followers = $visitor->followers();
        $view->friends = $visitor->friends();
        $view->set_global("active_page", "Top Video");
        $view->set_global('page_css', 'users/top_video.css');
        $view->set_global('page_js', 'users/top_video.js');

        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;

        $view->top_100_videos = Model_Videoke::query()
                ->where('is_blocked', 0)
               // ->where('created_at', "<", $ten_minutes_ago)
                ->where('youtube_link', 0)
                ->order_by('views', 'desc')
                ->limit(100)->get();
       
        $_SESSION['top_video_counter'] = 30;

        //Get all banners for this page
        $banners = Model_Banner::query()
        ->where('page', 'Top 100 videos')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;

        $this->template->title = 'Hiphopraw &raquo; Top 100 Videos';
        $this->template->content = $view;
    }

    public function action_model() {
        $CATEGORY_MODEL = 2;
        $view = View::forge('users/model');

        $view->set_global("active_page", "models");
        $view->set_global('page_css', 'users/model.css');
        $view->set_global('page_js', 'users/model.js');

        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        $random_videokes = Model_Videoke::query()
                ->where('is_blocked', 0)
                ->where('category_id', $CATEGORY_MODEL)
                ->where('created_at', "<", $ten_minutes_ago)
                ->order_by(DB::expr('RAND()'))->get();

        //print_r(count($random_videokes));
        //die;

        $featured_videos = Model_Featuredvideo::query()
            ->where('page', 'models')->order_by('created_at', 'desc')->limit(4)->get();
        $view->featured_videos = $featured_videos;
        $view->random_videokes = $random_videokes;
        $_SESSION['model_videos'] = $random_videokes;
        $_SESSION['model_logged_video_count'] = 8;
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
        
        $view->sponsors = $sponsors;

        $view->first_left_banner = $first_left_banner;
        $view->first_right_banner = $first_right_banner;

        $view->notification = $notification;
        $this->template->title = 'Hiphopraw &raquo; Models';
        $this->template->content = $view;
    }

    public function action_followers($user_id = null) {
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

        $this->template->title = 'Hiphopraw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_friends($user_id = null) {
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
        $view->set_global('page_js', 'users/show.js');
        $this->template->title = 'Hiphopraw &raquo; Profile';
        $this->template->content = $view;
    }

    public function action_home_login($user_id = null) {

        if (!$user_id) {
            parent::check_permission();
            $user_id = Auth::get_user_id();
            $user_id = $user_id[1];
        }


        $view = View::forge('users/home_login');

        if ($user = Model_User::find($user_id)) {
            $videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->limit(6)->get();

            $now = new DateTime();
            $now_timestamp_seconds = $now->getTimestamp();
            $ten_minutes_in_seconds = 10 * 60;
            $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
            $view->suggestions = Model_Videoke::query()
                    ->where('is_blocked', 0)
                    ->where('user_id', '!=', $user->id)
                    ->where('created_at', "<", $ten_minutes_ago)
                    ->order_by(DB::expr('RAND()'))
                    ->limit(5)->get();

            $view->user = $user;
            $view->count = sizeof($videokes);
            $view->videokes = $videokes;
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
//            $view->pagination = $pagination;
//            $view->videokes = $videokes
//                ->order_by('created_at', 'desc')
//                ->offset($pagination->offset)
//                ->limit($pagination->per_page)
//                ->get();
        } else {
            Response::redirect(Router::get("browse"));
        }

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


        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor1->followers());
        $view->set_global('page_css', 'users/home_login.css');
        $view->set_global('page_js', 'users/home_login.js');

        $this->template->title = 'Hip Hop Raw &raquo; Home';
        $this->template->content = $view;
    }

    public function action_comments($user_id = null) {

        $view = View::forge('users/comments');
        if ($user = Model_User::find($user_id)) {
            $videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->limit(6)->get();

            $now = new DateTime();
            $now_timestamp_seconds = $now->getTimestamp();
            $ten_minutes_in_seconds = 10 * 60;
            $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
            $view->suggestions = Model_Videoke::query()
                    ->where('is_blocked', 0)
                    ->where('user_id', '!=', $user->id)
                    ->where('created_at', "<", $ten_minutes_ago)
                    ->order_by(DB::expr('RAND()'))
                    ->limit(5)->get();

            $view->user = $user;
            $view->count = sizeof($videokes);
            $view->videokes = $videokes;
            // Configure the pagination
            //            $pagination = \Pagination::forge('pagination', array(
            //                'pagination_url' => \Uri::base(false) . 'videokes/index/' . $user->id,
            //                'total_items' => $view->count,
            //                'per_page' => 12,
            //                'uri_segment' => 4,
            //                'num_links' => 5,
            //            ));
            //            $view->pagination = $pagination;
            //            $view->videokes = $videokes
            //                ->order_by('created_at', 'desc')
            //                ->offset($pagination->offset)
            //                ->limit($pagination->per_page)
            //                ->get();
        } else {
            Response::redirect(Router::get("browse"));
        }

        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0);

            $view->comments_counter = $comments->count();
            $view->comments = $comments
                ->order_by('created_at', 'desc')
                ->get();
        } else {
            $view->comments = array();
            $view->comments_counter = 0;
        }
        $_SESSION['main_comments_counter'] = 0;
        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $view->followers = $visitor->followers();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());
        $view->set_global('page_css', 'users/home_login.css');
        $view->set_global('page_js', 'users/home_login.js');

        $this->template->title = 'Hip Hop Raw &raquo; Comments';
        $this->template->content = $view;
    }

    public function action_comment($user_id = null) {
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

    public function action_my_followers($user_id = null) {
        $view = View::forge('users/my_followers');

        /* }  */
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->friends = $visitor->friends();
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
        $view->followers_count = count($visitor->followers());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/my_followrs.css');

        $this->template->title = 'Hiphopraw &raquo; My followers';
        $this->template->content = $view;
    }

    public function action_show_following($user_id = null) {
        $view = View::forge('users/show_me');

        /* }  */
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->friends = $visitor->friends();
        $view->followers = $visitor->followers();
        $view->following = $visitor->following();
        // Get Profile Videokes
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0);

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
        $view->followers_count = count($visitor->followers());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/my_followrs.css');

        $this->template->title = 'Hiphopraw &raquo; My following';
        $this->template->content = $view;
    }
    public function action_list_friends($alphabet=null, $page=null) {
        $view = View::forge('users/my_friends');
        $alphabet = isset($alphabet) ? $alphabet : "A";
        $page =  isset($page) ? $page : 1;
        $user_id = $this->current_user->id;



        $users_list = Model_Friendship::query()->where('receiver_id',$user_id )->where('status','accepted'); 
        $view->total_users = $users_list->count();
        $friends=array();
        $counter = 0;
             foreach ($users_list as $key => $value) {

                    $friends[$counter] = Model_User::find($value['sender_id']);
                    $counter++;

                }

        $users_list = $friends->where('username', 'like', $alphabet . '%');
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

        $view->friends = $users_list;
        $view->current_user = $this->current_user;
        $view->set_global('page_css', 'users/my_friends.css');
        $view->set_global('page_js', 'users/my_friends.js');
        $this->template->title = 'Hiphopraw &raquo; My Friends';
  
        $this->template->content = $view;
    }
    public function action_my_friends($alphabet=null, $page=null) {

        $view = View::forge('users/my_friends');
        $alphabet = isset($alphabet) ? $alphabet : "A";
        $page =  isset($page) ? $page : 1;

        /* }  */
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);

        $view->total_friends = $visitor->friends();

        
        $view->friends = $visitor->friendsalpha($alphabet);

        $view->followers = $visitor->followers();
        $view->new_friends = $visitor->new_friends();
        //$view->followers = $visitor->followers();
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
        $view->followers_count = count($visitor->followers());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/my_friends.css');
        $view->set_global('page_js', 'users/my_friends.js');
        $this->template->title = 'Hiphopraw &raquo; My Friends';
        $this->template->content = $view;
    }
    public function action_chat_friends() {

        $response = Response::forge();
        $friends_usernames = array();
        $friends_state = array();

        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user_id = $this->current_user->id;
            $user = Model_User::find($user_id);
            $friends = $user->friends();

            
            if($friends){
                foreach ($friends as $friend) {
                    $online_user = \Auth\Model\Auth_User::find($friend->user_id);
                    if($online_user) {
                        $friends_state[$online_user->username] = $online_user->state;
                        array_push($friends_usernames, $online_user->username);
                    }
                }
            }

            $response->body(json_encode(array(
                'status' => true,
                'friends_usernames' => $friends_usernames,
                'friends_state' => $friends_state,
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_friends_state($roomuser) {

        $response = Response::forge();
        

        if (Input::method() == 'POST' or Input::is_ajax()) {
            
            $user = Model_User::query()->where('username', $roomuser)->get();
                  
                  
                  
            foreach ($user as $u){
                $friends_state= $u->state;           
            }
            
            $response->body(json_encode(array(
                'status' => true,
                'friends_state' => $friends_state,
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
    public function action_get_profile_picture() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                
                
                    $response->body(json_encode(array(
                        'status' => true,
                        'profile_picture' => Model_User::get_picture($user, "message"),
                    )));
                               
            }
            
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
    public function action_get_dialog_profile_picture() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                
                
                    $response->body(json_encode(array(
                        'status' => true,
                        'profile_picture' => Model_User::get_picture($user, "video"),
                    )));
                               
            }
            
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
        
    public function action_my_contest() {



        $view = View::forge('users/my_contest');
        $view->model_contest = new Model_Contest();
        /* }  */
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->friends = $visitor->friends();
        $view->followers = $visitor->followers();
        $view->new_friends = $visitor->new_friends();

        $view->my_active_contests = Model_Contest::query()
            ->where('status', 'active')
            ->related('category')
            ->related('videokes', array(
                'where' => array(
                    'user_id' => $this->current_user->id,
                ),
            ))->get();

         

        $contest_hiphop = 1;
        $contest_model = 2;    
        $status = 'active';

       $view->contest = $view->model_contest-> getByStatus($contest_hiphop, $status);
       $view->contest1 = $view->model_contest->getByStatus($contest_model, $status);     

       $active_contest =$view->model_contest->getByStatus($contest_hiphop, $status);

       $active_time = $active_contest['start_time'];

       $view->active_time = $active_time;

      // print_r(  $contest_hiphop );
       //die;
      // $view->contest = $view->model_contest-> getByID($contest_hiphop);
       
       //$view->contest1 = $view->model_contest-> getByID($contest_hiphop);
        
        $videokes_query = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('is_blocked', 0);
        //$result = DB::query("select id from contests_videos where contest_id = $contest_id")->as_assoc()->execute();
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

        $hiphopvideos = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('category_id', 1)
            ->get();
        $modelvideos = Model_Videoke::query()
            ->where('user_id', $user_id)
            ->where('category_id', 2)
            ->get();

        $view->hiphopv = $hiphopvideos;
        $view->modelv = $modelvideos;

        // Get Profile Friends
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());
        //$view->friends = $view->user->friends(Model_User::PROFILE_FRIENDS_LIMIT);
        $view->set_global('page_css', 'users/my_contest.css');
        $view->set_global('page_js', 'users/my_friends.js');
        $this->template->title = 'Hiphopraw &raquo; My Contest';
        $this->template->content = $view;
    }

    public function action_contest_bracket() {



        $view = View::forge('users/contest_bracket');
        $user_id = $this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
        $view->this_user=$user_id;
        $view->friends = $visitor->friends();
        $view->followers = $visitor->followers();
        $view->new_friends = $visitor->new_friends();



        $model_contest = new Model_Contest();
        $view->model_contest = $model_contest;


        $contest_hiphop = 1;
        $contest_model = 2;    
        $status = 'active';

       $view->contest = $view->model_contest-> getByStatus($contest_hiphop, $status);
       $view->contest1 = $view->model_contest->getByStatus($contest_model, $status);  


       $curtime = time();
       
        
       if( (($curtime >= (intval($view->contest['start_time'])+ 604800)) && ($curtime < (intval($view->contest['start_time'])+ 1209600))) && (intval($view->contest['current_round'] == 1))){
           $model_contest->computeEndofRounds();
        }

      elseif( (($curtime >= (intval($view->contest['start_time'])+ 1209600)) && ($curtime < (intval($view->contest['start_time'])+ 1814400))) && (intval($view->contest['current_round']) == 2)  ){
            $model_contest->computeEndofRounds();
        }
       else if ( (($curtime >=(intval($view->contest['start_time'])+ 1814400))&& ($curtime < (intval($view->contest['start_time'])+  2419200))) && (intval($view->contest['current_round']) == 3)  ){
            $model_contest->computeEndofRounds();
        }
        else if ( (($curtime >=(intval($view->contest['start_time'])+ 2419200)) && ($curtime <(intval($view->contest['end_time'])))) && (intval($view->contest['current_round']) == 4)  ){
            $model_contest->computeEndofRounds();
        } 


        if( (($curtime >= (intval($view->contest1['start_time'])+ 604800)) && ($curtime < (intval($view->contest1['start_time'])+ 1209600))) && (intval($view->contest1['current_round'] == 1))){
           $model_contest->computeEndofRounds();
        }

      elseif( (($curtime >= (intval($view->contest1['start_time'])+ 1209600)) && ($curtime < (intval($view->contest1['start_time'])+ 1814400))) && (intval($view->contest1['current_round']) == 2)  ){
            $model_contest->computeEndofRounds();
        }
       else if ( (($curtime >=(intval($view->contest1['start_time'])+ 1814400))&& ($curtime < (intval($view->contest1['start_time'])+  2419200))) && (intval($view->contest1['current_round']) == 3)  ){
            $model_contest->computeEndofRounds();
        }
        else if ( (($curtime >=(intval($view->contest1['start_time'])+ 2419200)) && ($curtime <(intval($view->contest1['end_time'])))) && (intval($view->contest1['current_round']) == 4)  ){
            $model_contest->computeEndofRounds();
        } 
  
       
      // $curtime = time();
            
      //  if( (($curtime >= (intval($view->contest['start_time'])+ 600)) && ($curtime < (intval($view->contest['start_time'])+ 1200))) && (intval($view->contest['current_round'] == 1))){
            
      //      $model_contest->computeEndofRounds();
      //   }

      // elseif( (($curtime >= (intval($view->contest['start_time'])+ 1200)) && ($curtime < (intval($view->contest['start_time'])+ 1800))) && (intval($view->contest['current_round']) == 2)  ){
      //       $model_contest->computeEndofRounds();
      //   }
      //  else if ( (($curtime >=(intval($view->contest['start_time'])+ 1800))&& ($curtime < (intval($view->contest['start_time'])+  2400))) && (intval($view->contest['current_round']) == 3)  ){
      //       $model_contest->computeEndofRounds();
      //   }
      //   else if ( (($curtime >=(intval($view->contest['start_time'])+ 2400)) && ($curtime <(intval($view->contest['end_time']))+600)) && (intval($view->contest['current_round']) == 4)  ){
           
      //       $model_contest->computeEndofRounds();
      //   }



      //   if( (($curtime >= (intval($view->contest1['start_time'])+ 600)) && ($curtime < (intval($view->contest1['start_time'])+ 1200))) && (intval($view->contest1['current_round'] == 1))){
            
      //      $model_contest->computeEndofRounds();
      //   }

      // elseif( (($curtime >= (intval($view->contest1['start_time'])+ 1200)) && ($curtime < (intval($view->contest1['start_time'])+ 1800))) && (intval($view->contest1['current_round']) == 2)  ){
      //       $model_contest->computeEndofRounds();
      //   }
      //  else if ( (($curtime >=(intval($view->contest1['start_time'])+ 1800))&& ($curtime < (intval($view->contest1['start_time'])+  2400))) && (intval($view->contest1['current_round']) == 3)  ){
      //       $model_contest->computeEndofRounds();
      //   }
      //   else if ( (($curtime >=(intval($view->contest1['start_time'])+ 2400)) && ($curtime <(intval($view->contest1['end_time']))+600)) && (intval($view->contest1['current_round']) == 4)  ){
           
      //       $model_contest->computeEndofRounds();
      //   }
    
  

       
        $view->thevideos = DB::select()->from('contests-videos')->limit(8);
       

        $view->contests = $view->model_contest->getAllContests()->as_array();
        $view->contests1 = $view->model_contest->getAllContests()->as_array();

        $contest_id1 = $view->contest['id'];
        $contest_id2 = $view->contest1['id'];

        
        

        $view->contests_by_category = $view->model_contest->arrangeByCategory($view->contests);
        $view->contests_by_category1 = $view->model_contest->arrangeByCategory($view->contests1);

        $view->contest_videos = $view->model_contest->getVideoRelations($contest_id1); 
        $view->contest_videos1 = $view->model_contest->getVideoRelations($contest_id2); 
        
        $view->current =  $view->contest1['start_time']+1200;
        
       

        $view->videos = array();
        $view->videos1 = array();

        foreach ($view->contest_videos as $idx => $rel) {


            $view->contest_videos[$idx]['video'] = Model_Videoke::query()->where('id', $rel['video_id'])->get();
        
        }

        foreach ($view->contest_videos1 as $idx => $rel) {


            $view->contest_videos1[$idx]['video'] = Model_Videoke::query()->where('id', $rel['video_id'])->get();
        
        }
        
        $banners = Model_Banner::query()
        ->where('page', 'Top 100 videos')
        ->where('position', 'Top')
        ->get();
        $view->banners = $banners;


        $view->round = array();
        $view->round1 = array();

        for ($round = 2; $round <= $view->contest['current_round']; $round++) {

            $view->round[$round] = $view->model_contest->pairVideos($view->contest_videos, $round);
        }
        

        for ($round = 2; $round <= $view->contest['current_round']; $round++) {

            $view->round1[$round] = $view->model_contest->pairVideos($view->contest_videos1, $round);
        }
        
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor->followers());
        $view->set_global('page_css', 'users/contest_bracket.css');
        $view->set_global('page_js', 'users/contest_bracket.js');
        $this->template->title = 'Hiphopraw &raquo; My Contest';
        $this->template->content = $view;
    }

     public function action_contest_join() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }

        $selected_videos = json_decode(Input::post("selected_videos"));
       
        $submitted_videos = array();

        foreach($selected_videos as $selected_video) {

            $submitted_videos = DB::query("SELECT * FROM contests_videos WHERE contest_id='".$selected_video->contest_id."' AND video_id='". $selected_video->video_id."'")->as_assoc()->execute();

               if(count($submitted_videos)==0) {
                    $newrow = array();
                    $newrow['contest_id'] = $selected_video->contest_id;
                    $newrow['video_id'] = $selected_video->video_id;
                    $newrow['round_id'] = 1;
                    $newrow['paired_with'] = 0;
                    $newrow['status'] = 'PENDING';
                    $newrow['winner'] = 'undetermined';
                    $newrow['created_at'] = strtotime('now');

                    DB::insert('contests_videos')->set($newrow)->execute();

                 }else{
                    $video = Model_Videoke::Find($selected_video->video_id);
                    $submitted_videos[]=$video->title;
                 }
                
          
        } 
        
        $response->body(json_encode(array(
                     'status' => true,
                     'submitted'=>$submitted_videos,
                     'message' => "Your Video have been submitted to this contest successfully",
                 )));
        return $response;
   } 

    public function action_videos_logged_show_more() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }


        $random_videokes_orginals = $_SESSION['loggedin_home_videos'];
        $counter_remove = 0;
        foreach ($random_videokes_orginals as $key => $random_videokes_orginal) {
            unset($random_videokes_orginals[$key]);
            $counter_remove++;
            if ($counter_remove == 8) {
                break;
            }
        }
        $_SESSION['loggedin_home_videos'] = $random_videokes_orginals;
        $random_videokes = array();
        $counter_display = 0;
        foreach ($random_videokes_orginals as $random_videokes_orginal) {
            array_push($random_videokes, $random_videokes_orginal);
            $counter_display++;
            if ($counter_display == 8) {
                break;
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
                'html' => View::forge('users/partials/videos_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
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

    public function action_model_logged_show_more() {
        $response = Response::forge();
        $CATEGORY_MODEL = 2;
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
 
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
                'html' => View::forge('users/partials/models_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
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

    public function action_hhrnews_logged_show_more() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
        
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
                'html' => View::forge('users/partials/hhrnews_single_view_more', array("random_videokes" => $random_videokes, "page_no" => Input::post("page_no")))->render(),
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

    public function action_top_video_show_more() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
        //$random_videokes = $_SESSION['random_videokes']->limit($_SESSION['counter'])->get();
        $now = new DateTime();
        $now_timestamp_seconds = $now->getTimestamp();
        $ten_minutes_in_seconds = 10 * 60;
        $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;

        $top_100_videos = Model_Videoke::query()
                ->where('is_blocked', 0)
                ->where('created_at', "<", $ten_minutes_ago)
                ->order_by('views', 'desc')
                ->limit(10)->offset($_SESSION['top_video_counter'])->get();
        $_SESSION['top_video_counter'] = $_SESSION['top_video_counter'] + 10;
        if (count($top_100_videos) < 10) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }
        if ($top_100_videos) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'html' => View::forge('users/partials/top_video_single_view_more', array("top_100_videos" => $top_100_videos, 'counter' => $_SESSION['top_video_counter']))->render(),
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

    public function action_comments_show_more() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or ! Input::is_ajax()) {
            return $response->set_status(400);
        }
        $user_id = $this->current_user->id;
        $result = DB::query("select id from videokes where user_id = $user_id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');

        if ($result->count() > 0) {
            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->order_by('created_at', 'desc')->limit(5)->offset($_SESSION['main_comments_counter'])->get();
            ;
        }
        $_SESSION['main_comments_counter'] = $_SESSION['main_comments_counter'] + 5;
        if (count($comments) < 5) {
            $identifier = 1;
        } else {
            $identifier = 0;
        }
        if ($comments) {
            //$videoke = Model_Videoke::find($comment->videoke_id);
            $response->body(json_encode(array(
                'status' => true,
                'identifier' => $identifier,
                'html' => View::forge('users/partials/comments_view_more', array("comments" => $comments))->render(),
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

}
