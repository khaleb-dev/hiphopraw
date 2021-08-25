<?php

namespace Fuel\Migrations;

class Create_Billings
{
	public function up()
	{
		\DBUtil::create_table('billings', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'country_id' => array('constraint' => 11, 'type' => 'int'),
			'state' => array('constraint' => 100, 'type' => 'varchar'),
			'city' => array('constraint' => 150, 'type' => 'varchar'),
			'postal_code' => array('constraint' => 50, 'type' => 'varchar'),
			'street_address' => array('type' => 'text'),
			'phone_number' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('billings');
	}
}