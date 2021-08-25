<?php

class Controller_Invites extends Controller_Base {

    public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array();

        parent::check_permission($login_exception);
    }

    public function action_send() {

        $view = View::forge('invites/send');
		$user_id=$this->current_user->id;
        $view->user = Model_User::find($user_id);
        $visitor = Model_User::find($user_id);
		$view->friends = $visitor->friends();
        $view->followers = $visitor->followers();
		$view->followers_count = count($visitor->followers());
       $view->friends_count = count($visitor->friends());
        if (Input::post()) {

            $val = Validation::forge();

            $val->add_callable('CustomRules');

            $val->add('emails', 'Email Addresses')
                    ->add_rule('required')
                    ->add_rule('multiple_emails');

            $val->add('message', 'Message')
                    ->add_rule('required');

            if ($val->run()) {

                $emails = explode(",", Input::post("emails"));

                foreach ($emails as $email) {
                    $email = trim($email);

                    // Save invitation
                    Model_Invite::forge(array(
                        "sender_id" => $this->current_user->id,
                        "friend_email" => $email,
                        "message" => Input::post("message")
                    ))->save();

                    // Send invitation email
                    try {
                        Email::forge()
                                ->to($email)
                                ->from("noreply@hiphopraw.com","Hip Hop Raw")
                                ->subject("Invitation to join hiphopraw.com")
                                ->html_body(View::forge('email/invite_friend', array("message" => Input::post("message"))))
                                ->send();

                        Session::set_flash("success", "Your invitation has been sent!");
                       // Response::redirect("users/show/" . $this->current_user->id);
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("error", "Your invitation could not be sent, please contact the Administrator for further instructions.");
                        Response::redirect(Router::get("invite"));
                    }
                }
            }
            $view->val = $val;
        }

        //$view->set_global('page_css', 'invites/send.css');
        $view->set_global('page_css', 'pages/settings.css');
        $view->set_global('page_js', 'invites/send.js');

        $this->template->title = 'Hip Hop Raw &raquo; Invite a Friend';
        $this->template->content = $view;
    }

    public function action_create_ajax() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $val = Validation::forge();

        $val->add_callable('CustomRules');

        $val->add('emails', 'Email Addresses')
                ->add_rule('required')
                ->add_rule('multiple_emails');

        $val->add('message', 'Message')
                ->add_rule('required');

        if ($val->run()) {
            $emails = explode(",", Input::post("emails"));

            foreach ($emails as $email) {
                $email = trim($email);

                // Save invitation
                Model_Invite::forge(array(
                    "sender_id" => $this->current_user->id,
                    "friend_email" => $email,
                    "message" => Input::post("message")
                ))->save();

                // Send invitation email
                try {
                    $name = ($this->current_user->stage_name && $this->current_user->stage_name) ? $this->current_user->stage_name  : $this->current_user->username;
                    Email::forge()
                            ->to($email)
                            ->from("noreply@hiphopraw.com","Hip Hop Raw")
                            ->subject("$name has shared content with you on hiphopraw.com")
                            ->html_body(View::forge('email/share_videoke', array("message" => Input::post("message"), "videoke_id" => Input::post("videoke_id"))))
                            ->send();
                    $response->body(json_encode(array(
                        'status' => true,
                        'heading' => "Shared!",
                        'message' => "Video shared with contacts.",
                    )));
                } catch (EmailSendingFailedException $e) {
                    return $response->set_status(500);
                }
            }
        } else {
            $response->body(json_encode(array(
                'status' => false,
                'heading' => "Error!",
                'validation' => array(
                    $val->error('emails')->get_message(),
                    $val->error('message')->get_message()
                )
            )));
        }

        return $response;
    }

}
