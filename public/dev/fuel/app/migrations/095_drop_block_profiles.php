<?php

namespace Fuel\Migrations;

class Drop_block_profiles
{
	public function up()
	{
		\DBUtil::drop_table('block_profiles');
	}

	public function down()
	{
		\DBUtil::create_table('block_profiles', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'blocker' => array('type' => 'varchar', 'null' => true, 'constraint' => 30),
			'blocked' => array('type' => 'varchar', 'null' => true, 'constraint' => 30),
			'status' => array('type' => 'varchar', 'null' => true, 'constraint' => 15),

		), array('id'));

	}
}