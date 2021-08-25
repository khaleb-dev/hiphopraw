<?php

use Fuel\Core\Model;

class Controller_Message extends Controller_Base {

    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        $messages = Model_message::find('all');
        $fromusername = Auth::instance()->get_screen_name();
        $data["subnav"] = array('Inbox' => 'active');
        $view = View::forge('messages/inbox', $data);
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();


        $inbox_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("to_member_id", $this->current_profile->id),
                        array("is_deleted_receiver", 0),
                        array("archive_inbox_id", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
				
			$MessagecountInbox=count($inbox_messages_retrived);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($inbox_messages_retrived);
			 
        $inbox_messages = \Arr::multisort($inbox_messages_retrived, array(
                    'created_at' => SORT_DESC,
                        ), true);
						
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox = $MessagecountInbox;					   
		$view->profile_address = $profile_address;	
       $view->profile_state = $profile_state;		
        $view->inbox_messages = $inbox_messages;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
     
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $view->set_global('page_js', 'messages/sent.js');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_compose() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        $friendship = Model_friendship::find('all');
        $profiles = Model_profile::find('all');
        $fromusername = Auth::instance()->get_screen_name();

        $view = View::forge('messages/compose');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();

        foreach ($users as $user) {
            $results12 = DB::select('id')
                    ->from('users')
                    ->where('username', $fromusername)
                    ->execute();
        }
		$profileid=DB::select('id')
		             ->from('profiles')
					 ->where('id',$this->current_profile->id)
					 ->execute();
	 $membertypeid=DB::select('member_type_id')
                       ->from('profiles')
                       ->where('id',$this->current_profile->id)	
                       ->execute();			

        foreach ($profiles as $profile) {
            $resultsprofile = DB::select('id')
                    ->from('profiles')
                    ->where('user_id', $results12[0]['id'])
                    ->execute();
        }

        if (Input::method() == 'POST') {
		     $val = Model_Message::validate('create');
            $username = Input::post('to_member_id');
            $checkuserid = DB::select('username')
                    ->from('users')
                    ->where('username', $username)
                    ->execute();

            foreach ($users as $user) {
                $results = DB::select('id')
                        ->from('users')
                        ->where('username', $username)
                        ->execute();
            }
            foreach ($profiles as $profile) {
                $recievername = DB::select('id')
                        ->from('profiles')
                        ->where('user_id', $results[0]['id'])
                        ->execute();
            }

            $message_status =0;
            $is_deleted_sender =0;
            $is_deleted_reciever =0;
            $parent_message_id = 0;
            $archive_inbox = 0;
            $archive_sent = 0;
            $is_deleted_reciever_forever = 0;
            $archive_inbox_id = 0;
            $archive_sent_id = 0;
            $trash_inbox_id = 0;
            $trash_sent_id = 0;
            $is_deleted_sender_forever = 0;


            if ($username == 'All') {
			
			
			// echo $this->current_profile->id ;
		    $mailaddressid = DB::select('user_id')
                                ->from('profiles')
                                ->where('id', $this->current_profile->id)
                                ->execute();
			$username = DB::select('username')
                                ->from('users')
                                ->where('id', $this->current_profile->id)
                                ->execute();				
			 $mailaddressmail=DB::select('email')
                                ->from('users')
                                ->where('id', $mailaddressid[0]['user_id'])
                                ->execute();
			
			 //echo $mailaddressmail[0]['email'];
			 //$email->to(array(
           //'example@mail.com',
      //'another@mail.com' => 'With a Name',
       //));

		
		 
                if ($val->run()) {
                    foreach ($friendship as $friends) {
					  
					
                        if ($friends->receiver_id == $this->current_profile->id) {
						    $current_date = date("Y-m-d H:i:s");
                            $message = Model_Message::forge(array(
                                        'from_member_id' => $resultsprofile[0]['id'],
                                        'to_member_id' => $friends->sender_id,
                                        'subject' => Input::post('subject'),
                                        'body' => Input::post('body'),
                                        'date_sent' => $current_date,
                                        'message_status' => $message_status,
                                        'is_deleted_sender' => $is_deleted_sender,
                                        'is_deleted_receiver' => $is_deleted_reciever,
                                        'parent_message_id' => $parent_message_id,
                                        'archive_inbox' => $archive_inbox,
                                        'archive_sent' => $archive_sent,
                                        'is_deleted_reciever_forever' => $is_deleted_reciever_forever,
                                        'archive_inbox_id' => $archive_inbox_id,
                                        'archive_sent_id' => $archive_sent_id,
                                        'trash_inbox_id' => $trash_inbox_id,
                                        'trash_sent_id' => $trash_sent_id,
                                        'is_deleted_sender_forever' => $is_deleted_sender_forever,
                                    ));
								

                            if ($message and $message->save()) {
                                if (
                                        Model_Notification::save_notifications(
                                                Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id
                                        )
                                ) 
								{
                                    $notification_profile = Model_Profile::find($message->to_member_id);
                                    $notification_user = Model_Users::find($notification_profile->user_id);
                                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();

                                    if (!empty($_POST['list']))
		                                    {
										$recievermail = DB::select('email')
                                                      ->from('users')
                                                      ->where('id',$friends->sender_id)
                                                      ->execute();
										$username1 = DB::select('username')
                                                     ->from('users')
                                                     ->where('id', $friends->sender_id)
                                                     ->execute();	
										
				                         $email = Email::forge();
										 $email->from($mailaddressmail[0]['email'],$username[0]['username']);
										 $email->subject(Input::post('subject'));
										 $email->to($recievermail[0]['email'], $username1[0]['username']);
										 $email->body(Input::post('body'));
											}


								   Session::set_flash('success', 'Message Sent ');
                                }
								
                            }
                        }
                    }
                    foreach ($friendship as $friends) {
                        if ($friends->sender_id == $this->current_profile->id) {
                            $current_date = date("Y-m-d H:i:s");
                            $message = Model_Message::forge(array(
                                        'from_member_id' => $resultsprofile[0]['id'],
                                        'to_member_id' => $friends->receiver_id,
                                        'subject' => Input::post('subject'),
                                        'body' => Input::post('body'),
                                        'date_sent' => $current_date,
                                        'message_status' => $message_status,
                                        'is_deleted_sender' => $is_deleted_sender,
                                        'is_deleted_receiver' => $is_deleted_reciever,
                                        'parent_message_id' => $parent_message_id,
                                        'archive_inbox' => $archive_inbox,
                                        'archive_sent' => $archive_sent,
                                        'is_deleted_reciever_forever' => $is_deleted_reciever_forever,
                                        'archive_inbox_id' => $archive_inbox_id,
                                        'archive_sent_id' => $archive_sent_id,
                                        'trash_inbox_id' => $trash_inbox_id,
                                        'trash_sent_id' => $trash_sent_id,
                                        'is_deleted_sender_forever' => $is_deleted_sender_forever,
                                    ));

                            if ($message and $message->save()) {
                                if (
                                        Model_Notification::save_notifications(
                                                Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id
                                        )
                                ) {
                                    $notification_profile = Model_Profile::find($message->to_member_id);
                                    $notification_user = Model_Users::find($notification_profile->user_id);
                                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();

										 if (!empty($_POST['list']))
		                                    {
										$recievermail = DB::select('email')
                                                      ->from('users')
                                                      ->where('id',$friends->sender_id)
                                                      ->execute();
										$username1 = DB::select('username')
                                                     ->from('users')
                                                     ->where('id', $friends->sender_id)
                                                     ->execute();	
										
				                         $email = Email::forge();
										 $email->from($mailaddressmail[0]['email'],$username[0]['username']);
										 $email->subject(Input::post('subject'));
										 $email->to($recievermail[0]['email'], $username1[0]['username']);
										 $email->body(Input::post('body'));
											}
										
										
										
                                    Session::set_flash('success', 'Message Sent ');
                                }
                            } else {
                                Session::set_flash('error', 'Could not save message.');
                            }
							 
                        }
                    }
                } else {
                    Session::set_flash('error', $val->error());
                }
            } 
			
			else if($username == 'All Clients')
			{
			    if ($val->run()) {
				
				
				 foreach ($profiles as $profile) {
						    $current_date = date("Y-m-d H:i:s");
                            $message = Model_Message::forge(array(
                                        'from_member_id' => $resultsprofile[0]['id'],
                                        'to_member_id' => $profile->id,
                                        'subject' => Input::post('subject'),
                                        'body' => Input::post('body'),
                                        'date_sent' => $current_date,
                                        'message_status' => $message_status,
                                        'is_deleted_sender' => $is_deleted_sender,
                                        'is_deleted_receiver' => $is_deleted_reciever,
                                        'parent_message_id' => $parent_message_id,
                                        'archive_inbox' => $archive_inbox,
                                        'archive_sent' => $archive_sent,
                                        'is_deleted_reciever_forever' => $is_deleted_reciever_forever,
                                        'archive_inbox_id' => $archive_inbox_id,
                                        'archive_sent_id' => $archive_sent_id,
                                        'trash_inbox_id' => $trash_inbox_id,
                                        'trash_sent_id' => $trash_sent_id,
                                        'is_deleted_sender_forever' => $is_deleted_sender_forever,
                                    ));
								

                            if ($message and $message->save()) {
                                if (
                                        Model_Notification::save_notifications(
                                                Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id
                                        )
                                ) 
								{
                                    $notification_profile = Model_Profile::find($message->to_member_id);
                                    $notification_user = Model_Users::find($notification_profile->user_id);
                                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();

                                    if (!empty($_POST['list']))
		                                    {
										$recievermail = DB::select('email')
                                                      ->from('users')
                                                      ->where('id',$profle->id)
                                                      ->execute();
										$username1 = DB::select('username')
                                                     ->from('users')
                                                     ->where('id', $profile->id)
                                                     ->execute();	
										
				                         $email = Email::forge();
										 $email->from($mailaddressmail[0]['email'],$username[0]['username']);
										 $email->subject(Input::post('subject'));
										 $email->to($recievermail[0]['email'], $username1[0]['username']);
										 $email->body(Input::post('body'));
											}


								   Session::set_flash('success', 'Message Sent ');
                                }
								
                            }
                     
                    }
				
				
				}
			
			}
			
			
			
			
			else if ($val->run()) {
                $current_date = date("Y-m-d H:i:s");
                $message = Model_Message::forge(array(
                            'from_member_id' => $resultsprofile[0]['id'],
                            'to_member_id' => $recievername[0]['id'],
                            'subject' => Input::post('subject'),
                            'body' => Input::post('body'),
                            'date_sent' => $current_date,
                            'message_status' => $message_status,
                            'is_deleted_sender' => $is_deleted_sender,
                            'is_deleted_receiver' => $is_deleted_reciever,
                            'parent_message_id' => $parent_message_id,
                            'archive_inbox' => $archive_inbox,
                            'archive_sent' => $archive_sent,
                            'is_deleted_reciever_forever' => $is_deleted_reciever_forever,
                            'archive_inbox_id' => $archive_inbox_id,
                            'archive_sent_id' => $archive_sent_id,
                            'trash_inbox_id' => $trash_inbox_id,
                            'trash_sent_id' => $trash_sent_id,
                            'is_deleted_sender_forever' => $is_deleted_sender_forever,
                        ));
                if ($message and $message->save()) {
                    if (
                            Model_Notification::save_notifications(
                                    Model_Notification::MESSAGE_SENT, $message->id, $message->to_member_id, $message->from_member_id
                            )
                    ) {
                        $notification_profile = Model_Profile::find($message->to_member_id);
                        $notification_user = Model_Users::find($notification_profile->user_id);
                        Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                            ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();

                         if (!empty($_POST['list']))
		                                    {
										$mailaddressid = DB::select('user_id')
                                                    ->from('profiles')
                                                    ->where('id', $this->current_profile->id)
                                                    ->execute();
			                            $username = DB::select('username')
                                                    ->from('users')
                                                    ->where('id', $this->current_profile->id)
                                                    ->execute();				
			                            $mailaddressmail=DB::select('email')
                                                  ->from('users')
                                                  ->where('id', $mailaddressid[0]['user_id'])
                                                  ->execute();
										$recievermail = DB::select('email')
                                                      ->from('users')
                                                      ->where('id',$recievername[0]['id'])
                                                      ->execute();
										$username1 = DB::select('username')
                                                     ->from('users')
                                                     ->where('id', $resultsprofile[0]['id'])
                                                     ->execute();	
										
				                         $email = Email::forge();
										 $email->from($mailaddressmail[0]['email'],$username[0]['username']);
										 $email->subject(Input::post('subject'));
										 $email->to($recievermail[0]['email'], $username1[0]['username']);
										 $email->body(Input::post('body'));
											}
						
						
						
						Session::set_flash('success', 'sent message');

                        Response::redirect('message');
                    }
                } else {
                    Session::set_flash('error','Could not save message.');
                }
            } 
			
			else {

                Session::set_flash('error', $val->error());
            }
            $view = View::forge('messages/compose');
     
		}
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->profileid=$profileid;
		$view->membertypeid=$membertypeid;
		$view->profile_address = $profile_address;	
       $view->profile_state = $profile_state;		
        $view->latest_members = $latest_members;
        $view->set('users', $users);
        $view->set('profiles', $profiles);
        $view->set('resultsprofile', $resultsprofile);
        $view->set('friendship', $friendship);
        $view->set_global('page_js', 'jquery.js');
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/compose.css');
        $view->set_global('page_js', 'messages/validate.js');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Compose';
        $this->template->content = $view;
    }

