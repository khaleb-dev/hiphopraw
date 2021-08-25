<?php
use Orm\Model;

class Model_Message extends Model
{
    const STATUS_READ = "read";
    const STATUS_UNREAD = "unread";

    protected static $_properties = array(
			'id',
		'from_member_id',
		'to_member_id',
		'subject',
		'body',
		'date_sent',
		'message_status',
		'parent_message_id',
		'is_deleted_sender',
		'is_deleted_receiver',
	    'is_deleted_reciever_forever',			
		'archive_inbox',
		'archive_sent',
		'created_at',
		'updated_at',
		'archive_inbox_id',
		'archive_sent_id',
		'trash_inbox_id',
		'trash_sent_id',
		'is_deleted_sender_forever',	
	);
protected static $_table_name = 'messages';
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
public static  function count_Inbox($profile_id) {
	              	$inbox_messages_retrived = Model_Message::find('all', array(
                    "where" => array(
                        array("to_member_id", $profile_id),
                        array("is_deleted_receiver", 0),
                        array("archive_inbox_id", 0),
                        array("trash_inbox_id", 0),
                    )
                ));
				
				if($inbox_messages_retrived>0)
		   {
		      return count($inbox_messages_retrived);
			  }
			  else
			   return 0;
			   }
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		//$val->add_field('id', 'Id', 'required|valid_string[numeric]');
		//$val->add_field('from_member_id', 'From Member Id', 'required|valid_string[numeric]');
		$val->add_field('to_member_id', 'To Member Id', 'required');
		$val->add_field('subject', 'Subject', 'required|max_length[255]');
		$val->add_field('body', 'Body', 'required');
		//$val->add_field('date_sent', 'Date Sent', 'required');
		//$val->add_field('message_status', 'Message Status', 'required|max_length[255]');
		//$val->add_field('parent_message_id', 'Parent Message Id', 'required|valid_string[numeric]');
		//$val->add_field('is_deleted_sender', 'Is Deleted Sender', 'required');
		//$val->add_field('is_deleted_reciever', 'Is Deleted Reciever', 'required');

		return $val;
	}
	
			
	
}
