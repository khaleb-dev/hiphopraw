<?php

namespace Fuel\Migrations;

class Add_archive_sent_id_to_messages
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'archive_sent_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'archive_sent_id'

		));
	}
}