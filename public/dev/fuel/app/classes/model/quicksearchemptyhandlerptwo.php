<?php
namespace Model;
use DB;
class Quicksearchemptyhandlerptwo extends \Model {
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
	
	
	public static function get_top_match_choice($username, $password)
	{
		$id = Quicksearchemptyhandlerptwo::get_profile_id($username, $password);
		$result = DB::select('top_matches')
		->from('setting')
		->join('profiles', 'right')->on('profiles.id', '=', 'setting.profile_id')
		->where('setting.profile_id',$id)
		->execute();
		return $result[0]['top_matches'];
	}
	public static function get_yourmatchfirstage($username, $password,$chosen1,$chosen2,$chosen3,$chosen4,$chosen5,$myactual1,$myactual2,$myactual3,$myactual4,$myactual5,$actual11,$actual21,$actual31,$actual41,$actual51)
	{
		$num_rows = 0;
		$resu = Quicksearch::get_gender($username, $password);
		$count = 200*DB::count_records('profiles');
		$result=array();
		$start = strtotime(date('Y-m-d', mktime(0, 0, 0, 12, 4, 1970)));
		$end = 99999999999;
		$topmatchchoice = Quicksearchemptyhandlerptwo::get_top_match_choice($username, $password);
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
		
		if(!empty($chosen1) && empty($chosen3) && empty($chosen4) && empty($chosen5))
		{
					$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array($actual21, $myactual2))
					->and_where($chosen1,$myactual1)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count))
					->execute();
					$curr_rows = count($result1);
					$num_rows += $curr_rows;
		    foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '78%');
			  }
					
					if($num_rows < log($count))
					{
						$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
						->from('profiles')
						->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
						->where('gender_id', '!=', $resu)
						->and_where('profiles.created_at','between', array($start, $end))
						->and_where($chosen2,'<', $actual21)
						->and_where($chosen1,$myactual1)
						->order_by('profiles.created_at','desc')
						->limit(log($count)-$num_rows)
						->or_where($chosen2,'>',  $myactual2)
						->where('gender_id', '!=', $resu)
						->and_where('profiles.created_at','between', array($start, $end))
						->and_where($chosen1,$myactual1)
						->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
						->order_by('profiles.created_at','desc')
						->limit(log($count)-$num_rows)
						->execute();
						$curr_rows = count($result2);
						$num_rows += $curr_rows;
						foreach($result2 as $value) {
							array_push($result, $value);
							array_push(self::$percentage, '55%');
						}
			
					}
					
					if($num_rows < log($count))
					{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array($actual21, $myactual2))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					 foreach($result3 as $value) {
			     	array_push($result, $value);
			     	array_push(self::$percentage, '23%');
			     }
				}
				self::$counter = count($result);
			}	

			if(!empty($chosen3) && empty($chosen1) && empty($chosen4) && empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
			 foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '35%');
			}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
				 foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			     }
						
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '12%');
					}
						
				}
				self::$counter = count($result);
			}

			if(!empty($chosen4) && empty($chosen3) && empty($chosen1) && empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '29%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
				 foreach($result2 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '23%');
			        }
						
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
				 foreach($result3 as $value) {
				  array_push($result, $value);
				  array_push(self::$percentage, '6%');
			    }
						
				}
			}
				
			if(!empty($chosen5) && empty($chosen3) && empty($chosen4) && empty($chosen2))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '27%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
						array_push(self::$percentage, '23%');
					}
						
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '4%');
					}
						
				}
			}
			
			if(!empty($chosen1) && !empty($chosen3) && empty($chosen4) && empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen1,$myactual1)
				->and_where($chosen3,$myactual3)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '90%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
					foreach($result2 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '78%');
					}
			
				}
					
			if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
					->and_where($chosen3,$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen3,$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '67%');
					}
			
				}
				
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
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
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result4);
					$num_rows += $curr_rows;
					foreach($result4 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '55%');
					}
						
				}
				
				
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen3,$myactual3)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '35%');
					}
						
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result6);
					$num_rows += $curr_rows;
					foreach($result6 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
						
				}
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen3,$myactual3)
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
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '12%');
					}
				}
				self::$counter = count($result);
			}
			
			if(!empty($chosen1) && !empty($chosen4) && empty($chosen3) && empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen1,$myactual1)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '84%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
				 foreach($result2 as $value) {
				   array_push($result, $value);
				   array_push(self::$percentage, '78%');
			     }
						
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '61%');
					}
						
				}
			
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
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
						array_push(self::$percentage, '55%');
					}
			
				}
			
			
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen4,$myactual4)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '29%');
					}
			
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result6);
					$num_rows += $curr_rows;
					foreach($result6 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
			
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen4,$myactual4)
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
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '6%');
					}
			
				}
			
			}

			if(!empty($chosen1) && !empty($chosen5) && empty($chosen4) && empty($chosen3))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen1,$myactual1)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
			 foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '82%');
			}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen1,$myactual1)
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
						array_push(self::$percentage, '78%');
					}
						
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '59%');
					}
						
				}
			
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen1,$myactual1)
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
						array_push(self::$percentage, '55%');
					}
			
				}
			
			
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen5,$myactual5)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '27%');
					}
			
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
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
						array_push(self::$percentage, '23%');
					}
			
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
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
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '4%');
					}
			
				}
			
			}
				
			if(!empty($chosen3) && empty($chosen1) && !empty($chosen4) && empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '41%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen3,$myactual3)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
				 foreach($result2 as $value) {
				   array_push($result, $value);
				   array_push(self::$percentage, '35%');
			        }
						
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '29%');
					}
						
				}
					
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
					$curr_rows = count($result4);
					$num_rows += $curr_rows;
					foreach($result4 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
			
				}
					
					
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '18%');
					}
			
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result6);
					$num_rows += $curr_rows;
				 foreach($result6 as $value) {
				   array_push($result, $value);
				   array_push(self::$percentage, '12%');
			    }
			
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '6%');
					}
			
				}
					
			}
			
			if(!empty($chosen3) && empty($chosen1) && !empty($chosen5) && empty($chosen4))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen3,$myactual3)
				->and_where($chosen5,$myactual5)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
				foreach($result1 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '39%');
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen3,$myactual3)
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
						array_push(self::$percentage, '35%');
					}
			
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
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
						array_push(self::$percentage, '27%');
					}
			
				}
					
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
					$curr_rows = count($result4);
					$num_rows += $curr_rows;
					foreach($result4 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
						
				}
					
					
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '16%');
					}
						
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
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
					->and_where($chosen3,$myactual3)
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
						array_push(self::$percentage, '12%');
					}
						
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
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
						array_push(self::$percentage, '4%');
					}
						
				}
					
			}
		
			if(empty($chosen3) && empty($chosen1) && !empty($chosen4) && !empty($chosen5))
			{
				$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where($chosen5,$myactual5)
				->and_where($chosen4,$myactual4)
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result1);
				$num_rows += $curr_rows;
			   foreach($result1 as $value) {
				array_push($result, $value);
				array_push(self::$percentage, '33%');
			    }
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
				   array_push(self::$percentage, '29%');
			      }
			
				}
					
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
						array_push(self::$percentage, '27%');
					}
			
				}
					
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
						array_push(self::$percentage, '23%');
					}
						
				}
					
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen5,$myactual5)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen5,$myactual5)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '10%');
					}
						
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
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
						array_push(self::$percentage, '6%');
					}
						
				}
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen2,'<', $actual21)
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
						array_push(self::$percentage, '4%');
					}
						
				}
					
			}
			if(!empty($chosen3) && !empty($chosen1) && !empty($chosen4) && empty($chosen5))
			{
				if($num_rows < log($count))
				{
					$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count))
					->execute();
					$curr_rows = count($result1);
					$num_rows += $curr_rows;
					foreach($result1 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '96%');
					}
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
					->and_where($chosen3,'=',$myactual3)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result2);
					$num_rows += $curr_rows;
					foreach($result2 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '90%');
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
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '84%');
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
					$curr_rows = count($result4);
					$num_rows += $curr_rows;
					foreach($result4 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '78%');
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
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>', $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen3,$myactual3)
					->and_where($chosen4,$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '73%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen3,$myactual3)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
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
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result6);
					$num_rows += $curr_rows;
					foreach($result6 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '67%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
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
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '61%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result8);
					$num_rows += $curr_rows;
					foreach($result8 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '55%');
					}
				}
				if($num_rows < log($count))
				{
					$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result9);
					$num_rows += $curr_rows;
					foreach($result9 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '41%');
					}
				}
				if($num_rows < log($count))
				{
					$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result10);
					$num_rows += $curr_rows;
				 foreach($result10 as $value) {
				   array_push($result, $value);
				   array_push(self::$percentage, '35%');
		           	}
				}
				if($num_rows < log($count))
				{
					$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
					->and_where($chosen4,$myactual4)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result11);
					$num_rows += $curr_rows;
					foreach($result11 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '29%');
					}
				}
				if($num_rows < log($count))
				{
					$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
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
					$curr_rows = count($result12);
					$num_rows += $curr_rows;
					foreach($result12 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
				}
				if($num_rows < log($count))
				{
					$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen4,'=',$myactual4)
					->and_where($chosen3,'=',$myactual3)
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
					->and_where($chosen4,'=',$myactual4)
					->and_where($chosen3,'=',$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result13);
					$num_rows += $curr_rows;
					foreach($result13 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '18%');
					}
				}
				if($num_rows < log($count))
				{
					$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen3,'=',$myactual3)
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
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen3,'=',$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result14);
					$num_rows += $curr_rows;
					foreach($result14 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '12%');
					}
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen4,'=',$myactual4)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
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
					->and_where($chosen4,'=',$myactual4)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result15);
					$num_rows += $curr_rows;
					foreach($result15 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '6%');
					}
				}
			
			}
			
			if(!empty($chosen3) && !empty($chosen1) && !empty($chosen5) && empty($chosen4))
			{
				if($num_rows < log($count))
				{
					$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count))
					->execute();
					$curr_rows = count($result1);
					$num_rows += $curr_rows;
					foreach($result1 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '94%');
					}
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
					->and_where($chosen3,'=',$myactual3)
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
						array_push(self::$percentage, '90%');
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
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '82%');
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
					$curr_rows = count($result4);
					$num_rows += $curr_rows;
					foreach($result4 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '78%');
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
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen3,$myactual3)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>', $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen3,$myactual3)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '71%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen3,$myactual3)
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
						array_push(self::$percentage, '67%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
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
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '59%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result8);
					$num_rows += $curr_rows;
					foreach($result8 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '55%');
					}
				}
				if($num_rows < log($count))
				{
					$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result9);
					$num_rows += $curr_rows;
					foreach($result9 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '39%');
					}
				}
				if($num_rows < log($count))
				{
					$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
						array_push(self::$percentage, '35%');
					}
				}
				if($num_rows < log($count))
				{
					$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
					->and_where($chosen5,$myactual5)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result11);
					$num_rows += $curr_rows;
					foreach($result11 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '27%');
					}
				}
				if($num_rows < log($count))
				{
					$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
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
					$curr_rows = count($result12);
					$num_rows += $curr_rows;
					foreach($result12 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '23%');
					}
				}
				if($num_rows < log($count))
				{
					$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen3,'=',$myactual3)
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
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen3,'=',$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result13);
					$num_rows += $curr_rows;
					foreach($result13 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '16%');
					}
				}
				if($num_rows < log($count))
				{
					$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen3,'=',$myactual3)
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
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen3,'=',$myactual3)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result14);
					$num_rows += $curr_rows;
					foreach($result14 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '12%');
					}
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result15);
					$num_rows += $curr_rows;
					foreach($result15 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '4%');
					}
				}
					
			}
			
			if(!empty($chosen4) && !empty($chosen1) && !empty($chosen5) && empty($chosen3))
			{
				if($num_rows < log($count))
				{
					$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where($chosen4,'=',$myactual4)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count))
					->execute();
					$curr_rows = count($result1);
					$num_rows += $curr_rows;
				 foreach($result1 as $value) {
				    array_push($result, $value);
				    array_push(self::$percentage, '88%');
			     }
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
					->and_where($chosen4,'=',$myactual4)
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
						array_push(self::$percentage, '84%');
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
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '82%');
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
						array_push(self::$percentage, '78%');
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
					->and_where($chosen2,'<', $actual21)
					->and_where($chosen4,$myactual4)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>', $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
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
						array_push(self::$percentage, '66%');
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
					->and_where($chosen2,'<',  $actual21)
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
						array_push(self::$percentage, '61%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '59%');
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
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen1,$myactual1)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
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
						array_push(self::$percentage, '55%');
					}
				}
				if($num_rows < log($count))
				{
					$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
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
						array_push(self::$percentage, '33%');
					}
				}
				if($num_rows < log($count))
				{
					$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
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
						array_push(self::$percentage, '29%');
					}
				}
				if($num_rows < log($count))
				{
					$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
					->and_where($chosen5,$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result11);
					$num_rows += $curr_rows;
					foreach($result11 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '27%');
					}
				}
				if($num_rows < log($count))
				{
					$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21, $myactual2))
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
						array_push(self::$percentage, '23%');
					}
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
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
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result13);
					$num_rows += $curr_rows;
				 foreach($result13 as $value) {
				    array_push($result, $value);
				    array_push(self::$percentage, '10%');
			     }
				}
				if($num_rows < log($count))
				{
					$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
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
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
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
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result14);
					$num_rows += $curr_rows;
					foreach($result14 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '6%');
					}
				}
				if($num_rows < log($count))
				{
					$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen1,'!=',$myactual1)
					->or_where($chosen1,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
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
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result15);
					$num_rows += $curr_rows;
					foreach($result15 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '4%');
					}
				}
					
			}
			if(!empty($chosen4) && !empty($chosen3) && !empty($chosen5) && empty($chosen1))
			{
				if($num_rows < log($count))
				{
					$result1 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where($chosen4,'=',$myactual4)
					->and_where($chosen5,$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count))
					->execute();
					$curr_rows = count($result1);
					$num_rows += $curr_rows;
				   foreach($result1 as $value) {
				     array_push($result, $value);
				     array_push(self::$percentage, '45%');
			        }
				}
				if($num_rows < log($count))
				{
					$result2 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen4,'=',$myactual4)
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
						array_push(self::$percentage, '41%');
					}
				}
				if($num_rows < log($count))
				{
					$result3 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen2,'between', array($actual21,  $myactual2))
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result3);
					$num_rows += $curr_rows;
					foreach($result3 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '39%');
					}
				}
				if($num_rows < log($count))
				{
					$result4 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,$myactual3)
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
						array_push(self::$percentage, '35%');
					}
				}
					
				if($num_rows < log($count))
				{
					$result5 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen4,'=',$myactual4)
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result5);
					$num_rows += $curr_rows;
					foreach($result5 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '33%');
					}
				}
				if($num_rows < log($count))
				{
					$result6 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where($chosen4,'=',$myactual4)
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
						array_push(self::$percentage, '29%');
					}
				}
				if($num_rows < log($count))
				{
					$result7 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result7);
					$num_rows += $curr_rows;
					foreach($result7 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '27%');
					}
				}
				if($num_rows < log($count))
				{
					$result8 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'between', array( $actual21,  $myactual2))
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
						array_push(self::$percentage, '23%');
					}
				}
				if($num_rows < log($count))
				{
					$result9 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result9);
					$num_rows += $curr_rows;
					foreach($result9 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '22%');
					}
				}
				if($num_rows < log($count))
				{
					$result10 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result10);
					$num_rows += $curr_rows;
					foreach($result10 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '18%');
					}
				}
				if($num_rows < log($count))
				{
					$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result11);
					$num_rows += $curr_rows;
					foreach($result11 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '16%');
					}
				}
				if($num_rows < log($count))
				{
					$result12 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where($chosen3,'=',$myactual3)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
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
						array_push(self::$percentage, '12%');
					}
				}
				self::$counter = count($result);
				if($num_rows < log($count))
				{
					$result13 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result13);
					$num_rows += $curr_rows;
					foreach($result13 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '10%');
					}
				}
				if($num_rows < log($count))
				{
					$result14 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where_open()
					->where($chosen5,'!=',$myactual5)
					->or_where($chosen5,'=',NULL)
					->and_where_close()
					->and_where($chosen4,'=',$myactual4)
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result14);
					$num_rows += $curr_rows;
					foreach($result14 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '6%');
					}
				}
				if($num_rows < log($count))
				{
					$result15 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
					->from('profiles')
					->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen2,'<',  $actual21)
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->or_where($chosen2,'>',  $myactual2)
					->where('gender_id', '!=', $resu)
					->and_where('profiles.created_at','between', array($start, $end))
					->and_where_open()
					->where($chosen3,'!=',$myactual3)
					->or_where($chosen3,'=',NULL)
					->and_where_close()
					->and_where($chosen5,'=',$myactual5)
					->and_where_open()
					->where($chosen4,'!=',$myactual4)
					->or_where($chosen4,'=',NULL)
					->and_where_close()
					->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
					->order_by('profiles.created_at','desc')
					->limit(log($count)-$num_rows)
					->execute();
					$curr_rows = count($result15);
					$num_rows += $curr_rows;
					foreach($result15 as $value) {
						array_push($result, $value);
						array_push(self::$percentage, '4%');
					}
				}
					
			}
			if(empty($chosen1) && empty($chosen3) && empty($chosen4) && empty($chosen5))
			{
				$result11 = DB::select('profiles.created_at','profiles.id','city','first_name','last_name','picture','profiles.user_id','state','username','group_id','email')
				->from('profiles')
				->join('users', 'right')->on('users.id', '=', 'profiles.user_id')
				->where('gender_id', '!=', $resu)
				->and_where('profiles.created_at','between', array($start, $end))
				->and_where($chosen2,'between', array($actual21, $myactual2))
				->and_where('state',Quicksearchemptyhandlerpnone::get_state($username, $password))
				->order_by('profiles.created_at','desc')
				->limit(log($count))
				->execute();
				$curr_rows = count($result11);
				$num_rows += $curr_rows;
				foreach($result11 as $value) {
					array_push($result, $value);
					array_push(self::$percentage, '23%');
				}
				self::$counter = count($result);
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
						
         
		return $result;
			
	}
	
}
