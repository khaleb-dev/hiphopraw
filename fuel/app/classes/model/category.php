
<?php

class Model_Category extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'name',
        'description',
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
    protected static $_table_name = 'categories';
    protected static $_has_many = array(
        'videoke' => array(
            'key_from' => 'id',
            'model_to' => 'Model_Videoke',
            'key_to' => 'category_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        )
    );

    public static function getCategories($include_all = false) {
        $categories = array();
        if ($include_all) {
            $categories["0"] = "All";
        }
        foreach (Model_Category::find("all") as $category) {
            $categories["$category->id"] = $category->name;
        }
        return $categories;
    }

    public static function categories() {
        $categories = array();
        $categories["0"] = "All";
        foreach (Model_Category::find("all") as $category) {
            $categories["$category->id"] = $category->name;
        }
        return $categories;
    }

}
