<?php

class Controller_Notification extends Controller_Base
{
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }


    public function action_mark_as_seen($notification_id)
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('page/404');

        $response = \Fuel\Core\Response::forge();

        if(Model_Notification::mark_as_seen($notification_id))
        {
            $response->body(json_encode(
                array('status' => true)
            ));

            return $response;
        }

        $response->body(json_encode(
            array('status' => false)
        ));

        return false;
    }

    public function action_create_chat_notification() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    Model_Notification::save_notifications(
                        Model_Notification::CHAT_REQUEST_SENT,
                        0,
                        $profile->id,
                        $this->current_profile->id
                    );

                    if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                        Email::forge()->to($user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a chat request.")))->priority(\Email\Email::P_HIGH)->send();
                    }
                    $response->body(json_encode(array(
                        'status' => true,
                        'message' => "The chat notification successfully sent",
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



}