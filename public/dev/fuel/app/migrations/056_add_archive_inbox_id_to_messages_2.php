<?php

namespace Fuel\Migrations;

class Add_archive_inbox_id_to_messages_2
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'archive_inbox_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'archive_inbox_id'

		));
	}
}