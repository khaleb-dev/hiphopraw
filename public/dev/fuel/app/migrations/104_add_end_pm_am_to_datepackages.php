<?php

namespace Fuel\Migrations;

class Add_end_pm_am_to_datepackages
{
	public function up()
	{
		\DBUtil::add_fields('datepackages', array(
			'end_pm_am' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datepackages', array(
			'end_pm_am'

		));
	}
}