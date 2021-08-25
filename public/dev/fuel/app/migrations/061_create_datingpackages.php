<?php

namespace Fuel\Migrations;

class Create_datingpackages
{
	public function up()
	{
		\DBUtil::create_table('datingpackages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'event_date' => array('type' => 'date'),
			'time_from' => array('type' => 'time'),
			'time_to' => array('type' => 'time'),
			'event_venue' => array('constraint' => 255, 'type' => 'varchar'),
			'short_description' => array('type' => 'text'),
			'long_description' => array('type' => 'text'),
			'picture' => array('type' => 'blob'),
			'is_featured' => array('constraint' => '"0","1"', 'type' => 'enum'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('datingpackages');
	}
}