<?php

namespace Fuel\Migrations;

class Create_banners
{
	public function up()
	{
		\DBUtil::create_table('banners', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'title' => array('constraint' => 100, 'type' => 'varchar'),
			'image' => array('constraint' => 100, 'type' => 'varchar'),
			'page' => array('constraint' => 50, 'type' => 'varchar'),
			'position' => array('constraint' => 50, 'type' => 'varchar'),
			'web_address' => array('constraint' => 100, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('banners');
	}
}