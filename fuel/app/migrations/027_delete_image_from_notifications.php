<?php

namespace Fuel\Migrations;

class Delete_image_from_notifications
{
	public function up()
	{
		\DBUtil::drop_fields('notifications', array(
			'image'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('notifications', array(
			'image' => array('constraint' => 100, 'type' => 'varchar'),

		));
	}
}