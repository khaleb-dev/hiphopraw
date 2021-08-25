<?php

class Model_Paymenttype extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'amount',
        'mode',
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
	protected static $_table_name = 'paymenttypes';

    /**
     * @var array    has_many relationships
     */
    protected static $_has_many = array(
        'services' => array(
            'model_to' => 'Model_Service',
            'key_from' => 'id',
            'key_to' => 'payment_type_id',
        ),
    );

    public function formatted_amount(){
        $decimal_value = substr($this->amount - intval($this->amount), 2);
        $decimal_value = $decimal_value == "" ? "00" : $decimal_value;

        return "$" . intval($this->amount) . "<sup>.". $decimal_value  ."</sup>";
    }

}
