<?php

namespace Fuel\Migrations;

class Add_likes_and_dislikes_to_videokes
{
	public function up()
	{
		\DBUtil::add_fields('videokes', array(
			'likes' => array('constraint' => 11, 'type' => 'int', 'default' => 0),
			'dislikes' => array('constraint' => 11, 'type' => 'int', 'default' => 0),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('videokes', array(
			'likes'
,			'dislikes'

		));
	}
}