<?php

namespace Fuel\Migrations;

class Create_datingagentinvitaions
{
	public function up()
	{
		\DBUtil::create_table('datingagentinvitaions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'dating_agent_profile' => array('constraint' => 11, 'type' => 'int'),
			'profile_from' => array('constraint' => 11, 'type' => 'int'),
			'profile_to' => array('constraint' => 11, 'type' => 'int'),
			'status' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('datingagentinvitaions');
	}
}