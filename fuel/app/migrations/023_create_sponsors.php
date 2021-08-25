<?php

namespace Fuel\Migrations;

class Create_sponsors
{
	public function up()
	{
		\DBUtil::create_table('sponsors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'sponsor' => array('constraint' => 100, 'type' => 'varchar'),
			'contact_info1' => array('constraint' => 150, 'type' => 'varchar'),
			'contact_info2' => array('constraint' => 150, 'type' => 'varchar'),
			'joined_date' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('sponsors');
	}
}