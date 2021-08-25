<?php

namespace Fuel\Migrations;

class Add_date_sent_to_messages
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'date_sent' => array('type' => 'datetime'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'date_sent'

		));
	}
}