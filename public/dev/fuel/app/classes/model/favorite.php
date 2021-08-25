<?php

class Model_Favorite extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'member_id',
		'favorite_member_id',
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
	protected static $_table_name = 'favorites';

    protected static $_belongs_to = array(
        'sender' => array(
            'key_from' => 'member_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
        'receiver' => array(
            'key_from' => 'favorite_member_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function favorite_exists($first_user_id, $second_user_id) {
        $favorite = DB::query("SELECT * FROM favorites WHERE (member_id = $first_user_id AND favorite_member_id = $second_user_id)")
            ->as_object('Model_Favorite')->execute();
        return count($favorite) > 0 ? true : false;
    }

    public static  function count_favorites($profile_id) {
        $favorites = Model_Favorite::find('all', array("where" => array(array("member_id", $profile_id),)));
        return count($favorites);
    }

}
