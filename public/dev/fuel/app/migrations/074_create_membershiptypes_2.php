<?php

namespace Fuel\Migrations;

class Create_membershiptypes_2
{
	public function up()
	{
		\DBUtil::create_table('membershiptypes_2', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
        \Model_Membershiptype::forge(array("name" => "Free"))->save();
        \Model_Membershiptype::forge(array("name" => "Premium"))->save();
        \Model_Membershiptype::forge(array("name" => "Dating Agent"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('membershiptypes_2');
	}
}