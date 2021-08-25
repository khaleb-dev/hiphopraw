<?php

namespace Fuel\Migrations;

class Create_bodytypes
{
    public function up()
    {
        \DBUtil::create_table('bodytypes', array(
            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name' => array('constraint' => 255, 'type' => 'varchar'),
            'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

        ), array('id'));

        \Model_Bodytype::forge(array("name" => "Slim"))->save();
        \Model_Bodytype::forge(array("name" => "Athletic"))->save();
        \Model_Bodytype::forge(array("name" => "Average"))->save();
        \Model_Bodytype::forge(array("name" => "Overweight"))->save();
    }

    public function down()
    {
        \DBUtil::drop_table('bodytypes');
    }
}