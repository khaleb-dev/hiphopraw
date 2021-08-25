<?php
use Orm\Model;

class Model_Datingpackageinvitation extends Model
{
	protected static $_properties = array(
		'id',
		'from_member_id',
		'to_member_id',
                'dating_package_id',
		'date_invited',
		'status',
		'created_at',
		'updated_at',
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

	public static function validate($factory)
	{
		$v = Validation::forge($factory);
		

		                
                $v->addField('to_member_id', 'to_member_id')
                ->required()
                 ->setMessage('{label} is required, please enter a value');
            return $v;
	}

}
