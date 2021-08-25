<?php

namespace Fuel\Migrations;

class Add_url_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'url' => array('type' => 'text'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'url'

		));
	}
}