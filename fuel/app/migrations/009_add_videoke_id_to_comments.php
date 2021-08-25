<?php

namespace Fuel\Migrations;

class Add_videoke_id_to_comments
{
	public function up()
	{
		\DBUtil::add_fields('comments', array(
			'videoke_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('comments', array(
			'videoke_id'

		));
	}
}