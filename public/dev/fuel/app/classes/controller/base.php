<?php

class Controller_Base extends Controller_Template{

    public function before(){
        parent::before();

        if(Auth::check()){
            list($driver, $user_id) = Auth::get_user_id();

            $this->current_user = \Auth\Model\Auth_User::find($user_id);
            $this->current_profile = Model_Profile::find('first', array("where" => array(array("user_id", $user_id))));

            if(Model_Datingagentinvitaion::has_pending_invitations($this->current_profile->id)){
                View::set_global('dating_agent_invitation', Model_Datingagentinvitaion::get_one_pending_invitation($this->current_profile->id));
            }
            if(Model_Referfriends::has_pending_invitations($this->current_profile->id)) {
                View::set_global('refer_friend', Model_Referfriends::get_one_pending_invitation($this->current_profile->id));
            }
            if(\Fuel\Core\Session::get_flash("logedIn") && Model_Profile::is_dating_agent($this->current_profile->id)){
                Response::redirect("agent/index");
            }
        } else {
            $this->current_user = null;
            $this->current_profile = null;
        }



        View::set_global('current_user', $this->current_user);
        View::set_global('current_profile', $this->current_profile);
		
		if($this->current_profile != null)
		{
            View::set_global('countFriend',  Model_Friendship::get_friends($this->current_profile->id));
            View::set_global('countHello',  Model_Hello::count_hello($this->current_profile->id));
            View::set_global('countImage',  Model_Image::count_image($this->current_profile->id));
            View::set_global('countEvent',  Model_Rsvp::count_event($this->current_profile->id));
            View::set_global('countFavorites',  Model_Favorite::count_favorites($this->current_profile->id));

            //Count all online members
            View::set_global('all_online_members_count',  Model_Profile::count_all_online_members());
        }
    }

    public function check_permission($exception){
        if(!Auth::check() && !in_array("*", $exception) && !in_array(Request::active()->action, $exception) ){
            Session::set_flash('error', 'Access to requested area requires logging in. Please login!');
            Response::redirect(Router::get("login"));
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
	
   
	  
}