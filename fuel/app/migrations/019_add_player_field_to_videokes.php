<?php

namespace Fuel\Migrations;

class Add_player_field_to_videokes
{
	public function up()
	{
		\DBUtil::add_fields('videokes', array(
			'player' => array('constraint' => "'html5','flowplayer'", 'type' => 'enum', 'default' => 'html5'),
			
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('videokes', array(
			'player'
		));
	}
}