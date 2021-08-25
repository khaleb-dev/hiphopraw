<?php

class Model_Event extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'long_description',
        'short_description',
        'url',
        'organizers_details',
		'venue',
		'start_date',
		'start_time',
        'end_time',
        'is_featured',
		'photo',
		'state',
		'city',
		'time_zone',
		'zip',
		'event_end_date',
		'start_pm_am',
		'end_pm_am',
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
        "event_list" => array("width" => 302, "height" => 225),
        "event_detail" => array("width" => 466, "height" => 344),
        "event_featured" => array("width" => 301, "height" => 231),
        "event_rsvp" => array("width" => 157, "height" => 126),
        "event_cover" => array("width" => 746, "height" => 360),
    );

    public static function get_active_events_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
        FROM events WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND event_end_date >= CURDATE()
        ORDER BY start_date ASC, start_time DESC")->execute();

        if(count($result) > 0)
            return $result;

        return false;
    }

    public static function get_past_events_by_region($state, $city)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
        FROM events WHERE state='".$state."' AND
        city LIKE '%".$city."%'
        AND event_end_date < CURDATE()
        ORDER BY start_date DESC, start_time DESC")->execute();

        if(count($result) > 0)
            return $result;

        return false;
    }

    public static function get_slug($event_id)
    {
        $event = Model_Event::find($event_id);
        if($event){
            return $event->slug;
        }

        return false;
    }


    public static function get_title($event_id)
    {
        $event = Model_Event::find($event_id);
        if($event){
            return $event->title;
        }

        return false;
    }

    public static function get_start_date($event_id)
    {
        $result = \Fuel\Core\DB::query("SELECT DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date
         FROM events WHERE id=$event_id")->execute();

        if(count($result) === 1)
            return $result[0];

        return false;
    }

    public static function find_by_slug($event_slug)
    {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
        FROM events WHERE slug='".$event_slug."'")->execute();

        if(count($result) === 1)
            return $result[0];

        return false;
    }

    public static function get_featured_events($limit = 4)
    {
        $events = \Fuel\Core\DB::query("SELECT id, title, slug, long_description,short_description, url, venue,
        DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
        state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at FROM events
        WHERE is_featured = 1 LIMIT ".$limit)->execute();
        if(count($events) > 0)
            return $events;

        return false;
    }

    public static function get_events_by_member_rsvp($user_id)
    {
        $rsvpied_events = \Fuel\Core\DB::query("SELECT * FROM rsvps WHERE member_id = $user_id")->execute();

        $count = count($rsvpied_events);
        $counter = 0;
        $where = ' WHERE ';

        foreach($rsvpied_events as $event){
            $where .= 'id = '.$event['event_id'];
            if($count !== ($counter + 1)){
                $where .= ' OR ';
            }
            ++$counter;
        }

        if(' WHERE ' !== $where){
            $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at
            FROM events".$where."
            ORDER BY start_date ASC, start_time DESC")->execute();

            if(count($result) > 0)
                return $result;
        }

        return false;
    }

    public static function get_distinct_event_states() {
        $result = \Fuel\Core\DB::query("SELECT distinct state from events where "
            . "event_end_date >= curdate()")->execute();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

    public static function get_events_by_location($location = null) {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at from events where"
            . " (venue like '%" . $location . "%' or city like '%" . $location . "%' or state like '%" . $location . "%')".  " and (event_end_date >= curdate())")->execute();
        if (count($result) > 0) {
            return $result;
        }
        return false;
    }
    public static function get_events_by_location_and_date($location = null, $start_date = null, $end_date = null) {
        $result = \Fuel\Core\DB::query("SELECT id, title, slug, long_description, short_description, url,venue,
            DATE_FORMAT(start_date,'%W, %M %d, %Y ') AS start_date, TIME_FORMAT(start_time, '%h:%i %p') AS start_time, photo,
            state, city, TIME_FORMAT(end_time, '%h:%i %p') AS end_time, created_at, updated_at from events where"
            . " (venue like '%" . $location . "%' or city like '%" . $location . "%' or state like '%" . $location . "%')".  " and "
            . "(event_end_date >= '" . $start_date . "') and (event_end_date <='" . $end_date."')")->execute();

        if (count($result) > 0) {
            return $result;
        }
        return false;
    }

}
