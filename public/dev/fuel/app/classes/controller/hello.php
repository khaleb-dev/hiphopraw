<?php

class Controller_Hello extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_send() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            if (!Model_Profile::find(Input::post("to_member_id"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to send a hello does not exist!"
                )));
            }
            else if(Input::post("from_member_id") !== $this->current_profile->id) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "You should be a member to send a hello!"
                )));
            }
            else if(Model_Hello::hello_exists($this->current_profile->id, Input::post("to_member_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A hello is already sent for this member!"
                )));
            } else {
                $hello = Model_Hello::forge(array(
                    "from_member_id" => $this->current_profile->id,
                    "to_member_id" => Input::post("to_member_id")
                ));
                $hello->save();

                //Notification for hello sender
                Model_Notification::save_notifications(
                    Model_Notification::HELLO_SENT,
                    $hello->id,
                    $this->current_profile->id,
                    $this->current_profile->id
                );

                //Notification for hello receiver
                Model_Notification::save_notifications(
                    Model_Notification::HELLO_RECEIVED,
                    $hello->id,
                    $hello->to_member_id,
                    $this->current_profile->id
                );

                $hello_member = Model_Profile::find($hello->to_member_id);
                $hello_user = Model_Users::find($hello_member->user_id);

                if (Model_Setting::is_set_email_notification($this->current_profile->id)){

                    Email::forge()->to($hello_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                    ->html_body(View::forge('email/notification', array("notification" => Model_Profile::get_username($this->current_profile->user_id) ." has sent you a hello.")))->priority(\Email\Email::P_HIGH)->send();
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "You have sent a hello to  <strong>" . Model_Profile::get_username($hello_member->user_id) . "</strong>.",
                )));
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_hello_exists() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $response->body(json_encode(array(
                'status' => Model_Hello::hello_exists(Input::post("from_member_id"), Input::post("to_member_id")),
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
}