<?php

class Model_Comment extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'videoke_id',
		'detail',
		'created_at',
		'updated_at',
		'parent_comment_id',
	    'is_deleted'
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
	protected static $_table_name = 'comments';

	protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'user_id',
            'key_to' => 'id'
        ),
        'videoke' => array(
            'key_from' => 'videoke_id',
            'key_to' => 'id'
        ),
    );
	
	public static function get_comments_by_receiver($receiver_id)
	{
		$comments = Model_Comment::find('all', array(
				'where' => array('videoke_id' => $receiver_id, 'parent_comment_id' => 0, 'is_deleted' => 0),
				'order_by' => array('created_at' => 'DESC'),
		));
		if(count($comments) > 0)
			return $comments;
	
		return false;
	}
	
	public static function get_comment_replies($parent_comment_id)
	{
		$comments = Model_Comment::find('all', array(
				'where' => array('parent_comment_id' => $parent_comment_id, 'is_deleted' => 0),
				'order_by' => array('created_at' => 'ASC'),
		));
		if(count($comments) > 0)
			return $comments;
	
		return false;
	}
	public static function get_comment_reply($parent_comment_id,$reply_id)
	{
		$comments = Model_Comment::find('all', array(
				'where' => array('id'=>$reply_id,'parent_comment_id' => $parent_comment_id, 'is_deleted' => 0),
				'order_by' => array('created_at' => 'ASC'),
		));
		if(count($comments) > 0)
			return $comments;
	
		return false;
	}
}
