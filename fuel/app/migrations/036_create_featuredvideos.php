<?php

namespace Fuel\Migrations;

class Create_featuredvideos
{
	public function up()
	{
		\DBUtil::create_table('featuredvideos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'video_id' => array('constraint' => 11, 'type' => 'int'),
			'page' => array('constraint' => 50, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('featuredvideos');
	}
}