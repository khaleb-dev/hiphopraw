<?php

namespace Fuel\Migrations;

class Add_profile_id_to_billings
{
	public function up()
	{
		\DBUtil::add_fields('billings', array(
			'profile_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('billings', array(
			'profile_id'

		));
	}
}