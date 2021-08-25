<?php

namespace Fuel\Migrations;

class Delete_picture_from_datingpackages
{
	public function up()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'picture'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('datingpackages', array(
			'picture' => array('type' => 'blob'),

		));
	}
}