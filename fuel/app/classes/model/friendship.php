
<?php

class Model_Friendship extends \Orm\Model {

    const STATUS_SENT = "sent";
    const STATUS_ACCEPTED = "accepted";
    const STATUS_REJECTED = "rejected";
    const STATUS_BLOCKED = "blocked";
    const STATUS_DELETED = "deleted";

    protected static $_properties = array(
        'id',
        'sender_id',
        'receiver_id',
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
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    protected static $_table_name = 'friendships';

    /**
     * @var array has_one relationships
     */
    protected static $_belongs_to = array(
        'sender' => array(
            'key_from' => 'sender_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
        'receiver' => array(
            'key_from' => 'receiver_id',
            'model_to' => 'Model_User',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function are_friends($first_user_id, $second_user_id) {
        $friend_request = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user_id AND receiver_id = $second_user_id AND status = '". Model_Friendship::STATUS_ACCEPTED ."') OR (sender_id = $second_user_id AND receiver_id = $first_user_id AND status = '". Model_Friendship::STATUS_ACCEPTED ."')")
                        ->as_object('Model_Friendship')->execute();
        return count($friend_request) > 0 ? true : false;
    }

    public static function request_exchanged($first_user_id, $second_user_id) {
        $friend_request = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user_id AND receiver_id = $second_user_id) OR (sender_id = $second_user_id AND receiver_id = $first_user_id)")
                        ->as_object('Model_Friendship')->execute();
        return count($friend_request) > 0 ? true : false;
    }
    

    public static function can_send_request($first_user_id, $second_user_id) {
        return !Model_Friendship::request_exchanged($first_user_id, $second_user_id);
    }

    public static function has_sent_request($first_user_id, $second_user_id) {
                $friend_request = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user_id AND receiver_id = $second_user_id AND status = '". Model_Friendship::STATUS_SENT . "')")
                        ->as_object('Model_Friendship')->execute();
        return count($friend_request) > 0 ? true : false;
    }

}
