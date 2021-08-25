<?php

namespace Fuel\Migrations;

class Add_city_to_datingpackages
{
	public function up()
	{
		\DBUtil::add_fields('datingpackages', array(
			'city' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'city'

		));
	}
}