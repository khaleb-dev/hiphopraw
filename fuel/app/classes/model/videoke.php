
<?php

class Model_Videoke extends \Orm\Model {

    const THUMB_CONTENT = "151x89";
    const THUMB_HOME = "172x114";
    const THUMB_SIDEBAR = "124x72";
    const THUMB_HOME_PLAYER = "285x200";
    const THUMB_ADMIN_VIDEO = "235x139";

    
   
 
    static $THUMB_PART1 = array( "size"=>Model_Videoke::THUMB_HOME, "duration"=>"00:00:01");
    static $THUMB_PART2 = array( "size"=>Model_Videoke::THUMB_HOME, "duration"=>"00:00:30");
    static $THUMB_PART3 = array( "size"=>Model_Videoke::THUMB_HOME, "duration"=>"00:00:55");
    static $THUMB_PART4 = array( "size"=>Model_Videoke::THUMB_HOME, "duration"=>"00:01:00");



    protected static $_has_many = array(
        'ratings' => array(
            'model_to' => 'Model_Rating',
            'key_from' => 'id',
            'key_to' => 'videoke_id',
            'cascade_delete' => true
        )  
    );

    protected static $_properties = array(
        'id',
        'user_id',
        'category_id',
        'title',
        'description',
        'key_words',
        'video',
        'youtube_link',
        'thumb_name',
        'views',
        'likes',
        'dislikes',
        'created_at',
        'updated_at',
        'is_blocked',
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
    );
    protected static $_table_name = 'videokes';
    protected static $_belongs_to = array(
        'user' => array(
            'key_from' => 'user_id',
            'key_to' => 'id'
        ),
        'category' => array(
            'key_from' => 'category_id',
            'key_to' => 'id'
    ));

    public function getByID($id){
    	 
    	try{
    		$output = DB::query("SELECT * FROM videokes WHERE id='".intval($id)."'")->execute()->as_array();
    
    		return $output[0];
    
    	}catch(Exception $err){
    		return null;
    	}
    }
    
    public function getVideokes($user_id=0, $category_id=0){
    
    	try{
    		$output = DB::query("SELECT * FROM videokes WHERE 1".
        						(($user_id > 0)?" AND user_id='".intval($user_id)."' ":"").
        						(($category_id > 0)?" AND category_id='".".intval($user_id)."."' ":"")
        				)->execute()->as_array();
    
    		return $output;
    
    	}catch(Exception $err){
    		return null;
    	}
    
    
    }
    
    
    /**
     * DISABLING WEBM AND OGG FORMATS, BECAUSE mp4 PLAYS ON ALL SUPPORTED DEVICES
     * @return multitype:multitype:string
     */
    public static function get_formats() {
        return array(
            "webm" => array("extension" => '.webm', "type" => 'video/webm'),
            "mp4" => array("extension" => '.mp4', "type" => 'video/mp4'),            
            "ogg" => array("extension" => '.ogg', "type" => 'video/ogg'),
        );
    }

    public static function get_thumbnail_sizes() {
        return array("151x89", "172x114", "124x72", "235x139");
    }
    public static function generate_thumbnails_of_four_size() {
        /* you can differ the sizes later */
        return array(Model_Videoke::$THUMB_PART1, Model_Videoke::$THUMB_PART2, Model_Videoke::$THUMB_PART3,Model_Videoke::$THUMB_PART4);
    }

    public static function get_html5_video_formats(){
        return array(".mp4", ".webm", ".ogg" );
    }

    public function get_video($format) {
        return Uri::create("uploads" . DS . Model_User::clean_name($this->user->username) . DS . "videokes" . DS . $this->video.".mp4");
    }

    public function get_picture($user, $size) {
        $file = DOCROOT . "uploads/" . Model_User::clean_name($user->username) . DS . "videokes" . DS . "thumb_" . $size . "_" . $this->video . ".jpg";
        if (file_exists($file)) {
            return Uri::create("uploads" . "/" . Model_User::clean_name($user->username) . "/" . "videokes" . "/" . "thumb_" . $size . "_" . $this->video . ".jpg");
        } else {
            return Uri::create("assets/img/defaults/" . "thumb_" . $size . "_video_picture.jpg");
        }
    }
    public function get_youtube_picture($user, $video_name) {
        return Uri::create("https://img.youtube.com/vi/" . $video_name . "/0.jpg");
    }

    public function get_picture_thumb($username, $number) {
        $file = DOCROOT . "uploads/" . $username . DS . "videokes" . DS . "thumb_" . $number . "_" . $this->video . ".jpg";
        if (file_exists($file)) {
            return Uri::create("uploads" . DS . Model_User::clean_name($user->username) . DS . "videokes" . DS . "thumb_" . $number . "_" . $this->video . ".jpg");
        } else {
            return Uri::create("assets/img/defaults/" . "thumb_" . $number . "_video_picture.jpg");
        }
    }

    public function thumbs_up(){
        if(!$this->is_new()){
            $q = DB::query('SELECT (SELECT COUNT(`id`) FROM `videokes_ratings` WHERE `videoke_id` = '.$this->id.' AND `rating` = \'1\') + (SELECT COUNT(`id`) FROM `videokes_ratings` WHERE `videoke_id` = '.$this->id.' AND `rating` = \'2\')*2 AS `sum`')->execute()->as_array();
            if(!empty($q)){
                $q = array_pop($q);
                return $q['sum'];
            }
        } 
        return 0;
    }

    public function thumbs_down(){
        if(!$this->is_new()){
            $q = DB::query('SELECT (SELECT COUNT(`id`) FROM `videokes_ratings` WHERE `videoke_id` = '.$this->id.' AND `rating` = \'-1\') + (SELECT COUNT(`id`) FROM `videokes_ratings` WHERE `videoke_id` = '.$this->id.' AND `rating` = \'-2\')*2 AS `sum`')->execute()->as_array();
            if(!empty($q)){
                $q = array_pop($q);
                return $q['sum'];
            }
        } 
        return 0;
    }

    public function votes(){
        if(!$this->is_new()){
            return count(Model_Rating::find_by_videoke_id($this->id));
        
        } 
    
    }

}
