<?php

namespace Fuel\Migrations;

class Drop_datingagentsubscriptions
{
	public function up()
	{
		\DBUtil::drop_table('datingagentsubscriptions');
	}

	public function down()
	{
		\DBUtil::create_table('datingagentsubscriptions', array(
			'id' => array('type' => 'int unsigned', 'null' => true, 'auto_increment' => true),
			'premium_member_id' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'expire_date' => array('type' => 'date', 'null' => true),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}