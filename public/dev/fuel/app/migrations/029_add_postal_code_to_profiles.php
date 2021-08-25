<?php

namespace Fuel\Migrations;

class Add_postal_code_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'postal_code' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'postal_code'

		));
	}
}