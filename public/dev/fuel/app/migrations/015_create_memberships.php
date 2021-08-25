<?php

namespace Fuel\Migrations;

class Create_Memberships
{
	public function up()
	{
		\DBUtil::create_table('memberships', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'membership_type_id' => array('constraint' => 11, 'type' => 'int'),
			'payment_type_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'payment_amount' => array('constraint' => '10, 2','type' => 'float', 'null' => true),
			'subscription_id' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'subscription_date' => array('type' => 'date', 'null' => true),
			'has_dating_agent' => array('type' => 'boolean', 'default' => 0),
			'dating_agent_payment' => array('constraint' => '10, 2', 'type' => 'float', 'null' => true),
			'transaction_id' => array('constraint' => 200, 'type' => 'varchar', 'null' => true),
			'transaction_date' => array('type' => 'date', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('memberships');
	}
}