<?php

namespace Fuel\Migrations;

class Drop_membershiptypes
{
	public function up()
	{
		\DBUtil::drop_table('membershiptypes');
	}

	public function down()
	{
		\DBUtil::create_table('membershiptypes', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'name' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}