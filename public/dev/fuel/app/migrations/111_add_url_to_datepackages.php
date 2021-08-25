<?php

namespace Fuel\Migrations;

class Add_url_to_datepackages
{
	public function up()
	{
		\DBUtil::add_fields('datepackages', array(
			'url' => array('type' => 'text', 'null' => true),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datepackages', array(
			'url'

		));
	}
}