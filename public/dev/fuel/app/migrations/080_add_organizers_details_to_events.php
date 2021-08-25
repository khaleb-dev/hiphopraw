<?php

namespace Fuel\Migrations;

class Add_organizers_details_to_events
{
	public function up()
	{
		\DBUtil::add_fields('events', array(
			'organizers_details' => array('constraint' => 255, 'type' => 'varchar'),
			'time_zone' => array('constraint' => 255, 'type' => 'varchar'),
			'zip' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('events', array(
			'organizers_details'
,			'time_zone'
,			'zip'

		));
	}
}