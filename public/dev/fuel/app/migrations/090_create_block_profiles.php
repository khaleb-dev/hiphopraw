<?php

namespace Fuel\Migrations;

class Create_block_profiles
{
	public function up()
	{
		\DBUtil::create_table('block_profiles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'blocker' => array('constraint' => 30, 'type' => 'varchar'),
			'blocked' => array('constraint' => 30, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('block_profiles');
	}
}