<?php

class Model_ReceivedMessage extends \Orm\Model {
    
    public static function get_validation(\Validation $val) {
        $val->add_callable('Model_ReceivedMessage');
        $val->add_field('to_member_id', 'to_member_id', 'required');
        $val->add_field('from_member_id', 'from_member_id', 'required');
        $val->add_field('subject', 'subject', 'required|min_length[3]|max_length[250]');
        return $val;
    }

}