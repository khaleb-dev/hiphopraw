<?php

namespace Fuel\Migrations;

class Create_genders
{
    public function up()
    {
        \DBUtil::create_table('genders', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

        ), array('id'));

        \Model_Gender::forge(array("name" => "male"))->save();
        \Model_Gender::forge(array("name" => "female"))->save();
    }

    public function down()
    {
        \DBUtil::drop_table('genders');
    }
}