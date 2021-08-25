<?php

namespace Fuel\Migrations;

class Add_field_archive_inbox
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'archive_inbox' => array('type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'archive_inbox'

		));
	}
}