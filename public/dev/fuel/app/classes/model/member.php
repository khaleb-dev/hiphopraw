<?php

class Model_Member extends \Orm\Model
{
    public static function get_validation(\Validation $val)
    {
        $val->add_callable('\Model_Member');
        $val->add_field('first_name', 'First Name', 'required|min_length[2]|max_length[45]');
        $val->add_field('last_name', 'Last Name', 'required|min_length[2]|max_length[45]');
        $val->add_field('username', 'Username', 'required|min_length[3]|max_length[45]');
        $val->add_field('password', 'Password', 'required|min_length[6]|max_length[100]');
        $val->add_field('email', 'Email Address', 'required|valid_email|min_length[5]|max_length[45]');
        $val->add_field('my_caption', 'My Caption', 'required|min_length[2]|max_length[45]');
            
        return $val;
    }
    
    public static function _validation_unique_username($username, Model_Member $user)
    {
        if ( ! $user->is_new() and $user->username === $username)
        {
            return true;
        }

        $exists = DB::select(DB::expr('COUNT(*) as total_count'))->from($user->table())
                ->where('username', '=', $username)->execute()->get('total_count');

        return (bool) !$exists;
    }

    public static function _validation_unique_email($email, Model_Member $user)
    {
        if ( ! $user->is_new() and $user->email === $email)
        {
            return true;
        }

        $exists = DB::select(DB::expr('COUNT(*) as total_count'))->from($user->table())->where('email', '=', $email)
                ->execute()->get('total_count');

        return (bool) !$exists;
    }
    
    public static function get_enum_values($field) {
        $column = DB::list_columns('members', $field);
        $options = array_values($column[$field]['options']);
        return $options;
    }
}
