<?php

namespace Fuel\Migrations;

class Add_field_archive_sent
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'archive_sent' => array('type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'archive_sent'

		));
	}
}