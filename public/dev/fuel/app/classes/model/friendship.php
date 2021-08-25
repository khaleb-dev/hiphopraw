<?php

class Model_Friendship extends \Orm\Model
{
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

    protected static $_belongs_to = array(
        'sender' => array(
            'key_from' => 'sender_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
        'receiver' => array(
            'key_from' => 'receiver_id',
            'model_to' => 'Model_Profile',
            'key_to' => 'id',
            'cascade_save' => true,
        ),
    );

    public static function request_exchanged($first_user_id, $second_user_id) {
        $friend_request = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user_id AND receiver_id = $second_user_id) OR (sender_id = $second_user_id AND receiver_id = $first_user_id)")
            ->as_object('Model_Friendship')->execute();
        return count($friend_request) > 0 ? true : false;
    }

    public static function are_friends($first_user_id, $second_user_id) {
        $friend_request = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user_id AND receiver_id = $second_user_id AND status = '". Model_Friendship::STATUS_ACCEPTED ."') OR (sender_id = $second_user_id AND receiver_id = $first_user_id AND status = '". Model_Friendship::STATUS_ACCEPTED ."')")
            ->as_object('Model_Friendship')->execute();
        return count($friend_request) > 0 ? true : false;
    }

    public static  function get_friends($profile_id) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $profile_id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $profile_id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
            ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($profile_id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $friend_ids)
            ->get() : array();
    }

    public static  function get_latest_friends($profile_id, $limit=10) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $profile_id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $profile_id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
            ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($profile_id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_Profile::query()
            ->where("id", "IN", $friend_ids)->order_by('created_at', 'desc')->limit($limit)
            ->get() : array();
    }

    public static function get_pending_friends($profile_id) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE receiver_id = $profile_id AND status = '" . Model_Friendship::STATUS_SENT . "' ")
            ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            array_push($friend_ids, $friendship->sender_id);
        }

        return count($friend_ids) > 0 ? Model_Profile::query()->where("id", "IN", $friend_ids)->get() : array();
    }
	

}
