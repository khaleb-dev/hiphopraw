<?php

namespace Fuel\Migrations;

class Create_ethnicities
{
    public function up()
    {
        \DBUtil::create_table('ethnicities', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

        ), array('id'));

        \Model_Ethnicity::forge(array("name" => "European"))->save();
        \Model_Ethnicity::forge(array("name" => "Latino"))->save();
        \Model_Ethnicity::forge(array("name" => "Black/African"))->save();
        \Model_Ethnicity::forge(array("name" => "Asian"))->save();
        \Model_Ethnicity::forge(array("name" => "Other"))->save();
    }

    public function down()
    {
        \DBUtil::drop_table('ethnicities');
    }
}