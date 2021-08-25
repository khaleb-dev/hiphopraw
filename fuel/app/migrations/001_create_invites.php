<?php

namespace Fuel\Migrations;

class Create_invites
{
	public function up()
	{
		\DBUtil::create_table('invites', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'sender_id' => array('constraint' => 11, 'type' => 'int'),
			'friend_email' => array('constraint' => 255, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('invites');
	}
}