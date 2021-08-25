<?php

class Controller_Followers extends Controller_Base {

    public $template = 'layout/template';

    public function before() {
        parent::before();

        $login_exception = array();

        parent::check_permission($login_exception);
    }


 

    public function action_create() {
        $response = Response::forge();

        if (Input::method() !== 'POST' or !Input::is_ajax() or $this->current_user->id !== Input::Post("sender_id") or $this->current_user->id == Input::Post("receiver_id")) {
            return $response->set_status(400);
        }

        $val = Validation::forge();

        $val->add('detail', 'Follower')
            ->add_rule('required');

        if (!$receiver = Model_User::find(Input::post("receiver_id"))) {
            $response->body(json_encode(array(
                'status' => false,
                'message' => "The user you are trying follow does not exist!"
            )));
        } 
        else if($already_sent = Model_Follower::follower_exchanged($this->current_user->id, Input::post("receiver_id"))){
             $response->body(json_encode(array(
                'status' => false,
                'message' => "you are following this person!"
            )));
        } else {

            $followership = Model_Follower::forge(array(
                        "follower_id" => $this->current_user->id,
                        "followed_id" => Input::post("receiver_id"),
            ));
            $followership->save();
            $receiver = Model_User::find($followership->followed_id);
            $response->body(json_encode(array(
                'status' => true,
                'message' => "Your are now following <strong>" . Html::anchor("users/show/$receiver->id", $receiver->username) . "</strong>",
            )));
        }

        return $response;
    }
    
    public function action_follow() {
    	$response = Response::forge();
    
    	if (Input::method() !== 'POST' or !Input::is_ajax() or $this->current_user->id !== Input::Post("current_user_id") or $this->current_user->id == Input::Post("user_id")) {
    		return $response->set_status(400);
    	}
    
    	
    
    	if (!$receiver = Model_User::find(Input::post("user_id"))) {
    		$response->body(json_encode(array(
    				'status' => 'error',
    				'message' => "The user you are trying follow does not exist!"
    		)));
    	}
    	else if($already_sent = Model_Follower::follower_exchanged($this->current_user->id, Input::post("user_id"))){
    		$response->body(json_encode(array(
    				'status' => 'error',
    				'message' => "you are following this person!"
    		)));
    	} else {
    
    		$followership = Model_Follower::forge(array(
    				"follower_id" => $this->current_user->id,
    				"followed_id" => Input::post("user_id"),
    		));
    		$followership->save();
    		$receiver = Model_User::find($followership->followed_id);
    		$response->body(json_encode(array(
    				'status' => 'success',
    				'message' => "Your are now following <strong>" . Html::anchor("users/show/$receiver->id", $receiver->username) . "</strong>",
    		)));
    	}
    
    	return $response;
    }
}
