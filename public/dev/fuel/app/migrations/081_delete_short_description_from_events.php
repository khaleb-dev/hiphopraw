<?php

namespace Fuel\Migrations;

class Delete_short_description_from_events
{
	public function up()
	{
		\DBUtil::drop_fields('events', array(
			'short_description'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('events', array(
			'short_description' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}
}