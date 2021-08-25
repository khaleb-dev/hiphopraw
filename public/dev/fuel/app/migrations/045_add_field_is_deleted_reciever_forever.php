<?php

namespace Fuel\Migrations;

class Add_field_is_deleted_reciever_forever
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'is_deleted_reciever_forever' => array('type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'is_deleted_reciever_forever'

		));
	}
}