<?php

namespace Fuel\Migrations;

class Add_cancelled_to_contest
{
	public function up()
	{
		\DBUtil::modify_fields('contests', array(
		    'status'	=>  array('constraint' => "'active','completed','deleted','cancelled'", 'type' => 'enum', 'default'=>'active'),
		    
		));
	
	}

	public function down()
	{
		\DBUtil::modify_fields('contests', array(
		    'status'	=>  array('constraint' => "'active','completed','deleted'", 'type' => 'enum', 'default'=>'active'),
		    
		));
	}
}