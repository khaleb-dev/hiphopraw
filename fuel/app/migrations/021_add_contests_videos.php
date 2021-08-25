<?php

namespace Fuel\Migrations;

class Add_contests_videos
{
	public function up()
	{
		\DBUtil::create_table('contests_videos', array(
				
				'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),

				'contest_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'video_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'round_id' => array('constraint' => 3, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'paired_with' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true, 'default' => 0),
				'winner'	=>  array('constraint' => "'undetermined', 'no', 'yes'", 'type' => 'enum', 'default'=>'undetermined'),
				
				'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
				'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
				
		
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('contests_videos');
	}
}