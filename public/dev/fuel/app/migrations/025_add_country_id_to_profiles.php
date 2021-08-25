<?php

namespace Fuel\Migrations;

class Add_country_id_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'country_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'country_id'

		));
	}
}