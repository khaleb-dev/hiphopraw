<?php

namespace Fuel\Migrations;

class Drop_memberships
{
	public function up()
	{
		\DBUtil::drop_table('memberships');
	}

	public function down()
	{
		\DBUtil::create_table('memberships', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'membership_type_id' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'payment_type_id' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'payment_amount' => array('type' => 'float', 'null' => true, 'constraint' => '10, 2'),
			'subscription_id' => array('type' => 'varchar', 'null' => true, 'constraint' => 200),
			'subscription_date' => array('type' => 'date', 'null' => true),
			'has_dating_agent' => array('type' => 'tinyint', 'default' => '0'),
			'dating_agent_payment' => array('type' => 'float', 'null' => true, 'constraint' => '10, 2'),
			'transaction_id' => array('type' => 'varchar', 'null' => true, 'constraint' => 200),
			'transaction_date' => array('type' => 'date', 'null' => true),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}