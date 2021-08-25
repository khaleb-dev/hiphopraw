<?php
namespace Model;
use DB;
use \Model\Quicksearchemptyhandlerpone;
use \Model\Quicksearchemptyhandlerptwo;
use \Model\Quicksearchemptyhandlerpthree;
use \Model\Quicksearchemptyhandlerpfour;
use \Model\Quicksearchemptyhandlerpfive;
use \Model\Quicksearchemptyhandlerpnone;
use Model_Notification;
class Quicksearch extends \Model {
	public static $counter = 0;
	public static $percentage = array();

	public static function get_counter()
	{
		return self::$counter;
	}
	public static function get_percentage()
	{
		return self::$percentage;
	}

	public static function get_profile_id($username, $password)
	{
		$result = DB::select('profiles.id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('username', $username)
		->and_where('password', $password)
		->execute();
		return $result[0]['id'];
	}

	public static function get_dating_agent_result($username, $password)
	{
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$dating_members=array();
		
			$dating_member = DB::select('profiles.id','city','first_name','last_name','picture','users.username','profiles.user_id','state','group_id', 'seeking_gender_id', 'ages_from', 'ages_to', 'relationship_status_id', 'want_kids', 'ethnicity_id', 'body_type_id')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('profiles.id', '!=', Quicksearch::get_profile_id($username, $password))
            ->where('is_activated', 1)
			->order_by('profiles.created_at','desc')
			->limit(log($count))
			->execute();
			foreach($dating_member as $value) {
				array_push($dating_members, $value);
			}
		
		return $dating_members;
	}

	public static function get_default_members($username, $password)
	{
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$default_members=array();
	
		$default_member = DB::select('profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
  		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('gender_id', '!=', $resu)
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
        ->and_where('is_activated',1)
		->order_by(DB::expr('RAND()'))
		->limit(30)
		->execute();
		foreach($default_member as $value) {
			array_push($default_members, $value);
		}
	
		return $default_members;
	}

	public static function get_top_match_choice($username, $password)
	{
		$id = Quicksearch::get_profile_id($username, $password);
		$result = DB::select('top_matches')
		->from('setting')
		->join('profiles', 'right')->on('profiles.id', '=', 'setting.profile_id')
		->where('setting.profile_id',$id)
		->execute();
		return $result[0]['top_matches'];
	}
	
	public static function get_all_online_members($username, $password)
	{
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$online_members=array();
		$check = Quicksearchemptyhandlerpnone::get_state($username, $password);
		if(!empty($check))
		{
			$online_member = DB::select('profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->and_where('is_logged_in',1)
			->limit(log($count))
			->execute();
			foreach($online_member as $value) {
				array_push($online_members, $value);
			}
		}
		return $online_members;
	}
	
	public static function get_online_members($username, $password)
	{
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$online_members=array();
		$check = Quicksearchemptyhandlerpnone::get_state($username, $password);
		if(!empty($check))
		{
		$online_member = DB::select('profiles.id','city','first_name','last_name','picture','users.username','profiles.user_id','state','group_id', 'seeking_gender_id', 'ages_from', 'ages_to', 'relationship_status_id', 'want_kids', 'ethnicity_id', 'body_type_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('gender_id', '!=', $resu)
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->and_where('is_logged_in',1)
        ->and_where('is_activated',1)
		->limit(7)
		->execute();
		foreach($online_member as $value) {
			array_push($online_members, $value);
		}
	 }
		return $online_members;
	}
		
	public static function get_priority1($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('name')
		->from('priorityfields')
		->join('profiles', 'right')->on('priorityfields.id', '=', 'profiles.priority_1')
		->where('user_id', $id)
        ->where('is_activated', 1)
		->execute();
		return $result;
	}

    public static function get_priority2($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('name')
		->from('priorityfields')
		->join('profiles', 'right')->on('priorityfields.id', '=', 'profiles.priority_2')
		->where('user_id', $id)
        ->where('is_activated', 1)
		->execute();
		return $result;
	}

    public static function get_priority3($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('name')
		->from('priorityfields')
		->join('profiles', 'right')->on('priorityfields.id', '=', 'profiles.priority_3')
		->where('user_id', $id)
        ->where('is_activated', 1)
		->execute();
		return $result;
	}

    public static function get_priority4($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('name')
		->from('priorityfields')
		->join('profiles', 'right')->on('priorityfields.id', '=', 'profiles.priority_4')
		->where('user_id', $id)
        ->where('is_activated', 1)
		->execute();
		return $result;
	}

    public static function get_priority5($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('name')
		->from('priorityfields')
		->join('profiles', 'right')->on('priorityfields.id', '=', 'profiles.priority_5')
		->where('user_id', $id)
        ->where('is_activated', 1)
		->execute();
		return $result;
	}
   
	public static function get_id($username, $password) 
	{
		$result = DB::select('id')
		->from('users')
		->where('username', $username)
		->and_where('password', $password)
		->execute();
		return $result[0]['id'];
	}

    public static function getcountry($id)
	{
		$result = DB::select('code')
		->from('countries')
		->where('id', $id)
		->execute();
		return $result[0]['code'];
	}
	
	public static function get_age_from($username, $password) 
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('ages_from')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['ages_from'];
	}
	
	public static function get_age_to($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('ages_to')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['ages_to'];
	}
	
	public static function get_seeking_relationship_status($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_relationship_status_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_relationship_status_id'];
	}

    public static function get_seeking_want_kids($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_want_kids')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_want_kids'];
	}

    public static function get_seeking_ethnicity($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_ethnicity_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_ethnicity_id'];
	}

    public static function get_seeking_eye_color($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_eye_color_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_eye_color_id'];
	}

    public static function get_seeking_religion($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_religion_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_religion_id'];
	}

    public static function get_seeking_drink($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_drink_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_drink_id'];
	}

    public static function get_seeking_location($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_location')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_location'];
		
	}

    public static function get_seeking_occupation($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_occupation_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_occupation_id'];
	}

    public static function get_seeking_have_kids($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_have_kids')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_have_kids'];
	}

    public static function get_seeking_body_type($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_body_type_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_body_type_id'];
	}

