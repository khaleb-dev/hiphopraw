<?php

namespace Fuel\Migrations;

class Create_messages
{
	public function up()
	{
		\DBUtil::create_table('messages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'from_member_id' => array('constraint' => 11, 'type' => 'int'),
			'to_member_id' => array('constraint' => 11, 'type' => 'int'),
			'subject' => array('type' => 'text'),
			'body' => array('type' => 'text'),
            'date_sent' => array('constraint' => 11, 'type' => 'int'),
            'message_status' => array('constraint' => 20, 'type' => 'varchar'),
            'is_deleted_sender' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),
            'is_deleted_receiver' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('messages');
	}
}