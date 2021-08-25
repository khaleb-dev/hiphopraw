<?php

namespace Fuel\Migrations;

class Create_haircolors
{
    public function up()
    {
        \DBUtil::create_table('haircolors', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

        ), array('id'));

        \Model_Haircolor::forge(array("name" => "Blonde"))->save();
        \Model_Haircolor::forge(array("name" => "Red"))->save();
        \Model_Haircolor::forge(array("name" => "Black"))->save();
        \Model_Haircolor::forge(array("name" => "Light Brown"))->save();
        \Model_Haircolor::forge(array("name" => "Dark Brown"))->save();
        \Model_Haircolor::forge(array("name" => "Grey"))->save();
        \Model_Haircolor::forge(array("name" => "White"))->save();
        \Model_Haircolor::forge(array("name" => "Aubum"))->save();
        \Model_Haircolor::forge(array("name" => "Bald"))->save();
        \Model_Haircolor::forge(array("name" => "Other"))->save();
    }

    public function down()
    {
        \DBUtil::drop_table('haircolors');
    }
}