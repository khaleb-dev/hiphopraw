<?php

namespace Fuel\Migrations;

class Create_states
{
	public function up()
	{
		\DBUtil::create_table('states', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_State::forge(array("name" => "Alabama"))->save();
        \Model_State::forge(array("name" => "Alaska"))->save();
        \Model_State::forge(array("name" => "Arizona"))->save();
        \Model_State::forge(array("name" => "Arkansas"))->save();
        \Model_State::forge(array("name" => "California"))->save();
        \Model_State::forge(array("name" => "Colorado"))->save();
        \Model_State::forge(array("name" => "Connecticut"))->save();
        \Model_State::forge(array("name" => "Delaware"))->save();
        \Model_State::forge(array("name" => "District of Columbia"))->save();
        \Model_State::forge(array("name" => "Florida"))->save();
        \Model_State::forge(array("name" => "Georgia"))->save();
        \Model_State::forge(array("name" => "Hawaii"))->save();
        \Model_State::forge(array("name" => "Idaho"))->save();
        \Model_State::forge(array("name" => "Illinois"))->save();
        \Model_State::forge(array("name" => "Indiana"))->save();
        \Model_State::forge(array("name" => "Iowa"))->save();
        \Model_State::forge(array("name" => "Kansas"))->save();
        \Model_State::forge(array("name" => "Kentucky"))->save();
        \Model_State::forge(array("name" => "Louisiana"))->save();
        \Model_State::forge(array("name" => "Maine"))->save();
        \Model_State::forge(array("name" => "Maryland"))->save();
        \Model_State::forge(array("name" => "Massachusetts"))->save();
        \Model_State::forge(array("name" => "Michigan"))->save();
        \Model_State::forge(array("name" => "Minnesota"))->save();
        \Model_State::forge(array("name" => "Mississippi"))->save();
        \Model_State::forge(array("name" => "Missouri"))->save();
        \Model_State::forge(array("name" => "Montana"))->save();
        \Model_State::forge(array("name" => "Nebraska"))->save();
        \Model_State::forge(array("name" => "Nevada"))->save();
        \Model_State::forge(array("name" => "New Hampshire"))->save();
        \Model_State::forge(array("name" => "New Jersey"))->save();
        \Model_State::forge(array("name" => "New Mexico"))->save();
        \Model_State::forge(array("name" => "New York"))->save();
        \Model_State::forge(array("name" => "North Carolina"))->save();
        \Model_State::forge(array("name" => "North Dakota"))->save();
        \Model_State::forge(array("name" => "Ohio"))->save();
        \Model_State::forge(array("name" => "Oklahoma"))->save();
        \Model_State::forge(array("name" => "Oregon"))->save();
        \Model_State::forge(array("name" => "Pennsylvania"))->save();
        \Model_State::forge(array("name" => "Rhode Island"))->save();
        \Model_State::forge(array("name" => "South Carolina"))->save();
        \Model_State::forge(array("name" => "South Dakota"))->save();
        \Model_State::forge(array("name" => "Tennessee"))->save();
        \Model_State::forge(array("name" => "Texas"))->save();
        \Model_State::forge(array("name" => "Utah"))->save();
        \Model_State::forge(array("name" => "Vermont"))->save();
        \Model_State::forge(array("name" => "Virginia"))->save();
        \Model_State::forge(array("name" => "Washington"))->save();
        \Model_State::forge(array("name" => "West Virginia"))->save();
        \Model_State::forge(array("name" => "Wisconsin"))->save();
        \Model_State::forge(array("name" => "Wyoming"))->save();

	}

	public function down()
	{
		\DBUtil::drop_table('states');
	}
}