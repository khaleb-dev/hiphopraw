<?php

namespace Fuel\Migrations;

class Add_is_logged_in_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'is_logged_in' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'is_logged_in'

		));
	}
}