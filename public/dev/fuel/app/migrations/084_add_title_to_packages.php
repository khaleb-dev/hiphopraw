<?php

namespace Fuel\Migrations;

class Add_title_to_packages
{
	public function up()
	{
		\DBUtil::add_fields('packages', array(
			'title' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('packages', array(
			'title'

		));
	}
}