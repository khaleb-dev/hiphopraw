<?php

class Model_Hello extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'from_member_id',
		'to_member_id',
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
	protected static $_table_name = 'hellos';

    protected static $_belongs_to = array(
        'sender' => array(
            'key_from' => 'from_member_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
        'receiver' => array(
            'key_from' => 'to_member_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function hello_exists($from_member_id, $to_member_id) {
        $hello = DB::query("SELECT * FROM hellos WHERE (from_member_id = $from_member_id AND to_member_id = $to_member_id)")
            ->as_object('Model_Hello')->execute();
        return count($hello) > 0 ? true : false;
    }

	public static  function count_hello($profile_id) {
        $hellos = Model_Hello::find('all', array("where" => array(array("to_member_id", $profile_id),)));
        return count($hellos);
    }

}
