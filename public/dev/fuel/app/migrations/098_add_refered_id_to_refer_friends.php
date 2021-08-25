<?php

namespace Fuel\Migrations;

class Add_refered_id_to_refer_friends
{
	public function up()
	{
		\DBUtil::add_fields('refer_friends', array(
			'refered_id' => array('type' => 'tinyint'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('refer_friends', array(
			'refered_id'

		));
	}
}