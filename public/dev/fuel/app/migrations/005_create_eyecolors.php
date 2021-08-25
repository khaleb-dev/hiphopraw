<?php

namespace Fuel\Migrations;

class Create_eyecolors
{
    public function up()
    {
        \DBUtil::create_table('eyecolors', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

        ), array('id'));

        \Model_Eyecolor::forge(array("name" => "Black"))->save();
        \Model_Eyecolor::forge(array("name" => "Blue"))->save();
        \Model_Eyecolor::forge(array("name" => "Green"))->save();
        \Model_Eyecolor::forge(array("name" => "Hazel"))->save();
        \Model_Eyecolor::forge(array("name" => "Brown"))->save();
        \Model_Eyecolor::forge(array("name" => "Grey"))->save();
        \Model_Eyecolor::forge(array("name" => "Other"))->save();
    }

    public function down()
    {
        \DBUtil::drop_table('eyecolors');
    }
}