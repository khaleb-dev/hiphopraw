<?php

class Model_Friend extends \Orm\Model {

    public static function get_pending_friends($member_id) {
        $pending_requests = Model_Friend::find('all', array(
                    'where' => array(
                        array('status', 'pending'),
                        array('to_member_id', $member_id),
                    ),
                ));
        $pending_friends = array();
        foreach ($pending_requests as $pending_request) {
            $objMember = Model_Member::find($pending_request->from_member_id);
            if ($objMember) {
                $row = array(
                    'friend_id' => $pending_request->id,
                    'member_id' => $objMember->id,
                    'gender' => $objMember->gender,
                    'username' => $objMember->username,
                    'my_caption' => $objMember->my_caption,
                    'avatar' => $objMember->avatar,
                    'date_accepted' => $pending_request->date_accepted,
                    'is_logged_in' => $objMember->is_logged_in
                );
                array_push($pending_friends, $row);
            }
        }
        return $pending_friends;
    }

    public static function get_friends($member_id) {
        $friends = DB::select('*')
                ->from('friends')
                ->where('from_member_id', $member_id)
                ->or_where('to_member_id', $member_id)
                ->where('status', 'accepted')
                ->as_object()->execute();
        $friends_list = array();
        foreach ($friends as $friend) {
            if ($friend->from_member_id == $member_id) {
                $objMember = Model_Member::find('first', array(
                            'where' => array(
                                array('is_suspended', 'false'),
                                array('id', $friend->to_member_id),
                            ),
                        ));
            } else {
                $objMember = Model_Member::find('first', array(
                            'where' => array(
                                array('is_suspended', 'false'),
                                array('id', $friend->from_member_id),
                            ),
                        ));
            }
            if ($objMember) {
                $row = array(
                    'friend_id' => $friend->id,
                    'member_id' => $objMember->id,
                    'gender' => $objMember->gender,
                    'username' => $objMember->username,
                    'my_caption' => $objMember->my_caption,
                    'avatar' => $objMember->avatar,
                    'date_accepted' => $friend->date_accepted,
                    'is_logged_in' => $objMember->is_logged_in
                );
                array_push($friends_list, $row);
            }
        }
        return $friends_list;
    }

}
