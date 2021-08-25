
<?php

class Model_Banner extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'title',
        'image',
        'page',
        'position',
        'web_address',
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
    protected static $_table_name = 'banners';

    public static function get_banner($banner) {
        if (isset($banner->image) && $banner->image != "") {
            return Uri::create("uploads/banner_image/" . $banner->image);
        } else {
            return "";
        }
    }

}
