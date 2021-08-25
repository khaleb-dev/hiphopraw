<?php

namespace Fuel\Migrations;

class Add_checkin_date_to_datingpackageinvitations
{
	public function up()
	{
		\DBUtil::add_fields('datingpackageinvitations', array(
			'checkin_date' => array('type' => 'date'),
			'checkin_time' => array('type' => 'time'),
			'booking_status' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackageinvitations', array(
			'checkin_date'
,			'checkin_time'
,			'booking_status'

		));
	}
}