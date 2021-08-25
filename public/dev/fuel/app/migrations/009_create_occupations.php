<?php

namespace Fuel\Migrations;

class Create_occupations
{
	public function up()
	{
		\DBUtil::create_table('occupations', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 100, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));

        \Model_Occupation::forge(array("name" => "Administrative/Secretarial"))->save();
        \Model_Occupation::forge(array("name" => "Artistic/Creative/Performance"))->save();
        \Model_Occupation::forge(array("name" => "Executive/Management"))->save();
        \Model_Occupation::forge(array("name" => "Artistic/Creative/Performance"))->save();
        \Model_Occupation::forge(array("name" => "Financial services"))->save();
        \Model_Occupation::forge(array("name" => "Labor/Construction"))->save();
        \Model_Occupation::forge(array("name" => "Legal"))->save();
        \Model_Occupation::forge(array("name" => "Medical/Dental/Veterinary"))->save();
        \Model_Occupation::forge(array("name" => "Sales/Marketing"))->save();
        \Model_Occupation::forge(array("name" => "Technical/Computers/Engineering"))->save();
        \Model_Occupation::forge(array("name" => "Travel/Hospitality/Transportation"))->save();
        \Model_Occupation::forge(array("name" => "Political/Govt/Civil Service/Military"))->save();
        \Model_Occupation::forge(array("name" => "Retail/Food services"))->save();
        \Model_Occupation::forge(array("name" => "Teacher/Professor"))->save();
        \Model_Occupation::forge(array("name" => "Student"))->save();
        \Model_Occupation::forge(array("name" => "Retired"))->save();
        \Model_Occupation::forge(array("name" => "Other profession"))->save();
	}

	public function down()
	{
		\DBUtil::drop_table('occupations');
	}
}