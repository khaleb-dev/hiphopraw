<?php

namespace Fuel\Migrations;

use Auth\Auth;

class Create_notifications
{
	public function up()
	{
		\DBUtil::create_table('notifications', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'notified_to' => array('constraint' => 11, 'type' => 'int'),
			'notification_type' => array('constraint' => 11, 'type' => 'int'),
			'message' => array('type' => 'text'),
			'url' => array('type' => 'text'),
			'seen' => array('type' => 'boolean'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('notifications');
	}

}