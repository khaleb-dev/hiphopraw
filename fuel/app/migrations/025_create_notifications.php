<?php

namespace Fuel\Migrations;

class Create_notifications
{
	public function up()
	{
		\DBUtil::create_table('notifications', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 100, 'type' => 'varchar'),
			'image' => array('constraint' => 100, 'type' => 'varchar'),
			'page' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('notifications');
	}
}