
<?php

class Model_Invite extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'sender_id' => array(
			'form' => array('type' => false),
		),
		'friend_email' => array(
			'label'		  => 'Email',
			'null'		  => false,
			'validation'  => array('required', 'valid_email')
		),
		'message' => array(
			'label'		  => 'Message',
			'null'		  => false
		),
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

	protected static $_table_name = 'invites';

	protected static $_belongs_to = array('user' => array(
		'key_from' => 'sender_id',
		'key_to' => 'id'
	));

}
