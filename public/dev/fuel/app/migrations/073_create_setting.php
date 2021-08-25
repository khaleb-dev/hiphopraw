<?php

namespace Fuel\Migrations;

class Create_setting
{
	public function up()
	{
		\DBUtil::create_table('setting', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'private_profile' => array('type' => 'tinyint'),
			'data_sharing' => array('type' => 'tinyint'),
			'where_we_all_meet' => array('type' => 'tinyint'),
			'hello_notification' => array('constraint' => 20, 'type' => 'varchar'),
			'message_notification' => array('constraint' => 20, 'type' => 'varchar'),
			'top_matches' => array('constraint' => 20, 'type' => 'varchar'),
			'special_offers' => array('constraint' => 20, 'type' => 'varchar'),
			'send_me_email_notifcation' => array('type' => 'tinyint'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('setting');
	}
}