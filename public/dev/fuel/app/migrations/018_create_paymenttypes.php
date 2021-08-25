<?php

namespace Fuel\Migrations;

class Create_Paymenttypes
{
	public function up()
	{
		\DBUtil::create_table('paymenttypes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'amount' => array('constraint' => "10, 2", 'type' => 'float'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

	}

	public function down()
	{
		\DBUtil::drop_table('paymenttypes');
	}
}