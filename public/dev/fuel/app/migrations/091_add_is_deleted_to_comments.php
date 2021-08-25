<?php

namespace Fuel\Migrations;

class Add_is_deleted_to_comments
{
	public function up()
	{
		\DBUtil::add_fields('comments', array(
			'is_deleted' => array('type' => 'bool'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('comments', array(
			'is_deleted'

		));
	}
}