<?php

class Controller_Friendship extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_request() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            if (!Model_Profile::find(Input::post("receiver_id"))) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "The user you are trying to send a friend request to does not exist!"
                )));
            }
            else if(Input::post("sender_id") !== $this->current_profile->id) {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A friend request sender does not exist!"
                )));
            }
            else if($already_sent = Model_Friendship::request_exchanged($this->current_profile->id, Input::post("receiver_id"))){
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "A friend request has already been exchanged with this person!"
                )));
            } else {

                $friendship = Model_Friendship::forge(array(
                    "sender_id" => $this->current_profile->id,
                    "receiver_id" => Input::post("receiver_id"),
                    "status" => Model_Friendship::STATUS_SENT
                ));
                $friendship->save();
                $receiver = Model_Profile::find($friendship->receiver_id);
                $response->body(json_encode(array(
                    'status' => true,
                    'message' => "Your friendship request sent to <strong>" . Model_Profile::get_username($receiver->user_id). "</strong>",
                )));
            }

            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_update() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $receiver_id = $this->current_profile->id;
            $sender_id = Input::post("sender_id");

            $friendship =Model_Friendship::query()->where("sender_id", "=", $sender_id)
                                                    ->where("receiver_id", "=", $receiver_id)->get_one();

            if ($friendship) {
                $friendship->status = Input::post("status");

                if($friendship->status === Model_Friendship::STATUS_REJECTED){
                    $friendship->delete();
                } else {
                    $friendship->save();
                }

                if($friendship->status == Model_Friendship::STATUS_ACCEPTED){
                    $response_message = "Friendship request accepted.";
                }else if($friendship->status == Model_Friendship::STATUS_REJECTED){
                    $response_message =  "Friendship request denied.";
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => $response_message,
                )));
            } else {
                $response->body(json_encode(array(
                    'status' => false,
                    'message' => "Friendship request does not exist!",
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_manage_friends() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $current_profile_id = $this->current_profile->id;
            $friend_id = Input::post("friend_id");

            $friendship = Model_Friendship::query()->and_where_open()
                ->where("sender_id", "=", $current_profile_id)
                ->where("receiver_id", "=", $friend_id)
                ->and_where_close()
                ->or_where_open()
                ->where("sender_id", "=", $friend_id)
                ->where("receiver_id", "=", $current_profile_id)
                ->or_where_close()
                ->get_one();

            if ($friendship) {
                $friendship->status = Input::post("status");

                if($friendship->status === Model_Friendship::STATUS_DELETED){
                    $friendship->delete();
                } else {
                    $friendship->save();
                }

                if($friendship->status == Model_Friendship::STATUS_BLOCKED){
                    $response_message = "Friend has been blocked.";
                }else if($friendship->status == Model_Friendship::STATUS_DELETED){
                    $response_message =  "Friend has been deleted.";
                }

                $response->body(json_encode(array(
                    'status' => true,
                    'message' => $response_message,
                )));
            } else {
                $response->set_status(500);
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }

    public function action_get_friends_usernames() {
        $response = Response::forge();
        $friends_usernames = array();

        if (Input::method() == 'POST' or Input::is_ajax()) {
            $friends = Model_Friendship::get_friends($this->current_profile->id);
            if($friends){
                foreach ($friends as $friend) {
                    $user = \Auth\Model\Auth_User::find($friend->user_id);
                    if($user) {
                        array_push($friends_usernames, $user->username);
                    }
                }
            }
            $response->body(json_encode(array(
                'status' => true,
                'friends_usernames' => $friends_usernames,
            )));
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
}