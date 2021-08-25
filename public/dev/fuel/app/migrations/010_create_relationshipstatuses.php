<?php

namespace Fuel\Migrations;

class Create_relationshipstatuses
{
	public function up()
	{
		\DBUtil::create_table('relationshipstatuses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Relationshipstatus::forge(array("name" => "Single"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Married"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Divorced"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Separated"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Attached"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Widowed"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('relationshipstatuses');
	}
}