<?php

class Controller_Favorite extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_save() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            if (!Model_Profile::find(Input::post("favorite_member_id"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to save as favorite does not exist!"
                )));
            }
            else if(Input::post("member_id") !== $this->current_profile->id) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "You should be a member to save a member as favorite!"
                )));
            }
            else if(Model_Favorite::favorite_exists($this->current_profile->id, Input::post("favorite_member_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A member is already saved as favorite!"
                )));
            } else {
                $favorite = Model_Favorite::forge(array(
                    "member_id" => $this->current_profile->id,
                    "favorite_member_id" => Input::post("favorite_member_id")
                ));
                $favorite->save();

                //Notification for favorite receiver
                Model_Notification::save_notifications(
                    Model_Notification::SAVED_AS_FAVORITE,
                    $favorite->id,
                    $favorite->favorite_member_id,
                    $this->current_profile->id
                );

                $notification_profile = Model_Profile::find($favorite->favorite_member_id);
                $notification_user = Model_Users::find($notification_profile->user_id);

                if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                    ->html_body(View::forge('email/notification', array("notification" => Model_Profile::get_username($this->current_profile->user_id) ." has saved you as favorite.")))->priority(\Email\Email::P_HIGH)->send();
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "You have saved  <strong>" . Model_Profile::get_username($notification_profile->user_id) . "</strong> as Favorite.",
                )));
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_favorite_exists() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $response->body(json_encode(array(
                'status' => Model_Favorite::favorite_exists(Input::post("member_id"), Input::post("favorite_member_id")),
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
}