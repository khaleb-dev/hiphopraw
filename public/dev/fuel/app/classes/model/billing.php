<?php

class Model_Billing extends \Orm\Model
{
	protected static $_properties = array(
		'id',
        'profile_id',
		'country_id',
		'state',
		'city',
		'postal_code',
		'street_address',
		'phone_number',
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
	protected static $_table_name = 'billings';

    /**
     * one to one relationship to Auth_User
     */
    protected static $_belongs_to = array(
        'profile' => array(
            'key_from' => 'profile_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
        ),
    );
}
