<?php

namespace Fuel\Migrations;

class Create_friendships
{
	public function up()
	{
		\DBUtil::create_table('friendships', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'sender_id' => array('constraint' => 11, 'type' => 'int'),
			'receiver_id' => array('constraint' => 11, 'type' => 'int'),
			'status' => array('constraint' => 20, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('friendships');
	}
}