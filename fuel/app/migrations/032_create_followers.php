<?php

namespace Fuel\Migrations;

class Create_followers
{
	public function up()
	{
		\DBUtil::create_table('followers', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'follower_id' => array('constraint' => 1, 'type' => 'int'),
			'followed_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('followers');
	}
}