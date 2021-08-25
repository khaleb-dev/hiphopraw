<?php

namespace Fuel\Migrations;

class Create_datingagentsubscriptions
{
	public function up()
	{
		\DBUtil::create_table('datingagentsubscriptions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'premium_member_id' => array('constraint' => 11, 'type' => 'int'),
			'expire_date' => array('type' => 'date'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('datingagentsubscriptions');
	}
}