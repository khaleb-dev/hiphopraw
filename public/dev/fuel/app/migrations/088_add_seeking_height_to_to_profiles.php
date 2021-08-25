<?php

namespace Fuel\Migrations;

class Add_seeking_height_to_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'seeking_height_to' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'seeking_height_to'

		));
	}
}