<?php

namespace Fuel\Migrations;

class Insert_to_body_type_and_ethnicity
{
    public function up()
    {
        \Model_Bodytype::forge(array("name" => "Curvy"))->save();
        \Model_Bodytype::forge(array("name" => "Above Average"))->save();
        \Model_Ethnicity::forge(array("name" => "White/Caucasian"))->save();
        \Model_Ethnicity::forge(array("name" => "Latino/Hispanic"))->save();
        \Model_Ethnicity::forge(array("name" => "Middle Eastern"))->save();

    }

    public function down()
    {
    }
}