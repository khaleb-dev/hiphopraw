<?php

namespace Fuel\Migrations;

class Add_status_to_message
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'status' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'status'

		));
	}
}