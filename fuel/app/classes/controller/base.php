<?php

class Controller_Base extends Controller_Template {

    public function before() {
        parent::before();

        if (Auth::check()) {
            list($driver, $user_id) = Auth::get_user_id();

            $this->current_user = Model_User::find($user_id);
            $new_friends = $this->current_user->new_friends();
            $new_messages =  $this->current_user->new_messages();
            $new_comments =  $this->current_user->new_comments_count();

            View::set_global('header_new_friends', $new_friends);
            View::set_global('header_new_messages', $new_messages);
            View::set_global('header_new_comments', $new_comments);

        } else {
            $this->current_user = null;
        }

        View::set_global('current_user', $this->current_user);
    }

    public function check_permission($exception = array("")) {
        if (!Auth::check() && !in_array("*", $exception) && !in_array(Request::active()->action, $exception)) {
            Session::set_flash('error', 'Access to requested area requires logging in. Please login!');
            Response::redirect(Router::get("login"));
        }
    }

}
