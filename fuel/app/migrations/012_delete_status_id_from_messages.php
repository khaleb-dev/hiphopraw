<?php

namespace Fuel\Migrations;

class Delete_status_id_from_messages
{
	public function up()
	{
		\DBUtil::drop_fields('messages', array(
			'status_id'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('messages', array(
			'status_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}
}