<?php

namespace Fuel\Migrations;

class Add_is_deleted_sender_forever_to_messages
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'is_deleted_sender_forever' => array('type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'is_deleted_sender_forever'

		));
	}
}