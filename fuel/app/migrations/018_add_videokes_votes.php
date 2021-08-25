<?php

namespace Fuel\Migrations;

class Add_videokes_votes
{
	public function up()
	{
		\DBUtil::create_table('videokes_votes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'video_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'timestamp' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'vote' => array('constraint' => 4, 'type' => 'tinyint', 'default' => 0),
			'contest_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
			'round_id' => array('constraint' => 3, 'type' => 'tinyint', 'unsigned'=>true, 'default' => 0),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('videokes_votes');
	}
}