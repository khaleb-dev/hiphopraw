<?php

class Controller_Friendships extends Controller_Base {

    public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array();

        parent::check_permission($login_exception);
    }

    public function action_index($user_id = 0, $page = 1) {
        $view = View::forge('friendships/index');

        if($user = Model_User::find($user_id)){

            $view->user = $user;
            $view->count = $user->friends_count();
            $view->videokes_count = Model_Videoke::query()->where('user_id', $user_id)->where('is_blocked', 0)->count();

            // Configure the pagination
            $pagination = \Pagination::forge('pagination', array(
                'pagination_url' => \Uri::base(false).'users/' . $user->id . '/friends/index',
                'total_items' => $view->count,
                'per_page' => 20,
                'uri_segment' => 5,
                'num_links' => 5,
            ));

            $view->pagination = $pagination;
            $view->friends = $user->friends_paged($pagination->per_page, $pagination->offset);

        } else {
            Session::set_flash("error", "Could not find the specified user!");
            Response::redirect("members");
        }

        $view->set_global('page_css', 'friendships/index.css');
        $view->set_global('page_js', 'friendships/index.js');

        $this->template->title = 'Hip Hop Raw &raquo; Friendships ';
        $this->template->content = $view;
    }

    public function action_manage() {
        $view = View::forge('friendships/manage');

        $user = Model_User::find($this->current_user->id);

        $view->new_friends = $user->new_friends();

        $view->friends = $user->friends();

        $view->set_global('page_css', 'friendships/index.css');
        $view->set_global('page_js', 'friendships/index.js');

        $this->template->title = 'Hip Hop Raw &raquo; Friendships ';
        $this->template->content = $view;
    }

    public function action_create() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax() or $this->current_user->id !== Input::Post("sender_id") or $this->current_user->id == Input::Post("receiver_id")) {
            return $response->set_status(400);
        }

        $val = Validation::forge();

        $val->add('detail', 'Friendship')
            ->add_rule('required');

        if (!$receiver = Model_User::find(Input::post("receiver_id"))) {
            $response->body(json_encode(array(
                'status' => false,
                'message' => "The user you are trying to send a friend request to does not exist!"
            )));
        } 
        else if($already_sent = Model_Friendship::request_exchanged($this->current_user->id, Input::post("receiver_id"))){
             $response->body(json_encode(array(
                'status' => false,
                'message' => "A friend request has already been exchanged with this person!"
            )));
        } else {

            $friendship = Model_Friendship::forge(array(
                        "sender_id" => $this->current_user->id,
                        "receiver_id" => Input::post("receiver_id"),
                        "status" => Model_Friendship::STATUS_SENT
            ));
            $friendship->save();

            $res = array();


            $receiver = Model_User::find($friendship->receiver_id);
            $receiver_email = $receiver->email;
            $sender = Model_User::find($friendship->sender_id);
            $sender_name = $sender->username;

                    try {
                        Email::forge()->to($receiver_email)->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject($sender_name." wants to add you on hiphopraw.com")->html_body(View::forge('email/request_friendship'))->send();
                        $res["request_status"] = 'success';
                        $res["email"] = $receiver_email;
                    } catch (EmailSendingFailedException $e) {
                        $res["request_status"] = 'failed';
                        $res["error"] = CANNOT_SEND_EMAIL;
                    }


            $response->body(json_encode(array(
                'status' => true,
                'res' => $res,
                'message' => "Your friendship request sent to <strong>" . Html::anchor("users/show/$receiver->id", $receiver->username) . "</strong>",
            )));
        }

        return $response;
    }

    public function action_show($friendship_id, $user_id) {
        $response = Response::forge();

        if (Input::method() !== 'GET' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        if ($friendship = Model_Friendship::find($friendship_id)) {
            $response->body(json_encode(array(
                'status' => true,
                'html' => View::forge('comments/partials/single', array("comment" => $friendship))->render(),
            )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }

    public function action_update() {
        $response = Response::forge();
        
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $r_id = Input::post("receiver_id");
        $s_id = Input::post("sender_id");

        $friendship = Model_Friendship::query()->and_where_open()
                                                    ->where("sender_id", "=", $s_id)
                                                    ->where("receiver_id", "=", $r_id)
                                                ->and_where_close()
                                                ->or_where_open()
                                                    ->where("sender_id", "=", $r_id)
                                                    ->where("receiver_id", "=", $s_id)
                                                ->or_where_close()
                                                ->get_one();

        if ($friendship) {
            // Update friedship status accepted/rejected/blocked 
            $friendship->status = Input::post("status");
            // If the request was rejected then delete it else save it
            if($friendship->status === Model_Friendship::STATUS_REJECTED || $friendship->status === Model_Friendship::STATUS_DELETED){
                $friendship->delete();
            } else {
                $friendship->save();
            }
           // $html_display = Model_User::find(Input::post("sender_id"));
            // Send response message to user who sent the original friendship request
            $receiver = Model_User::find(Input::post("sender_id"));
            $message = Model_Message::forge(array(
                "from_user_id" => Input::post("receiver_id"),
                "to_user_id" => Input::post("sender_id"),
                "title" => "Friend Request " . Input::post("status"),
                "parent_message_id"=>0,
                "detail" => "The friend request you sent to " . $receiver->username . " has been " . Input::post("status"),
                "status" => Model_Message::SENT,
                "read_status" => Model_Message::UNREAD
            ));
            $message->save();
            
            if($friendship->status == Model_Friendship::STATUS_ACCEPTED){
                $response_message = "Friendship request accepted.";
                $identifer = true;
            }else if($friendship->status == Model_Friendship::STATUS_REJECTED){
                $response_message =  "Friendship request denied.";
                $identifer = false;
            }else if($friendship->status == Model_Friendship::STATUS_BLOCKED){
                $response_message =  "Friend has been blocked.";
                $identifer = false;
            }else if($friendship->status == Model_Friendship::STATUS_DELETED){
                $response_message =  "Friend has been deleted.";
                $identifer = false;
            }           
                         
            $response->body(json_encode(array(
                'status' => true,
                'message' => $response_message,
            	'html' => View::forge('users/partials/single_my_friend', array("friend" => $receiver))->render(),
            	'identifer'=>$identifer,
            )));
        } else {
            return $response->set_status(500);
        }
        
        return $response;
    }

 

}
