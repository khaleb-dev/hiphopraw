<?php

namespace Fuel\Migrations;

class Add_disable_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'disable' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'disable'

		));
	}
}