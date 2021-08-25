<?php

namespace Fuel\Migrations;

class Add_start_pm_am_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'start_pm_am' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'start_pm_am'

		));
	}
}