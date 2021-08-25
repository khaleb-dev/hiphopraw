<?php

class Controller_Refer_friends extends Controller_Base {
    public $template = 'layout/template';

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_send($id=null) {
	
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
        
         $subscribed = Model_Service::query()
         ->where("profile_id", $this->current_profile->id)
         ->get_one();
       
		 //$view->friends  =$friends;
		// $view->friends =$friends;
		// $view->set('friends',$friends);
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

		
		
        $view->current_user = $this->current_user;
        //$view->get_friend= $get_friend;
		$view->friends= $friends;
		$view->profile = $profile;
        $online_members = Quicksearch::get_online_members($username, $password);
        $view->latest_photos = Model_Image::query()->where("member_id", $profile->id)->order_by('created_at', 'desc')->limit(10)->get();
        $view->online_members  =  $online_members;
        $view->referd  =  $referd;
        $view->subscribed  =  $subscribed;
        $view->set_global("active_page", "dashboard");
        $view->set_global('page_js', 'profile/public_profile.js');
        $view->set_global('page_css', 'profile/public_profile.css');

        $this->template->title = 'WHERE WE ALL MEET &raquo; Public Profile';
        $this->template->content = $view;
    }
}