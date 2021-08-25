<?php

namespace Fuel\Migrations;

class Create_smokes
{
	public function up()
	{
		\DBUtil::create_table('smokes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Smoke::forge(array("name" => "Non-smoker"))->save();
        \Model_Smoke::forge(array("name" => "Light/Social smoker"))->save();
        \Model_Smoke::forge(array("name" => "Heavy smoker"))->save();
        \Model_Smoke::forge(array("name" => "Cigar/Pipe smoker"))->save();
        \Model_Smoke::forge(array("name" => "Other"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('smokes');
	}
}