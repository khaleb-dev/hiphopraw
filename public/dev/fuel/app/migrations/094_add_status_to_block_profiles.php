<?php

namespace Fuel\Migrations;

class Add_status_to_block_profiles
{
	public function up()
	{
		\DBUtil::add_fields('block_profiles', array(
			'status' => array('constraint' => 15, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('block_profiles', array(
			'status'

		));
	}
}