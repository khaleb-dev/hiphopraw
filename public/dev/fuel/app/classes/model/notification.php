<?php

class Model_Notification extends \Orm\Model
{
    //Notification object type names
    const MESSAGE_SENT = 1;
    const HELLO_RECEIVED = 2;
    const EVENT_RSVP_SENT = 3;
    const DATING_PACKAGE_INVITATION_SENT = 4;
    const HELLO_SENT = 5;
    const DATING_AGENT_INVITATION_SENT = 6;
    const NEW_MATCH_FOUND = 7;
    const REFERRED_A_FRIEND = 8;
    const SAVED_AS_FAVORITE = 9;
    const CHAT_REQUEST_SENT =10;
  
    //Notification categories
    const MESSAGE_NOTIFICATIONS = 1;
    const HELLO_NOTIFICATIONS = 1;
    const FAVORITE_NOTIFICATIONS = 1;
    const CHAT_NOTIFICATIONS =1;
    const DATING_PACKAGE_NOTIFICATIONS = 1;
    const DATING_AGENT_NOTIFICATIONS = 1;
    const MATCH_NOTIFICATIONS = 1;
    const FRIEND_NOTIFICATIONS = 1;
    const EVENT_NOTIFICATIONS = 2;

	protected static $_properties = array(
		'id',
		'object_id',
		'object_type_id',
		'actor_id',
		'subject_id',
		'seen',
        'category',
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
	protected static $_table_name = 'notifications';


    /**
     * @param $object_type should match with static const variables of the Notification model
     * @param $object_id is the id of the record acted upon
     * @param $notified_to is the user id of the user being notified
     * @param $notified_by is the user id of the user sending the notification
     * @return bool
     */
    public static function save_notifications($object_type, $object_id, $notified_to, $notified_by)
    {
        $notification = new Model_Notification();
        $notification->object_type_id = $object_type;
        $notification->object_id = $object_id;
        $notification->actor_id = $notified_by;
        $notification->subject_id = $notified_to;
        $notification->seen = 0;

        switch($object_type){

            case(self::MESSAGE_SENT):
                $notification->category = self::MESSAGE_NOTIFICATIONS;
                break;

            case(self::HELLO_SENT):
            case(self::HELLO_RECEIVED):
                $notification->category = self::HELLO_NOTIFICATIONS;
                break;
            case(self::SAVED_AS_FAVORITE):
                $notification->category = self::FAVORITE_NOTIFICATIONS;
                break;
            case(self::CHAT_REQUEST_SENT):
                $notification->category = self::CHAT_NOTIFICATIONS;
                break;
            case(self::DATING_PACKAGE_INVITATION_SENT):
                $notification->category = self::DATING_PACKAGE_NOTIFICATIONS;
                break;

            case(self::EVENT_RSVP_SENT):
                $notification->category = self::EVENT_NOTIFICATIONS;
                break;

            case(self::DATING_AGENT_INVITATION_SENT):
                $notification->category = self::DATING_AGENT_NOTIFICATIONS;
                break;

            case(self::NEW_MATCH_FOUND):
                $notification->category = self::MATCH_NOTIFICATIONS;
                break;

            case(self::REFERRED_A_FRIEND):
                $notification->category = self::FRIEND_NOTIFICATIONS;
                break;

            default:
                $notification->category = 0;
                break;
        }

        if($notification->save()){
            return true;
        }

        return false;
    }

    public static function get_notifications($notified_to)
    {
        $notifications = \Fuel\Core\DB::query("SELECT * FROM notifications
                            WHERE subject_id=$notified_to
                            AND seen = 0
                            ORDER BY category ASC, created_at DESC")
                            ->execute();

        if(count($notifications) > 0)
            return $notifications;

        return false;
    }

    public static function mark_as_seen($notification_id)
    {
        $notification = Model_Notification::find($notification_id);
        $notification->seen = 1;

        if($notification->save())
            return true;

        return false;
    }

}
