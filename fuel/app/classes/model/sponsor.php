
<?php

class Model_Sponsor extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'sponsor',
		'image',
		'contact_info1',
		'contact_info2',
		'joined_date',
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
	protected static $_table_name = 'sponsors';
	public static function get_sponsor($sponsor) {
        if (isset($sponsor->image) && $sponsor->image != "") {
            return Uri::create("uploads/sponsor_image/" . $sponsor->image);
        } else {
            return "";
        }
    }

}
