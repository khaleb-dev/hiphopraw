<?php
class Model_Rating extends \Orm\Model {

    protected static $_properties = array(
        'id'
        , 'user_id'
        , 'videoke_id' 
        , 'timestamp'
        , 'rating'
    );

    protected static $_observers = array(
    );

    public static $_table_name = 'videokes_ratings';
    
}
