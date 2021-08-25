<?php

namespace Fuel\Migrations;

class Add_record_to_seeking_fields
{
    public function up()
    {
        \Model_Bodytype::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Ethnicity::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Eyecolor::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Haircolor::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Occupation::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Relationshipstatus::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Religion::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Smoke::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Drink::forge(array("name" => "Doesn't Matter"))->save();
        \Model_Gender::forge(array("name" => "Doesn't Matter"))->save();
    }

    public function down()
    {
    }
}