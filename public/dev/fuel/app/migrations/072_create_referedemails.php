<?php

namespace Fuel\Migrations;

class Create_referedemails
{
	public function up()
	{
		\DBUtil::create_table('referedemails', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'email_from' => array('constraint' => 255, 'type' => 'varchar'),
			'refered_email' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('referedemails');
	}
}