<?php

namespace Fuel\Migrations;

class Create_comments
{
	public function up()
	{
		\DBUtil::create_table('comments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'parent_comment_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'comment_to' => array('constraint' => 11, 'type' => 'int'),
			'comment_from' => array('constraint' => 11, 'type' => 'int'),
			'comment' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('comments');
	}
}