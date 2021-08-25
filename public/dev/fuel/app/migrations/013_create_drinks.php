<?php

namespace Fuel\Migrations;

class Create_drinks
{
	public function up()
	{
		\DBUtil::create_table('drinks', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Drink::forge(array("name" => "Non-drinker"))->save();
        \Model_Drink::forge(array("name" => "Light/Social drinker"))->save();
        \Model_Drink::forge(array("name" => "Heavy drinker"))->save();
        \Model_Drink::forge(array("name" => "Other"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('drinks');
	}
}