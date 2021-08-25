<?php

class Model_Package extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'event_date',
		'short_description',
        'long_description',
		'event_venue',
        'price',
        'is_featured',
		'picture',
		'state',
		'city',
		'time_from',
		'time_to',
		'zip_code',
		
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
	protected static $_table_name = 'packages';
	
	public static $thumbnails = array(
			"event_list" => array("width" => 263, "height" => 171),
			"event_detail" => array("width" => 370, "height" => 240),
			"event_featured" => array("width" => 111, "height" => 89),
			"event_rsvp" => array("width" => 157, "height" => 126),
			"event_cover" => array("width" => 746, "height" => 360),
	);

}