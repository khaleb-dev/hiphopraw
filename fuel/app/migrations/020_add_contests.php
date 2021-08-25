<?php

namespace Fuel\Migrations;

class Add_contests
{
	public function up()
	{
		\DBUtil::create_table('contests', array(
				
				'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
				'status'	=>  array('constraint' => "'active','completed','deleted'", 'type' => 'enum', 'default'=>'active'),
				'category_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'start_time' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'end_time' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'current_round' => array('constraint' => 3, 'type' => 'tinyint', 'unsigned' => true, 'default'=> 0),
				'winner' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'name' => array('constraint' => 255, 'type' => 'varchar', 'null' => true, 'default'=>null),
				
				'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
				'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
				
		
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('contests');
	}
}