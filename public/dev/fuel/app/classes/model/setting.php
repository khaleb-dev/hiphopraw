<?php
use Orm\Model;

class Model_Setting extends Model
{
   
    protected static $_properties = array(
		
		'id',
		'private_profile',
		'data_sharing',
		'where_we_all_meet',
		'hello_notification',
		'message_notification',
		'top_matches',
		'special_offers',
		'send_me_email_notifcation',
		'profile_id',
		);
  
		
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
	protected static $_table_name = 'setting';
	
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
			$val->add_field('paswword', 'password', 'required');
		
		return $val;
	}
		
	public static function is_set_privacy($id)
	{

		$result = Model_Setting::query()
		->where('private_profile', '=', 1)
		->where('profile_id', '=', $id)
		->get_one();
		
		if(count($result) === 1){
			return true;
		}
		else
		{
		
		return false;
		}
	}

    public static function is_set_email_notification($id)
    {
        $result = Model_Setting::query()
            ->where('send_me_email_notifcation', '=', 1)
            ->where('profile_id', '=', $id)
            ->get_one();
        if(count($result) === 1){
            return true;
        }
        else
        {
            return false;
        }
    }
	
	}
