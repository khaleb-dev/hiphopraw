<?php

namespace Fuel\Migrations;

class Add_fields_to_profile
{
    public function up() {
        \DBUtil::add_fields('profiles', array(
            'my_caption' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'birth_date' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'city' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'state' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'zip' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'picture' => array('constraint' => 100, 'type' => 'varchar', 'null' => true),
            'is_activated' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),
            'is_completed' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),
            'is_blocked' => array('constraint' => 1, 'type' => 'tinyint', 'default' => 0),
            'activation_code' => array('constraint' => 50, 'type' => 'varchar'),
            'height' => array('constraint' => 50, 'type' => 'varchar', 'null' => true),
            'body_type_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'ethnicity_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'eye_color_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'hair_color_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'member_type_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
        ));
    }

    public function down() {
        \DBUtil::drop_fields('profiles', array(
            'my_caption',
            'birth_date',
            'city',
            'state',
            'zip',
            'picture',
            'is_activated',
            'is_completed',
            'is_blocked',
            'activation_code',
            'height',
            'body_type_id',
            'ethnicity_id',
            'eye_color_id',
            'hair_color_id',
            'member_type_id',
        ));
    }
}