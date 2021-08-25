<?php

namespace Fuel\Migrations;

class Eva_add_birthday_gender_and_mobile_to_users_metadata
{
	public function up()
	{
		foreach(\Auth\Model\Auth_User::find("all") as $user){
			\Auth::update_user(array(
				"birthday" => \Date::forge(),
				"gender_id" => 1,
				"mobile" => "(555) 555 5555",
			),$user->username);
		}
	}

	public function down()
	{
		$metadata = \Auth\Model\Auth_Metadata::query()->where('key', 'birthday')->or_where('key', 'gender_id')->or_where('key', 'mobile')->get();
		
		foreach($metadata as $meta){
			$meta->delete();
		}
	}
}