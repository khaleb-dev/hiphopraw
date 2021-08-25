<?php

namespace Fuel\Migrations;

class Add_notification_to_notifications
{
	public function up()
	{
		\DBUtil::add_fields('notifications', array(
			'notification' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('notifications', array(
			'notification'

		));
	}
}