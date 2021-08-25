<?php

namespace Fuel\Migrations;

class Create_religions
{
	public function up()
	{
		\DBUtil::create_table('religions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Religion::forge(array("name" => "Agnostic"))->save();
        \Model_Religion::forge(array("name" => "Atheist"))->save();
        \Model_Religion::forge(array("name" => "Buddhist/Taoist"))->save();
        \Model_Religion::forge(array("name" => "Christian/Catholic"))->save();
        \Model_Religion::forge(array("name" => "Christian/Protestant"))->save();
        \Model_Religion::forge(array("name" => "Christian/Other"))->save();
        \Model_Religion::forge(array("name" => "Jewish"))->save();
        \Model_Religion::forge(array("name" => "Hindu"))->save();
        \Model_Religion::forge(array("name" => "Muslim/Islam"))->save();
        \Model_Religion::forge(array("name" => "Spiritual but not religious"))->save();
        \Model_Religion::forge(array("name" => "Other"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('religions');
	}
}