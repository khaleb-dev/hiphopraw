<?php

namespace Fuel\Migrations;

class Add_picture_to_datingpackages
{
	public function up()
	{
		\DBUtil::add_fields('datingpackages', array(
			'picture' => array('type' => 'longblob'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'picture'

		));
	}
}