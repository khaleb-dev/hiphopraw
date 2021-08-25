<?php

namespace Fuel\Migrations;

class Add_short_description_to_events_3
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'short_description' => array('type' => 'text'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'short_description'

		));
	}
}