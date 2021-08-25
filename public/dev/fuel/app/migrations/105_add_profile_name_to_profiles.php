<?php

namespace Fuel\Migrations;

class Add_profile_name_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'profile_name' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'profile_name'

		));
	}
}