<?php

namespace Fuel\Migrations;

class Create_notifications_2
{
	public function up()
	{
		\DBUtil::create_table('notifications', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'object_id' => array('constraint' => 11, 'type' => 'int'),
			'object_type_id' => array('constraint' => 11, 'type' => 'int'),
			'actor_id' => array('constraint' => 11, 'type' => 'int'),
			'subject_id' => array('constraint' => 11, 'type' => 'int'),
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