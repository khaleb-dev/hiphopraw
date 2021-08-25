<?php

namespace Fuel\Migrations;

class Delete_date_sent_from_messages
{
	public function up()
	{
		\DBUtil::drop_fields('messages', array(
			'date_sent'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('messages', array(
			'date_sent' => array('constraint' => 11, 'type' => 'int'),

		));
	}
}