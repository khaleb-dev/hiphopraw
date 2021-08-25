<?php

namespace Fuel\Migrations;

class Add_zip_code_to_datingpackages
{
	public function up()
	{
		\DBUtil::add_fields('datingpackages', array(
			'zip_code' => array('constraint' => 10, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackages', array(
			'zip_code'

		));
	}
}