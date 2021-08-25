<?php

namespace Fuel\Migrations;

class Add_dating_package_id_to_datingpackageinvitations
{
	public function up()
	{
		\DBUtil::add_fields('datingpackageinvitations', array(
			'dating_package_id' => array('constraint' => 11, 'type' => 'int'),

		));
	}

	public function down()
	{
		\DBUtil::drop_fields('datingpackageinvitations', array(
			'dating_package_id'

		));
	}
}