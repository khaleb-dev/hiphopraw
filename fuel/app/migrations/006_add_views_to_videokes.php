<?php

namespace Fuel\Migrations;

class Add_views_to_videokes
{
	public function up()
	{
		\DBUtil::add_fields('videokes', array(
			'views' => array('constraint' => 11, 'type' => 'int'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('videokes', array(
			'views'

		));
	}
}