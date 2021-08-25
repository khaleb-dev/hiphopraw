<?php

namespace Fuel\Migrations;

class Add_status_to_contests_videos
{
	public function up()
	{
		\DBUtil::add_fields('contests_videos', array(
			'status' => array('constraint' => 30, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('contests_videos', array(
			'status'

		));
	}
}