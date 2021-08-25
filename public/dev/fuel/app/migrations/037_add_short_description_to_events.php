<?php

namespace Fuel\Migrations;

class Add_short_description_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'short_description' => array('constraint' => 400, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'short_description'

		));
	}
}