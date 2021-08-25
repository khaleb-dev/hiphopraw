<?php

namespace Fuel\Migrations;

use Fuel\Core\DBUtil;

class Modify_profile_name
{
	public function up()
	{
        \DBUtil::modify_fields('profiles', array(
			'profile_name' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'profile_name'

		));
	}
}