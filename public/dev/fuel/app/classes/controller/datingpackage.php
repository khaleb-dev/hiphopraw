<?php

class Controller_Datingpackage extends Controller_Base {

    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index($id=null) {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        
        $profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        $view = View::forge('datingPackage/index');
        $view->set('id', $id);
		$view->profile_address = $profile_address;	
        $view->profile_state = $profile_state;	
        $view->set_global('featureddatingpackages', Model_Datingpackage::get_random_featured_dating_packages());
        $view->set_global('datingpackages', Model_Datingpackage::get_random_active_dating_packages(4));
        $view->set_global('friend_list', Model_Datingpackage::get_friend_list());
        $view->set_global('destination_list', Model_Datingpackage::get_distinct_package_destinations());

        $view->set_global('active_page', "DatingPackages");
        $view->set_global('page_css', 'datingPackage/datingPackage.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Invitation';
        $this->template->content = $view;
    }

    public function action_refer($id = null) {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
					   
        $view = View::forge('datingPackage/refer');
        $view->set('id', $id);
	$view->profile_address = $profile_address;	
        $view->profile_state = $profile_state;		
        $view->set_global("friend_list", Model_Datingpackage::get_friend_list());
        $view->set_global("active_page", "Datingpackages");
        $view->set_global('page_css', 'datingPackage/datingPackage_detail.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Reference';
        $this->template->content = $view;
    }

    public function action_invite($id = null) {
        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        
        $view = View::forge('datingPackage/invite');
        $view->profile_address = $profile_address;	
        $view->profile_state = $profile_state;
        $view->set('id', $id);
        $view->set_global("friend_list", Model_Datingpackage::get_friend_list());
        $view->set_global("active_page", "Datingpackages");
        $view->set_global('page_css', 'datingPackage/datingPackage_invite.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Reference';
        $this->template->content = $view;
    }

    public function action_view($id=null) {

        if (!\Auth\Auth::check())
            \Fuel\Core\Response::redirect('users/login');
        		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
        $view = View::forge('datingPackage/view');
        $view->profile_address = $profile_address;	
        $view->profile_state = $profile_state;
        $view->set('id', $id);
        $destination = Input::post('destination');
        $checkin = Input::post('checkin');
        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = Input::post('checkout');
        $checkout = date('Y-m-d', strtotime($checkout));
        if ($destination !== null && ($checkin == '1970-01-01' || $checkout == '1970-01-01')) {
            $view->set_global("datingpackages", Model_Datingpackage::get_dating_packages_by_destination($destination));
        } elseif (isset($destination) && ($checkin !== null || $checkout !== null)) {
            $view->set_global("datingpackages", Model_Datingpackage::get_dating_packages_by_destination_and_date($destination, $checkin, $checkout));
        }
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
        $view->set_global("active_page", "DatingPackages");
        $view->set_global('page_css', 'datingPackage/datingPackage.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package Invitation';
        $this->template->content = $view;
    }

    public function action_refer_a_friend($dp_id) {
        //this commented line doesn't render the details of the user detail so it created a problem on the $from_user-email variable
        //thus it is changed to the next line
        // $from_user = Model_Users::query(array('user_id', \Auth\Auth::get('id')))->get_one();
        $from_user = Model_users::find($this->current_profile->id);
        // $from_profile = Model_Profile::query(array('id', $from_user->user_id))->get_one();
        $from_profile = Model_Profile::find($from_user->id);
        $from_name = $from_profile['first_name'] . ' ' . $from_profile['last_name'];
        $to_email = \Fuel\Core\Input::post('email');
        $message = \Fuel\Core\Input::post('message');
        if (isset($to_email) && $to_email != NULL) {
            $datingpackage = Model_Datingpackage::find(\Fuel\Core\Input::post('dp_id'));
            $datingpackage_url = \Fuel\Core\Uri::base() . 'datingPackage/refer/' . $dp_id;

            //$from_user->email="yaller2004@gmail.com";
            $response = Response::forge();
            try {
                Email::forge()
                        ->to($to_email)
                        ->from($from_user->email)
                        ->subject("Checkout this dating package")
                        ->html_body(
                                View::forge('email/datingPackage_refer_a_friend', array(
                                    "message" => $message,
                                    "datingpackage_url" => $datingpackage_url,
                                    "from_name" => $from_name,
                                        )
                                )
                        )->send();

                $response->body(json_encode(array(
                    'status' => true,
                )));
                Session::set_flash('success', 'You have sent the request successfully.');
                Response::redirect('datingPackage/refer/' . $dp_id);
            } catch (EmailSendingFailedException $e) {
                $response->body(json_encode(array(
                    'status' => false,
                )));
                Session::set_flash('error', 'there is a problem with the email address. Make sure you entered a valid email!');
                Response::redirect('datingPackage/refer/' . $dp_id);
            }

            return $response;
        } else {
            Session::set_flash('error', 'there is a problem with the email address. Make sure you entered a valid email!');
            Response::redirect('datingPackage/refer/' . $dp_id);
        }
    }

    public function action_invite_a_friend($id = null) {

        $invite['from_member_id'] = $this->current_profile->id;
        $invite['to_member_id'] = Input::post('to_member_id');
        $invite['dating_package_id'] = $id;
        $invite['checkin_time'] = Input::post('checkin_time');
        $invite['checkin_date']= Input::post('checkin_date');
       
        //original dating package date
        $package_date = Input::post('dp_checkin_date');
        if (isset($invite['checkin_date']) && $invite['checkin_date'] != null) {
             $invite['checkin_date'] = date('Y-m-d', strtotime($invite['checkin_date']));
            if ($package_date != $invite['checkin_date']) {
                Session::set_flash('error', 'This dating package is not available for the selected date. Please select from the highlighted ones only');
                \Fuel\Core\Response::redirect('datingPackage/refer/'.$id);
                return;  
            } else {
                $invite['checkin_date'] = date('Y/m/d', strtotime($invite['checkin_date']));
            }

            if (isset($invite['to_member_id']) && $invite['to_member_id'] != NULL) {
                $result = Model_Datingpackage::send_invitation($invite);
                if ($result) {
                    Model_Notification::save_notifications(
                            Model_Notification::DATING_PACKAGE_INVITATION_SENT, $invite['dating_package_id'], $invite['to_member_id'], $this->current_profile->id
                    );

                    $notification_profile = Model_Profile::find($invite['to_member_id']);
                    $notification_user = Model_Users::find($notification_profile->user_id);
                    Email::forge()->to($notification_user->email)->from("admin@whereweallmeet.com")->subject("WhereWeAllMeet Notification")
                        ->html_body(View::forge('email/notification', array("notification" => $this->current_profile->first_name . ' ' . $this->current_profile->last_name ." has invited you to a dating package!")))->priority(\Email\Email::P_HIGH)->send();

                    Session::set_flash('success', 'You have successfully sent the invitation.');
                    \Fuel\Core\Response::redirect('datingPackage/refer/'.$id);
                } else {
                    Session::set_flash('error', 'There is an error sending the invitation. Please, try later.');
                    \Fuel\Core\Response::redirect('datingPackage/refer/'.$id);
                }
            } else {
                Session::set_flash('error', 'Please select a friend to send this invitation');
                \Fuel\Core\Response::redirect('datingPackage/refer/'.$id);
            }
        } else {
            Session::set_flash('error', 'There is a no date selected. Click on the highlighted date to select.');
           \Fuel\Core\Response::redirect('datingPackage/refer/'.$id);
        }
    }

    public function action_accept_invite($invitation_id = null) {
        $result = Model_Datingpackage::set_reply_for_invitation($invitation_id, "Accept");
        if ($result) {
            Session::set_flash('success', 'You have successfully accepted the invite');
            Response::redirect('datingPackage/');
        } else {
            Session::set_flash('error', 'There is a problem accepting this invitation. Please retry later!');
            Response::redirect('datingPackage/');
        }
    }

    public function action_reject_invite($invitation_id = null) {
        $result = Model_Datingpackage::set_reply_for_invitation($invitation_id, "Reject");
        if ($result) {
            Session::set_flash('success', 'You have successfully rejected the invitation');
            Response::redirect('datingPackage/');
        } else {
            Session::set_flash('error', 'There is a problem rejecting this invitation. Please retry later!');
            Response::redirect('datingPackage/');
        }
    }

    public function action_cancel_booking($invitation_id = null) {
        $result = Model_Datingpackage::set_cancel_booking($invitation_id, "Cancel");
        if ($result) {
            Session::set_flash('success', 'You have successfully canceled your booking to the invitation');
            Response::redirect('datingPackage/');
        } else {
            Session::set_flash('error', 'There is a problem cancelling this invitation. Please contact the administrator');
            Response::redirect('datingPackage/');
        }
    }

    public function action_confirm_booking($invitation_id = null) {

        Session::set_flash('success', 'This will take you to a third party website');
        Response::redirect('datingPackage/');
    }

    public function action_create() {
        $view = View::forge('datingPackage/create');
        $view->set_global("active_page", "datingPackages");
        $view->set_global('page_css', 'datingPackage/create.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; Dating Package';
        $this->template->content = $view;
    }

    public function action_createdp() {
        //the following line of code is added from event's package
        //here write the code that calls the respective task from the model
        try {
            $datingpackage = array();
            if (\Fuel\Core\Input::post()) {
                $datingpackage['title'] = Input::post('title');
                $event_date = Input::post('event_date');
                $datingpackage['event_date'] = date('Y/m/d', strtotime($event_date));
                $datingpackage['short_description'] = Input::post('short_description');
                $datingpackage['long_description'] = Input::post('long_description');
                $datingpackage['state'] = Input::post('state');
                $datingpackage['city'] = Input::post('city');
                $datingpackage['event_venue'] = Input::post('event_venue');
                $datingpackage['time_from'] = Input::post('time_from');
                $datingpackage['time_to'] = Input::post('time_to');
                $datingpackage['price'] = Input::post('price');

                if (isset($_POST['is_featured']) && $_POST['is_featured'] == true) {
                    $datingpackage['is_featured'] = 1;
                    echo 'is_featured=' . $datingpackage['is_featured'];
                } else {
                    $datingpackage['is_featured'] = 0;
                    echo 'is_featured=' . $datingpackage['is_featured'];
                }
                if (count($_FILES) > 0) {
                    if (is_uploaded_file($_FILES['picture']['tmp_name'])) {
                        $imgData = addslashes(file_get_contents($_FILES['picture']['tmp_name']));
                        //$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
                        $datingpackage['picture'] = $imgData;
                    }
                }
                $result = Model_Datingpackage::create_dating_package($datingpackage);
                if ($result) {

                    Session::set_flash('success', 'You have successfully Saved the dating package');
                    Response::redirect('datingPackage/create');
                } else {

                    Session::set_flash('error', 'There is an error and the dating package is not saved. Please try again');
                    Response::redirect('datingPackage/create');
                }
            }
        } catch (Exception $e) {
            Session::set_flash('step', 2);
            Session::set_flash('error', 'The dating package is not saved. Please retry');
            \Fuel\Core\Response::redirect('datingPackage/create');
        }
    }

}
