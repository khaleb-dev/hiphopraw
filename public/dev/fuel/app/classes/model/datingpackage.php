<?php
use Orm\Model;
class Model_Datingpackage extends Model {

    protected static $_properties = array(
        'id',
        'title',
        'event_date',
        'time_from',
        'time_to',
        'event_venue',
        'short_description',
        'long_description',
        'picture',
        'is_featured',  
        'price',
        'state',
        'city',
        'zip_code',
    	'price',
    	'zip_code',
        'is_featured',    	
        'created_at',
        'updated_at',
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_Slug',
    );
    
    protected static $_table_name = 'events';
    
    
    public static $thumbnails = array(
        "datingpackage_list" => array("width" => 263, "height" => 171),
        "datingpackage_detail" => array("width" => 370, "height" => 240),
        "datingpackage_featured" => array("width" => 111, "height" => 89),
        "datingpackage_rsvp" => array("width" => 157, "height" => 126),
    );
    
    
    public static function validate($factory) {
        $val = Validation::forge($factory);
        $val->add('title', 'Title')->add_rule('required');
        $val->add('event_date', 'Event Date')->add_rule('required');
        $val->add('time_from', 'Start Time')->add_rule('required');
        $val->add('time_to', 'End Time')->add_rule('required');
        $val->add('event_venue', 'event venue')->add_rule('required');
        $val->add('long_description', 'Long Description')->add_rule('required');
        $val->add('short_description', 'Short Description')->add_rule('required');

        return $val;
    }
    
    
    //this method returns all the dating packages that are not yet expired
    public static function get_active_dating_packages() {
        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where is_featured='0' " .
                                        " and event_end_date >= curdate()")->execute();

