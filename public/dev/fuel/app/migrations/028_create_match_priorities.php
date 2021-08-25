<?php

namespace Fuel\Migrations;

class Create_match_priorities
{
	public function up()
	{
        \DBUtil::add_fields('profiles', array(
            'priority_1' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'priority_2' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'priority_3' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'priority_4' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'priority_5' => array('constraint' => 11, 'type' => 'int', 'null' => true),
        ));
	}

	public function down()
	{
        \DBUtil::drop_fields('profiles', array(
            'priority_1',
            'priority_2',
            'priority_3',
            'priority_4',
            'priority_5',
        ));
	}
}