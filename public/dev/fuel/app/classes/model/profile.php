<?php

class Model_Profile extends \Orm\Model
{

    protected static $_properties = array(
        'id',
        'user_id',
        'first_name',
        'last_name',
        'gender_id',
        'postal_code',
        'my_caption',
        'birth_date',
        'city',
        'state',
        'zip',
        'address',
        'picture',
        'is_activated',
        'is_completed',
        'is_blocked',
        'activation_code',
        'height',
        'body_type_id',
        'ethnicity_id',
        'eye_color_id',
        'hair_color_id',
        'member_type_id',
        'occupation_id',
        'relationship_status_id',
        'have_kids',
        'want_kids',
        'religion_id',
        'smoke_id',
        'drink_id',
        'about_me',
        'things_looking_for',
        'first_thing_noticable',
        'interest',
        'friends_describe_me',
        'for_fun',
        'favorite_things',
        'last_book_read',
        'ages_from',
        'ages_to',
        'seeking_gender_id',
        'seeking_location',
        'seeking_occupation_id',
        'seeking_relationship_status_id',
        'seeking_have_kids',
        'seeking_want_kids',
        'seeking_body_type_id',
        'seeking_ethnicity_id',
        'seeking_height',
        'seeking_height_to',
        'seeking_eye_color_id',
        'seeking_hair_color_id',
        'seeking_religion_id',
        'seeking_smoke_id',
        'seeking_drink_id',
        'priority_1',
        'priority_2',
        'priority_3',
        'priority_4',
        'priority_5',
        'created_at',
        'updated_at',
        'is_logged_in',
		'disable',
        'profile_name'
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'profiles';

    /**
     * one to one relationship to Auth_User
     */
    protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'user_id',
            'model_to' => 'Auth\Model\Auth_User',
            'key_to' => 'id',
        ),
    );

    /**
     * @var array    has_many relationships
     */
    protected static $_has_many = array(
        'services' => array(
            'model_to' => 'Model_Service',
            'key_from' => 'id',
            'key_to' => 'profile_id',
            'cascade_delete' => true,
        ),
        'billing' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Billing',
            'key_to' => 'profile_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );

    // in a Model_Post which has and belongs to many Users
    // = multiple posts per user and multiple users (authors) per post
    protected static $_many_many = array(
        'paymenttypes' => array(
            'key_from' => 'id',
            'key_through_from' => 'profile_id', // column 1 from the table in between, should match a posts.id
            'table_through' => 'services', // both models plural without prefix in alphabetical order
            'key_through_to' => 'payment_type_id', // column 2 from the table in between, should match a users.id
            'model_to' => 'Model_Paymenttype',
            'key_to' => 'id',
        )
    );

    public static $thumbnails = array(
        "profile" => array("width" => 242, "height" => 190),
        "members_list" => array("width" => 146, "height" => 116),
        "profile_medium" => array("width" => 163, "height" => 140),
        "members_medium" => array("width" => 127, "height" => 97),
        "slimbox" => array("width" => 600, "height" => 400),
        "activity-avatar" => array("width" => 47, "height" => 47),
    );

    public static function clean_name($name)
    {
        return preg_replace("/[^A-Za-z0-9]/", "", $name);
    }

    public static function get_picture($picture, $user_id, $type)
    {
        $user = \Auth\Model\Auth_User::find($user_id);
        if (isset($picture) && $picture != "") {
            if($type == "original") {
                return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $picture);
            }
            elseif($type == "slimbox") {
                $file_name = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture;
                if(file_exists($file_name)) {
                    return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture);
                }
                else {
                    $original_file = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $picture;
                    $save_as = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture;
                    Image::load($original_file)->crop_resize(600, 400)->save($save_as);
                    return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture);
                }
            }
            elseif($type == "activity-avatar") {
                $file_name = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture;
                if(file_exists($file_name)) {
                    return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture);
                }
                else {
                    $original_file = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $picture;
                    $save_as = "uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture;
                    Image::load($original_file)->crop_resize(47, 47)->save($save_as);
                    return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture);
                }
            }
            else {
                return Uri::create("uploads/" . Model_Profile::clean_name($user['username']) . "/" . $type . "_" . $picture);
            }
        } else {
            return Uri::create("assets/img/defaults/" . $type . "_pic.jpg");
        }
    }

    public static function get_age($birthDate) {
        return date("Y")-date("Y", $birthDate);
    }

    public static function get_birth_date_from_age($age)
    {
        $year = (date("Y") - $age);
        $month = date("m");
        $day = date("d");
        return strtotime(date('Y-m-d', mktime(0, 0, 0, $month, $day, $year)));
    }

    public function is_paid_member()
    {
        return Model_Profile::query()
            ->related("services")
            ->related("paymenttypes")
            ->where('id', "=", 13)
            ->where('paymenttypes.mode', "=", 'recurring')
            ->count() > 0;
    }

    public function has_paid_service($service_type_id)
    {
        return Model_Profile::query()
            ->related("services")
            ->where('id', "=", $this->id)
            ->where('services.payment_type_id', "=", $service_type_id)
            ->count() > 0;
    }
    
    public static function get_dating_agents()
    {
    	$result = Model_Profile::find('all', array(
    			'where' => array('member_type_id' => Model_Membershiptype::DATING_AGENT_MEMBER)));
    	if(count($result) > 0)
    		return $result;
    	
    	return false;
    }
    
    public static function is_dating_agent($profile_id)
    {
    	$result = Model_Profile::query()
    		->where('member_type_id', '=', Model_Membershiptype::DATING_AGENT_MEMBER)
    		->where('id', '=', $profile_id)
    		->get_one();
    	
    	if(count($result) === 1){
    		return true;
    	}
    	
    	return false;
    }

    public static function is_premium_member($profile_id)
    {
    	$result = Model_Profile::query()
    	->where('member_type_id', '=', Model_Membershiptype::PREMIER_MEMBER)
    	->where('id', '=', $profile_id)
    	->get_one();
    	 
    	if(count($result) === 1){
    		return true;
    	}
    	 
    	return false;
    }

    public static function get_username($user_id, $no_of_chars=0)
    {
        $user = \Auth\Model\Auth_User::find($user_id);
        return $user ? ($no_of_chars==0? $user->username : \Fuel\Core\Str::truncate($user->username, $no_of_chars)) : "";
    }
    
    public static function is_deleted_account($profile_id)
    {
    	$result = Model_Profile::query()
    	->where('disable', '=', 1)
    	->where('id', '=', $profile_id)
    	->get_one();
    	 
    	if(count($result) === 1){
    		return true;
    	}
    	 
    	return false;
    }
    
    public static function is_free_member($profile_id)
    {
    	$result = Model_Profile::query()
    	->where('member_type_id', '=', Model_Membershiptype::FREE_MEMBER)
    	->where('id', '=', $profile_id)
    	->get_one();
    
    	if(count($result) === 1){
    		return true;
    	}
    
    	return false;
    }

    public static function get_admin_user_ids() {
        $admin_users =  Model_Users::find('all', array('where' => array('group_id' => 5)));
        $admin_user_ids = ''; $i=0;
        foreach($admin_users as $admin){
            if($i == count($admin_users)-1) {
                $admin_user_ids .= $admin->id.'';
            }
            else {
                $admin_user_ids .= ','.$admin->id.',';
            }
            $i++;
        }
        return array($admin_user_ids);
    }

    public static function count_all_online_members() {
        $result = Model_Profile::find('all', array(
            'where' => array('is_logged_in' => 1)));
        return count($result);
    }
}
