<?php

namespace Fuel\Migrations;

class Add_event_end_date_to_datepackages
{
	public function up()
	{
		\DBUtil::add_fields('datepackages', array(
			'event_end_date' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datepackages', array(
			'event_end_date'

		));
	}
}