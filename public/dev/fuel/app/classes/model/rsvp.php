<?php

class Model_Rsvp extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'event_id',
		'member_id',
		'created_at',
		'updated_at',
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
	protected static $_table_name = 'rsvps';


    public static function is_going($event_id, $user_id = null)
    {
        is_null($user_id) and $user_id = \Auth\Auth::get('id');

        $query = Model_Rsvp::query()->where(array(
            'event_id' => $event_id,
            'member_id'  => $user_id,
        ));

        if($query->count() > 0){
            return true;
        }

        return false;
    }
	public static  function count_event($profile_id) {
        $events = Model_Rsvp::find('all', array("where" => array(array("member_id", $profile_id),)));
        return count($events);
    }

}
