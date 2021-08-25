<?php

namespace Fuel\Migrations;

class Add_videokes_ratings
{
    public function up()
    {
        \DBUtil::create_table('videokes_ratings', array(

            'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'videoke_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
            'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
            'rating' => array('constraint' => 3, 'type'=>'tinyint', 'unsigned' => false, 'default' => 0),
            'timestamp' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('videokes_ratings');
    }
}