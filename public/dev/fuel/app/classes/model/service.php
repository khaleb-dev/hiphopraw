<?php

class Model_Service extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'profile_id',
		'payment_type_id',
		'payment_amount',
		'transaction_id',
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
	protected static $_table_name = 'services';

    protected static $_belongs_to = array(
        'profile' => array(
            'key_from' => 'profile_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
        ),
        'paymenttype' => array(
            'key_from' => 'payment_type_id',
            'model_to' => 'Model_Paymenttype',
            'key_to' => 'id',
        ),
    );

    public static function has_service($profile_id, $payment_type_id)
    {
        return Model_Service::query()->where('profile_id', $profile_id)->where('payment_type_id', $payment_type_id)->count() > 0;
    }

}
