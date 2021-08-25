<?php

namespace Fuel\Migrations;

class Add_category_id_to_videokes
{
	public function up()
	{
		\DBUtil::add_fields('videokes', array(
			'category_id' => array('constraint' => 11, 'type' => 'int'),
		));
		
//		$cate = \Model_Category::find("first");
//
//		$vis = \Model_Videoke::find("all");
//
//		foreach ($vis as $vi){
//			$vi->category_id = $cate->id;
//			$vi->save();
//		}
	}

	public function down()
	{
		\DBUtil::drop_fields('videokes', array(
			'category_id'
		));
	}
}