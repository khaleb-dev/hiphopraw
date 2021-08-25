<?php

namespace Fuel\Migrations;

class Add_is_featured_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'is_featured' => array('type' => 'boolean'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'is_featured'

		));
	}
}