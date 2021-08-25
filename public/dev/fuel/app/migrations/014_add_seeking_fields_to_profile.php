<?php

namespace Fuel\Migrations;

class Add_seeking_fields_to_profile
{
    public function up() {
        \DBUtil::add_fields('profiles', array(
            'occupation_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'relationship_status_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'have_kids' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'want_kids' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'religion_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'smoke_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'drink_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'about_me' => array('type' => 'text', 'null' => true),
            'things_looking_for' => array('type' => 'text', 'null' => true),
            'first_thing_noticable' => array('type' => 'text', 'null' => true),
            'interest' => array('type' => 'text', 'null' => true),
            'friends_describe_me' => array('type' => 'text', 'null' => true),
            'for_fun' => array('type' => 'text', 'null' => true),
            'favorite_things' => array('type' => 'text', 'null' => true),
            'last_book_read' => array('type' => 'text', 'null' => true),
            'ages_from' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'ages_to' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_location' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'seeking_occupation_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_relationship_status_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_have_kids' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'seeking_want_kids' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'seeking_body_type_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_ethnicity_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_height' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'seeking_eye_color_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_hair_color_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_religion_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_smoke_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'seeking_drink_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
        ));
    }

    public function down() {
        \DBUtil::drop_fields('profiles', array(
            'occupation_id',
            'relationship_status_id',
            'have_kids',
            'want_kids',
            'religion_id',
            'smoke_id',
            'drink_id',
            'about_me',
            'things_looking_for',
            'first_thing_noticable',
            'interest',
            'friends_describe_me',
            'for_fun',
            'favorite_things',
            'last_book_read',
            'ages_from',
            'ages_to',
            'seeking_location',
            'seeking_occupation_id',
            'seeking_relationship_status_id',
            'seeking_have_kids',
            'seeking_want_kids',
            'seeking_body_type_id',
            'seeking_ethnicity_id',
            'seeking_height',
            'seeking_eye_color_id',
            'seeking_hair_color_id',
            'seeking_religion_id',
            'seeking_smoke_id',
            'seeking_drink_id',
        ));
    }
}