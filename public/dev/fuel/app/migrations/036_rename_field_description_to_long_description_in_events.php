<?php

namespace Fuel\Migrations;

class Rename_field_description_to_long_description_in_events
{
	public function up()
	{
		\DBUtil::modify_fields('events', array(
			'description' => array('name' => 'long_description', 'type' => 'text')
		));
	}

	public function down()
	{
	\DBUtil::modify_fields('events', array(
			'long_description' => array('name' => 'description', 'type' => 'text')
		));
	}
}