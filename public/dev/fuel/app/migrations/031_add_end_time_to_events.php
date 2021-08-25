<?php

namespace Fuel\Migrations;

class Add_end_time_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'end_time' => array('type' => 'time'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'end_time'

		));
	}
}