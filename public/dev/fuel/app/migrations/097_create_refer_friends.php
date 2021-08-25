<?php

namespace Fuel\Migrations;

class Create_refer_friends
{
	public function up()
	{
		\DBUtil::create_table('refer_friends', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'refer_from' => array('type' => 'tinyint'),
			'refer_to' => array('type' => 'tinyint'),
			'status' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('refer_friends');
	}
}