    public static function get_seeking_height($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_height')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_height'];
	}

    public static function get_seeking_hair_color($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_hair_color_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_hair_color_id'];
	}

    public static function get_seeking_smoke($username, $password)
	{
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('seeking_smoke_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['seeking_smoke_id'];
	}

    public static function get_gender($username, $password)
	{   
		$id = Quicksearch::get_id($username, $password);
		$result = DB::select('gender_id')
		->from('profiles')
		->where('user_id', $id)
		->execute();
		return $result[0]['gender_id'];
	}

    public static function get_yourmatch($username, $password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$myactual1,$myactual2,$myactual3,$myactual4,$myactual5,$actual11,$actual21,$actual31,$actual41,$actual51)
	{   
		
		$num_rows = 0;
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$result=array();		
		$start = strtotime(date('Y-m-d', mktime(0, 0, 0, 12, 4, 1970)));
		$end = 99999999999;
		$topmatchchoice = Quicksearch::get_top_match_choice($username, $password);
	if($topmatchchoice == 'Three per week')
		{
	        
		if((date('l') == 'Monday') && (strtotime("now") > strtotime("monday 12:00:00")))
		{
			$start = strtotime("last saturday 4:00:01");
			$end = strtotime("monday 12:00:00");
		}
		
		if((date('l') == 'Tuesday') || ((date('l') == 'Wednesday') && (strtotime("now") < strtotime("wednesday 20:00:00"))))
		{
			$start = strtotime("last saturday 4:00:01");
			$end = strtotime("last monday 12:00:00");
		}
		
		if((date('l') == 'Wednesday') && (strtotime("now") > strtotime("wednesday 20:00:00")))
		{
			$start = strtotime("last monday 12:00:01");
			$end = strtotime("wednesday 20:00:00");
		}
		if((date('l') == 'Thursday') || (date('l') == 'Friday') || ((date('l') == 'Saturday') &&(strtotime("now") < strtotime("saturday 4:00:00"))))
		{
			$start = strtotime("last monday 12:00:01");
			$end = strtotime("last wednesday 20:00:00");
		}
		
		if((date('l') == 'Saturday') && (strtotime("now") > strtotime("saturday 4:00:00")))
		{
			$start = strtotime("last wednesday 20:00:01");
			$end = strtotime("saturday 4:00:00");
		}
	
		if((date('l') == 'Sunday') || ((date('l') == 'Monday') &&(strtotime("now") < strtotime("monday 12:00:00"))))
		{
			$start = strtotime("last wednesday 20:00:01");
			$end = strtotime("last saturday 4:00:00");
		}
		
		}
		
		if($topmatchchoice == 'Every Day')
		{
	

		if(date('l') == 'Monday')
		{
		  $start = strtotime("monday 00:00:00");
		  $end = strtotime("now");
		}
		if(date('l') == 'Tuesday')
		{
			$start = strtotime("tuesday 00:00:00");
			$end = strtotime("now");
		}
		if(date('l') == 'Wednesday')
		{
			
			$start = strtotime("wednesday 00:00:00");
			$end = strtotime("now");
		}
		if(date('l') == 'Thursday')
		{
			$start = strtotime("thursday 00:00:00");
			$end = strtotime("now");
		}
		if(date('l') == 'Friday')
		{
			$start = strtotime("friday 00:00:00");
			$end = strtotime("now");
		}
		if(date('l') == 'Saturday')
		{
			$start = strtotime("saturday 00:00:00");
			$end = strtotime("now");
		}
		if(date('l') == 'Sunday')
		{
			$start = strtotime("sunday 00:00:00");
			$end = strtotime("now");
		}
			
		}
		
		if($topmatchchoice != 'Three per week' && $topmatchchoice != 'Every Day' )
		{
			$start = strtotime(date('Y-m-d', mktime(0, 0, 0, 12, 4, 1970)));
			$end = 99999999999;
		}
		//age is chosen as priority1
		if($chosen1=='birth_date')	
		{ 					     	
			$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('profiles.created_at','between', array($start, $end))
			->and_where($chosen1,'between', array($actual11, $myactual1))        
			->and_where($chosen2,$myactual2)        
			->and_where($chosen3,$myactual3)
			->and_where($chosen4,$myactual4)
			->and_where($chosen5,$myactual5) 
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->order_by('profiles.created_at','desc')
			->limit(log($count))    
			->execute();			
			$curr_rows = count($result1);
			$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			if($num_rows < log($count))                  
			{
				$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result2);
				$num_rows += $curr_rows;
			foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
				
			}
			 
			if($num_rows < log($count))      
			{
				$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result3);
				$num_rows += $curr_rows;
			foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
				
			}
			 
			if($num_rows < log($count))                
			{
				$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result4);
				$num_rows += $curr_rows;
			foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
			}
			if($num_rows < log($count))
			{
				$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result5);
				$num_rows += $curr_rows;
			foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
			}
			if($num_rows < log($count))
			{
				$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result6);
				$num_rows += $curr_rows;
			foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
			}
			if($num_rows < log($count))
			{
				$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result7);
				$num_rows += $curr_rows;
			foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
			}
			if($num_rows < log($count))
			{
				$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result8);
				$num_rows += $curr_rows;
				foreach($result8 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '78%');
				}
			}
			 
			if($num_rows < log($count))
			{
				$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows) 
				->execute();
				$curr_rows = count($result9);
				$num_rows += $curr_rows;
			foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
			}
			if($num_rows < log($count))
			{
				$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result10);
				$num_rows += $curr_rows;
			foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
			}
			if($num_rows < log($count))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
			foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
			}
			if($num_rows < log($count))
			{
				$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result12);
				$num_rows += $curr_rows;
			foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
			}
			if($num_rows < log($count))
			{
				$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result13);
				$num_rows += $curr_rows;
			foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
			}
			if($num_rows < log($count))
			{
				$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result14);
				$num_rows += $curr_rows;
			foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
			}
			if($num_rows < log($count))
			{
				$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array($actual11, $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result15);
				$num_rows += $curr_rows;
			foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
			
			}
			if($num_rows < log($count))
			{
				$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'between', array( $actual11,  $myactual1))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result16);
				$num_rows += $curr_rows;				
			foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
				
			}
			
			}
			if($num_rows < log($count))
			{
				$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<', $actual11)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',$myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result17);
				$num_rows += $curr_rows;
			foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
			}
			if($num_rows < log($count))
			{
				$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result18);
				$num_rows += $curr_rows;
			foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
			}
			if($num_rows < log($count))
			{
				$result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>', $myactual1)
				->where('gender_id', '!=', $resu)	
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result19);
				$num_rows += $curr_rows;
			foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
			}
			if($num_rows < log($count))
			{
				$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<', $actual11)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result20);
				$num_rows += $curr_rows;
			foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
			}
			if($num_rows < log($count))
			{
				$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<', $actual11)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)	
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result21);
				$num_rows += $curr_rows;
			foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
			}
			if($num_rows < log($count))
			{
				$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result22);
				$num_rows += $curr_rows;
			foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
			}
			if($num_rows < log($count))
			{
				$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result23);
				$num_rows += $curr_rows;
			foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
			}
			if($num_rows < log($count))
			{
				$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result24);
				$num_rows += $curr_rows;
			foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
			}
			if($num_rows < log($count))
			{
				$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result25);
				$num_rows += $curr_rows;
			foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
			}
			if($num_rows < log($count))
			{
				$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result26);
				$num_rows += $curr_rows;
			foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
			}
			if($num_rows < log($count))
			{
				$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result27);
				$num_rows += $curr_rows;
			foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
			}		
			if($num_rows < log($count))
			{
				$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result28);
				$num_rows += $curr_rows;
			foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
			}
			self::$counter = count($result);
			if($num_rows < log($count))
			{
				$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<', $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result29);
				$num_rows += $curr_rows;
			foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
			}
			if($num_rows < log($count))
			{
				$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<', $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result30);
				$num_rows += $curr_rows;
			foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
			}
			if($num_rows < log($count))
			{
				$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,'<',  $actual11)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen1,'>',  $myactual1)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result31);
				$num_rows += $curr_rows;
			foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
						
			$num_rows1 = 0;
			$bool = 0;
			if(empty($chosen1))
			{
				$chosen1 = 0;
			}
			if(empty($chosen2))
			{
				$chosen2 = 0;
			}
			if(empty($chosen3))
			{
				$chosen3 = 0;
			}
			if(empty($chosen4))
			{
				$chosen4 = 0;
			}
			if(empty($chosen5))
			{
				$chosen5 = 0;
			}
			
			if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
			{
				$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
				->where('relationship_status_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				foreach($result32 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
			{
				$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
				->where('want_kids','!=',null)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result33);
				$num_rows1 += $curr_rows1;
				foreach($result33 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
			{
				$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
				->where('ethnicity_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result34);
				$num_rows1 += $curr_rows1;
				foreach($result34 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
			{
				$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
				->where('eye_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result35);
				$num_rows1 += $curr_rows1;
				foreach($result35 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
			{
				$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
				->where('religion_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result36);
				$num_rows1 += $curr_rows1;
				foreach($result36 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
			{
				$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
				->where('drink_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result37);
				$num_rows1 += $curr_rows1;
				foreach($result37 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
				
			if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
			{
				$bool = 0;
				$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('state',Quicksearch::get_seeking_location($username, $password))
				->where('state','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result38);
				$num_rows1 += $curr_rows1;
				foreach($result38 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
			
			if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
			{
			
				$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
				->where('occupation_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result39);
				$num_rows1 += $curr_rows1;
				foreach($result39 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
			{
				$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
				->where('have_kids','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result40);
				$num_rows1 += $curr_rows1;
				foreach($result40 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
			{
				$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
				->where('body_type_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result41);
				$num_rows1 += $curr_rows1;
				foreach($result41 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
			{
				$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('height',Quicksearch::get_seeking_height($username, $password))
				->where('height','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result42);
				$num_rows1 += $curr_rows1;
				foreach($result42 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
			{
				$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
				->where('hair_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result43);
				$num_rows1 += $curr_rows1;
				foreach($result43 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
			{
				$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
				->where('smoke_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result44);
				$num_rows1 += $curr_rows1;
				foreach($result44 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			

	 }
	 
	 
	}
		
		//age is chosen as priority2
		
		if($chosen2=='birth_date')
		{   
			$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('profiles.created_at','between', array($start, $end))
			->and_where($chosen1,$myactual1)        
			->and_where($chosen2,'between', array($actual21, $myactual2))        
			->and_where($chosen3,$myactual3)
			->and_where($chosen4,$myactual4)
			->and_where($chosen5,$myactual5)  
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->order_by('profiles.created_at','desc')
			->limit(log($count))
			->execute();
			$curr_rows = count($result1);
			$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			if($num_rows < log($count))                 
			{
				$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4) 
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result2);
				$num_rows += $curr_rows;
			foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
			}
		
			if($num_rows < log($count))      
			{
				$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result3);
				$num_rows += $curr_rows;
			foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
			}
		
			if($num_rows < log($count))                 
			{
				$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result4);
				$num_rows += $curr_rows;
			foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
			}
			if($num_rows < log($count))
			{
				$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array($actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result5);
				$num_rows += $curr_rows;
			foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
			}
			if($num_rows < log($count))
			{
				$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result6);
				$num_rows += $curr_rows;
			foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
			}
			if($num_rows < log($count))
			{
				$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array($actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result7);
				$num_rows += $curr_rows;
			foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
			}
			if($num_rows < log($count))
			{
				$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result8);
				$num_rows += $curr_rows;
			foreach($result8 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			}
			}
		
			if($num_rows < log($count))
			{
				$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<', $actual21)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>', $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result9);
				$num_rows += $curr_rows;
			foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
			}
			if($num_rows < log($count))
			{
				$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result10);
				$num_rows += $curr_rows;
			foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
			}
			if($num_rows < log($count))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
			foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
			}
			if($num_rows < log($count))
			{
				$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result12);
				$num_rows += $curr_rows;
			foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
			}
			if($num_rows < log($count))
			{
				$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result13);
				$num_rows += $curr_rows;
			foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
			}
			if($num_rows < log($count))
			{
				$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result14);
				$num_rows += $curr_rows;
			foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
			}
			if($num_rows < log($count))
			{
				$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result15);
				$num_rows += $curr_rows;
			foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
			}
			if($num_rows < log($count))
			{
				$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result16);
				$num_rows += $curr_rows;
			foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
			}
			}
			if($num_rows < log($count))
			{
				$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array( $actual21, $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result17);
				$num_rows += $curr_rows;
			foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
			}
			if($num_rows < log($count))
			{
				$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result18);
				$num_rows += $curr_rows;
			foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
			}
			if($num_rows < log($count))
			{
				$result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array($actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result19);
				$num_rows += $curr_rows;
			foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
			}
			if($num_rows < log($count))
			{
				$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result20);
				$num_rows += $curr_rows;
			foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
			}
			if($num_rows < log($count))
			{
				$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array($actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result21);
				$num_rows += $curr_rows;
			foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
			}
			if($num_rows < log($count))
			{
				$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array($actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result22);
				$num_rows += $curr_rows;
			foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
			}
			if($num_rows < log($count))
			{
				$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result23);
				$num_rows += $curr_rows;
			foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
			}
			if($num_rows < log($count))
			{
				$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'between', array( $actual21,  $myactual2))
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result24);
				$num_rows += $curr_rows;
			foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
			}
			if($num_rows < log($count))
			{
				$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>', $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result25);
				$num_rows += $curr_rows;
			foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
			}
			if($num_rows < log($count))
			{
				$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result26);
				$num_rows += $curr_rows;
			foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
			}
			if($num_rows < log($count))
			{
				$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result27);
				$num_rows += $curr_rows;
			foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
			}
			if($num_rows < log($count))
			{
				$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>', $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result28);
				$num_rows += $curr_rows;
			foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
			}
			self::$counter = count($result);
			if($num_rows < log($count))
			{
				$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result29);
				$num_rows += $curr_rows;
			foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
			}
			if($num_rows < log($count))
			{
				$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<', $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result30);
				$num_rows += $curr_rows;
			foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
			}
			if($num_rows < log($count))
			{
				$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,'<',  $actual21)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen2,'>',  $myactual2)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result31);
				$num_rows += $curr_rows;
			foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
			}
			
			$num_rows1 = 0;
			$bool = 0;
			if(empty($chosen1))
			{
				$chosen1 = 0;
			}
			if(empty($chosen2))
			{
				$chosen2 = 0;
			}
			if(empty($chosen3))
			{
				$chosen3 = 0;
			}
			if(empty($chosen4))
			{
				$chosen4 = 0;
			}
			if(empty($chosen5))
			{
				$chosen5 = 0;
			}
			
			if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
			{
				$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
				->where('relationship_status_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				foreach($result32 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
			{
				$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
				->where('want_kids','!=',null)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result33);
				$num_rows1 += $curr_rows1;
				foreach($result33 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
			{
				$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
				->where('ethnicity_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result34);
				$num_rows1 += $curr_rows1;
				foreach($result34 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
			{
				$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
				->where('eye_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result35);
				$num_rows1 += $curr_rows1;
				foreach($result35 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
			{
				$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
				->where('religion_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result36);
				$num_rows1 += $curr_rows1;
				foreach($result36 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
			{
				$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
				->where('drink_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result37);
				$num_rows1 += $curr_rows1;
				foreach($result37 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
				
			if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
			{
				$bool = 0;
				$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('state',Quicksearch::get_seeking_location($username, $password))
				->where('state','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result38);
				$num_rows1 += $curr_rows1;
				foreach($result38 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
			
			if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
			{
			
				$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
				->where('occupation_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result39);
				$num_rows1 += $curr_rows1;
				foreach($result39 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
			{
				$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
				->where('have_kids','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result40);
				$num_rows1 += $curr_rows1;
				foreach($result40 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
			{
				$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
				->where('body_type_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result41);
				$num_rows1 += $curr_rows1;
				foreach($result41 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
			{
				$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('height',Quicksearch::get_seeking_height($username, $password))
				->where('height','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result42);
				$num_rows1 += $curr_rows1;
				foreach($result42 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
			{
				$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
				->where('hair_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result43);
				$num_rows1 += $curr_rows1;
				foreach($result43 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
			{
				$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
				->where('smoke_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result44);
				$num_rows1 += $curr_rows1;
				foreach($result44 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
				
			
			
		}
		
		//age is chosen as priority3
		
		if($chosen3=='birth_date')
		{   
			$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('profiles.created_at','between', array($start, $end))
			->and_where($chosen1,$myactual1)        
			->and_where($chosen2,$myactual2)        
			->and_where($chosen3,'between', array( $actual31,  $myactual3))
			->and_where($chosen4,$myactual4)
			->and_where($chosen5,$myactual5)
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->order_by('profiles.created_at','desc')
			->limit(log($count))
			->execute();
			$curr_rows = count($result1);
			$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			
			if($num_rows < log($count))                   
			{
				$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4) 
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result2);
				$num_rows += $curr_rows;
			foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
			}
			
			if($num_rows < log($count))     
			{
				$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result3);
				$num_rows += $curr_rows;
			foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
			}
			
			if($num_rows < log($count))                 
			{
				$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result4);
				$num_rows += $curr_rows;
			foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<', $actual31)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>', $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result5);
				$num_rows += $curr_rows;
			foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<', $actual31)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result6);
				$num_rows += $curr_rows;
			foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result7);
				$num_rows += $curr_rows;
			foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result8);
				$num_rows += $curr_rows;
			foreach($result8 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result9);
				$num_rows += $curr_rows;
			foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31, $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result10);
				$num_rows += $curr_rows;
			foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
			foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array($actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result12);
				$num_rows += $curr_rows;
			foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<',  $actual31)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result13);
				$num_rows += $curr_rows;
			foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<', $actual31)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result14);
				$num_rows += $curr_rows;
			foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)				
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result15);
				$num_rows += $curr_rows;
			foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result16);
				$num_rows += $curr_rows;
			foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result17);
				$num_rows += $curr_rows;
			foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result18);
				$num_rows += $curr_rows;
			foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31, $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result19);
				$num_rows += $curr_rows;
			foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result20);
				$num_rows += $curr_rows;
			foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<', $actual31)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result21);
				$num_rows += $curr_rows;
			foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
			}
			
			if($num_rows < log($count))
			{
				$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'>',  $myactual3)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result22);
				$num_rows += $curr_rows;
			foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
			}
			if($num_rows < log($count))
			{
				$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result23);
				$num_rows += $curr_rows;
			foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
			}
			if($num_rows < log($count))
			{
				$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,'<',  $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result24);
				$num_rows += $curr_rows;
			foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
			}
			if($num_rows < log($count))
			{
				$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result25);
				$num_rows += $curr_rows;
			foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
			}
			if($num_rows < log($count))
			{
				$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result26);
				$num_rows += $curr_rows;
			foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
			}
			if($num_rows < log($count))
			{
				$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31,  $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result27);
				$num_rows += $curr_rows;
			foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
			}
			if($num_rows < log($count))
			{
				$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'between', array( $actual31, $myactual3))
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result28);
				$num_rows += $curr_rows;
			foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
			}
			self::$counter = count($result);
			if($num_rows < log($count))
			{
				$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result29);
				$num_rows += $curr_rows;
			foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
			}
			if($num_rows < log($count))
			{
				$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<',  $actual31)
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result30);
				$num_rows += $curr_rows;
			foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
			}
			if($num_rows < log($count))
			{
				$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,'<', $actual31)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen3,'>',  $myactual3)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result31);
				$num_rows += $curr_rows;
			foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
			}
			
			$num_rows1 = 0;
			$bool = 0;
			if(empty($chosen1))
			{
				$chosen1 = 0;
			}
			if(empty($chosen2))
			{
				$chosen2 = 0;
			}
			if(empty($chosen3))
			{
				$chosen3 = 0;
			}
			if(empty($chosen4))
			{
				$chosen4 = 0;
			}
			if(empty($chosen5))
			{
				$chosen5 = 0;
			}
			
			if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
			{
				$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
				->where('relationship_status_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				foreach($result32 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
			{
				$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
				->where('want_kids','!=',null)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result33);
				$num_rows1 += $curr_rows1;
				foreach($result33 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
			{
				$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
				->where('ethnicity_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result34);
				$num_rows1 += $curr_rows1;
				foreach($result34 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
			{
				$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
				->where('eye_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result35);
				$num_rows1 += $curr_rows1;
				foreach($result35 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
			{
				$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
				->where('religion_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result36);
				$num_rows1 += $curr_rows1;
				foreach($result36 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
			{
				$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
				->where('drink_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result37);
				$num_rows1 += $curr_rows1;
				foreach($result37 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
				
			if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
			{
				$bool = 0;
				$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('state',Quicksearch::get_seeking_location($username, $password))
				->where('state','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result38);
				$num_rows1 += $curr_rows1;
				foreach($result38 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
			
			if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
			{
			
				$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
				->where('occupation_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result39);
				$num_rows1 += $curr_rows1;
				foreach($result39 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
			{
				$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
				->where('have_kids','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result40);
				$num_rows1 += $curr_rows1;
				foreach($result40 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
			{
				$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
				->where('body_type_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result41);
				$num_rows1 += $curr_rows1;
				foreach($result41 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
			{
				$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('height',Quicksearch::get_seeking_height($username, $password))
				->where('height','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result42);
				$num_rows1 += $curr_rows1;
				foreach($result42 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
			{
				$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
				->where('hair_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result43);
				$num_rows1 += $curr_rows1;
				foreach($result43 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
			{
				$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
				->where('smoke_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result44);
				$num_rows1 += $curr_rows1;
				foreach($result44 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
				
			
		}
		
		//age is chosen as priority4
		
		if($chosen4=='birth_date')
		{   
			$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('profiles.created_at','between', array($start, $end))
			->and_where($chosen1,$myactual1)        
			->and_where($chosen2,$myactual2)        
			->and_where($chosen3,$myactual3)
			->and_where($chosen4,'between', array($actual41, $myactual4))
			->and_where($chosen5,$myactual5) 
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->order_by('profiles.created_at','desc')
			->limit(log($count))
			->execute();
			$curr_rows = count($result1);
			$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			if($num_rows < log($count))                    
			{
				$result2= DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array($actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result2);
				$num_rows += $curr_rows;
			foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
			}
		
			if($num_rows < log($count))      
			{
				$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result3);
				$num_rows += $curr_rows;
			foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
			}
		
			if($num_rows < log($count))                 
			{
				$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result4);
				$num_rows += $curr_rows;
			foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
			}
			if($num_rows < log($count))
			{
				$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array($actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result5);
				$num_rows += $curr_rows;
			foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
			}
			if($num_rows < log($count))
			{
				$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result6);
				$num_rows += $curr_rows;
			foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
			}
			if($num_rows < log($count))
			{
				$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result7);
				$num_rows += $curr_rows;
			foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
			}
			if($num_rows < log($count))
			{
				$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result8);
				$num_rows += $curr_rows;
			foreach($result8 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			}
			}
		
			if($num_rows < log($count))
			{
				$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result9);
				$num_rows += $curr_rows;
			foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
			}
			if($num_rows < log($count))
			{
				$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array($actual41, $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result10);
				$num_rows += $curr_rows;
			foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
			}
			if($num_rows < log($count))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
			foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
			}
			if($num_rows < log($count))
			{
				$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result12);
				$num_rows += $curr_rows;
			foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
			}
			if($num_rows < log($count))
			{
				$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result13);
				$num_rows += $curr_rows;
			foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
			}
			if($num_rows < log($count))
			{
				$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result14);
				$num_rows += $curr_rows;
			foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
			}
			if($num_rows < log($count))
			{
				$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result15);
				$num_rows += $curr_rows;
			foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
			}
			if($num_rows < log($count))
			{
				$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result16);
				$num_rows += $curr_rows;
			foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
			}
			}
			if($num_rows < log($count))
			{
				$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result17);
				$num_rows += $curr_rows;
			foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
			}
			if($num_rows < log($count))
			{
				$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result18);
				$num_rows += $curr_rows;
			foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
			}
			if($num_rows < log($count))
			{
				$result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result19);
				$num_rows += $curr_rows;
			foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
			}
			if($num_rows < log($count))
			{
				$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result20);
				$num_rows += $curr_rows;
			foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
			}
			if($num_rows < log($count))
			{
				$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41, $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result21);
				$num_rows += $curr_rows;
			foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
			}
			if($num_rows < log($count))
			{
				$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result22);
				$num_rows += $curr_rows;
			foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
			}
			if($num_rows < log($count))
			{
				$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result23);
				$num_rows += $curr_rows;
			foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
			}
			if($num_rows < log($count))
			{
				$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result24);
				$num_rows += $curr_rows;
			foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
			}
			if($num_rows < log($count))
			{
				$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result25);
				$num_rows += $curr_rows;
			foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
			}
			if($num_rows < log($count))
			{
				$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result26);
				$num_rows += $curr_rows;
			foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
			}
			if($num_rows < log($count))
			{
				$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result27);
				$num_rows += $curr_rows;
			foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
			}
			if($num_rows < log($count))
			{
				$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,'<',  $actual41)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen5,'!=',$myactual5)
				->or_where($chosen5,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result28);
				$num_rows += $curr_rows;
			foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
			}
			self::$counter = count($result);
			if($num_rows < log($count))
			{
				$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result29);
				$num_rows += $curr_rows;
			foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
			}
			if($num_rows < log($count))
			{
				$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'between', array( $actual41,  $myactual4))
				->and_where($chosen5,'!=',$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result30);
				$num_rows += $curr_rows;
			foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
				
			}
			if($num_rows < log($count))
			{
				$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,'<', $actual41)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen4,'>',  $myactual4)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result31);
				$num_rows += $curr_rows;
			foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
			}
			
			$num_rows1 = 0;
			$bool = 0;
			if(empty($chosen1))
			{
				$chosen1 = 0;
			}
			if(empty($chosen2))
			{
				$chosen2 = 0;
			}
			if(empty($chosen3))
			{
				$chosen3 = 0;
			}
			if(empty($chosen4))
			{
				$chosen4 = 0;
			}
			if(empty($chosen5))
			{
				$chosen5 = 0;
			}
			
			if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
			{
				$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
				->where('relationship_status_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				foreach($result32 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
			{
				$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->where('want_kids','!=',null)
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result33);
				$num_rows1 += $curr_rows1;
				foreach($result33 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
			{
				$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
				->where('ethnicity_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result34);
				$num_rows1 += $curr_rows1;
				foreach($result34 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
			{
				$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
				->where('eye_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result35);
				$num_rows1 += $curr_rows1;
				foreach($result35 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
			{
				$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
				->where('religion_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result36);
				$num_rows1 += $curr_rows1;
				foreach($result36 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
			{
				$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
				->where('drink_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result37);
				$num_rows1 += $curr_rows1;
				foreach($result37 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
				
			if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
			{
				$bool = 0;
				$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('state',Quicksearch::get_seeking_location($username, $password))
				->where('state','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result38);
				$num_rows1 += $curr_rows1;
				foreach($result38 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
			
			if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
			{
			
				$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
				->where('occupation_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result39);
				$num_rows1 += $curr_rows1;
				foreach($result39 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
			{
				$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
				->where('have_kids','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result40);
				$num_rows1 += $curr_rows1;
				foreach($result40 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
			{
				$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
				->where('body_type_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result41);
				$num_rows1 += $curr_rows1;
				foreach($result41 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
			{
				$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('height',Quicksearch::get_seeking_height($username, $password))
				->where('height','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result42);
				$num_rows1 += $curr_rows1;
				foreach($result42 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
			{
				$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
				->where('hair_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result43);
				$num_rows1 += $curr_rows1;
				foreach($result43 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
			{
				$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
				->where('smoke_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result44);
				$num_rows1 += $curr_rows1;
				foreach($result44 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
		}
			
		//age is chosen as priority5
		
		if($chosen5=='birth_date')
		{  
			$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			->from('profiles')
			->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
			->where('gender_id', '!=', $resu)
			->and_where('profiles.created_at','between', array($start, $end))
			->and_where($chosen1,$myactual1)        
			->and_where($chosen2,$myactual2)       
			->and_where($chosen3,$myactual3)
			->and_where($chosen4,$myactual4)
			->and_where($chosen5,'between', array( $actual51, $myactual5))
			->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
			->order_by('profiles.created_at','desc')
			->limit(log($count))
			->execute();
			$curr_rows = count($result1);
			$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			if($num_rows < log($count))                    
			{
				$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result2);
				$num_rows += $curr_rows;
			foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
			}
		
			if($num_rows < log($count))      
			{
				$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result3);
				$num_rows += $curr_rows;
			foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
			}
		
			if($num_rows < log($count))                
			{
				$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>', $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result4);
				$num_rows += $curr_rows;
			foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
			}
			if($num_rows < log($count))
			{
				$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result5);
				$num_rows += $curr_rows;
			foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
			}
			if($num_rows < log($count))
			{
				$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result6);
				$num_rows += $curr_rows;
			foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
			}
			if($num_rows < log($count))
			{
				$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51, $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result7);
				$num_rows += $curr_rows;
			foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
			}
			if($num_rows < log($count))
			{
				$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result8);
				$num_rows += $curr_rows;
			foreach($result8 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			}
			}
		
			if($num_rows < log($count))
			{
				$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result9);
				$num_rows += $curr_rows;
			foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
			}
			if($num_rows < log($count))
			{
				$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result10);
				$num_rows += $curr_rows;
			foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
			}
			if($num_rows < log($count))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
			foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
			}
			if($num_rows < log($count))
			{
				$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result12);
				$num_rows += $curr_rows;
			foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
			}
			if($num_rows < log($count))
			{
				$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result13);
				$num_rows += $curr_rows;
			foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
			}
			if($num_rows < log($count))
			{
				$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result14);
				$num_rows += $curr_rows;
			foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
			}
			if($num_rows < log($count))
			{
				$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result15);
				$num_rows += $curr_rows;
			foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
			}
			if($num_rows < log($count))
			{
				$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>', $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen1,$myactual1)
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result16);
				$num_rows += $curr_rows;
			foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
			}
			}
			if($num_rows < log($count))
			{
				$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result17);
				$num_rows += $curr_rows;
			foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
			}
			if($num_rows < log($count))
			{
				$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result18);
				$num_rows += $curr_rows;
			foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
			}
			if($num_rows < log($count))
			{
				$result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result19);
				$num_rows += $curr_rows;
			foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
			}
			if($num_rows < log($count))
			{
				$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<', $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result20);
				$num_rows += $curr_rows;
			foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
			}
			if($num_rows < log($count))
			{
				$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result21);
				$num_rows += $curr_rows;
			foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
			}
			if($num_rows < log($count))
			{
				$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result22);
				$num_rows += $curr_rows;
			foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
			}
			if($num_rows < log($count))
			{
				$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result23);
				$num_rows += $curr_rows;
			foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
			}
			if($num_rows < log($count))
			{
				$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
		        ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where($chosen2,$myactual2)
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result24);
				$num_rows += $curr_rows;
			foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
			}
			if($num_rows < log($count))
			{
				$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result25);
				$num_rows += $curr_rows;
			foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
			}
			if($num_rows < log($count))
			{
				$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result26);
				$num_rows += $curr_rows;
			foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
			}
			if($num_rows < log($count))
			{
				$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
			    ->from('profiles')
			    ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result27);
				$num_rows += $curr_rows;
			foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
			}
			if($num_rows < log($count))
			{
				$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where($chosen3,$myactual3)
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result28);
				$num_rows += $curr_rows;
			foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
			}
			self::$counter = count($result);
			if($num_rows < log($count))
			{
				$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result29);
				$num_rows += $curr_rows;
			foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
			}
			if($num_rows < log($count))
			{
				$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where($chosen5,'<',  $actual51)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->or_where($chosen5,'>',  $myactual5)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result30);
				$num_rows += $curr_rows;
			foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
			}
			if($num_rows < log($count))
			{
				$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where_open()
				->where($chosen1,'!=',$myactual1)
				->or_where($chosen1,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen2,'!=',$myactual2)
				->or_where($chosen2,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen3,'!=',$myactual3)
				->or_where($chosen3,'=',NULL)
				->and_where_close()
				->and_where_open()
				->where($chosen4,'!=',$myactual4)
				->or_where($chosen4,'=',NULL)
				->and_where_close()
				->and_where($chosen5,'between', array( $actual51,  $myactual5))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows)
				->execute();
				$curr_rows = count($result31);
				$num_rows += $curr_rows;
			foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
			}
			
			$num_rows1 = 0;
			$bool = 0;
			if(empty($chosen1))
			{
				$chosen1 = 0;
			}
			if(empty($chosen2))
			{
				$chosen2 = 0;
			}
			if(empty($chosen3))
			{
				$chosen3 = 0;
			}
			if(empty($chosen4))
			{
				$chosen4 = 0;
			}
			if(empty($chosen5))
			{
				$chosen5 = 0;
			}
			
			if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
			{
				$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
				->where('relationship_status_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				foreach($result32 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
			{
				$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
				->where('want_kids','!=',null)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result33);
				$num_rows1 += $curr_rows1;
				foreach($result33 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
			{
				$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
				->where('ethnicity_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result34);
				$num_rows1 += $curr_rows1;
				foreach($result34 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
			{
				$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
				->where('eye_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result35);
				$num_rows1 += $curr_rows1;
				foreach($result35 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
			{
				$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
				->where('religion_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result36);
				$num_rows1 += $curr_rows1;
				foreach($result36 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
			{
				$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
				->where('drink_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result37);
				$num_rows1 += $curr_rows1;
				foreach($result37 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
				
			if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
			{
				$bool = 0;
				$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('state',Quicksearch::get_seeking_location($username, $password))
				->where('state','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result38);
				$num_rows1 += $curr_rows1;
				foreach($result38 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			
			}
			
			if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
			{
			
				$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
				->where('occupation_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result39);
				$num_rows1 += $curr_rows1;
				foreach($result39 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
			{
				$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
				->where('have_kids','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result40);
				$num_rows1 += $curr_rows1;
				foreach($result40 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
						array_push($result, $value);
						array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
			{
				$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
				->where('body_type_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result41);
				$num_rows1 += $curr_rows1;
				foreach($result41 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
			{
				$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('height',Quicksearch::get_seeking_height($username, $password))
				->where('height','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result42);
				$num_rows1 += $curr_rows1;
				foreach($result42 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
			{
				$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
				->where('hair_color_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result43);
				$num_rows1 += $curr_rows1;
				foreach($result43 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
			
			if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
			{
				$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
				->where('smoke_id','!=',null)
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count)-$num_rows1)
				->execute();
				$curr_rows1 = count($result44);
				$num_rows1 += $curr_rows1;
				foreach($result44 as $value) {
					foreach($result as $member) {
						if($value['id'] == $member['id'])
						{
							$bool = 1;
						}
					}
					if($bool == 0 )
					{
					 array_push($result, $value);
					 array_push(self::$percentage, 'min. 7.2%');
					}
					$bool = 0;
				}
			}
				
		
		}
				
		//if age is not selected as a priority 
		
		if($chosen1 != 'birth_date' && $chosen2 != 'birth_date' && $chosen3 != 'birth_date' && $chosen4 != 'birth_date' && $chosen5 != 'birth_date')
		{
	
		$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('gender_id', '!=', $resu) 
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where($chosen1,$myactual1)        
		->and_where($chosen2,$myactual2)        
		->and_where($chosen3,$myactual3)
		->and_where($chosen4,$myactual4)
		->and_where($chosen5,$myactual5)
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count))
		->execute();
		$curr_rows = count($result1);
		$num_rows += $curr_rows;
		foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '100%');
			}
			
	  if($num_rows < log($count))                    
	  {
	  	$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('gender_id', '!=', $resu) 
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where($chosen1,$myactual1)        
		->and_where($chosen2,$myactual2)
		->and_where($chosen3,$myactual3)
		->and_where($chosen4,$myactual4) 
		->and_where_open()
		->where($chosen5,'!=',$myactual5)
		->or_where($chosen5,'=',NULL)
		->and_where_close()
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows)
		->execute();
		$curr_rows = count($result2);
		$num_rows += $curr_rows;
	  foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '96%');
			}
	  }
	  
	  if($num_rows < log($count))      
	  {
	  	$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)  
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)        
	  	->and_where($chosen2,$myactual2)
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result3);
	  	$num_rows += $curr_rows;
	  foreach($result3 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '94%');
			}
	  }
	  
	  if($num_rows < log($count))                 
	  {
	  	$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where($chosen2,$myactual2)
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result4);
	  	$num_rows += $curr_rows;
	  foreach($result4 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '90%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result5);
	  	$num_rows += $curr_rows;
	  foreach($result5 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '88%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result6);
	  	$num_rows += $curr_rows;
	  foreach($result6 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '84%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result7);
	  	$num_rows += $curr_rows;
	  foreach($result7 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
	  }
	  
	  if($num_rows < log($count))                
	  {
	  	$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	    ->order_by('profiles.created_at','desc')
	    ->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result8);
	  	$num_rows += $curr_rows;
	  foreach($result8 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result9);
	  	$num_rows += $curr_rows;
	  foreach($result9 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '77%');
			}
	 
	  } 
	  
	  if($num_rows < log($count))
	  {
	  	$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result10);
	  	$num_rows += $curr_rows;
	  foreach($result10 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '73%');
			}
	  }
	  
	  
	  if($num_rows < log($count))                
	  {
	  	$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result11);
	  	$num_rows += $curr_rows;
	  foreach($result11 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '71%');
			}
	  }
	  if($num_rows < log($count))                
	  {
	  	$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result12);
	  	$num_rows += $curr_rows;
	  foreach($result12 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '67%');
			}
	  }
	  if($num_rows < log($count))                
	  {
	  	$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result13);
	  	$num_rows += $curr_rows;
	  foreach($result13 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '66%');
			}
	  } 
	  if($num_rows < log($count))                 
	  {
	  	$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result14);
	  	$num_rows += $curr_rows;
	  foreach($result14 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '61%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result15);
	  	$num_rows += $curr_rows;
	  foreach($result15 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '59%');
			}
	  }
	  if($num_rows < log($count))                
	  {
	  	$result16 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where($chosen1,$myactual1)
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result16);
	  	$num_rows += $curr_rows;
	  foreach($result16 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '55%');
			}
	  	
	  }
	  if($num_rows < log($count))               
	  {
	  	$result17 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result17);
	  	$num_rows += $curr_rows;
	  foreach($result17 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '45%');
			}
	  	
	  } 
	  if($num_rows < log($count))                 
	  {
	  	$result18 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result18);
	  	$num_rows += $curr_rows;
	  foreach($result18 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '41%');
			}
	  }
	  if($num_rows < log($count))                
	  {
	  $result19 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  ->from('profiles')
	  ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  ->where('gender_id', '!=', $resu)
	  ->and_where('profiles.created_at','between', array($start, $end))
	  ->and_where_open()
	  ->where($chosen1,'!=',$myactual1)
	  ->or_where($chosen1,'=',NULL)
	  ->and_where_close()
	  ->and_where($chosen2,$myactual2)
	  ->and_where($chosen3,$myactual3)
	  ->and_where_open()
	  ->where($chosen4,'!=',$myactual4)
	  ->or_where($chosen4,'=',NULL)
	  ->and_where_close()
	  ->and_where($chosen5,$myactual5)
	  ->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  ->order_by('profiles.created_at','desc')
	  ->limit(log($count)-$num_rows)
	  ->execute();
	  $curr_rows = count($result19);
	  $num_rows += $curr_rows;
	  foreach($result19 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '39%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result20 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result20);
	  	$num_rows += $curr_rows;
	  foreach($result20 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
	  }
	  if($num_rows < log($count))                
	  {
	  	$result21 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result21);
	  	$num_rows += $curr_rows;
	  foreach($result21 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			}
	  } 
	  if($num_rows < log($count))                
	  {
	  	$result22 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result22);
	  	$num_rows += $curr_rows;
	  foreach($result22 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '29%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result23 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result23);
	  	$num_rows += $curr_rows;
	  foreach($result23 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '27%');
			}
	  }
	  if($num_rows < log($count))              
	  {
	  	$result24 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen2,$myactual2)
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result24);
	  	$num_rows += $curr_rows;
	  foreach($result24 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			}
	  } 
	  if($num_rows < log($count))                 
	  {
	  	$result25 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result25);
	  	$num_rows += $curr_rows;
	  foreach($result25 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '22%');
			}
	  } 
	  if($num_rows < log($count))                
	  {
	  	$result26 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result26);
	  	$num_rows += $curr_rows;
	  foreach($result26 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '18%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result27 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result27);
	  	$num_rows += $curr_rows;
	  foreach($result27 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '16%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result28 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen3,$myactual3)
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result28);
	  	$num_rows += $curr_rows;
	  foreach($result28 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '12%');
			}
	  } 
	  self::$counter = count($result);
	  if($num_rows < log($count))                 
	  {
	  	$result29 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result29);
	  	$num_rows += $curr_rows;
	  foreach($result29 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '10%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result30 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen4,$myactual4)
	  	->and_where_open()
	  	->where($chosen5,'!=',$myactual5)
	  	->or_where($chosen5,'=',NULL)
	  	->and_where_close()
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result30);
	  	$num_rows += $curr_rows;
	  foreach($result30 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '6%');
			}
	  }
	  if($num_rows < log($count))                 
	  {
	  	$result31 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
	  	->from('profiles')
	  	->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
	  	->where('gender_id', '!=', $resu)
	  	->and_where('profiles.created_at','between', array($start, $end))
	  	->and_where_open()
	  	->where($chosen1,'!=',$myactual1)
	  	->or_where($chosen1,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen2,'!=',$myactual2)
	  	->or_where($chosen2,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen3,'!=',$myactual3)
	  	->or_where($chosen3,'=',NULL)
	  	->and_where_close()
	  	->and_where_open()
	  	->where($chosen4,'!=',$myactual4)
	  	->or_where($chosen4,'=',NULL)
	  	->and_where_close()
	  	->and_where($chosen5,$myactual5)
	  	->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
	  	->order_by('profiles.created_at','desc')
	  	->limit(log($count)-$num_rows)
	  	->execute();
	  	$curr_rows = count($result31);
	  	$num_rows += $curr_rows;
	  foreach($result31 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '4%');
			}
	  } 
	 
	
	}
	
	$actual5a = Quicksearch::get_age_from($username, $password);
	$actual51a = Quicksearch::get_age_to($username, $password);
	$year5a = (date("Y") - $actual5a);
	$month5a = date("m");
	$day5a = date("d");
	$actual5a = strtotime(date('Y-m-d', mktime(0, 0, 0, $month5a, $day5a, $year5a)));
	$year51a = (date("Y") - $actual51a);
	$month51a = date("m");
	$day51a = date("d");
	$actual51a = strtotime(date('Y-m-d', mktime(0, 0, 0, $month51a, $day51a, $year51a)));
	$num_rows1 = 0;
	$bool = 0;
	if(empty($chosen1))
	{
		$chosen1 = 0;
	}
	if(empty($chosen2))
	{
		$chosen2 = 0;
	}
	if(empty($chosen3))
	{
		$chosen3 = 0;
	}
	if(empty($chosen4))
	{
		$chosen4 = 0;
	}
	if(empty($chosen5))
	{
		$chosen5 = 0;
	}
	
	if($chosen1 !== 'birth_date' && $chosen2 !== 'birth_date' && $chosen3 !== 'birth_date' && $chosen4 !== 'birth_date' && $chosen5 !== 'birth_date')
	{
		$result321 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('birth_date','between', array($actual51a,$actual5a))
		->where('birth_date','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count))
		->execute();
		$curr_rows1 = count($result321);
		$num_rows1 += $curr_rows1;
		foreach($result321 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
			array_push($result, $value);
			array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	
	if($chosen1 !== 'relationship_status_id' && $chosen2 !== 'relationship_status_id' && $chosen3 !== 'relationship_status_id' && $chosen4 !== 'relationship_status_id' && $chosen5 !== 'relationship_status_id')
	{
		$result32 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('relationship_status_id',Quicksearch::get_seeking_relationship_status($username, $password))
		->where('relationship_status_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result32);
		$num_rows1 += $curr_rows1;
		foreach($result32 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	if($chosen1 !== 'want_kids' && $chosen2 !== 'want_kids' && $chosen3 !== 'want_kids' && $chosen4 !== 'want_kids' && $chosen5 !== 'want_kids')
	{
		$result33 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->where('want_kids',Quicksearch::get_seeking_want_kids($username, $password))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->where('want_kids','!=',null)
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result33);
		$num_rows1 += $curr_rows1;
		foreach($result33 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'ethnicity_id' && $chosen2 !== 'ethnicity_id' && $chosen3 !== 'ethnicity_id' && $chosen4 !== 'ethnicity_id' && $chosen5 !== 'ethnicity_id')
	{
		$result34 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('ethnicity_id',Quicksearch::get_seeking_ethnicity($username, $password))
		->where('ethnicity_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result34);
		$num_rows1 += $curr_rows1;
		foreach($result34 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'eye_color_id' && $chosen2 !== 'eye_color_id' && $chosen3 !== 'eye_color_id' && $chosen4 !== 'eye_color_id' && $chosen5 !== 'eye_color_id')
	{
		$result35 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('eye_color_id',Quicksearch::get_seeking_eye_color($username, $password))
		->where('eye_color_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result35);
		$num_rows1 += $curr_rows1;
		foreach($result35 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'religion_id' && $chosen2 !== 'religion_id' && $chosen3 !== 'religion_id' && $chosen4 !=='religion_id' && $chosen5 !== 'religion_id')
	{
		$result36 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('religion_id',Quicksearch::get_seeking_religion($username, $password))
		->where('religion_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result36);
		$num_rows1 += $curr_rows1;
		foreach($result36 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'drink_id' && $chosen2 !== 'drink_id' && $chosen3 !== 'drink_id' && $chosen4 !== 'drink_id' && $chosen5 !== 'drink_id')
	{
		$result37 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('drink_id',Quicksearch::get_seeking_drink($username, $password))
		->where('drink_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result37);
		$num_rows1 += $curr_rows1;
		foreach($result37 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	
	}
		
	if($chosen1 !== 'state' && $chosen2 !== 'state' && $chosen3 !== 'state' && $chosen4 !== 'state' && $chosen5 !== 'state')
	{
		
		$result38 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('state',Quicksearch::get_seeking_location($username, $password))
		->where('state','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result38);
		$num_rows1 += $curr_rows1;
		foreach($result38 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	
	}
	
	if($chosen1 !== 'occupation_id' && $chosen2 !== 'occupation_id' && $chosen3 !== 'occupation_id' && $chosen4 !== 'occupation_id' && $chosen5 !== 'occupation_id')
	{
	
		$result39 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('occupation_id',Quicksearch::get_seeking_occupation($username, $password))
		->where('occupation_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result39);
		$num_rows1 += $curr_rows1;
		foreach($result39 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'have_kids' && $chosen2 !== 'have_kids' && $chosen3 !== 'have_kids' && $chosen4 !== 'have_kids' && $chosen5 !== 'have_kids')
	{
		$result40 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('have_kids',Quicksearch::get_seeking_have_kids($username, $password))
		->where('have_kids','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result40);
		$num_rows1 += $curr_rows1;
		foreach($result40 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'body_type_id' && $chosen2 !== 'body_type_id' && $chosen3 !== 'body_type_id' && $chosen4 !== 'body_type_id' && $chosen5 !== 'body_type_id')
	{
		$result41 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('body_type_id',Quicksearch::get_seeking_body_type($username, $password))
		->where('body_type_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result41);
		$num_rows1 += $curr_rows1;
		foreach($result41 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'height' && $chosen2 !== 'height' && $chosen3 !== 'height' && $chosen4 !== 'height' && $chosen5 !== 'height')
	{
		$result42 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('height',Quicksearch::get_seeking_height($username, $password))
		->where('height','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result42);
		$num_rows1 += $curr_rows1;
		foreach($result42 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'hair_color_id' && $chosen2 !== 'hair_color_id' && $chosen3 !== 'hair_color_id' && $chosen4 !== 'hair_color_id' && $chosen5 !== 'hair_color_id')
	{
		$result43 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('hair_color_id',Quicksearch::get_seeking_hair_color($username, $password))
		->where('hair_color_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result43);
		$num_rows1 += $curr_rows1;
		foreach($result43 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	if($chosen1 !== 'smoke_id' && $chosen2 !== 'smoke_id' && $chosen3 !== 'smoke_id' && $chosen4 !== 'smoke_id' && $chosen5 !== 'smoke_id')
	{
		$result44 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','group_id')
		->from('profiles')
		->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
		->where('smoke_id',Quicksearch::get_seeking_smoke($username, $password))
		->where('smoke_id','!=',null)
		->where('gender_id', '!=', $resu)
		->and_where('profiles.created_at','between', array($start, $end))
		->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
		->order_by('profiles.created_at','desc')
		->limit(log($count)-$num_rows1)
		->execute();
		$curr_rows1 = count($result44);
		$num_rows1 += $curr_rows1;
		foreach($result44 as $value) {
			foreach($result as $member) {
				if($value['id'] == $member['id'])
				{
					$bool = 1;
				}
			}
			if($bool == 0 )
			{
				array_push($result, $value);
				array_push(self::$percentage, 'min. 7.2%');
			}
			$bool = 0;
		}
	}
	
	
	
   
	return $result;
	
  }
  
    public static function browse_members($search_param)
  {
        $count = 200*DB::count_records('profiles');

        $result = DB::select('profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
          ->from('profiles')
          ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
          ->and_where('gender_id','=',$search_param["seeking_gender_id"])
          ->and_where('birth_date','between', array( $search_param["birth_date_from"],  $search_param["birth_date_to"]))
          ->and_where('is_activated',1);

        if(!empty($search_param["state"])){
          $result = $result->and_where('state','like','%'.$search_param["state"].'%');
        }
        if(!empty($search_param["key_words"])) {
          $result = $result->and_where_open()
              ->where('about_me','like','%'.$search_param["key_words"].'%')
              ->or_where('things_looking_for','like','%'.$search_param["key_words"].'%')
              ->or_where('first_thing_noticable','like','%'.$search_param["key_words"].'%')
              ->or_where('interest','like','%'.$search_param["key_words"].'%')
              ->or_where('friends_describe_me','like','%'.$search_param["key_words"].'%')
              ->or_where('for_fun','like','%'.$search_param["key_words"].'%')
              ->or_where('favorite_things','like','%'.$search_param["key_words"].'%')
              ->or_where('last_book_read','like','%'.$search_param["key_words"].'%')
              ->and_where_close();
        }
        if($search_param["online_members"]) {
            $result = $result->and_where('is_logged_in',1);
        }
        if($search_param["body_type_id"]){
            $result = $result->and_where('body_type_id', $search_param["body_type_id"]);
        }
        if($search_param["ethnicity_id"]){
          $result = $result->and_where('ethnicity_id', $search_param["ethnicity_id"]);
        }
        if($search_param["occupation_id"]){
          $result = $result->and_where('occupation_id', $search_param["occupation_id"]);
        }
        if($search_param["faith_id"]){
          $result = $result->and_where('religion_id', $search_param["faith_id"]);
        }
        if($search_param["kids"]){
          $result = $result->and_where('have_kids', $search_param["kids"]);
        }

        $result = $result->order_by('profiles.created_at','desc');

        return $search_param["view_all_result"] ? $result->execute(): $result->limit(log($count))->execute();
  }

    public static function browse_member_friends($search_param)
    {
        if(!empty($search_param["email"]) || !empty($search_param["first_name"]) || !empty($search_param["last_name"])){
            $result = DB::select('profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
                ->from('profiles')
                ->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
                ->where('is_activated',1);
            if(!empty($search_param["email"])){
                $result = $result->and_where('email','like','%'.$search_param["email"].'%');
            }
            if(!empty($search_param["first_name"])) {
                $result = $result->and_where('first_name','like','%'.$search_param["first_name"].'%');
            }
            if(!empty($search_param["last_name"])) {
                $result = $result->and_where('last_name','like','%'.$search_param["last_name"].'%');
            }

            $result = $result->order_by('profiles.created_at','desc');

            return $search_param["view_all_result"] ? $result->execute(): $result->limit(20)->execute();
        }
        else {
            return null;
        }
    }


  public static function get_result($username, $password)
  {
  	$result1 = Quicksearch::get_priority1($username, $password);
  	$result2 = Quicksearch::get_priority2($username, $password);
  	$result3 = Quicksearch::get_priority3($username, $password);
  	$result4 = Quicksearch::get_priority4($username, $password);
  	$result5 = Quicksearch::get_priority5($username, $password);
  	 
  	$first =  $result1[0]['name'];
  	$second = $result2[0]['name'];
  	$third =  $result3[0]['name'];
  	$fourth = $result4[0]['name'];
  	$fifth =  $result5[0]['name'];
  	
  	
  	
  	if($first == 0 || empty($first))
  	{
  		$chosen1 = '';
  		$actual1 = 0;
  		$actual11 = 0;
  	}
  	if($second == 0 || empty($second))
  	{
  		$chosen2 = '';
  		$actual2 = 0;
  		$actual21 = 0;
  	}
  	if($third == 0 || empty($third))
  	{
  		$chosen3 = '';
  		$actual3 = 0;
  		$actual31 = 0;
  	}
  	if($fourth == 0 || empty($fourth))
  	{
  		$chosen4 = '';
  		$actual4 = 0;
  		$actual41 = 0;
  	}
  	if($fifth == 0 || empty($fifth))
  	{
  		$chosen5 = '';
  		$actual5 = 0;
  		$actual51 = 0;
  	}
  	if(!empty($first))
  	{
  		switch ($first)
  		{
  	
  			case 'Age':
  				$actual1 = Quicksearch::get_age_from($username, $password);
  				$actual11 = Quicksearch::get_age_to($username, $password); 	
  				$chosen1 = 'birth_date';
  				$year1 = (date("Y") - $actual1);
  				$month1 = date("m");
  				$day1 = date("d");
  				$actual1 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month1, $day1, $year1)));
  				$year11 = (date("Y") - $actual11);
  				$month11 = date("m");
  				$day11 = date("d");
  				$actual11 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month11, $day11, $year11)));
  				break;
  			case 'Relationship Status':
  				$actual1 = Quicksearch::get_seeking_relationship_status($username, $password);
  				$chosen1 = 'relationship_status_id';
  				break;
  			case 'Want Kids':
  				$actual1 = Quicksearch::get_seeking_want_kids($username, $password);
  				$chosen1 = 'want_kids';
  				break;
  			case 'Ethnicity':
  				$actual1 = Quicksearch::get_seeking_ethnicity($username, $password);
  				$chosen1 = 'ethnicity_id';
  				break;
  			case 'Eye Color':
  				$actual1 = Quicksearch::get_seeking_eye_color($username, $password);
  				$chosen1 = 'eye_color_id';
  				break;
  			case 'Religion':
  				$actual1 = Quicksearch::get_seeking_religion($username, $password);
  				$chosen1 = 'religion_id';
  				break;
  			case 'Drink':
  				$actual1 = Quicksearch::get_seeking_drink($username, $password);
  				$chosen1 = 'drink_id';
  				break;
  			case 'Location':
  				$actual1 = Quicksearch::get_seeking_location($username, $password);
  				$chosen1 = 'state';
  				break;
  			case 'Occupation':
  				$actual1 = Quicksearch::get_seeking_occupation($username, $password);
  				$chosen1 = 'occupation_id';
  				break;
  			case 'Have Kids':
  				$actual1 = Quicksearch::get_seeking_have_kids($username, $password);
  				$chosen1 = 'have_kids';
  				break;
  			case 'Body Type':
  				$actual1 = Quicksearch::get_seeking_body_type($username, $password);
  				$chosen1 = 'body_type_id';
  				break;
  			case 'Height':
  				$actual1 = Quicksearch::get_seeking_height($username, $password);
  				$chosen1 = 'height';
  				break;
  			case 'Hair Color':
  				$actual1 = Quicksearch::get_seeking_hair_color($username, $password);
  				$chosen1 = 'hair_color_id';
  				break;
  			case 'Smoke':
  				$actual1 = Quicksearch::get_seeking_smoke($username, $password);
  				$chosen1 = 'smoke_id';
  				break;
  			default:
  				;
  		}
  	}
  	if(!empty($second))
  	{
  		switch ($second)
  		{
  	
  			case 'Age':
  				$actual2 = Quicksearch::get_age_from($username, $password);
  				$actual21 = Quicksearch::get_age_to($username, $password);
  				$chosen2 = 'birth_date';
  				$year2 = (date("Y") - $actual2);
  				$month2 = date("m");
  				$day2 = date("d");
  				$actual2 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month2, $day2, $year2)));
  				$year21 = (date("Y") - $actual21);
  				$month21 = date("m");
  				$day21 = date("d");
  				$actual21 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month21, $day21, $year21)));
  				break;
  			case 'Relationship Status':
  				$actual2 = Quicksearch::get_seeking_relationship_status($username, $password);
  				$chosen2 = 'relationship_status_id';
  				break;
  			case 'Want Kids':
  				$actual2 = Quicksearch::get_seeking_want_kids($username, $password);
  				$chosen2 = 'want_kids';
  				break;
  			case 'Ethnicity':
  				$actual2 = Quicksearch::get_seeking_ethnicity($username, $password);
  				$chosen2 = 'ethnicity_id';
  				break;
  			case 'Eye Color':
  				$actual2 = Quicksearch::get_seeking_eye_color($username, $password);
  				$chosen2 = 'eye_color_id';
  				break;
  			case 'Religion':
  				$actual2 = Quicksearch::get_seeking_religion($username, $password);
  				$chosen2 = 'religion_id';
  				break;
  			case 'Drink':
  				$actual2 = Quicksearch::get_seeking_drink($username, $password);
  				$chosen2 = 'drink_id';
  				break;
  			case 'Location':
  				$actual2 = Quicksearch::get_seeking_location($username, $password);
  				$chosen2 = 'state';
  				break;
  			case 'Occupation':
  				$actual2 = Quicksearch::get_seeking_occupation($username, $password);
  				$chosen2 = 'occupation_id';
  				break;
  			case 'Have Kids':
  				$actual2 = Quicksearch::get_seeking_have_kids($username, $password);
  				$chosen2 = 'have_kids';
  				break;
  			case 'Body Type':
  				$actual2 = Quicksearch::get_seeking_body_type($username, $password);
  				$chosen2 = 'body_type_id';
  				break;
  			case 'Height':
  				$actual2 = Quicksearch::get_seeking_height($username, $password);
  				$chosen2 = 'height';
  				break;
  			case 'Hair Color':
  				$actual2 = Quicksearch::get_seeking_hair_color($username, $password);
  				$chosen2 = 'hair_color_id';
  				break;
  			case 'Smoke':
  				$actual2 = Quicksearch::get_seeking_smoke($username, $password);
  				$chosen2 = 'smoke_id';
  				break;
  			default:
  				;
  		}
  	}
  	if(!empty($third))
  	{
  		switch ($third)
  		{
  			
  	
  			case 'Age':
  				$actual3 = Quicksearch::get_age_from($username, $password);
  				$actual31 = Quicksearch::get_age_to($username, $password);
  				$chosen3 = 'birth_date';
  				$year3 = (date("Y") - $actual3);
  				$month3 = date("m");
  				$day3 = date("d");
  				$actual3 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month3, $day3, $year3)));
  				$year31 = (date("Y") - $actual31);
  				$month31 = date("m");
  				$day31 = date("d");
  				$actual31 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month31, $day31, $year31)));
  				break;
  			case 'Relationship Status':
  				$actual3 = Quicksearch::get_seeking_relationship_status($username, $password);
  				$chosen3 = 'relationship_status_id';
  				break;
  			case 'Want Kids':
  				$actual3 = Quicksearch::get_seeking_want_kids($username, $password);
  				$chosen3 = 'want_kids';
  				break;
  			case 'Ethnicity':
  				$actual3 = Quicksearch::get_seeking_ethnicity($username, $password);
  				$chosen3 = 'ethnicity_id';
  				break;
  			case 'Eye Color':
  				$actual3 = Quicksearch::get_seeking_eye_color($username, $password);
  				$chosen3 = 'eye_color_id';
  				break;
  			case 'Religion':
  				$actual3 = Quicksearch::get_seeking_religion($username, $password);
  				$chosen3 = 'religion_id';
  				break;
  			case 'Drink':
  				$actual3 = Quicksearch::get_seeking_drink($username, $password);
  				$chosen3 = 'drink_id';
  				break;
  			case 'Location':
  				$actual3 = Quicksearch::get_seeking_location($username, $password);
  				$chosen3 = 'state';
  				break;
  			case 'Occupation':
  				$actual3 = Quicksearch::get_seeking_occupation($username, $password);
  				$chosen3 = 'occupation_id';
  				break;
  			case 'Have Kids':
  				$actual3 = Quicksearch::get_seeking_have_kids($username, $password);
  				$chosen3 = 'have_kids';
  				break;
  			case 'Body Type':
  				$actual3 = Quicksearch::get_seeking_body_type($username, $password);
  				$chosen3 = 'body_type_id';
  				break;
  			case 'Height':
  				$actual3 = Quicksearch::get_seeking_height($username, $password);
  				$chosen3 = 'height';
  				break;
  			case 'Hair Color':
  				$actual3 = Quicksearch::get_seeking_hair_color($username, $password);
  				$chosen3 = 'hair_color_id';
  				break;
  			case 'Smoke':
  				$actual3 = Quicksearch::get_seeking_smoke($username, $password);
  				$chosen3 = 'smoke_id';
  				break;
  			default:
  				;
  		}
  	}
  	if(!empty($fourth))
  	{
  		switch ($fourth)
  		{
  			case 'Age':
  				$actual4 = Quicksearch::get_age_from($username, $password);
  				$actual41 = Quicksearch::get_age_to($username, $password);
  				$chosen4 = 'birth_date';
  				$year4 = (date("Y") - $actual4);
  				$month4 = date("m");
  				$day4 = date("d");
  				$actual4 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month4, $day4, $year4)));
  				$year41 = (date("Y") - $actual41);
  				$month41 = date("m");
  				$day41 = date("d");
  				$actual41 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month41, $day41, $year41)));
  				break;
  			case 'Relationship Status':
  				$actual4 = Quicksearch::get_seeking_relationship_status($username, $password);
  				$chosen4 = 'relationship_status_id';
  				break;
  			case 'Want Kids':
  				$actual4 = Quicksearch::get_seeking_want_kids($username, $password);
  				$chosen4 = 'want_kids';
  				break;
  			case 'Ethnicity':
  				$actual4 = Quicksearch::get_seeking_ethnicity($username, $password);
  				$chosen4 = 'ethnicity_id';
  				break;
  			case 'Eye Color':
  				$actual4 = Quicksearch::get_seeking_eye_color($username, $password);
  				$chosen4 = 'eye_color_id';
  				break;
  			case 'Religion':
  				$actual4 = Quicksearch::get_seeking_religion($username, $password);
  				$chosen4 = 'religion_id';
  				break;
  			case 'Drink':
  				$actual4 = Quicksearch::get_seeking_drink($username, $password);
  				$chosen4 = 'drink_id';
  				break;
  			case 'Location':
  				$actual4 = Quicksearch::get_seeking_location($username, $password);
  				$chosen4 = 'state';
  				break;
  			case 'Occupation':
  				$actual4 = Quicksearch::get_seeking_occupation($username, $password);
  				$chosen4 = 'occupation_id';
  				break;
  			case 'Have Kids':
  				$actual4 = Quicksearch::get_seeking_have_kids($username, $password);
  				$chosen4 = 'have_kids';
  				break;
  			case 'Body Type':
  				$actual4 = Quicksearch::get_seeking_body_type($username, $password);
  				$chosen4 = 'body_type_id';
  				break;
  			case 'Height':
  				$actual4 = Quicksearch::get_seeking_height($username, $password);
  				$chosen4 = 'height';
  				break;
  			case 'Hair Color':
  				$actual4 = Quicksearch::get_seeking_hair_color($username, $password);
  				$chosen4 = 'hair_color_id';
  				break;
  			case 'Smoke':
  				$actual4 = Quicksearch::get_seeking_smoke($username, $password);
  				$chosen4 = 'smoke_id';
  				break;
  			default:
  				;
  		}
  	}
  	if(!empty($fifth))
  	{
  		switch ($fifth)
  		{
  	
  			case 'Age':
  				$actual5 = Quicksearch::get_age_from($username, $password);
  				$actual51 = Quicksearch::get_age_to($username, $password);
  				$chosen5 = 'birth_date';
  				$year5 = (date("Y") - $actual5);
  				$month5 = date("m");
  				$day5 = date("d");
  				$actual5 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month5, $day5, $year5)));
  				$year51 = (date("Y") - $actual51);
  				$month51 = date("m");
  				$day51 = date("d");
  				$actual51 = strtotime(date('Y-m-d', mktime(0, 0, 0, $month51, $day51, $year51)));
  				break;
  			case 'Relationship Status':
  				$actual5 = Quicksearch::get_seeking_relationship_status($username, $password);
  				$chosen5 = 'relationship_status_id';
  				break;
  			case 'Want Kids':
  				$actual5 = Quicksearch::get_seeking_want_kids($username, $password);
  				$chosen5 = 'want_kids';
  				break;
  			case 'Ethnicity':
  				$actual5 = Quicksearch::get_seeking_ethnicity($username, $password);
  				$chosen5 = 'ethnicity_id';
  				break;
  			case 'Eye Color':
  				$actual5 = Quicksearch::get_seeking_eye_color($username, $password);
  				$chosen5 = 'eye_color_id';
  				break;
  			case 'Religion':
  				$actual5 = Quicksearch::get_seeking_religion($username, $password);
  				$chosen5 = 'religion_id';
  				break;
  			case 'Drink':
  				$actual5 = Quicksearch::get_seeking_drink($username, $password);
  				$chosen5 = 'drink_id';
  				break;
  			case 'Location':
  				$actual5 = Quicksearch::get_seeking_location($username, $password);
  				$chosen5 = 'state';
  				break;
  			case 'Occupation':
  				$actual5 = Quicksearch::get_seeking_occupation($username, $password);
  				$chosen5 = 'occupation_id';
  				break;
  			case 'Have Kids':
  				$actual5 = Quicksearch::get_seeking_have_kids($username, $password);
  				$chosen5 = 'have_kids';
  				break;
  			case 'Body Type':
  				$actual5 = Quicksearch::get_seeking_body_type($username, $password);
  				$chosen5 = 'body_type_id';
  				break;
  			case 'Height':
  				$actual5 = Quicksearch::get_seeking_height($username, $password);
  				$chosen5 = 'height';
  				break;
  			case 'Hair Color':
  				$actual5 = Quicksearch::get_seeking_hair_color($username, $password);
  				$chosen5 = 'hair_color_id';
  				break;
  			case 'Smoke':
  				$actual5 = Quicksearch::get_seeking_smoke($username, $password);
  				$chosen5 = 'smoke_id';
  				break;
  			default:
  				;
  		}
  	}
  	
  	if(!empty($chosen1) )
  	{
  	if($chosen1 != 'birth_date')
  		{
  			if(empty($actual1))
  			{
  			 $actual1 = 0;
  			}
  		}
  	}
  	if(!empty($chosen2) )
  	{
  		if($chosen2 != 'birth_date')
  		{
  			if(empty($actual2))
  			{
  				$actual2 = 0;
  			}
  		}
  	}
  	
  	if(!empty($chosen3) )
  	{
  		if($chosen3 != 'birth_date')
  		{
  			if(empty($actual3))
  			{
  				$actual3 = 0;
  			}
  		}
  	}
  	
  	if(!empty($chosen4) )
  	{
  		if($chosen4 != 'birth_date')
  		{
  			if(empty($actual4))
  			{
  				$actual4 = 0;
  			}
  		}
  	}
  	
  	if(!empty($chosen5) )
  	{
  		if($chosen5 != 'birth_date')
  		{
  			if(empty($actual5))
  			{
  				$actual5 = 0;
  			}
  		}
  	}
  	
  	$result = array();
  	if($chosen1 == 'birth_date')
  	{
  		
  		  		
  		if(empty($chosen2) || empty($chosen3) || empty($chosen4) || empty($chosen5))
  		{ 
  		$result1 = Quicksearchemptyhandlerpone::get_yourmatchfirstage($username, $password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,$actual11,0,0,0,0);
  		$counter = Quicksearchemptyhandlerpone::get_counter();
  		$percentage = Quicksearchemptyhandlerpone::get_percentage();
  		}
  	}
  	 
  	if($chosen1 == 'birth_date')
  	{
  		if(!empty($chosen2) && !empty($chosen3) && !empty($chosen4) && !empty($chosen5))
  		{
  		$result1 =  Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,$actual11,0,0,0,0);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  		}
  	}
  	
  	if($chosen2 == 'birth_date')
  	{
  		if(empty($chosen1) || empty($chosen3) || empty($chosen4) || empty($chosen5))
  		{
  		$result1 = Quicksearchemptyhandlerptwo::get_yourmatchfirstage($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,$actual21,0,0,0);
  		$counter = Quicksearchemptyhandlerptwo::get_counter();
  		$percentage = Quicksearchemptyhandlerptwo::get_percentage();
  		}
  	}
  	 
  	if($chosen2 == 'birth_date')
  	{
  		if(!empty($chosen1) && !empty($chosen3) && !empty($chosen4) && !empty($chosen5))
  		{
  		$result1 = Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,$actual21,0,0,0);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  		}
  	}
  	
  	if($chosen3 == 'birth_date')
  	{
  		if(empty($chosen1) || empty($chosen2) || empty($chosen4) || empty($chosen5))
  		{
  		$result1 = Quicksearchemptyhandlerpthree::get_yourmatchfirstage($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,$actual31,0,0);
  		$counter = Quicksearchemptyhandlerpthree::get_counter();
  		$percentage = Quicksearchemptyhandlerpthree::get_percentage();
  		}
  	}
  	
  	if($chosen3 == 'birth_date')
  	{
  		if(!empty($chosen1) && !empty($chosen2) && !empty($chosen4) && !empty($chosen5))
  		{
  		$result1 = Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,$actual31,0,0);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  	
  		}
  	}
  	 
  	if($chosen4 == 'birth_date')
  	{
  		if(empty($chosen1) || empty($chosen2) || empty($chosen3) || empty($chosen5))
  		{
  		$result1 = Quicksearchemptyhandlerpfour::get_yourmatchfirstage($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,$actual41,0);
  		$counter = Quicksearchemptyhandlerpfour::get_counter();
  		$percentage = Quicksearchemptyhandlerpfour::get_percentage();
  		}
  	}
  	if($chosen4 == 'birth_date')
  	{
  		if(!empty($chosen1) && !empty($chosen2) && !empty($chosen3) && !empty($chosen5))
  		{
  		$result1 = Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,$actual41,0);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  		}
  	}
  	if($chosen5 == 'birth_date')
  	{
  		if(empty($chosen1) || empty($chosen2) || empty($chosen3) || empty($chosen4))
  		{
  		$result1 = Quicksearchemptyhandlerpfive::get_yourmatchfirstage($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,0,$actual51);
  		$counter = Quicksearchemptyhandlerpfive::get_counter();
  		$percentage = Quicksearchemptyhandlerpfive::get_percentage();
  		}
  	}
  	if($chosen5 == 'birth_date')
  	{
  		if(!empty($chosen1) && !empty($chosen2) && !empty($chosen3) && !empty($chosen4))
  		{
  		$result1 = Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,0,$actual51);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  		}
  	}
  	 
  	if($chosen1 != 'birth_date' && $chosen2 != 'birth_date' && $chosen3 != 'birth_date' && $chosen4 != 'birth_date' && $chosen5 != 'birth_date')
  	{
  		if(empty($chosen1) || empty($chosen2) || empty($chosen3) ||empty($chosen4)|| empty($chosen5))
  		{
  		$result1 = Quicksearchemptyhandlerpnone::get_yourmatchfirstage($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,0,0);
  		$counter = Quicksearchemptyhandlerpnone::get_counter();
  		$percentage = Quicksearchemptyhandlerpnone::get_percentage();
  		}
  	}
  	
  	
  	if($chosen1 != 'birth_date' && $chosen2 != 'birth_date' && $chosen3 != 'birth_date' && $chosen4 != 'birth_date' && $chosen5 != 'birth_date')
  	{
  		if(!empty($chosen1) && !empty($chosen2) && !empty($chosen3) && !empty($chosen4)&& !empty($chosen5))
  		{
  		$result1 = Quicksearch::get_yourmatch($username,$password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$actual1,$actual2,$actual3,$actual4,$actual5,0,0,0,0,0);
  		$counter =  Quicksearch::get_counter();
  		$percentage = Quicksearch::get_percentage();
  		}
  	}
  
 	
  	
  	$topmatchchoicesettings = Quicksearch::get_top_match_choice($username, $password);
  	$profile_id = Quicksearch::get_profile_id($username, $password);
  	if($topmatchchoicesettings == 'Three notifications ')
  	{
  	if((date('l') == 'Monday'))
  	{
  		$bool1 = 0;
  		foreach($result1 as $value) {
  			if($value['created_at'] > strtotime("last saturday"))
  			{
  				$bool1 = 1;
  			}
  		}
  		if($bool1 == 1 )
  		{
  		// Model_Notification::save_notifications(Model_Notification::NEW_MATCH_FOUND, 0, $profile_id, 0);
  		}	
  	}
  	
  	if((date('l') == 'Wednesday'))
  	{
  		$bool2 = 0;
  		foreach($result1 as $value) {
  			if($value['created_at'] > strtotime("last monday"))
  			{
  				$bool2 = 1;
  			}
  		}
  		if($bool2 == 1 )
  		{
  			// Model_Notification::save_notifications(Model_Notification::NEW_MATCH_FOUND, 0, $profile_id, 0);
  		}
  	}
  	
  	if((date('l') == 'Saturday'))
  	{
  		$bool3 = 0;
  		foreach($result1 as $value) {
  			if($value['created_at'] > strtotime("last wednesday"))
  			{
  				$bool3 = 1;
  			}
  		}
  		if($bool3 == 1 )
  		{
  			// Model_Notification::save_notifications(Model_Notification::NEW_MATCH_FOUND, 0, $profile_id, 0);
  		}
  	}
  		
  	}
  	
  	if($topmatchchoicesettings == 'Notifications of top')
  	{ 
  		if((date('l') == 'Monday'))
  		{
  			
  			$bool4 = 0;
  			foreach($result1 as $value) {				
  					if($value['created_at'] > strtotime("last monday"))
  					{
  						$bool4 = 1;
  					} 				
  			}	
  			if($bool4 == 1 )
  			{ 		
  			// Model_Notification::save_notifications(Model_Notification::NEW_MATCH_FOUND, 0, $profile_id, 0);
  			}
  		}
  	}

  	array_push($result, $result1);
  	array_push($result, $counter);
  	array_push($result, $percentage);
  	 	
  	return $result;
  	
  }
  
 
  	
}