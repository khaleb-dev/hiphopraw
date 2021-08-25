
<?php

class Model_Message extends \Orm\Model
{
    const INBOX = "inbox";    
    const READ = "read";
    const UNREAD = "unread";
    const DRAFT = "draft";
    const SENT = "sent";
    const TRASH = "trash";
    
	protected static $_properties = array(
		'id',
		'from_user_id',
		'to_user_id',
		'title',
		'detail',
		'status',
		'parent_message_id',
		'read_status',
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
	protected static $_table_name = 'messages';

    protected static $_belongs_to = array(
        'sender' => array(
            'model_to' => 'Model_User',
            'key_from' => 'from_user_id',
            'key_to' => 'id',
        ),
        'receiver' => array(
            'model_to' => 'Model_User',
            'key_from' => 'to_user_id',
            'key_to' => 'id',
        ),
    );
    public static function get_message_replies($parent_message_id)
	{
		$messages = Model_Message::find('all', array(
				'where' => array('parent_message_id' => $parent_message_id),
				'order_by' => array('created_at' => 'ASC'),
		));
		if(count($messages) > 0)
			return $messages;
	
		return false;
	}
}
