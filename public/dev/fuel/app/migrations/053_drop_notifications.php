<?php

namespace Fuel\Migrations;

class Drop_notifications
{
	public function up()
	{
		\DBUtil::drop_table('notifications');
	}

	public function down()
	{
		\DBUtil::create_table('notifications', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'notified_to' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'notification_type' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'message' => array('type' => 'text', 'null' => true),
			'url' => array('type' => 'text', 'null' => true),
			'seen' => array('type' => 'tinyint', 'null' => true),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}