<?php

class Controller_Messages extends Controller_Base {

	public $template = 'layout/user-template';

    public function before() {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index($status=null, $user_id=null) {
	//public function action_index($user_id = null){
        
		$view = View::forge('messages/index');

       /*  if ($user_id !== $this->current_user->id) {
            Response::redirect('users/' . $this->current_user->id . '/messages/' . Model_Message::INBOX);
        } */ 
		if ($status === Model_Message::SENT) {
			$messages_query = Model_Message::query()->where('from_user_id', $user_id)->where('status', $status);
			//$view->count_sent = $messages_query->count();
            $view->page_loaded = "sent";
			$view->messages = $messages_query
			->order_by('created_at', 'desc')
			->get();
		}
         else if ($status === Model_Message::DRAFT) {
            $messages_query = Model_Message::query()->where('from_user_id', $user_id)->where('status', $status);
            //$view->count_draft = $messages_query->count();
            $view->page_loaded = "draft";
            $view->messages = $messages_query
            ->order_by('created_at', 'desc')
            ->get();
        } else if ($status === Model_Message::INBOX) {
            $messages_query = Model_Message::query()->where('to_user_id', $user_id)->where('status', Model_Message::SENT);
           // $view->count_inbox = $messages_query->count();
            $view->page_loaded = "inbox";
            $view->messages = $messages_query
            ->order_by('created_at', 'desc')
            ->get();
        } else if ($status === Model_Message::TRASH) {
            $messages_query = Model_Message::query()->where('to_user_id', $user_id)->where('status', $status);
            //$view->count_trash = $messages_query->count();
            $view->page_loaded = "trash";
            $view->messages = $messages_query
            ->order_by('created_at', 'desc')
            ->get();
        }
        $messages_query_sent = Model_Message::query()->where('from_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::SENT);
        $messages_query_draft = Model_Message::query()->where('from_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::DRAFT);
        $messages_query_inbox = Model_Message::query()->where('to_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::SENT);
        $messages_query_trash = Model_Message::query()->where('to_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::TRASH);
        $view->count_sent = $messages_query_sent->count();
        $view->count_draft =  $messages_query_draft->count();
        $view->count_inbox = $messages_query_inbox ->count();
        $view->count_trash = $messages_query_trash ->count();
        $view->status = $status;

        //  $messages_to_delete = Model_Message::find("all");
        //  foreach($messages_to_delete as $m_delete){

        //          $m_delete->delete();

        // }
       // $view->count = $messages_query->count();
        // Configure the pagination
       /*  $pagination = \Pagination::forge('pagination', array(
            'pagination_url' => \Uri::base(false).'users/'. $this->current_user->id .'/messages/list/'. $status,
            'total_items' => $view->count,
            'per_page' => 10,
            'uri_segment' => 6,
            'num_links' => 5,
        )); */

       // $view->pagination = $pagination;
/*         $view->messages = $messages_query
                            ->order_by('created_at', 'desc')
                            ->get(); */

        $view->set_global('page_css', 'messages/index.css');
        $view->set_global('page_js', 'messages/index.js');
        $view->set_global('active_message_link', $status);
        $view->set_global('heading', $status);

        $this->template->title = 'Hiphopraw &raquo; Messages';
        $this->template->content = $view; 		
	 	if ($user = Model_User::find($user_id)) {
            $videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->limit(6)->get();

            $now = new DateTime();
            $now_timestamp_seconds = $now->getTimestamp();
            $ten_minutes_in_seconds = 10 * 60;
            $ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
            $view->suggestions = Model_Videoke::query()
                ->where('is_blocked', 0)
                ->where('user_id', '!=', $user->id)
                ->where('created_at', "<", $ten_minutes_ago)
                ->order_by(DB::expr('RAND()'))
                ->limit(5)->get();

            $view->user = $user;
            //$view->count = sizeof($videokes);
            $view->videokes = $videokes;
            
        } else {
            Response::redirect(Router::get("browse"));
        }
		
		$visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers(); 
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor1->followers());
       // $view->set_global('page_css', 'messages/index.css');
       // $view->set_global('page_js', 'users/home_login.js');
        //$view->set_global('active_message_link', $status);
        //$view->set_global('heading', $status);
		
        $this->template->title = 'Hip Hop Raw &raquo; Messages';

        $this->template->content = $view;
		
    }

    
    public function action_new($user_id=null) {
        $view = View::forge('messages/new');
		
       /*  if ($user_id !== $this->current_user->id) {
            Response::redirect('users/' . $this->current_user->id . '/messages/new');
        } */
        $messages_query_sent = Model_Message::query()->where('from_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::SENT);
        $messages_query_draft = Model_Message::query()->where('from_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::DRAFT);
        $messages_query_inbox = Model_Message::query()->where('to_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::SENT);
        $messages_query_trash = Model_Message::query()->where('to_user_id', $user_id)->where('read_status', Model_Message::UNREAD)->where('status', Model_Message::TRASH);
        $view->count_sent = $messages_query_sent->count();
        $view->count_draft =  $messages_query_draft->count();
        $view->count_inbox = $messages_query_inbox ->count();
        $view->count_trash = $messages_query_trash ->count();
        if ($user = Model_User::find($user_id)) {
        	$videokes = Model_Videoke::query()->where('user_id', $user->id)->where('is_blocked', 0)->limit(6)->get();
        
        	$now = new DateTime();
        	$now_timestamp_seconds = $now->getTimestamp();
        	$ten_minutes_in_seconds = 10 * 60;
        	$ten_minutes_ago = $now_timestamp_seconds - $ten_minutes_in_seconds;
        	$view->suggestions = Model_Videoke::query()
        	->where('is_blocked', 0)
        	->where('user_id', '!=', $user->id)
        	->where('created_at', "<", $ten_minutes_ago)
        	->order_by(DB::expr('RAND()'))
        	->limit(5)->get();
        
        	$view->user = $user;
        	
        	$view->videokes = $videokes;
        	
        } else {
        	Response::redirect(Router::get("browse"));
        }
        
        
        $users = array("All" => "All");
        foreach ($this->current_user->friends() as $user) {
            $users["$user->id"] = $user->username;
        }
        $view->users = $users; 
		
        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor1->followers());

        $view->set_global('page_css', 'messages/index.css');
        //$view->set_global('page_js', 'messages/new.js');
        //$view->set_global('active_message_link', "compose");
        //$view->set_global('heading', "Compose Message");

        $this->template->title = 'Hip Hop Raw &raquo; Send Message';
        $this->template->content = $view;
    }

    public function action_create() {
        $view = View::forge('messages/new');

        if (Input::post()) {
            $val = Validation::forge();

            $val->add('to_user_id', 'Member')
                    ->add_rule('required');

            $val->add('title', 'Title')
                    ->add_rule('required')
                    ->add_rule('max_length', 255);

            $val->add('detail', 'Message')
                    ->add_rule('required');

            if ($val->run()) {
                $post = Input::post();
                if($post["to_user_id"] == "All"){
                    foreach($this->current_user->friends() as $friend){
                        $post["to_user_id"] = $friend->id;
                        $post["status"] = Input::post('is_draft') == false ? Model_Message::DRAFT : Model_Message::SENT;
                        $post["read_status"] = Model_Message::UNREAD;
                        $post["parent_message_id"] = 0;
                        Model_Message::forge($post)->save();

            
                    $receiver_email = $friend->email;
                    $sender_name = $this->current_user->username;

                    try {
                        Email::forge()->to($receiver_email)->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject($sender_name." has sent you a message on hiphopraw.com")->html_body(View::forge('email/new_message',array("message" => Input::post("detail")) ))->send();
                        
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("failure", 'could not send email'); 
                    }
                }
                    
                } else {
                    $post["status"] = Input::post('is_draft') == false ? Model_Message::DRAFT : Model_Message::SENT;
                    $post["read_status"] = Model_Message::UNREAD;
                    $post["parent_message_id"] = 0;
                    Model_Message::forge($post)->save();


                    $receiver = Model_User::find($post["to_user_id"]);
                    $receiver_email = $receiver->email;
                    $sender_name = $this->current_user->username;

                    try {
                        Email::forge()->to($receiver_email)->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject($sender_name." has sent you a message on hiphopraw.com")->html_body(View::forge('email/new_message', array("message" => Input::post("detail"))))->send();
                        
                    } catch (EmailSendingFailedException $e) {
                        Session::set_flash("failure", 'could not send email'); 
                    }
                }  
                $flash = Input::post('is_draft') == true ? "Message successfully sent!" : "Message not sent!";
                Session::set_flash("success", $flash);                
                $view->val = $val;
            }
        }

        $users = array();
        foreach (\Model\Auth_User::query()->where('id', '!=', $this->current_user->id)->get() as $user) {
            $users["$user->id"] = $user->username;
        }
        Response::redirect("messages/new/".$this->current_user->id);
        $view->users = $users;
        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers();
        $view->set_global('page_css', 'messages/new.css');
        $view->set_global('page_js', 'messages/new.js');
        $view->set_global('active_message_link', "compose");
        $view->set_global('heading', "Compose Message");

        $this->template->title = 'Hip Hop Raw &raquo; Compose Message';
        $this->template->content = $view;
    }

    public function action_create_ajax() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }

        $val = Validation::forge();

        $val->add('title', 'Title')
            ->add_rule('required');
        
        $val->add('detail', 'Message')
            ->add_rule('required');
         $the_post = Input::post();
         

        if ($val->run()) {
            $post = Input::post();
            $receiver = Model_User::find(Input::post("to_user_id"));
            $post["parent_message_id"] =0;
            $message = Model_Message::forge($post);
            $message->save();


            $res = array();


            $receiver = Model_User::find(Input::post("to_user_id"));
            $receiver_email = $receiver->email;
            $sender = Model_User::find(Input::post("from_user_id"));
            $sender_name = $sender->username;

                    try {
                        Email::forge()->to($receiver_email)->from("noreply@hiphopraw.com", "Hip Hop Raw")->subject($sender_name." has sent you a message on hiphopraw.com")->html_body(View::forge('email/new_message', array("message" => Input::post("detail"))))->send();
                        $res["request_status"] = 'success';
                        $res["email"] = $receiver_email;
                    } catch (EmailSendingFailedException $e) {
                        $res["request_status"] = 'failed';
                        $res["error"] = CANNOT_SEND_EMAIL;
                    }

            $response->body(json_encode(array(
                'status' => true,
                'heading' => "Sent!",
                'res'=>$res,
                'message' => "Message sent to " . $receiver->username . ".",
            )));
        } else {
            $response->body(json_encode(array(
                'status' => false,
                'heading' => "Error!",
                'validation' => array(
                    $val->error('title')->get_message(),
                    $val->error('detail')->get_message()
                )
            )));
        }

        return $response;
    }

    public function action_show($message_id) {

         if (! $message_id || ! $message = Model_Message::find($message_id)) {
            return $response->set_status(400);
        }

        $view = View::forge('messages/show');
        $sender = \Model\Auth_User::find($message->from_user_id);
        $user = \Model\Auth_User::find($message->to_user_id);

       /*  if (!$sender || !$user) {
            Response::redirect('users/' . $this->current_user->id . '/messages/list/inbox');
        } */

        $view->sender = $sender;
        $view->user = $user;

        // $messages = Model_Message::query()->where(array("from_user_id" => $sender->id, "to_user_id" => $user->id, "status" => Model_Message::SENT))
        //                                   ->or_where(array("from_user_id" => $user->id, "to_user_id" => $sender->id, "status" => Model_Message::SENT))
        //                                   ->order_by("created_at", "desc")
        //                                   ->get();

        $view->message = $message;

        $current_message = Model_Message::find($message_id);
        $current_message->read_status = Model_Message::READ;
        $current_message->save();
        
 
        $visitor = Model_User::find($this->current_user->id);
        $view->friends = $visitor->friends();
        $visitor1 = Model_User::find($this->current_user->id);
        $view->followers = $visitor1->followers();
        $view->friends_count = count($visitor->friends());
        $view->followers_count = count($visitor1->followers());
        
        
        
        
        
        
        
        $view->set_global('page_css', 'messages/index.css');
        $view->set_global('page_js', 'messages/index.js');

        $this->template->title = 'Hip Hop Raw &raquo; Messages From ' . $sender->username;
        $this->template->content = $view;
    }

    public function action_message_reply()
    {
        $this->template="";
        /* if( ! \Fuel\Core\Input::is_ajax() or ! Input::post()){
         \Fuel\Core\Response::redirect('pages/404');
        } */
        $message = Model_message::forge();
    
        $message->detail = trim(Input::post('message_detail'));
        $message->from_user_id = Input::post('from_user_id');
        $message->to_user_id = Input::post('to_user_id');
        
        $message->parent_message_id = Input::post('parent_message_id');
        $message->title = Input::post('title');
        $message->status = 'sent';
        $message->read_status = 'unread';
    
        $message->save();


    
        //$orginal_message= Model_Message::find(Input::post('orginal_id'));
        Response::redirect(Uri::create("messages/show/".Input::post('orginal_id')));
    }

    public function action_edit($message_id, $user_id) {
        if ($user_id !== $this->current_user->id) {
            Response::redirect('users/' . $this->current_user->id . '/messages/list/inbox');
        }

        if (!$message = Model_Message::find($message_id)) {
            Session::set_flash("error", "Draft message not found!");
            Response::redirect('users/' . $this->current_user->id . '/messages/list/inbox');
        }

        $view = View::forge('messages/edit');

        $users = array();
        foreach (\Model\Auth_User::query()->where('id', '!=', $this->current_user->id)->get() as $user) {
            $users["$user->id"] = $user->username;
        }

        $view->users = $users;
        $view->message = $message;

        $view->set_global('page_css', 'messages/edit.css');
        $view->set_global('page_js', 'messages/edit.js');
        $view->set_global('active_message_link', "draft");
        $view->set_global('heading', "Edit Draft");

        $this->template->title = 'Hip Hop Raw &raquo; Edit Draft';
        $this->template->content = $view;
    }

    public function action_update($message_id, $user_id) {

        if ($user_id !== $this->current_user->id) {
            Response::redirect('users/' . $this->current_user->id . '/messages/list/inbox');
        }

        if (!$message = Model_Message::find($message_id)) {
            Session::set_flash("error", "Draft message not found!");
            Response::redirect('users/' . $this->current_user->id . '/messages/list/inbox');
        }

        $view = View::forge('messages/index');

        if (Input::post()) {
            $val = Validation::forge();

            $val->add('to_user_id', 'Member')
                    ->add_rule('required');

            $val->add('title', 'Title')
                    ->add_rule('required')
                    ->add_rule('max_length', 255);

            $val->add('detail', 'Message')
                    ->add_rule('required');

            if ($val->run()) {
                $post = Input::post();
                $post["status"] = Input::post('is_draft') == true ? Model_Message::DRAFT : Model_Message::SENT;
                $post["read_status"] = Model_Message::UNREAD;

                $message->set($post)->save();
                $flash = Input::post('is_draft') == true ? "Message saved as draft." : "Message successfully sent!";
                Session::set_flash("success", $flash);
                Response::redirect("users/" . $this->current_user->id . "/messages/list/inbox");
                $view->val = $val;
            }
        }

        $users = array();
        foreach (\Model\Auth_User::query()->where('id', '!=', $this->current_user->id)->get() as $user) {
            $users["$user->id"] = $user->username;
        }
        $view->users = $users;

        $view->set_global('page_css', 'messages/index.css');
        $view->set_global('page_js', 'messages/index.js');
        $view->set_global('active_message_link', "draft");
        $view->set_global('heading', "Inbox");

        $this->template->title = 'Hip Hop Raw &raquo; Messages';
        $this->template->content = $view;
    }

    public function action_destroy($message_id, $user_id = null) {
        $response = Response::forge();

        /* if (!Input::is_ajax() or $this->current_user->id !== $user_id) {
            return $response->set_status(400);
        } */

        if ($message = Model_Message::find($message_id)) {
            
            // Delete Completely if already in Trash
            if($message->status == Model_Message::TRASH){
                $messages_under = Model_Message::query()
                                   ->where('parent_message_id',$message_id)
                                    ->get();

                if($messages_under){
                    foreach($messages_under as $sub_message){
                      $sub_message->delete();
                    }
                }
                $message->delete();
                $response_message = "Your message has been deleted!";
            } else {
                // Move to Trash
                $messages_under = Model_Message::query()
                                   ->where('parent_message_id',$message_id)
                                    ->get();

                if($messages_under){
                    foreach($messages_under as $sub_message){
                      $sub_message->status=Model_Message::TRASH;
                    }
                }
                $message->status = Model_Message::TRASH;

                $message->save();
                $response_message = "Your message has been moved to trash.";
            }           

            $response->body(json_encode(array(
                'status' => true,
                'message' => $response_message
            )));
        } else {
            return $response->set_status(500);
        }

        return $response;
    }
	
}