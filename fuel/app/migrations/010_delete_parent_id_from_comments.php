<?php

namespace Fuel\Migrations;

class Delete_parent_id_from_comments
{
	public function up()
	{
		\DBUtil::drop_fields('comments', array(
			'parent_id'

		));
	}

	public function down()
	{
		\DBUtil::add_fields('comments', array(
			'parent_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}
}