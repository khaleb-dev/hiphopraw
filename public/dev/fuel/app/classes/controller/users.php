<?php

class Controller_Users extends Controller_Base {

    public $template = 'layout/template';

    public function before() {
        parent::before();

        $login_exception = array("login", "sign_up", "activate", "forgot_password", "reset_password", "reset", "index", "show", "resend_activation", "send_activation");

        parent::check_permission($login_exception);
    }

    public function action_login() {

        if ($this->current_user) {
            Response::redirect("profile/dashboard/");
        }

        $view = View::forge('users/login');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);

            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255);

            if ($val->run()) {

                $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")), 'or' => array(array('email', Input::post("username")),),)));
                if(isset($user)) {
                    $objProfile = Model_Profile::find('first', array(
                        'where' => array(
                            array('user_id', $user->id),
                        ),
                    ));

                    if(isset($objProfile)) {
                        if (isset($objProfile) && !$objProfile->is_activated) {
                            Response::redirect("users/resend_activation/msg");
                        }

                        if (isset($objProfile) && $objProfile->is_blocked) {
                            Session::set_flash('error', 'Your account is blocked. Please contact TMYW admin for solution.');
                            Response::redirect(Router::get("login"));
                        }
                         if (isset($objProfile) && $objProfile->disable==1) {
                            Session::set_flash('error', 'Your Profile has been disabled, Please contact the Whereweallmeet.com support team for assistance');
                            Response::redirect(Router::get("login"));
                        }

                        if (Auth::login()) {
                        $objProfile->is_logged_in = 1;
                        $objProfile->save();

                        if ($user->group_id == 5) {
                            Response::redirect("admin/");
                        } else {
                            if($objProfile->is_completed) {
                                \Fuel\Core\Session::set_flash("logedIn", true);
                                Response::redirect("profile/dashboard");
                            }
                            else {
                                Response::redirect("profile/edit");
                            }
                        }
                    } else {
                        Session::set_flash('error', 'Wrong username/password combination. Please try again!');
                    }
                    } else {
                        Session::set_flash('error', 'The profile does not exist. Please signup again.');
                        Response::redirect(Router::get("login"));
                    }
                }
                else {
                    Session::set_flash('error', 'The user does not exist . Please try again.');
                    Response::redirect(Router::get("login"));
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'users/login.css');

        $this->template->title = "WHERE WE ALL MEET  &raquo; Login";
        $this->template->content = $view;
    }

    public function action_logout() {
        $this->current_profile->is_logged_in = 0;
        $this->current_profile->save();

        Auth::logout();
        Response::redirect('pages/home');
    }

    public function action_chat_login() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_in = 1;
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
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $profile->is_logged_in = 0;
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

    public function action_sign_up() {

        $view = View::forge("users/sign_up");

        if (Input::post()) {
            $post = Input::post();

            $val = Validation::forge();

            $val->add('first_name', 'First Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('last_name', 'Last Name')->add_rule('required')->add_rule('max_length', 255);
            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');
            $val->add('username', 'Username')->add_rule('required')->add_rule('max_length', 255);
            $val->add('password', 'Password')->add_rule('required')->add_rule('max_length', 255)->add_rule('min_length', 6);
            $val->add('confirm_password', 'Confirm Password')->add_rule('match_field', 'password');

            if ($val->run()) {
                try {
                    $activation_code = Crypt::encode($post["username"]);
                    $user_id = Auth::create_user(
                                    $post["username"], $post["password"], $post["email"], 3
                    );

                    if ($user_id) {
                        $post["user_id"] = $user_id;
                        $post["activation_code"] = $activation_code;
                        $post["member_type_id"] = 1; //Free Member
                        $post["is_activated"] = 0;
                        $post["is_completed"] = 0;
                        $post["is_blocked"] = 0;
                        $post["is_logged_in"] = 0;
                        $post["disable"]=0;
                        $profile = Model_Profile::forge($post);
                        $profile->save();
                    }

                    try {
                        Email::forge()->to($post["email"])->from("noreply@whereweallmeet.com")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => $activation_code)))->send();
                        
                        $view->success = true;
                    } catch (EmailSendingFailedException $e) {
                        $view->error = "Your confirmation email could not be sent, please contact the Administrator for further instructions.";
                    }
                } catch (Auth\SimpleUserUpdateException $e) {
                    $view->error = $e->getMessage();
                }
               
                $email = DB::select('refered_email')
                        ->from('referedemails')
                        ->where('refered_email', $_POST['email'])
                        ->execute();
                $num_records = count($email);
                if($num_records > 0) {
                    $email_refered = DB::select('email_from','refered_email')
                                    ->from('referedemails')
                                    ->where('refered_email', $_POST['email'])
                                    ->execute();
                    $sender_email =  $email_refered[0]['email_from'];
                    $refered_email =  $email_refered[0]['refered_email'];
                    $id_ref = DB::select('profiles.id')
                                ->from('profiles')
                                ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                                ->where('email', $refered_email)
                                ->execute();
                    $id_refered =  $id_ref[0]['id'];

                    $email_refered = DB::select('profiles.id')
                                    ->from('profiles')
                                    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                                    ->where('email', $sender_email)
                                    ->execute();
                    $email_sender_id = $email_refered[0]['id'];

                    $email_data["sender_id"] = $id_refered;
                    $email_data["receiver_id"] = $email_sender_id;
                    $email_data["status"] = 'sent';

                    $emails = Model_Friendship::forge($email_data);
                    $emails->save();
                }
            }
            $view->val = $val;
        }
                
        $view->genders = Model_Gender::find('all');
        $view->state = Model_State::find('all');
        $view->set_global('page_css', 'users/sign_up.css');

        $this->template->title = "WHERE WE ALL MEET &raquo;  Sign Up";
        $this->template->content = $view;
    }

    public function action_activate($code) {
        $state = Model_State::find('all');

        $view = View::forge("users/activate");
        $view->state = $state;

        if ($code) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Crypt::decode($code)))));
            if ($user) {
                if (Auth::force_login($user)) {
                    $objProfile = Model_Profile::find('first', array(
                        'where' => array(
                            array('user_id', $user->id),
                        ),
                    ));

                    if($objProfile){
                        $objProfile->is_activated = 1;
                        if($objProfile->save()){
                            $view->success = true;
                            Response::redirect("users/build_profile");
                        }
                        else{
                            $view->success = false;
                            $view->error = "Account activation failed.";
                        }
                    }
                    else {
                        $view->error = "Activation Code not correct, please use the link forwarded to your email." ;
                    }
                }
            } else {
                $view->error = "Activation Code not correct, please use the link forwarded to your email.";
            }
        }

        $this->template->title = "WHERE WE ALL MEET &raquo;  Account Activation";
        $this->template->content = $view;
    }

    public function action_build_profile() {
        $state = Model_State::find('all');
        $view = View::forge("users/build_profile");
        $view->state = $state;

        $view->set_global('page_js', 'users/build_profile.js');
        $view->set_global('page_css', 'users/build_profile.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Account Activation";
        $this->template->content = $view;
    }

    public function action_forgot_password() {
        if ($this->current_user) {
            Response::redirect("profile/dashboard/");
        }

        $view = View::forge('users/forgot_password');

        if (Input::post()) {

            $val = Validation::forge();

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if ($val->run()) {
                $user = \Model\Auth_User::find('first', array("where" => array(array("email", Input::post("email")))));
                if ($user) {

                    $reset_code = Crypt::encode($user->username);
                    try {
                        Email::forge()->to(Input::post("email"))->from("noreply@whereweallmeet.com")->subject("Forgot Password")->html_body(View::forge('email/forgot_password', array("reset_code" => $reset_code)))->send();

                        Session::set_flash("success", "Your password reset email is successfully sent. Please use the link provided in the email to reset your password.");
                        Response::redirect("users/login");
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error", "Your password recovery email could not be sent, please contact the Administrator for further instructions.");
                    }
                } else {
                    Session::set_flash("error", "Your email is not registered. Please Sign Up to get a new account!");
                }
            }
            $view->val = $val;
        }

        $view->set_global('page_css', 'users/forgot_password.css');

        $this->template->title = "WHERE WE ALL MEET &raquo; Forgot Password";
        $this->template->content = $view;
    }

    public function action_reset_password($code) {

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
                Response::redirect("users/login");
            }
        } else {
            Session::set_flash("error", "Please use the link provided in your the email to reset your password.");
            Response::redirect("login");
        }

        $view->set_global('page_css', 'users/forgot_password.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Reset Password";
        $this->template->content = $view;
    }

    public function action_reset() {
        if (Input::post("password")) {
            $old_password = Auth::reset_password(Input::post("username"));
            Auth::change_password($old_password, Input::post("password"), Input::post("username"));

            Session::set_flash("success", "Your password has been successfully reset!");

            Response::redirect("profile/dashboard");
        }
        Response::redirect("users/reset_password/wrong");
    }

    public function action_resend_activation($msg = null) {

        $view = View::forge("users/resend_activation");

        if(isset($msg)) {
            $view->error_message = "Your account is awaiting activation. Please use the link in your conformation email to activate your account or use the form below to resend the activation code";
        }

        $view->set_global('page_css', 'users/forgot_password.css');
        $this->template->title = "WHERE WE ALL MEET &raquo;  Resend Activation";
        $this->template->content = $view;
    }

    public function action_send_activation() {
        if (Input::post()) {
            $val = Validation::forge();

            $val->add('email', 'Email')->add_rule('required')->add_rule('max_length', 255)->add_rule('valid_email');

            if ($val->run()) {
                $user = \Model\Auth_User::find('first', array("where" => array(array("email", Input::post("email")))));
                if ($user) {
                    try {
                        Email::forge()->to(Input::post("email"))->from("noreply@whereweallmeet.com")->subject("Sign Up Confirmation")->html_body(View::forge('email/sign_up', array("activation_code" => Crypt::encode($user->username))))->send();

                        Session::set_flash("success", "Your account activation code has been sent to your email. Please use the link forwarded to your email to activate your account.");
                        Response::redirect(Router::get("login"));
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error", "Your account activation code could not be sent. Please try again.");
                        Response::redirect("users/resend_activation/msg");
                    }
                } else {
                    Session::set_flash("error", "The email doesn't exist. Please try again.");
                    Response::redirect("users/resend_activation");
                }
            } else {
                Session::set_flash("error", "Invalid email. Please try again.");
                Response::redirect("users/resend_activation");
            }

        }
        Response::redirect("users/resend_activation/msg");
    }
}
