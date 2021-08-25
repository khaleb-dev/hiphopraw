<?php

namespace Fuel\Migrations;

class Create_hellos
{
	public function up()
	{
		\DBUtil::create_table('hellos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'from_member_id' => array('constraint' => 11, 'type' => 'int'),
			'to_member_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('hellos');
	}
}