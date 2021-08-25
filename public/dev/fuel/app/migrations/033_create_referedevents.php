<?php

namespace Fuel\Migrations;

class Create_referedevents
{
	public function up()
	{
		\DBUtil::create_table('referedevents', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'event_id' => array('constraint' => 11, 'type' => 'int'),
			'refered_by' => array('constraint' => 11, 'type' => 'int'),
			'refered_to' => array('constraint' => 11, 'type' => 'int'),
			'message' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('referedevents');
	}
}