    public function action_sent() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        $messages = Model_message::find('all');
        $fromusername = Auth::instance()->get_screen_name();
        $view = View::forge('messages/sent');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $sent_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("from_member_id", $this->current_profile->id),
                        array("is_deleted_sender", 0),
                        array("archive_sent_id", 0),
                        array("trash_sent_id", 0),
                    )
                ));
	$MessagecountSent=count( $sent_messages_retrived);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($sent_messages_retrived);
        $sent_messages = \Arr::multisort($sent_messages_retrived, array(
                    'created_at' => SORT_DESC,
                        ), true);
						
	$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountSent = $MessagecountSent;
		$view->profile_address = $profile_address;	
       $view->profile_state = $profile_state;		
        $view->sent_messages = $sent_messages;
        $view->latest_members = $latest_members;
        $view->set('users', $users);
        $view->set('profiles', $profiles);
        $view->set('messages', $messages);
        $view->set_global("active_page", "messages");
        $view->set_global('page_js', 'messages/sent.js');
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_delete_forever() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/trash_total');
            } else {
                $deleted = $_POST['list'];
                $messages = Model_message::find('all');
                foreach ($deleted as $delete) {
                    foreach ($messages as $message) {
                        $trash_sent = DB::select('trash_sent_id')
                                ->from('messages')
                                ->where('id', $delete)
                                ->execute();
                    }
                    foreach ($messages as $message) {
                        $trash_inbox = DB::select('trash_inbox_id')
                                ->from('messages')
                                ->where('id', $delete)
                                ->execute();
                    }
                    if ($this->current_profile->id == $trash_sent[0]['trash_sent_id']) {
                        $results = DB::update('messages')
                                ->where('id', $delete)
                                ->value('is_deleted_sender_forever', $trash_sent[0]['trash_sent_id'])
                                ->execute();
                    } else {
                        $results = DB::update('messages')
                                ->where('id', $delete)
                                ->value('is_deleted_reciever_forever', $trash_inbox[0]['trash_inbox_id'])
                                ->execute();
                    }
                }
            }
        }
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
			
			
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        $view = View::forge('messages/trash');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
			$MessagecountSent=count($trash_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($trash_sent_id);
              $MessagecountInbox=count($trash_inbox_id);		  
                if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($trash_inbox_id);
		   $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox = $MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->trash_inbox_id = $trash_inbox_id;
        $view->latest_members = $latest_members;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_recover_trashed() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $fromusername = Auth::instance()->get_screen_name();
        $messages = Model_message::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/trash_total');
            } else
                $deleted = $_POST['list'];
            foreach ($messages as $message) {
                $trash_sent = DB::select('trash_sent_id')
                        ->from('messages')
                        ->where('from_member_id', $this->current_profile->id)
                        ->execute();
            }
            foreach ($messages as $message) {
                $trash_inbox = DB::select('trash_inbox_id')
                        ->from('messages')
                        ->where('to_member_id', $this->current_profile->id)
                        ->execute();
            }
            foreach ($deleted as $delete) {
                foreach ($messages as $message) {
                    $trash_sent = DB::select('trash_sent_id')
                            ->from('messages')
                            ->where('id', $delete)
                            ->execute();
                }
                foreach ($messages as $message) {
                    $trash_inbox = DB::select('trash_inbox_id')
                            ->from('messages')
                            ->where('id', $delete)
                            ->execute();
                }
                if ($this->current_profile->id == $trash_sent[0]['trash_sent_id']) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('trash_sent_id', '0');
                    $results->execute();
                } elseif ($this->current_profile->id == $trash_inbox[0]['trash_inbox_id']) {
                    $results = DB::update('messages')
                            ->where('id', $delete)
                            ->value('trash_inbox_id', '0')
                            ->execute();
                }
            }
        }
        $users = Model_Users::find('all');
        $profiles = Model_profile::find('all');
        $view = View::forge('messages/trash');
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
		
	$MessagecountSent=count($trash_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($trash_sent_id);
			 $MessagecountInbox=count($trash_inbox_id);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($trash_inbox_id); 
			 $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('users', $users);
        $view->set('profiles', $profiles);
        $view->set('messages', $messages);
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_trash() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $messages = Model_message::find('all');
        $users = Model_Users::find('all');
        $profiles = Model_profile::find('all');
        $view = View::forge('messages/trash');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->latest_members = $latest_members;
        $view->set('selectedinbox1', $selectedinbox1);
        $view->set('profiles', $profiles);
        $view->set('messages', $messages);
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_archive_inbox() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/index');
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('archive_inbox_id', $this->current_profile->id);
                    $results->execute();
                }
            }
        }
        $archive_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
			
        $archive_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
		$MessagecountSent=count($archive_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($archive_sent_id);
			 $MessagecountInbox=count($archive_inbox_id);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($archive_inbox_id); 
			 $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
			  
        $profiles = Model_profile::find('all');
        $messages = Model_message::find('all');
        $view = View::forge('messages/archive');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $view->archive_sent_id = $archive_sent_id;
        $inbox_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("to_member_id", $this->current_profile->id),
                        array("is_deleted_receiver", 0),
                        array("archive_inbox_id", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
        $inbox_messages = \Arr::multisort($inbox_messages_retrived, array(
                    'created_at' => SORT_DESC,
                        ), true);

		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->inbox_messages = $inbox_messages;
        $view->archive_inbox_id = $archive_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_archive_total() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        $profiles = Model_profile::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    if ($selectedinbox[0]['from_member_id'] == $trashedselectedsent[0]['trash_sent_id']) {
                        $results = DB::update('messages');
                        $results->where('id', $delete);
                        $results->value('archive_inbox_id', $selectedinbox[0]['to_member_id']);
                        $results->execute();
                    }
                }
            }
        }
        $archive_sent_id1 = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                        array("trash_sent_id", 0),
                    )
                ));
        $archive_sent_id = \Arr::multisort($archive_sent_id1, array(
                    'created_at' => SORT_DESC,
                        ), true);

        $archive_inbox_id1 = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
        $archive_inbox_id = \Arr::multisort($archive_inbox_id1, array(
                    'created_at' => SORT_DESC,
                        ), true);

	  $MessagecountSent=count($archive_sent_id1);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($archive_sent_id1);
			 $MessagecountInbox=count($archive_inbox_id1);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($archive_inbox_id1); 
			 $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
						
        $profiles = Model_profile::find('all');
        $messages = Model_message::find('all');
        $view = View::forge('messages/archive');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
	$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		$view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->archive_sent_id = $archive_sent_id;
        $view->archive_inbox_id = $archive_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_js', 'messages/sent.js');
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_archive_sent() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/sent');
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('archive_sent_id', $this->current_profile->id);
                    $results->execute();
                }
            }
        }
        $archive_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $archive_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
			$MessagecountSent=count($archive_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($archive_sent_id);
              $MessagecountInbox=count($archive_inbox_id);		  
                if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($archive_inbox_id);
		   $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
				
        $messages = Model_message::find('all');
        $view = View::forge('messages/archive');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $sent_messages = Model_Message::find('all', array(
                    "where" => array(
                        array("from_member_id", $this->current_profile->id),
                        array("is_deleted_sender", 0),
                        array("archive_sent_id", 0),
                        array("trash_sent_id", 0),
                    )
                ));
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->sent_messages = $sent_messages;
        $view->archive_sent_id = $archive_sent_id;
        $view->archive_inbox_id = $archive_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('results', $results);
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_recover_inbox() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/archive_total');
            }
            else
                $deleted = $_POST['list'];
            $messages = Model_message::find('all');
            foreach ($deleted as $delete) {
                foreach ($messages as $message) {
                    $archive_sent = DB::select('archive_sent_id')
                            ->from('messages')
                            ->where('id', $delete)
                            ->execute();
                }
                foreach ($messages as $message) {
                    $archive_inbox = DB::select('archive_inbox_id')
                            ->from('messages')
                            ->where('id', $delete)
                            ->execute();
                }
                if ($this->current_profile->id == $archive_sent[0]['archive_sent_id']) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('archive_sent_id', '0');
                    $results->execute();
                } elseif ($this->current_profile->id == $archive_inbox[0]['archive_inbox_id']) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('archive_inbox_id', '0');
                    $results->execute();
                }
            }
        }
        $messages = Model_message::find('all');
        $view = View::forge('messages/archive');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $archive_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $archive_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("archive_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
		$MessagecountSent=count($archive_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($archive_sent_id);
			 $MessagecountInbox=count($archive_inbox_id);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($archive_inbox_id); 
			 $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->archive_sent_id = $archive_sent_id;
        $view->archive_inbox_id = $archive_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_trash_inbox() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/index');
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('trash_inbox_id', $this->current_profile->id);
                    $results->execute();
                }
            }
        }
        $profiles = Model_profile::find('all');
        $messages = Model_message::find('all');
        $view = View::forge('messages/inbox');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                    )
                ));
        $inbox_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("to_member_id", $this->current_profile->id),
                        array("is_deleted_receiver", 0),
                        array("archive_inbox_id", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
		$MessagecountInbox=count($inbox_messages_retrived);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($inbox_messages_retrived);
        $inbox_messages = \Arr::multisort($inbox_messages_retrived, array(
                    'created_at' => SORT_DESC,
                        ), true);
     $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox = $MessagecountInbox;		
		$view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->inbox_messages = $inbox_messages;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_trash_sent() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {
            if (empty($_POST['list'])) {
                Response::redirect('message/sent');
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('trash_sent_id', $this->current_profile->id);
                    $results->execute();
                }
            }
        }
        $profiles = Model_profile::find('all');
        $messages = Model_message::find('all');
        $view = View::forge('messages/sent');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();

        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
         $MessagecountSent=count($trash_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($trash_sent_id);
              $MessagecountInbox=count($trash_inbox_id);		  
                if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($trash_inbox_id);
		   $MessagecountSent=$MessagecountInbox + $MessagecountSent;
        $sent_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("from_member_id", $this->current_profile->id),
                        array("is_deleted_sender", 0),
                        array("archive_sent_id", 0),
                        array("trash_sent_id", 0),
                    )
                ));
        $sent_messages = \Arr::multisort($sent_messages_retrived, array(
                    'created_at' => SORT_DESC,
                        ), true);
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountSent = $MessagecountSent;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->sent_messages = $sent_messages;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_trash_total() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $messages = Model_message::find('all');
        $profiles = Model_profile::find('all');
        $users = Model_Users::find('all');
        if (Input::method() == 'POST') {

            if (empty($_POST['list'])) {
                
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    $results = DB::update('messages');
                    $results->where('id', $delete);
                    $results->value('archive_inbox_id', $selectedinbox[0]['to_member_id']);
                    $results->execute();
                }
            }
        }
        $view = View::forge('messages/trash');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                    )
                ));
		$MessagecountSent=count($trash_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($trash_sent_id);
			 $MessagecountInbox=count($trash_inbox_id);
			 if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($trash_inbox_id); 
			 $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		$view->MessagecountInbox=$MessagecountInbox;
		$view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->latest_members = $latest_members;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set_global('page_js', 'messages/sent.js');
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }

    public function action_archive_deleted() {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        $users = Model_Users::find('all');
        $messages = Model_message::find('all');
        foreach ($messages as $message) {
            $archive_sent_delete = DB::select('archive_sent_id')
                    ->from('messages')
                    ->where('from_member_id', $this->current_profile->id)
                    ->execute();
        }
        foreach ($messages as $message) {
            $archive_inbox_delete = DB::select('archive_inbox_id')
                    ->from('messages')
                    ->where('to_member_id', $this->current_profile->id)
                    ->execute();
        }
        if (Input::method() == 'POST') {

            if (empty($_POST['list'])) {
                Response::redirect('message/archive_total');
            } else {
                $deleted = $_POST['list'];
                foreach ($deleted as $delete) {
                    foreach ($messages as $message) {
                        if ($this->current_profile->id == $archive_sent_delete[0]['archive_sent_id']) {
                            $results = DB::update('messages');
                            $results->where('id', $delete);
                            $results->value('trash_sent_id', $this->current_profile->id);
                            $results->execute();
                        } else {
                            $results = DB::update('messages');
                            $results->where('id', $delete);
                            $results->value('trash_inbox_id', $this->current_profile->id);
                            $results->execute();
                        }
                    }
                }
            }
        }
        $profiles = Model_profile::find('all');
        $view = View::forge('messages/trash');
        $latest_members = DB::select()
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->order_by('created_at', 'desc')
                        ->limit(8)->execute()->as_array();
        $trash_sent_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_sent_id", $this->current_profile->id),
                        array("is_deleted_sender_forever", 0),
                        array("trash_sent_id", 0),
                    )
                ));
        $trash_inbox_id = Model_Message::find('all', array(
                    "where" => array(
                        array("trash_inbox_id", $this->current_profile->id),
                        array("is_deleted_reciever_forever", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
		$MessagecountSent=count($trash_sent_id);
			 if(empty($MessagecountSent))
			{
			 $MessagecountSent==0;
			}
			 else 
			  $MessagecountSent=count($trash_sent_id);
              $MessagecountInbox=count($trash_inbox_id);		  
                if(empty($MessagecountInbox))
			{
			 $MessagecountInbox==0;
			}
			 else 
			  $MessagecountInbox=count($trash_inbox_id);
		   $MessagecountInbox=$MessagecountInbox + $MessagecountSent;
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
		 $view->MessagecountInbox = $MessagecountInbox;
		 $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->trash_sent_id = $trash_sent_id;
        $view->trash_inbox_id = $trash_inbox_id;
        $view->latest_members = $latest_members;
        $view->set('profiles', $profiles);
        $view->set('users', $users);
        $view->set('messages', $messages);
        $view->latest_members = $latest_members;
        $view->set_global("active_page", "messages");
        $view->set_global('page_css', 'messages/messages.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Messages Inbox';
        $this->template->content = $view;
    }
    
    

    public function action_create_ajax() {
        $response = Response::forge();
        if (Input::method() !== 'POST' or !Input::is_ajax()) {
            return $response->set_status(400);
        }
        $val = Validation::forge();
        $val->add('subject', 'Subject')->add_rule('required');
        $val->add('body', 'Body')->add_rule('required');
        if ($val->run()) {
            $receiver = Model_Profile::find(Input::post("to_member_id"));
            $post = Input::post();
            $post["date_sent"] = date('Y-m-d', Date::forge()->get_timestamp());
            $post["is_deleted_sender"] = 0;
            $post["is_deleted_receiver"] = 0;
            $post["parent_message_id"] = 0;
            $post["archive_inbox"] = 0;
            $post["archive_sent"] = 0;
            $post["is_deleted_reciever_forever"] = 0;
            $post["archive_inbox_id"] = 0;
            $post["archive_sent_id"] = 0;
            $post["trash_inbox_id"] = 0;
            $post["trash_sent_id"] = 0;
            $post["is_deleted_sender_forever"] = 0;

            $message = Model_Message::forge($post);
            $message->save();

            //Sends notification
            Model_Notification::save_notifications(
                Model_Notification::MESSAGE_SENT,
                $message->id,
                $message->to_member_id,
                $message->from_member_id
            );

            $notification_profile = Model_Profile::find($message->to_member_id);
            $notification_user = Model_Users::find($notification_profile->user_id);

            if (Model_Setting::is_set_email_notification($this->current_profile->id)){
                Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                    ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();
            }

            $response->body(json_encode(array(
                        'status' => true,
                        'heading' => "Sent!",
                        'message' => "Message sent to ". Model_Profile::get_username($receiver->user_id),
                    )));
        } else {
            $response->body(json_encode(array(
                        'status' => false,
                        'heading' => "Error!",
                        'validation' => array(
                            $val->error('subject') ? $val->error('subject')->get_message() : '',
                            $val->error('body') ? $val->error('body')->get_message() : ''
                        )
                    )));
        }
        return $response;
    }
    
    public function action_create_by_group_ajax() {
    	
    	$response = Response::forge();
    	
    	if (Input::method() !== 'POST' or !Input::is_ajax()) {
    		return $response->set_status(400);
    	}
    	
    	$val = Validation::forge();
    	$val->add('subject', 'Subject')->add_rule('required');
    	$val->add('body', 'Body')->add_rule('required');
    	if ($val->run()) {
    		$group_id = Input::post('to_group_id');
    		$users = Model_Users::query()->where('group_id', $group_id)->get();
    		
    		foreach ($users as $user){
    			$receiver = Model_Profile::query()->where('user_id',$user->id)->get_one();
    			$post = Input::post();
    			$post["date_sent"] = date('Y-m-d', Date::forge()->get_timestamp());
    			$post["to_member_id"] = $receiver->id;
    			$post["is_deleted_sender"] = 0;
    			$post["is_deleted_receiver"] = 0;
    			$post["parent_message_id"] = 0;
    			$post["archive_inbox"] = 0;
    			$post["archive_sent"] = 0;
    			$post["is_deleted_reciever_forever"] = 0;
    			$post["archive_inbox_id"] = 0;
    			$post["archive_sent_id"] = 0;
    			$post["trash_inbox_id"] = 0;
    			$post["trash_sent_id"] = 0;
    			$post["is_deleted_sender_forever"] = 0;
    			
    			$message = Model_Message::forge($post);
    			$message->save();
    			
    			//Sends notification
    			Model_Notification::save_notifications(
    					Model_Notification::MESSAGE_SENT,
    					$message->id,
    					$message->to_member_id,
    					$message->from_member_id
    			);

                $notification_profile = Model_Profile::find($message->to_member_id);
                $notification_user = Model_Users::find($notification_profile->user_id);
                Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                    ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has sent you a message.")))->priority(\Email\Email::P_HIGH)->send();

            }
    		
    
    		
    
    		$response->body(json_encode(array(
    				'status' => true,
    				'heading' => "Sent!",
    				'message' => "Message sent to $receiver->first_name $receiver->last_name .",
    		)));
    	} else {
    		$response->body(json_encode(array(
    				'status' => false,
    				'heading' => "Error!",
    				'validation' => array(
    						$val->error('subject') ? $val->error('subject')->get_message() : '',
    						$val->error('body') ? $val->error('body')->get_message() : ''
    				)
    		)));
    	}
    	return $response;
    }
    

}