        if (count($result) > 0)
            return $result;
        else
            return false;
    }

    
    
    //this mehtod returns all the ding packages that are not expried and which are featured
    public static function get_featured_dating_packages() {
        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where is_featured='1' "
                        . "and event_end_date >= curdate()")->execute();

        if (isset($result) && count($result) > 0)
            return $result;
        else
            return false;
    }

    
    
    public static function get_random_featured_dating_packages($limit = 9999) {

        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where is_featured='1' "
                        . "and event_end_date >= curdate()")->execute();
        $max = count($result);
        //call to a  random number generator
        $arr = Model_Datingpackage::generate_random_index($max, $limit);
        $random_result = array();
        foreach ($arr as $selected) {
            $random_result[] = $result[$selected];
        }
        if (count($random_result) > 0) {
            return $random_result;
        } else {
            return false;
        }
    }

    
    
    // gets all the dating packages
    public static function get_dating_package($id) {
        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where id=" . $id)->execute();
        if (count($result) > 0)
            return $result;
        else
            return false;
    }
 // gets all the dating packages that are active and randomly
    public static function get_random_active_dating_packages($limit = 8) {
             
        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where is_featured='0' " .
                                        " and event_end_date >= curdate()"    . "")->execute();
        $max = count($result);
        $arr = array();
        //call to a  random number generator
        $arr = Model_Datingpackage::generate_random_index($max, $limit);
        //gets the random dating packages using the random indexes generated 
        $random_result = array();
        foreach ($arr as $selected) {
            $random_result[] = $result[$selected];
        }
        if (count($random_result) > 0) {
            return $random_result;
        } else {
            return false;
        }
    }

    
    
    
    // gets all the dating packages that are active and randomly by location
    public static function get_random_active_dating_packages_by_state($limit = 9999, $uid) {
        //using the current user id ($uid) get the state from the profiles table. if the state is null return false othwise 
        //search the dating package by including the state
        $state=  Model_Datingpackage::get_user_state($uid);
        if($state==null)
            return false;
        $result = \Fuel\Core\DB::query("SELECT  * from datepackages where state like '%" . $state . "%'  and event_end_date >= curdate()")->execute();
        $max = count($result);
        $arr = array();
        //call to a  random number generator
        $arr = Model_Datingpackage::generate_random_index($max, $limit);
        //gets the random dating packages using the random indexes generated 
        $random_result = array();
        foreach ($arr as $selected) {
            $random_result[] = $result[$selected];
        }
        if (count($random_result) > 0) {
            return $random_result;
        } else {
            return false;
        }
    }

    
    
    public static function get_dating_packages_by_destination($search_destination = null) {
        $result = \Fuel\Core\DB::query("SELECT * from datepackages where"
                        . " (event_venue like '%" . $search_destination . "%' or city like '%" . $search_destination . "%' or state like '%" . $search_destination . "%')".  " and (event_end_date >= curdate())")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
     public static function get_dating_packages_by_destination_and_date($search_destination = null, $start_date = null, $end_date = null) {
        $result = \Fuel\Core\DB::query("SELECT * from datepackages where"
                       . " (event_venue like '%" . $search_destination . "%' or city like '%" . $search_destination . "%' or state like '%" . $search_destination . "%')".  " and "
                        . "(event_end_date >= '" . $start_date . "') and (event_end_date <='" . $end_date."')")->execute();
       
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public static function get_distinct_package_destinations() {
        $result = \Fuel\Core\DB::query("SELECT distinct state from datepackages where "
                . "event_end_date >= curdate() ")->execute();
       
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    
       
    public static function get_dating_packages_picture($pid = null) {
        if (isset($pid)) {
            $result = \Fuel\Core\DB::query("SELECT picture FROM datepackages WHERE id=" . $pid)->execute();
            header("Content-type:image/jpg;base64");
            echo $result['picture'];
        }
    }

    
    
    public static function send_invitation($invite) {
        //this model receives the details of invitation from the controller and saves the data
        $from_member_id = $invite['from_member_id'];
        $to_member_id = $invite['to_member_id'];
        $dating_package_id = $invite['dating_package_id'];
        $checkin_time=$invite['checkin_time'];
        $checkin_date=$invite['checkin_date'];
        $result = \Fuel\Core\DB::query("insert into datingpackageinvitations(from_member_id, to_member_id,"
                        . "dating_package_id,date_invited,status,checkin_date,checkin_time, booking_status,created_at) "
                        . "values($from_member_id , $to_member_id, $dating_package_id, now(), 'None','$checkin_date','$checkin_time','Pending', now())")->execute();
        return $result;
    }

    
    
    public static function get_invitation($userid) {
        //this model receives the details of invitation from the controller and saves the data
        $result = \Fuel\Core\DB::query("Select dp.*,dpi.from_member_id,dpi.id as invitation_id from datepackages dp inner join datingpackageinvitations dpi "
                        . "on dp.id=dpi.dating_package_id where dpi.to_member_id= $userid and dpi.status='none'LIMIT 1 ")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    
        public static function get_pendingInvitations($userid) {
        //this model receives the details of invitation from the controller and saves the data
        $result = \Fuel\Core\DB::query("Select dp.*,dpi.from_member_id,dpi.status,dpi.to_member_id,dpi.id as invitation_id from datepackages dp inner join datingpackageinvitations dpi "
                        . "on dp.id=dpi.dating_package_id where dpi.from_member_id= $userid and dpi.booking_status='Pending' and dp.event_end_date>=curdate()LIMIT 1 ")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    
    
    public static function set_reply_for_invitation($invitation_id, $reply) {
        $result = \Fuel\Core\DB::query("update datingpackageinvitations set status='" . $reply . "' where id='" . $invitation_id . "'")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    
        public static function set_cancel_booking($invitation_id, $reply) {
        $result = \Fuel\Core\DB::query("update datingpackageinvitations set booking_status='" . $reply . "' where id='" . $invitation_id . "'")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    
    
    public static function send_reference($refer) {
        //this model receives the details of invitation from the controller and saves the data
        $from_member_id = $refer['from_member_id'];
        $to_member_id = $refer['to_member_id'];
        $dating_package_id = $refer['dating_package_id'];
        //$status=$invite['status'];
        $result = \Fuel\Core\DB::query("insert into datingpackagereferences(from_member_id, to_member_id, "
                        . "dating_package_id,date_referred) "
                        . "values($from_member_id , $to_member_id, $dating_package_id, now())")->execute();
        return $result;
    }
    
    

    public static function get_user_name($uid) {
        $result = \Fuel\Core\DB::query("SELECT user_id, first_name, last_name from profiles where"
                        . " id=$uid")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

        public static function get_user_state($uid) {
        $result = \Fuel\Core\DB::query("SELECT state from profiles where"
                        . " id=$uid")->execute();
        if (count($result) > 0) {
            return $result[0]['state'];
        }
        return false;
    }
    
    public static function get_friend_list() {
        $id = \Auth\Auth::get('id');
        $result = \Fuel\Core\DB::query("SELECT user_id, first_name, last_name from profiles where"
                        . " user_id in (select receiver_id from friendships where status='accepted' and sender_id=" . $id . ")")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    
    
    public static function create_dating_package($datingpackage) {
        if (isset($datingpackage['picture'])) {
            $result = \Fuel\Core\DB::query("insert into datepackages(title, event_date, time_from, time_to,state,city, event_venue,"
                            . "short_description,long_description, picture, is_featured, price, zip_code) "
                            . "values('" . $datingpackage['title'] . "','" . $datingpackage['event_date'] . "','" . $datingpackage['time_from'] . "','"
                            . $datingpackage['time_to'] . "','" . $datingpackage['state'] . "','" . $datingpackage['city'] . "','" . $datingpackage['event_venue'] . "','" . $datingpackage['short_description'] . "','"
                            . $datingpackage['long_description'] . "',TO_BASE64('" . $datingpackage['picture'] . "'),'" . $datingpackage['is_featured'] . "','" . $datingpackage['price'] . "','" . $datingpackage['zip_code'] . "')")->execute();
        } else {
            $result = \Fuel\Core\DB::query("insert into datepackages(title, event_date, time_from, time_to,state,city, event_venue,"
                            . "short_description,long_description, picture, is_featured, price, zip_code) "
                            . "values('" . $datingpackage['title'] . "','" . $datingpackage['event_date'] . "','" . $datingpackage['time_from'] . "','"
                            . $datingpackage['time_to'] . "','" . $datingpackage['state'] . "','" . $datingpackage['city'] . "','" . $datingpackage['event_venue'] . "','" . $datingpackage['short_description'] . "','"
                            . $datingpackage['long_description'] . "'," .  $datingpackage['is_featured'] . "','" . $datingpackage['price'] . "','" . $datingpackage['zip_code'] . "')")->execute();
        }
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    
    
    public static function generate_random_index($max, $limit) {
        //Check whether the database contains enough active dating packages
        //if the record is less than the requested limit we generate only the available ones else generate upto the limit
        $arr = array();
        if ($max < $limit) {
            $randbound = $max - 1;
            while (count($arr) < $max) {
                $x = mt_rand(0, $randbound);
                if (!in_array($x, $arr)) {
                    $arr[] = $x;
                }
            }
        } else {
            $randbound = $max - 1;
            while (count($arr) < $limit) {
                $x = mt_rand(0, $randbound);
                if (!in_array($x, $arr)) {
                    $arr[] = $x;
                }
            }
        }
        return $arr;
    }

}


