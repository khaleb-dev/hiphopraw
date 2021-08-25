<?php

use \Model\Quicksearch;

class Controller_Profile extends Controller_Base {

    public $template = 'layout/template';

    public function before() {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }    
    public function action_quicksearch()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	 
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	
    	if(count($subsc) === 1)
    	{
    	$subscribed = true;
    	}
    	else
    	{
    	$subscribed = false;
    	}
    	
    	$online_members = Quicksearch::get_online_members($username, $password);
    	$result = Quicksearch::get_result($username, $password);  
    	$dating_members = Quicksearch::get_dating_agent_result($username, $password);
    	$view = View::forge('profile/quicksearch_view');   	
    	if($this->current_profile->member_type_id == 3)
    	{
    		$view->latest_members = $dating_members;
    	}
    	else
    	{
    		$view->latest_members = $result[0];
    		$view->counter = $result[1];
    		$view->percentage = $result[2];
    	}
    	$view->online_members  =  $online_members;
    	$view->referd  =  $referd;
    	$view->subscribed  =  $subscribed;
    	$view->set_global('page_js', 'profile/dashboard.js');
    	$view->set_global('page_css', 'profile/dashboard.css');
    	
    	$this->template->title = 'WHERE WE ALL MEET &raquo; All Latest Members';
    	$this->template->content = $view;
    	    	
    	
    }

    public function action_online_members()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    $subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	
    	if(count($subsc) === 1)
    	{
    	$subscribed = true;
    	}
    	else
    	{
    	$subscribed = false;
    	}
    	$view = View::forge('profile/all_online_friends');
    	$online_members = Quicksearch::get_all_online_members($username, $password);
    	$view->online_members  =  $online_members;
    	$view->referd  =  $referd;
    	$view->subscribed  =  $subscribed;
    	$view->set_global('page_js', 'profile/dashboard.js');
    	$view->set_global('page_css', 'profile/dashboard.css');
    	 
    	$this->template->title = 'WHERE WE ALL MEET &raquo; Online Members';
    	$this->template->content = $view;
    
    	 
    }   

    public function action_dashboard()
    {
        $username = Auth::get_screen_name();
        $password = Auth::get('password');

        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
            $referd = false;
        }
        else {
            $referd = true;
        }
	
        $membertype_id = Model_profile::find('all', array(
                            "where" => array(
                                array("id", $this->current_profile->id),
                                array("member_type_id", 2),
                               )
                        ));
			
        $subsc = Model_Service::query()
            ->where("profile_id", $this->current_profile->id)
            ->get_one();
    	
    	if(count($subsc) === 1)
    	{
    	    $subscribed = true;
    	}
    	else
    	{
    	    $subscribed = false;
    	}
        $profile_address = DB::select('city')
                            ->from('profiles')
                            ->where('id', $this->current_profile->id)
                               ->execute();
        $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();	

        $featured_events = Model_Event::get_featured_events();
        $result = Quicksearch::get_result($username, $password);
        $dating_members = Quicksearch::get_dating_agent_result($username, $password);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view = View::forge('profile/dashboard');
        if($this->current_profile->member_type_id == 3)
          {
            $view->latest_members = $dating_members;
          }
        else
        {
            $view->latest_members = $result[0];
            $view->counter = $result[1];
            $view->percentage = $result[2];
        }
        $view->online_members  = $online_members ;
        $view->referd  =  $referd;
        $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $view->subscribed  =  $subscribed;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);

        $notifications = Model_Notification::get_notifications($this->current_profile->id);
        if($notifications) {
            $view->notifications = $notifications;
        }

        if ($featured_events !== false) {
            $view->set_global("featured_events", $featured_events);
        }

        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/dashboard.js');
        $view->set_global('page_css', 'profile/dashboard.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Dashboard';
        $this->template->content = $view;
    }

    public function action_edit() {
        $gender = Model_Gender::find('all');
        $state = Model_State::find('all');
        $occupation = Model_Occupation::find('all');
        $relationship_status = Model_Relationshipstatus::find('all');
        $body_type = Model_Bodytype::find('all');
        $ethnicity = Model_Ethnicity::find('all');
        $eye_color = Model_Eyecolor::find('all');
        $hair_color = Model_Haircolor::find('all');
        $religion = Model_Religion::find('all');
        $smoke = Model_Smoke::find('all');
        $drink = Model_Drink::find('all');
        $priority_field = Model_Priorityfield::find('all');

        $view = View::forge('profile/edit', array(
                    'gender' => $gender,
                    'state' => $state,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'priority_field' => $priority_field,
                ));

        $preferred_members = DB::select('id', 'user_id', 'first_name', 'last_name', 'picture', 'city', 'state')
                        ->from('profiles')
                        ->where('id', '<>', $this->current_profile->id)
                        ->where('birth_date', '>=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_to))
                        ->where('birth_date', '<=', Model_Profile::get_birth_date_from_age($this->current_profile->ages_from))
                        ->where('gender_id', $this->current_profile->gender_id == 1 ? 2 : 1) //inorder to select opposite gender
                        ->where('state', $this->current_profile->state)
                        ->where('disable', 0)
                        ->where('is_activated', 1)
                        ->where('user_id', 'not in', Model_Profile::get_admin_user_ids() )
                        ->where('member_type_id', '<>', Model_Membershiptype::DATING_AGENT_MEMBER)
                        ->order_by(DB::expr('RAND()'))->limit(4)->execute()->as_array();

        $view->preferred_members = $preferred_members;
        $view->profile = $this->current_profile;
        $view->current_user = $this->current_user;

        $view->set_global('page_js', 'profile/edit.js');
        $view->set_global('page_css', 'profile/edit.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Edit Profile';
        $this->template->content = $view;
    }

    public function action_update() {
        if (Input::method() == 'POST') {
            $post = Input::post();

            foreach ($post as $key => $value) {
                if ($value == '') {
                    unset($post[$key]);
                }
                else{
                	if(isset($post['city'])){
                		$post['city'] = trim($post['city']);
                	}                    
                }
            }

            $post['birth_date'] = strtotime(date('Y-m-d', mktime(0, 0, 0, $post['month'], $post['day'], $post['year'])));
            unset($post['month'], $post['day'], $post['year']);

            $height = '';
            $height .= isset($post['height_foot']) ? $post['height_foot'] . "'" : '';
            $height .= isset($post['height_inches']) ? $post['height_inches'] . "''" : '';
            if ($height != '') {
                $post['height'] = $height;
            }

            $seeking_height = '';
            $seeking_height .= isset($post['seeking_height_foot']) ? $post['seeking_height_foot'] . "'" : '';
            $seeking_height .= isset($post['seeking_height_inches']) ? $post['seeking_height_inches'] . "''" : '';
            if ($seeking_height != '') {
                $post['seeking_height'] = $seeking_height;
            }

            $seeking_height_to = '';
            $seeking_height_to .= isset($post['seeking_height_to_foot']) ? $post['seeking_height_to_foot'] . "'" : '';
            $seeking_height_to .= isset($post['seeking_height_to_inches']) ? $post['seeking_height_to_inches'] . "''" : '';
            if ($seeking_height_to != '') {
                $post['seeking_height_to'] = $seeking_height_to;
            }

            unset($post['height_foot'], $post['height_inches'], $post['seeking_height_foot'], $post['seeking_height_inches'], $post['seeking_height_to_foot'], $post['seeking_height_to_inches']);

            if ($this->current_profile) {
                if($this->current_profile->picture == ""){
                    $post['is_completed'] = 0; //if profile picture is not yet uploaded set is_completed to false
                }

                $this->current_profile->set($post);
                if ($this->current_profile->save()) {
                    Session::set_flash('success', 'User profile updated successfully.!');
                } else {
                    Session::set_flash('error', 'Updating user profile failed. Please try again!');
                }
            } else {
                Session::set_flash('error', 'Please login to edit profile.');
            }
        }

        if (Input::is_ajax()) {
            $response = Response::forge();
            $response->body(json_encode(array(
                        'status' => true,
                    )));
            return $response;
        } else {
            if ($this->current_profile->is_completed) {
                Response::redirect("profile/dashboard");
            } else {
                Response::redirect("profile/edit");
            }
        }
    }

    public function action_upload_profile_picture() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $profile->picture = $file['saved_as'];
                    $profile->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Your profile picture is successfully uploaded!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a profile picture to upload!");
            }
        }
        Response::redirect('profile/edit');
    }

    public function action_public_profile($id=null,$browse=null)
    {
    	
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	
        if($id==null) {
            $profile = $this->current_profile;
        } else {
            $profile = Model_Profile::find($id);
        }

        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
       $num_records = count($email);
         if($num_records == 0){           
         	$referd = false;
         }
         else {
         	$referd = true;
         } 
        
         $subsc = Model_Service::query()
         ->where("profile_id", $this->current_profile->id)
         ->get_one();
          
         if(count($subsc) === 1)
         {
         	$subscribed = true;
         }
         else
         {
         	$subscribed = false;
         }
       
		 //$view->friends  =$friends;
		// $view->friends =$friends;
		// $view->set('friends',$friends);
		$profile_address = DB::select('city')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
	  $profile_state = DB::select('state')
                        ->from('profiles')
                        ->where('id', $this->current_profile->id)
                           ->execute();
         if(!empty($profile->gender_id))
         {
        $gender = Model_Gender::find($profile->gender_id);
        $occupation = Model_Occupation::find($profile->occupation_id);
        $relationship_status = Model_Relationshipstatus::find($profile->relationship_status_id);
        $body_type = Model_Bodytype::find($profile->body_type_id);
        $ethnicity = Model_Ethnicity::find($profile->ethnicity_id);
        $eye_color = Model_Eyecolor::find($profile->eye_color_id);
        $hair_color = Model_Haircolor::find($profile->hair_color_id);
        $religion = Model_Religion::find($profile->religion_id);
        $smoke = Model_Smoke::find($profile->smoke_id);
        $drink = Model_Drink::find($profile->drink_id);
        $seeking_gender = Model_Gender::find($profile->seeking_gender_id);
        $seeking_occupation = Model_Occupation::find($profile->seeking_occupation_id);
        $seeking_relationship_status = Model_Relationshipstatus::find($profile->seeking_relationship_status_id);
        $seeking_body_type = Model_Bodytype::find($profile->seeking_body_type_id);
        $seeking_ethnicity = Model_Ethnicity::find($profile->seeking_ethnicity_id);
        $seeking_eye_color = Model_Eyecolor::find($profile->seeking_eye_color_id);
        $seeking_hair_color = Model_Haircolor::find($profile->seeking_hair_color_id);
        $seeking_religion = Model_Religion::find($profile->seeking_religion_id);
        $seeking_smoke = Model_Smoke::find($profile->seeking_smoke_id);
        $seeking_drink = Model_Drink::find($profile->seeking_drink_id);
        $view = View::forge('profile/public_profile', array(
                    'gender' => $gender,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'seeking_gender' => $seeking_gender,
                    'seeking_occupation' => $seeking_occupation,
                    'seeking_relationship_status' => $seeking_relationship_status,
                    'seeking_body_type' => $seeking_body_type,
                    'seeking_ethnicity' => $seeking_ethnicity,
                    'seeking_eye_color' => $seeking_eye_color,
                    'seeking_hair_color' => $seeking_hair_color,
                    'seeking_religion' => $seeking_religion,
                    'seeking_smoke' => $seeking_smoke,
                    'seeking_drink' => $seeking_drink,
                ));
				
			
				
		$friends=Model_Friendship::get_friends($this->current_profile->id);

	   
		$view->browse = $browse;
        $view->current_user = $this->current_user;
        //$view->get_friend= $get_friend;
		$view->friends= $friends;
		$view->profile = $profile;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->latest_photos = Model_Image::query()->where("member_id", $profile->id)->order_by('created_at', 'desc')->limit(4)->get();
        $view->profile_address = $profile_address;
        $view->profile_state = $profile_state;
        $featured_events = Model_Event::get_featured_events(3);
        $view->featured_events = $featured_events !== false? Model_Event::get_featured_events(3) : null;

        $notifications = Model_Notification::get_notifications($profile->id);
        if($notifications) {
             $view->notifications = $notifications;
        }

        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
		
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/public_profile.js');
        $view->set_global('page_css', 'profile/public_profile.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Public Profile';
        $this->template->content = $view;
    }
    else
    {
    	\Fuel\Core\Response::redirect('pages/404');
    }
   }

    public function action_my_profile()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
        $profile = $this->current_profile;
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $gender = Model_Gender::find($profile->gender_id);
        $occupation = Model_Occupation::find($profile->occupation_id);
        $relationship_status = Model_Relationshipstatus::find($profile->relationship_status_id);
        $body_type = Model_Bodytype::find($profile->body_type_id);
        $ethnicity = Model_Ethnicity::find($profile->ethnicity_id);
        $eye_color = Model_Eyecolor::find($profile->eye_color_id);
        $hair_color = Model_Haircolor::find($profile->hair_color_id);
        $religion = Model_Religion::find($profile->religion_id);
        $smoke = Model_Smoke::find($profile->smoke_id);
        $drink = Model_Drink::find($profile->drink_id);
        $seeking_gender = Model_Gender::find($profile->seeking_gender_id);
        $seeking_occupation = Model_Occupation::find($profile->seeking_occupation_id);
        $seeking_relationship_status = Model_Relationshipstatus::find($profile->seeking_relationship_status_id);
        $seeking_body_type = Model_Bodytype::find($profile->seeking_body_type_id);
        $seeking_ethnicity = Model_Ethnicity::find($profile->seeking_ethnicity_id);
        $seeking_eye_color = Model_Eyecolor::find($profile->seeking_eye_color_id);
        $seeking_hair_color = Model_Haircolor::find($profile->seeking_hair_color_id);
        $seeking_religion = Model_Religion::find($profile->seeking_religion_id);
        $seeking_smoke = Model_Smoke::find($profile->seeking_smoke_id);
        $seeking_drink = Model_Drink::find($profile->seeking_drink_id);
        $view = View::forge('profile/my_profile', array(
                    'gender' => $gender,
                    'occupation' => $occupation,
                    'relationship_status' => $relationship_status,
                    'body_type' => $body_type,
                    'ethnicity' => $ethnicity,
                    'eye_color' => $eye_color,
                    'hair_color' => $hair_color,
                    'religion' => $religion,
                    'smoke' => $smoke,
                    'drink' => $drink,
                    'seeking_gender' => $seeking_gender,
                    'seeking_occupation' => $seeking_occupation,
                    'seeking_relationship_status' => $seeking_relationship_status,
                    'seeking_body_type' => $seeking_body_type,
                    'seeking_ethnicity' => $seeking_ethnicity,
                    'seeking_eye_color' => $seeking_eye_color,
                    'seeking_hair_color' => $seeking_hair_color,
                    'seeking_religion' => $seeking_religion,
                    'seeking_smoke' => $seeking_smoke,
                    'seeking_drink' => $seeking_drink,
                ));
        $view->current_user = $this->current_user;
        $view->profile = $profile;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->latest_photos = Model_Image::query()->where("member_id", $profile->id)->order_by('created_at', 'desc')->limit(10)->get();
	    $view->featured_datingPackages = Model_Datingpackage::get_random_active_dating_packages_by_state(9999,$this->current_profile->id);

        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->my_friends = Model_Friendship::get_friends($this->current_profile->id);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_profile.css');


        $this->template->title = 'WHERE WE ALL MEET &raquo; My Profile';
        $this->template->content = $view;
    }

    public function action_my_hellos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	 
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/my_hellos');

        $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
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

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");        
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_hellos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    }

    public function action_my_favorites()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
        $view = View::forge('profile/my_favorites');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $favorites_profiles = array();
        $profile_ids = array();
        $favorites = Model_Favorite::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        foreach ($favorites as $favorite) {
            array_push($profile_ids, $favorite->favorite_member_id);
        }
        if (!empty($profile_ids)) {
            $favorites_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
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
        $view->current_user = $this->current_user;
        $view->favorites_profiles = $favorites_profiles;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/my_hellos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Favorites';
        $this->template->content = $view;
    }

    public function action_my_friends()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/my_friends');
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
        $view->current_user = $this->current_user;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");

        $view->set_global('page_js', 'profile/my_friends.js');      

        $view->set_global('page_css', 'profile/my_friends.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
    }

    public function action_my_photos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}

        $view = View::forge('profile/my_photos');
        $view->profile_address = $this->current_profile->city;
	    $view->profile_state = $this->current_profile->state;
        $view->current_user = $this->current_user;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->images = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/my_photos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Photos';
        $this->template->content = $view;
    }

    public function action_manage_photos()
    {
    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
    	
    	$subsc = Model_Service::query()
    	->where("profile_id", $this->current_profile->id)
    	->get_one();
    	 
    	if(count($subsc) === 1)
    	{
    		$subscribed = true;
    	}
    	else
    	{
    		$subscribed = false;
    	}
        $view = View::forge('profile/manage_photos');

		 //$count_image = Model_Friendship::get_friends($this->current_profile->id);
		 //print_r(count($count_image));
		 // die;
        if (Input::post('btnRemovePhoto')) {
            if (count(Input::post('image_items')) > 0) {
                $images = Input::post('image_items');
                foreach ($images as $image_id) {
                    if($image_id == "profile") {
                        try {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            $file = File::get($image_directory . $this->current_profile->picture); //delete the main image
                            $file->delete();
                            foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                $file = File::get($image_directory . $type . "_" . $this->current_profile->picture);
                                $file->delete();
                            }
                        } catch (Exception $e) {

                        }
                        $this->current_profile->picture = "";
                        $this->current_profile->save();
                    }
                    else {
                        $objImage = Model_Image::find($image_id);
                        if ($objImage) {
                            $image_directory = DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($this->current_user['username']) . DIRECTORY_SEPARATOR;
                            try {
                                $file = File::get($image_directory . $objImage->file_name); //delete the main image
                                $file->delete();
                                foreach (Model_Profile::$thumbnails as $type => $dimensions) { //delete all thumbnails
                                    $file = File::get($image_directory . $type . "_" . $objImage->file_name);
                                    $file->delete();
                                }
                            } catch (Exception $e) {

                            }
                            $objImage->delete();
                        }
                    }
                }
                Session::set_flash("success", "Photos deleted successfully !");
            } else {
                Session::set_flash("error", "Select at least one photo to delete !");
            }
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
        $view->current_user = $this->current_user;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->my_photos = Model_Image::find('all', array("where" => array(array("member_id", $this->current_profile->id))));
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_photos.js');
        $view->set_global('page_css', 'profile/my_photos.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Manage Photos';
        $this->template->content = $view;
    }

    public function action_upload_photo() {
        if (Input::post()) {
            $post = Input::post();
            $user = $this->current_user;
            $profile = $this->current_profile;

            $upload_file = Input::file("picture");

            if ($upload_file["size"] > 0) {

                $config = array(
                    'path' => DOCROOT . "uploads" . DIRECTORY_SEPARATOR . Model_Profile::clean_name($user['username']),
                    'auto_rename' => false,
                    'overwrite' => true,
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    'create_path' => true,
                    'path_chmod' => 0777,
                    'file_chmod' => 0777,
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    Upload::save();
                    $file = Upload::get_files(0);
                    $post['member_id'] = $this->current_profile->id;
                    $post['file_name'] = $file['saved_as'];
                    $objImage = Model_Image::forge($post);
                    $objImage->save();

                    $filepath = $file['saved_to'] . $file['saved_as'];

                    foreach (Model_Profile::$thumbnails as $type => $dimensions) {
                        Image::load($filepath)->crop_resize($dimensions["width"], $dimensions["height"])->save($file['saved_to'] . $type . "_" . $file['saved_as']);
                    }
                    Session::set_flash("success", "Photo uploaded successfully!");
                } else {
                    Session::set_flash("error", "The file is not valid. Please try again!");
                }

                foreach (Upload::get_errors() as $file) {
                    Session::set_flash("error", $file['errors'][0]['error']);
                }
            } else {
                Session::set_flash("error", "Select a picture to upload!");
            }
        }
        Response::redirect('profile/my_photos');
    }

    public function action_my_setting() {
        $view = View::forge('profile/my_setting');
         $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $online_members = Quicksearch::get_online_members($username, $password);
         
		 $setting_value=Db::select('profile_id')
		            ->from('setting')
					->where('profile_id',$this->current_profile->id)
					->execute();
				
	      if(empty($setting_value[0]['profile_id'])){
		        $view = View::forge('profile/my_setting');
		                   }
	             else {
	         $view = View::forge('profile/update_setting');
	                  }
	     // $blocked_profile=Model_Profile::find('all',array("where"=> array(array("is_blocked",0))));
		 //$profiles = Model_profile::find('all',);
		 $savedsetting=Model_Setting::find('all',array(
		                     "where"=> array(
							 array("profile_id" ,$this->current_profile->id),
							 )
		               ));
					
		$profiles = Model_profile::find('all', array(
                    "where" => array(
                        array("is_blocked",1),
                   )
                ));
		
		
	     $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
		
		
		
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
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
      $view->profile_address = $profile_address;	
	  $view->profile_state = $profile_state;	
        $view->getemailaddress=$getemailaddress;
		$view->savedsetting=$savedsetting;
        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
		$view->setting_id=$setting_id; 
        $view->subscribed  =  $subscribed;
		$view->set('profiles', $profiles);
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    }

    public function action_delete_account() {
       $view = View::forge('profile/my_setting');
       $username = Auth::get_screen_name();
       $password = Auth::get('password');
       $email = DB::select('refered_email')
       ->from('referedemails')
       ->where('refered_email', $this->current_user->email)
       ->execute();
       $num_records = count($email);
       if($num_records == 0){
       	$referd = false;
       }
       else {
       	$referd = true;
       }
       
       $subsc = Model_Service::query()
       ->where("profile_id", $this->current_profile->id)
       ->get_one();
        
       if(count($subsc) === 1)
       {
       	$subscribed = true;
       }
       else
       {
       	$subscribed = false;
       }
	    $online_members = Quicksearch::get_online_members($username, $password);
		$savedsetting=Model_Setting::find('all',array(
		                     "where"=> array(
							 array("profile_id" ,$this->current_profile->id),
							 )
		               ));
	   if (Input::method() == 'POST') {
	   	$val = Model_Setting::validate('create');
	         //echo Auth::hash_password($_POST['paswword']).'<br>';
			 //echo $password;
			 
			 
			 $email=$_POST['email'];
			 $emailcheck=DB::select('id')
			             ->from('users')
						 ->where('email',$email)
						 ->execute();
						 
						
			 if ($val->run()) 
			 {
			  //echo $_POST['paswword'];
			 if($password==Auth::hash_password($_POST['paswword']))
			    {
			     $disable=DB::update('profiles')
				            ->where('user_id',$emailcheck[0]['id'])
							->value('disable',1)
							->execute();
							Response::redirect(Router::get("login"));
			     }
				
			  }
			 else {
                    Session::set_flash('error', $val->error());
					 $view = View::forge('profile/update_setting');
					
                }

	       }
		   $profiles = Model_profile::find('all', array(
                    "where" => array(
                        array("is_blocked",1),
                   )
                ));
 $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
				$setting_id = Model_setting::find('all', array(
                    "where" => array(
                        array("profile_id", $this->current_profile->id),
                     )
                ));
        $view->getemailaddress=$getemailaddress;
         $view->setting_id=$setting_id; 
		
        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
		$view->set('profiles',$profiles);
		 $view->savedsetting=$savedsetting;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
    
           
       
    }

    public function action_insert_setting() {
	 $view = View::forge('profile/my_setting');
       $username = Auth::get_screen_name();
       $password = Auth::get('password');
       $email = DB::select('refered_email')
       ->from('referedemails')
       ->where('refered_email', $this->current_user->email)
       ->execute();
       $num_records = count($email);
       if($num_records == 0){
       	$referd = false;
       }
       else {
       	$referd = true;
       }
       
       $subsc = Model_Service::query()
       ->where("profile_id", $this->current_profile->id)
       ->get_one();
        
       if(count($subsc) === 1)
       {
       	$subscribed = true;
       }
       else
       {
       	$subscribed = false;
       }
	    $online_members = Quicksearch::get_online_members($username, $password);
	
		 
		if (Input::method() == 'POST') {
	
		   if(empty($_POST['list']) )
		   {
		      $_POST['list']=0;
		   }			 
		if(empty($_POST['list1']))
			       {
				   $_POST['list1']=0; 
				   }
		if(empty($_POST['list2']))
				   {
				    $_POST['list2']=0; 
				   }
		if(empty($_POST['list3']))
				   {
				   $_POST['list3']=0; 
				   }
				   
		  
	   $hello=$_POST['hellosetting'];
	   $message=$_POST['messagesetting'];
	   $perweek=$_POST['perweek'];
	   $subscribe=$_POST['subscribe'];
				  // echo $_POST['list'];
				   // echo $_POST['list1'];
					// echo $_POST['list2'];
					 // echo $_POST['list3'];
	 		   
	    $setting = Model_Setting::forge(array(
                      'private_profile'=> $_POST['list'],
                      'data_sharing'=>$_POST['list1'],
                      'where_we_all_meet'=> $_POST['list2'],
                      'hello_notification'=>$hello,
                      'message_notification'=>$message,
                      'top_matches'=>$perweek,
                      'special_offers'=>$subscribe,
                      'send_me_email_notifcation'=>$_POST['list3'],
					   'profile_id'=>$this->current_profile->id,
                           ));
				if ($setting and $setting->save())
				{	
				 Session::set_flash('success', 'updated file ');
                 Response::redirect('profile/my_setting');
						   
		 }
		}
		 $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
        $view->getemailaddress=$getemailaddress;

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
     
	 }

    public function action_updating_setting() {
	       $view = View::forge('profile/my_setting');
         $username = Auth::get_screen_name(); 
        $password = Auth::get('password');
        $online_members = Quicksearch::get_online_members($username, $password);
        $email = DB::select('refered_email')
        ->from('referedemails')
        ->where('refered_email', $this->current_user->email)
        ->execute();
        $num_records = count($email);
        if($num_records == 0){
        	$referd = false;
        }
        else {
        	$referd = true;
        }
        $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        if (Input::method() == 'POST') {
		   if(empty($_POST['list']) )
		   {
		      $_POST['list']=0;
		   }			 
		if(empty($_POST['list1']))
			       {
				   $_POST['list1']=0; 
				   }
		if(empty($_POST['list2']))
				   {
				    $_POST['list2']=0; 
				   }
		if(empty($_POST['list3']))
				   {
				   $_POST['list3']=0; 
				   }
			 $hello=$_POST['hellosetting'];
	   $message=$_POST['messagesetting'];
	   $perweek=$_POST['perweek'];
	   $subscribe=$_POST['subscribe'];

	   $result = DB::update('setting')
                  ->set(array(
                      'private_profile'=>$_POST['list'],
                      'data_sharing'=>$_POST['list1'],
					  'where_we_all_meet'=>$_POST['list2'],
                      'hello_notification'=>$hello,
					  'message_notification'=>$message,
                      'top_matches'=>$perweek,
					  'special_offers'=>$subscribe,
                      'send_me_email_notifcation'=>$_POST['list3'],
    ))
    ->where('profile_id', '=',$this->current_profile->id)
    ->execute();
		    Session::set_flash('success', 'updated file ');
                 Response::redirect('profile/my_setting');
						   
		 
					  
			}		  
        $hello_profiles = array();
        $profile_ids = array();
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $this->current_profile->id))));
        foreach ($hellos as $hello) {
            array_push($profile_ids, $hello->from_member_id);
        }
        if (!empty($profile_ids)) {
            $hello_profiles = Model_Profile::query()->where("id", "IN", $profile_ids)->get();
        }
        $getprofileid=DB::select('user_id')
                     ->from('profiles')
                     ->where('id',$this->current_profile->id)
                     ->execute();
           
        $getemailaddress= Model_users::find('all', array(
                    "where" => array(
                        array("id",$getprofileid[0]['user_id']),
                    )
                ));
        $view->getemailaddress=$getemailaddress;

        $view->current_user = $this->current_user;
        $view->hello_profiles = $hello_profiles;
        $view->online_members = $online_members ;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_profile.js');
        $view->set_global('page_css', 'profile/my_setting.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; My Hellos';
        $this->template->content = $view;
	  }

	public function action_refer_friends()
    {
	    	$username = Auth::get_screen_name();
    	$password = Auth::get('password');
    	$email = DB::select('refered_email')
    	->from('referedemails')
    	->where('refered_email', $this->current_user->email)
    	->execute();
    	$num_records = count($email);
    	if($num_records == 0){
    		$referd = false;
    	}
    	else {
    		$referd = true;
    	}
		if (Input::method() == 'POST') {
		$refer_from = Input::post('refer_from');
		$refer_id = Input::post('refered_id');
		$refer_to= $_POST['referOption'];
		$status= 0;
		 $refer_friends = Model_Referfriends::forge(array(
                                        'refer_from' => $refer_from,
                                        'refer_to' => $refer_to,
										'refered_id' => $refer_id,
                                        'status' => $status,
                                        ));
	    if ($refer_friends and $refer_friends->save()) {
                       	{
                      Session::set_flash('success', 'successfully refered to a friends ');
                         }
		
		 }
		 }
     $subsc = Model_Service::query()
        ->where("profile_id", $this->current_profile->id)
        ->get_one();
         
        if(count($subsc) === 1)
        {
        	$subscribed = true;
        }
        else
        {
        	$subscribed = false;
        }
        $view = View::forge('profile/my_friends');
        $view->current_user = $this->current_user;
        $view->pending_friends = Model_Friendship::get_pending_friends($this->current_profile->id);
        $view->friends = Model_Friendship::get_friends($this->current_profile->id);
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->online_members  =  $online_members;  
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/my_friends.js');      
        $view->set_global('page_css', 'profile/my_friends.css');
        $this->template->title = 'WHERE WE ALL MEET &raquo; My Friends';
        $this->template->content = $view;
	
	
    	    }

    public function action_accept_invitation($invitation_id)
    {
        if( ! Input::is_ajax())
        \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();
        $invitation = Model_Referfriends::find($invitation_id);
        $invitation->status = Model_Referfriends::INVITATION_ACCEPTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'accepted' => true,
                'url' => \Fuel\Core\Uri::create('profile/public_profile/'.$invitation->refered_id)
            )));
        }

        return $response->body(json_encode(array(
            'accepted' => false,
        )));

    }

    public function action_reject_invitation($invitation_id)
    {
        if( ! Input::is_ajax())
            \Fuel\Core\Response::redirect('pages/404');

        $response = \Fuel\Core\Response::forge();
        $invitation = Model_Referfriends::find($invitation_id);
        $invitation->status = Model_Referfriends::INVITATION_REJECTED;

        if($invitation->save()){
            return $response->body(json_encode(array(
                'rejected' => true,
            )));
        }

        return $response->body(json_encode(array(
            'rejected' => false,
        )));

    }

    public function action_get_profile_picture() {
        $response = Response::forge();
        if (Input::method() == 'POST' or Input::is_ajax()) {
            $user = \Model\Auth_User::find('first', array("where" => array(array("username", Input::post("username")))));
            if($user) {
                $profile = Model_Profile::find('first', array("where" => array(array("user_id", $user->id))));
                if($profile) {
                    $response->body(json_encode(array(
                        'status' => true,
                        'profile_picture' => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"),
                    )));
                }
                else {
                    $response->body(json_encode(array(
                        'status' => false,
                        'profile_picture' => Model_Profile::get_picture("", 0, "members_list"),
                    )));
                }
            }
            else {
                $response->body(json_encode(array(
                    'status' => false,
                    'profile_picture' => Model_Profile::get_picture("", 0, "members_list"),
                )));
            }
            return $response;
        }
        else {
            return $response->set_status(400);
        }
    }
}