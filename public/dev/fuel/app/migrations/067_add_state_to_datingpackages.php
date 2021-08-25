<?php

namespace Fuel\Migrations;

class Add_state_to_datingpackages
{
	public function up()
	{
		\DBUtil::add_fields('datingpackages', array(
			'state' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'state'

		));
	}
}