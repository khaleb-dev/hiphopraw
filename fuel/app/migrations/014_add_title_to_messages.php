<?php

namespace Fuel\Migrations;

class Add_title_to_messages
{
	public function up()
	{
		\DBUtil::add_fields('messages', array(
			'title' => array('constraint' => 255, 'type' => 'varchar'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('messages', array(
			'title'

		));
	}
}