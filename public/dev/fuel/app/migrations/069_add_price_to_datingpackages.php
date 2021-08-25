<?php

namespace Fuel\Migrations;

class Add_price_to_datingpackages
{
	public function up()
	{
		\DBUtil::add_fields('datingpackages', array(
			'price' => array('type' => 'float'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'price'

		));
	}
}