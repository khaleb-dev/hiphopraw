<?php

namespace Fuel\Migrations;

class Create_packages
{
	public function up()
	{
		\DBUtil::create_table('packages', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'event_date' => array('type' => 'date'),
			'time_from' => array('type' => 'time'),
			'time_to' => array('type' => 'time'),
			'event_venue' => array('constraint' => 255, 'type' => 'varchar'),
			'short_description' => array('type' => 'text'),
			'long_description' => array('type' => 'text'),
			'is_featured' => array('constraint' => 1, 'type' => 'tinyint'),
			'picture' => array('constraint' => 255, 'type' => 'varchar'),
			'state' => array('constraint' => 255, 'type' => 'varchar'),
			'city' => array('constraint' => 255, 'type' => 'varchar'),
			'price' => array('type' => 'float'),
			'zip_code' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('packages');
	}
}