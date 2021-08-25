<?php

namespace Fuel\Migrations;

class Add_is_blocked_to_videokes
{
	public function up()
	{
		\DBUtil::add_fields('videokes', array(
			'is_blocked' => array('constraint' => 1,'type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('videokes', array(
			'is_blocked'

		));
	}
}