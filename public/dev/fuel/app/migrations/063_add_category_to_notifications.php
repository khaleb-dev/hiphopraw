<?php

namespace Fuel\Migrations;

class Add_category_to_notifications
{
	public function up()
	{
		\DBUtil::add_fields('notifications', array(
			'category' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('notifications', array(
			'category'

		));
	}
}