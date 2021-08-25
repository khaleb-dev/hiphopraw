<?php

namespace Fuel\Migrations;

class Add_address_to_profiles
{
	public function up()
	{
		\DBUtil::add_fields('profiles', array(
			'address' => array('type' => 'text', "null" => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('profiles', array(
			'address'

		));
	}
}