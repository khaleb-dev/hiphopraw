<?php

namespace Fuel\Migrations;

class Add_profile_id_to_setting
{
	public function up()
	{
		\DBUtil::add_fields('setting', array(
			'profile_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('setting', array(
			'profile_id'

		));
	}
}