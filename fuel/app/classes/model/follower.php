
<?php

class Model_Follower extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'follower_id',
		'followed_id',
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
	protected static $_table_name = 'followers';
	
	
	public static function follower_exchanged($first_user_id, $second_user_id) {
		$follower_request = DB::query("SELECT * FROM followers WHERE (follower_id = $first_user_id AND followed_id = $second_user_id)")
		->as_object('Model_Follower')->execute();
		return count($follower_request) > 0 ? true : false;
	}
	public static function following_status($first_user_id, $second_user_id) {
		$follower_request = DB::query("SELECT * FROM followers WHERE (followed_id = $first_user_id AND follower_id = $second_user_id)")
		->as_object('Model_Follower')->execute();
		return count($follower_request) > 0 ? true : false;
	}

}
