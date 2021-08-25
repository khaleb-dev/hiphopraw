<?php

namespace Fuel\Migrations;

class Create_priorityfields
{
	public function up()
	{
		\DBUtil::create_table('priorityfields', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Priorityfield::forge(array("name" => "Age"))->save();
        \Model_Priorityfield::forge(array("name" => "Location"))->save();
        \Model_Priorityfield::forge(array("name" => "Occupation"))->save();
        \Model_Priorityfield::forge(array("name" => "Relationship Status"))->save();
        \Model_Priorityfield::forge(array("name" => "Have Kids"))->save();
        \Model_Priorityfield::forge(array("name" => "Want Kids"))->save();
        \Model_Priorityfield::forge(array("name" => "Body Type"))->save();
        \Model_Priorityfield::forge(array("name" => "Ethnicity"))->save();
        \Model_Priorityfield::forge(array("name" => "Height"))->save();
        \Model_Priorityfield::forge(array("name" => "Eye Color"))->save();
        \Model_Priorityfield::forge(array("name" => "Hair Color"))->save();
        \Model_Priorityfield::forge(array("name" => "Religion"))->save();
        \Model_Priorityfield::forge(array("name" => "Smoke"))->save();
        \Model_Priorityfield::forge(array("name" => "Drink"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('priorityfields');
	}
}