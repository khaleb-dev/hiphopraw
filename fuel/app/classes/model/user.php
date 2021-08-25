<?php

class Model_User extends Auth\Model\Auth_User {

    const PROFILE_COMMENTS_LIMIT = 5;
    const PROFILE_VIDEOKES_LIMIT = 8;
    const PROFILE_FRIENDS_LIMIT = 12;

    /**
     * @var array   has_many relationships
     */
    protected static $_has_many = array(
        'metadata' => array(
            'model_to' => 'Model\\Auth_Metadata',
            'key_from' => 'id',
            'key_to' => 'parent_id',
            'cascade_delete' => true,
        ),
        'userpermission' => array(
            'model_to' => 'Model\\Auth_Userpermission',
            'key_from' => 'id',
            'key_to' => 'user_id',
            'cascade_delete' => false,
        ),
        'invites' => array(
            'model_to' => 'Model_Invite',
            'key_from' => 'id',
            'key_to' => 'sender_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'videokes' => array(
            'model_to' => 'Model_Videoke',
            'key_from' => 'id',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'comments' => array(
            'model_to' => 'Model_Comment',
            'key_from' => 'id',
            'key_to' => 'user_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'messages_received' => array(
            'model_to' => 'Model_Message',
            'key_from' => 'id',
            'key_to' => 'to_user_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'messages_sent' => array(
            'model_to' => 'Model_Message',
            'key_from' => 'id',
            'key_to' => 'from_user_id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
        'friendships_sent' => array(
            'model_to' => 'Model_Friendship',
            'key_from' => 'id',
            'key_to' => 'sender_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
        'friendships_received' => array(
            'model_to' => 'Model_Friendship',
            'key_from' => 'id',
            'key_to' => 'receiver_id',
            'cascade_save' => true,
            'cascade_delete' => true,
        ),
    );

    /**
     * @var array   many_many relationships
     */
    protected static $_many_many = array(
        'roles' => array(
            'key_from' => 'id',
            'model_to' => 'Model\\Auth_Role',
            'key_to' => 'id',
            'table_through' => null,
            'key_through_from' => 'user_id',
            'key_through_to' => 'role_id',
        ),
        'permissions' => array(
            'key_from' => 'id',
            'model_to' => 'Model\\Auth_Permission',
            'key_to' => 'id',
            'table_through' => null,
            'key_through_from' => 'user_id',
            'key_through_to' => 'perms_id',
        )
    );
    public static $thumbnails = array(
        "profile" => array("width" => 300, "height" => 300),
        "home_page" => array("width" => 159, "height" => 141),
        "winners" => array("width" => 144, "height" => 87),
        "message" => array("width" => 63, "height" => 59),
        "latest_winners" => array("width" => 128, "height" => 111),
        "genre" => array("width" => 148, "height" => 87),
        "video" => array("width" => 151, "height" => 89),
    );

    public static function clean_name($name) {
        return preg_replace("/[^A-Za-z0-9]/", "", $name);
    }

    public static function get_picture($user, $type) {
        if (isset($user->profile_picture) && $user->profile_picture != "") {
            return Uri::create("uploads" . "/" . Model_User::clean_name($user->username) . "/" . $type . "_" . $user->profile_picture);
        } else {
            return Uri::create("assets/img/defaults/" . $type . "_profile_picture.jpg");
        }
    }

    public function friends() {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
                ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->get() : array();
    }

    public function friendsalpha($alpha=null) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
                ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->where('username', 'like', $alpha . '%')
                ->get() : array();
    }


    public function followers() {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM followers WHERE (followed_id = $this->id)")
                ->as_object('Model_Follower')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->followed_id) {
                array_push($friend_ids, $friendship->follower_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->get() : array();
    }

    public function following() {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM followers WHERE (follower_id = $this->id)")
                ->as_object('Model_Follower')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->follower_id) {
                array_push($friend_ids, $friendship->followed_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->get() : array();
    }

    public static function mutual_friends($first_user, $second_user) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $first_user->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $first_user->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
                ->as_object('Model_Friendship')->execute();
        $friendshipsss = DB::query("SELECT * FROM friendships WHERE (sender_id = $second_user->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $second_user->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
                ->as_object('Model_Friendship')->execute();




        foreach ($friendships as $friendship) {
            foreach ($friendshipsss as $friendshipss) {
                if ($friendship->sender_id == $friendshipss->sender_id) {
                    array_push($friend_ids, $friendship->sender_id);
                }
                if ($friendship->receiver_id == $friendshipss->sender_id) {
                    array_push($friend_ids, $friendshipss->sender_id);
                }
                if ($friendship->sender_id == $friendshipss->receiver_id) {
                    array_push($friend_ids, $friendship->sender_id);
                }
                if ($friendship->receiver_id == $friendshipss->receiver_id) {
                    array_push($friend_ids, $friendshipss->receiver_id);
                }
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->get() : array();
    }

    public function friends_paged($limit, $offset) {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR (receiver_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "')")
                ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()
                ->where("id", "IN", $friend_ids)
                ->limit($limit)
                ->offset($offset)
                ->get() : array();
    }

    public function new_friends() {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE receiver_id = $this->id AND status = '" . Model_Friendship::STATUS_SENT . "' ")
                ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()->where("id", "IN", $friend_ids)->get() : array();
    }
    public function new_messages() {
        $message_ids = array();

        $messages = DB::query("SELECT * FROM messages WHERE to_user_id = $this->id AND read_status = 'unread' AND status ='sent' ")
                ->as_object('Model_Message')->execute();


        foreach ($messages as $message) {
            if ($this->id == $message->to_user_id) {
                array_push($message_ids, $message->id);
            }
        }
        
        return $message_ids;
    }

    public function all_friends() {
        $friend_ids = array();

        $friendships = DB::query("SELECT * FROM friendships WHERE (sender_id = $this->id AND status = '" . Model_Friendship::STATUS_ACCEPTED . "') OR ( receiver_id = $this->id AND status IN ('" . Model_Friendship::STATUS_ACCEPTED . "', '" . Model_Friendship::STATUS_SENT . "'))")
                ->as_object('Model_Friendship')->execute();

        foreach ($friendships as $friendship) {
            if ($this->id == $friendship->sender_id) {
                array_push($friend_ids, $friendship->receiver_id);
            } else {
                array_push($friend_ids, $friendship->sender_id);
            }
        }

        return count($friend_ids) > 0 ? Model_User::query()->where("id", "IN", $friend_ids)->get() : array();
    }

    public function about_me() {
        $about_me = $this->about_you;

        if (strlen($about_me) > 50) {
            $words = explode(" ", $about_me);
            return implode(" ", array_slice($words, 0, count($words) / 2)) . " <span id='more'>" . implode(" ", array_slice($words, count($words) / 2, count($words) / 2)) . "</span>";
        }

        return $about_me;
    }

    public function category() {
        if (isset($this->category_id)) {
            return Model_Category::find($this->category_id)->name;
        }
        return "";
    }

    public function friends_count() {
        return count($this->friends());
    }

    public function pending_friends_count() {
        return count($this->new_friends());
    }

    public function comments_count() {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        $result = DB::query("select id from videokes where user_id = $this->id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');
        return $result->count() > 0 ? Model_Comment::query()
                ->where("videoke_id", "IN", $vids)
                ->count() : 0;
    }
    public function new_comments_count() {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        $result = DB::query("select id from videokes where user_id = $this->id")->as_assoc()->execute();
        $vids = $result->as_array('id', 'id');
        if($result->count() > 0) {

            $comments = Model_Comment::query()->where("videoke_id", "IN", $vids)->where("parent_comment_id", "=", 0)->where("is_deleted", "=", 0)->limit(5);
            
          

        return $comments
                ->order_by('created_at', 'desc')
                ->limit(Model_User::PROFILE_COMMENTS_LIMIT)
                ->get();
        }
        else {
            return 0;
        }
    }

    public function messages_count() {
        return Model_Message::query()->where("to_user_id", $this->id)->where(array("status" => Model_Message::SENT, "read_status" => Model_Message::UNREAD))->count();
    }

    public function videokes_count() {
        return Model_Videoke::query()->where("user_id", $this->id)->where('is_blocked', 0)->count();
    }

}
