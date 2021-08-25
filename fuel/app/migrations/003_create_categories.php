<?php

namespace Fuel\Migrations;

class Create_categories
{
	public function up()
	{
		\DBUtil::create_table('categories', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 255, 'type' => 'varchar'),
			'description' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id'));
		
		$cats = array("Hip Hop Artist", "Elite Model");
		
		foreach ($cats as $cat){
			\Model_Category::forge(array("name" => $cat, "description" => $cat))->save();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('categories');
	}
}