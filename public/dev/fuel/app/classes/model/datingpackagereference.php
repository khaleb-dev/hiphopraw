<?php

class Model_Datingpackagereference extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'from_member_id',
		'to_member_id',
		'dating_package_id',
		'date_referred',
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
	protected static $_table_name = 'datingpackagereferences';

}
