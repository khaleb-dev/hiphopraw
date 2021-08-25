<?php

namespace Fuel\Migrations;

class Add_is_logged_in_to_users
{
	public function up()
	{
		\DBUtil::add_fields('is_logged_in', array(
			'is_logged_in' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('is_logged_in', array(
			'is_logged_in'

		));
	}
}