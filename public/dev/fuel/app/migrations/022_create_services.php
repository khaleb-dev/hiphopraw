<?php

namespace Fuel\Migrations;

class Create_services
{
	public function up()
	{
		\DBUtil::create_table('services', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'profile_id' => array('constraint' => 11, 'type' => 'int'),
			'payment_type_id' => array('constraint' => 11, 'type' => 'int'),
			'payment_amount' => array('type' => 'float'),
			'transaction_id' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('services');
	}
}