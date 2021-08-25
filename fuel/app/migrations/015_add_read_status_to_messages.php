<?php

namespace Fuel\Migrations;

class Add_read_status_to_messages
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'read_status' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'read_status'

		));
	}
}