<?php

class Model_Comment extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'parent_comment_id',
		'comment_to',
		'comment_from',
		'comment',
        'is_deleted',
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
	protected static $_table_name = 'comments';
	
	public static function get_comments_by_receiver($receiver_id)
	{
		$comments = Model_Comment::find('all', array(
				'where' => array('comment_to' => $receiver_id, 'parent_comment_id' => null, 'is_deleted' => false),
				'order_by' => array('created_at' => 'DESC'),					
				));
		if(count($comments) > 0)
			return $comments;
		
		return false;
	}
	
	public static function get_comment_replies($parent_comment_id)
	{
		$comments = Model_Comment::find('all', array(
				'where' => array('parent_comment_id' => $parent_comment_id, 'is_deleted' => false),
				'order_by' => array('created_at' => 'ASC'),
		));
		if(count($comments) > 0)
			return $comments;
	
		return false;
	}

}
