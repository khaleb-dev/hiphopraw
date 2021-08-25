<?php

class Model_Image extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'member_id',
		'description',
		'file_name',
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
	protected static $_table_name = 'images';
	
	
	public static  function count_image($profile_id) {
        $images = Model_Image::find('all', array("where" => array(array("member_id", $profile_id),)));
        $count = count($images);
        $profile= Model_Profile::find($profile_id);
        if($profile->picture != ""){
            $count += 1;
        }
        return $count;
    }
}
