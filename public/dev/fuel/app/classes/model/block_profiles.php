<?php
use Orm\Model;

class Model_Block_profiles extends Model
{
   
    protected static $_properties = array(
		
		'id',
		'blocker',
		'blocked',
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
	protected static $_table_name = 'block_profiles';
	
	
	
	
	}
?>