<?php

class Model_Contest extends \Orm\Model {

    protected static $_properties = array(
        'id',
        'category_id',
        'start_time',
        'end_time',
        'current_round',
        'winner',
        'name',
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
    );
    public static $_table_name = 'contests';
    protected static $_belongs_to = array(
        'category' => array(
            'key_from' => 'category_id',
            'key_to' => 'id'
    ));
    protected static $_many_many = array(
        'videokes' => array(
            'key_from' => 'id',
            'key_through_from' => 'contest_id', 
            'table_through' => 'contests_videos', 
            'key_through_to' => 'video_id', 
            'model_to' => 'Model_Videoke',
            'key_to' => 'id',
            //'cascade_save' => true,
            //'cascade_delete' => false,
        )
    );

    public function getByID($contest_id) {

        try {
            $output = DB::query("SELECT * FROM contests WHERE id='" . intval($contest_id) . "'")->execute()->as_array();
            
            return $output[0];
        } catch (Exception $err) {
            return null;
        }
    }
    public function getByStatus($category_id, $status) {
        
        try {
            $output = DB::query("SELECT * FROM contests WHERE category_id='" . intval($category_id) . "' AND  status='" . $status . "' ")->execute()->as_array();

            return $output[0];
        } catch (Exception $err) {
            return null;
        }
    }


    public function getVideo($id) {

        try {
            $output = DB::query("SELECT * FROM videokes WHERE id='" . intval($id) . "'")->execute()->as_array();

            return $output[0];
        } catch (Exception $err) {
            return null;
        }
    }

    public function getVideoRelations($contest_id = 0, $round_id = -1, $winner = null) {


        $sql = "SELECT * FROM `contests_videos` WHERE 1 ";


        ## SEARCH FOR CONTEST ID
        $sql .= ($contest_id > 0) ? " AND contest_id='" . intval($contest_id) . "' " : '';

        ## ROUND SEARCH
        $sql .= ($round_id > -1) ? " AND round_id='" . intval($round_id) . "' " : '';

        ## SEARCH FOR WINNERS
        $sql .= ($winner) ? " AND  `winner`='" . addslashes($winner) . "' " : '';


        return DB::query($sql)->execute()->as_array();
    }

    public function getUserVideoRelations($user_id, $completed = false) {

        return DB::query("SELECT `contests_videos`.*,  `videokes`.*"
                . "FROM `contests_videos` " .
                " INNER JOIN videokes ON videokes.id = `contests_videos`.video_id " .
                " INNER JOIN contests ON contests.id = `contests_videos`.contest_id " .
                " WHERE videokes.user_id='" . intval($user_id) . "' " .
                (($completed == false) ? " AND contests.status='active' " : " AND contests.status='completed' ")
            )->execute()->as_array();
    }

    public function filterVideoByRound($video_rels, $contest_arr) {
        $out = array();

        foreach ($video_rels as $vrel) {

            $round = $contest_arr[$vrel['contest_id']]['current_round'];

            if ($vrel['round_id'] == $round) {
                $out[] = $vrel;
            }
        }

        return $out;
    }

    public function getCategoryImage($category_id) {

        switch ($category_id) {
            default:

                return Asset::img("contest/unknown.png");

                break;
            case 1:
                return Asset::img("contest/singers.jpg");
            case 2:
                return Asset::img("contest/rappers.jpg");
            case 3:
                return Asset::img("contest/dancers.jpg");
            case 4:
                return Asset::img("contest/bands.jpg");
            case 5:
                return Asset::img("contest/spokenword.jpg");
            case 6:
                return Asset::img("contest/djs.jpg");
            case 7:
                return Asset::img("contest/lipsync.jpg");
            case 8:
                return Asset::img("contest/kidtalent.jpg");
            case 9:
                return Asset::img("contest/rants.jpg");
            case 10:
                return Asset::img("contest/judges.jpg");
            case 11:

                return Asset::img("contest/comedians.jpg");
        }
    }

    /**
     * Get Contests, optionally based on parameters
     * @param number $category_id	The ID of the contest category to search, default 0 = no category specified/ignore
     * @param string $status		The Status of the contest you want to return, default "active" = all active contests, "completed", "deleted"
     * @param number $round_id		Gets contests of a specified round (optional)
     */
    public function getContests($category_id = 0, $status = "active", $round_id = -1) {


        $sql = "SELECT * FROM `contests` WHERE 1 ";


        ## SEARCH FOR CATEGORY
        $sql .= ($category_id > 0) ? " AND category_id='" . intval($category_id) . "' " : '';

        ## SEARCH FOR STATUS
        $sql .= ($status != '') ? " AND  `status`='" . $status . "' " : '';

        $sql .= ($round_id > -1) ? " AND current_round='" . intval($round_id) . "' " : '';

        return DB::query($sql)->execute();
    }
    public function getPastContests($category_id = 0, $status = "active", $round_id = -1) {


        $sql = "SELECT * FROM `contests` WHERE 1 ";


        ## SEARCH FOR CATEGORY
        $sql .= ($category_id > 0) ? " AND category_id='" . intval($category_id) . "' " : '';

        ## SEARCH FOR STATUS
        $sql .= ($status != '') ? " AND  `status`!='" . $status . "' " : '';

        $sql .= ($round_id > -1) ? " AND current_round='" . intval($round_id) . "' " : '';

        return DB::query($sql)->execute();
    }

    public function getByStartTime( $status = "completed", $time) {


        $sql = "SELECT * FROM `contests` WHERE 1 ";

        ## SEARCH FOR STATUS
        $sql .= ($status != '') ? " AND  `status`='" . $status . "' " : '';

        $sql .= ($time > -1) ? " AND start_time='" . intval($time) . "' " : '';

        return DB::query($sql)->execute();
    }

    public function getContest($category_id = 0, $status = "active", $round_id = -1) {

        $output =array();
        $sql = "SELECT * FROM `contests` WHERE 1 ";


        ## SEARCH FOR CATEGORY
        $sql .= ($category_id > 0) ? " AND category_id='" . intval($category_id) . "' " : '';

        ## SEARCH FOR STATUS
        $sql .= ($status != '') ? " AND  `status`='" . $status . "' " : '';

        $sql .= ($round_id > -1) ? " AND current_round='" . intval($round_id) . "' " : '';
        
        $output[]= DB::query($sql)->execute()->as_array();

        return $output[0];
    }

    /**
     * Get ALL contests, completed or not
     */
    public function getAllContests() {
        return $this->getContests(0, '');
    }

    public function arrangeByCategory($contests_array = array()) {

        $out = array();

        foreach ($contests_array as $con) {
            $out[$con['category_id']][] = $con;
        }

        return $out;
    }

    /**
     * Remember to Prepopulate ['video'] with teh videoke object, before you pass in $contest_videos 
     * @param unknown $videorels
     */
    public function pairVideos($contest_videos, $round_id) {

        $pairs = array();
        $completed_ids = array();


        $x = 0;
        foreach ($contest_videos as $videorel) {

            if ($videorel['round_id'] != $round_id)
                continue;

            // SKIP COMPLETED VIDEOS
            if (in_array($videorel['video_id'], $completed_ids))
                continue;

            $pairs[$x] = array();


            $pairs[$x][0] = $videorel;

            $completed_ids[] = $videorel['video_id'];


            // FIND PAIR
            foreach ($contest_videos as $videorel) {

                if ($videorel['round_id'] != $round_id)
                    continue;

                if ($pairs[$x][0]['paired_with'] == $videorel['video_id']) {
                    $pairs[$x][1] = $videorel;
                    $completed_ids[] = $videorel['video_id'];
                    break;
                }
            }

            $x++;
        }

        ##print_r($pairs);
        return $pairs;
    }

    /**
     * Reset contest to a specific round - Useful for debugging/testing
     * @param unknown $contest_id
     * @param unknown $round
     */
    public function resetContest($contest_id, $round) {

        $contest_id = intval($contest_id);

        if ($round > 3 || $round < 0) {
            echo "Round #" . $round . " is OUT OF RANGE (0-3)\n";
            return false;
        }

        if ($contest_id <= 0) {
            echo "Contest ID#" . $contest_id . " is OUT OF RANGE (0-3)\n";
            return false;
        }

        $result = DB::update('contests')
            ->set(
                array(
                    "status" => "active",
                    "current_round" => $round,
                    "winner" => 0
                )
            )
            ->where('id', '=', $contest_id)
            ->execute();

        ## REMOVE ALL ADVANCED ROUNDS
        DB::query("DELETE FROM `contests_videos` WHERE contest_id='$contest_id' AND round_id > '$round'")->execute();

        ## RESET CURRENT ROUND WINNERS
        DB::query("UPDATE `contests_videos` SET winner='undetermined' WHERE contest_id='$contest_id' AND round_id='$round'")->execute();


        echo "CONTEST #" . $contest_id . " RESET TO ROUND #" . $round . "\n";
        return true;
    }

    public function getCompletedContests($category_id) {
        return $this->getContests($category_id, 'completed');
    }

    /**
     * Compute End of Rounds
     * 
     * 1) Get all active contests
     * 1.5) Make sure it's time for the contest to compute again
     * 2) Determine what round it is
     * 3) Get all videos for that round
     * 4) Get all votes for each video
     * 5) ???
     * 6) Profit.
     * 
     * http://showmevideoke.com/SMVK-contest-logic.jpg
     */
    public function computeEndofRounds() {


        $cres = $this->getContests(0, 'active')->as_array();
        foreach ($cres as $contest) {

            $videos = array();
            $sorted = array();


           // echo date("H:i:s m/d/Y") . " Current Contest ID# " . $contest['id'] . " - Round " . $contest['current_round'] . "\n";

            ##################
            ## TIME CHECK!!

            $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);
            //$round_time = $contest['start_time'] + ($contest['current_round'] * 600);

            $curtime = time();
            // $curtime =  1423177211;

            // ITS NOT TIME TO RUN YET
            if ($curtime < $round_time) {

              //  echo date("H:i:s m/d/Y") . " ID# " . $contest['id'] . " Not time to run yet. Next Round: " . date("H:i:s m/d/Y", $round_time) . "\n";
                continue;
            }


            ##################
            // ROUND ZERO - VOTES ARE BASED ON LIKES
            if ($contest['current_round'] <= 1) {


                // GET ALL ASSOCIATED VIDEOS (TO GET LIKES)
                $videorel = $this->getVideoRelations($contest['id'], 1);


               // echo date("H:i:s m/d/Y") . " Videos found for this round: " . count($videorel) . "\n";

                // IF THERE ARE VIDEOS IN THIS ROUND
                if (count($videorel) > 0) {

                    // BUILD WHERE STRING TO MAKE GRABING VIDEOS SORTED BY LIKES EASIER
                    $wherestr = " AND (";
                    $x = 0;
                    foreach ($videorel as $vrow) {
                        if ($x++ > 0)
                            $wherestr.= " OR ";
                        $wherestr .= "videokes.id='" . $vrow['video_id'] . "'";
                    }
                    $wherestr.= ") ";


// 	        			## GET ALL VIDEOS THAT WERE ADDED TO THE CONTEST
// 	        			$videos = DB::query("SELECT * FROM videokes WHERE 1 $wherestr ")->execute()->as_array();
// 	        			## RANDOMIZE STACK
// 	        			shuffle($videos);
// 	        			print_r($videos);
// 	        			$videos = $this->sortByLikes($videos);
// 	        			echo "After like sort: ";
// 	        			print_r($videos);
// 	        			exit;


                    $sql = "SELECT videokes.*, SUM(videokes_ratings.rating) AS sum_rating FROM videokes " .
                        " LEFT JOIN videokes_ratings ON videokes_ratings.videoke_id = videokes.id " .
                        " WHERE 1 $wherestr " .
                        " GROUP BY videokes.id " .
                        " ORDER BY `sum_rating` DESC " .
                        "LIMIT 8";
                    //echo $sql;
                    // GET TOP 8 VIDEOS SORTED BY `likes`
                    $videos = DB::query($sql)->execute()->as_array();

                    // FIX SUM_RATING = BLANK or null
                    foreach ($videos as $idx => $vid) {
                        $videos[$idx]['sum_rating'] = intval($vid['sum_rating']);
                    }

// 	        			print_r($videos);exit;
                    // IF THERE ARE NOT 8 VIDEOS TO RANK, THE CONTEST CANCELS ITSELF
                    if (count($videos) < 8) {

                        // CALL IT OFF
                        // MARK CONTEST AS CANCELLED
                        //DB::query("UPDATE contests SET `status`='cancelled' WHERE id='".$contest['id']."'")->execute();

                       // echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " CANCELLED - ONLY " . count($videos) . " VIDEOS SUBMITTED\n";

                        // CANCEL TEH CONTEST - NO VIDEOS SUBMITTED
                        DB::update('contests')
                            ->value("status", "cancelled")
                            ->where('id', '=', $contest['id'])
                            ->execute();


                        // COULD ADD SOME SORT OF NOTIFICATION HERE
                        // SKIP
                        continue;
                    }



                    // GET A SUM OF THE RATINGS OF ALL OF THE VIDEOS ADDED TO THE CONTEST
// 	        			$sql = "SELECT SUM(rating) AS sum_rating, videoke_id FROM videokes_ratings ".
// 	        								" WHERE 1 $wherestr ".
// 	        								" GROUP BY videoke_id ".
// 	        								" ORDER BY `sum_rating` DESC ".
// 	        								"LIMIT 8";
// 	        			echo $sql;
// 	        			$video_ratingz = DB::query($sql)->execute()->as_array();
// 	        			print_r($video_ratingz);exit;
                    // BUILD THE ARRAY OF VIDEOS, FROM THE RESULTS
                    //print_r($videos);
                    // RANDOMIZE ARRAY BEFORE PAIRING THEM UP
                    shuffle($videos);

                    ##print_r($videos);
                    //exit;
                    // PAIR THEM UP
                    for ($x = 0; $x < count($videos); $x+=2) {

                        if (isset($videos[$x + 1])) {


                            ## ADD THE PAIR INFORMATION tO ARRAY
                            $videos[$x]['paired_with'] = $videos[$x + 1]['id'];
                            $videos[$x + 1]['paired_with'] = $videos[$x]['id'];

                            // NO OTHER VIDEO TO PAIR IT UP WITH :((
                        } else {

                            $videos[$x]['paired_with'] = 0;
                        }
                    }

                    // GO THOUGH ALL VIDEO ASSOCIATIONS
                    foreach ($videorel as $vrow) {

                        $is_winner = false;
                        $video_idx = -1;

                        // TRY TO FIND VIDEO ON WINNER STACK
                        foreach ($videos as $vidx => $video) {
                            if ($video['id'] == $vrow['video_id']) {
                                $is_winner = true;
                                $video_idx = $vidx;
                                break;
                            }
                        }


                        // FOUND THEM ON WINNER STACK
                        if ($is_winner == true) {

                           // echo date("H:i:s m/d/Y") . " Video #" . $vrow['video_id'] . " WINNER - Likes:" . $video['sum_rating'] . "\n";


                            // MARK ASSOC RECORD AS WINNER
                            $result = DB::update('contests_videos')
                                ->value("winner", "yes")
                                ->value("status","Qualified")
                                ->where('id', '=', $vrow['id'])
                                ->execute();

                            ##print_r($videos);
                            // ADD THEM TO THE NEXT ROUND
                            $newrow = array();
                            $newrow['contest_id'] = $vrow['contest_id'];
                            $newrow['video_id'] = $vrow['video_id'];
                            $newrow['round_id'] = 2;
                            $newrow['paired_with'] = $videos[$video_idx]['paired_with'];
                            $newrow['winner'] = 'undetermined';
                            list($insert_id, $rows_affected) = DB::insert('contests_videos')->set($newrow)->execute();

                            // LOSER!
                        } else {

                           // echo date("H:i:s m/d/Y") . " Video #" . $vrow['video_id'] . " LOSER\n";

                            // MARK ASSOC RECORD AS LOSER
                            $result = DB::update('contests_videos')
                                ->value("winner", "no")
                                ->value("status","Failed")
                                ->where('id', '=', $vrow['id'])
                                ->execute();
                        }
                    }
                } else {

                    //echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " CANCELLED - NO VIDEOS SUBMITTED\n";

                    // CANCEL TEH CONTEST - NO VIDEOS SUBMITTED 
                    DB::update('contests')
                        ->value("status", "cancelled")
                        ->where('id', '=', $contest['id'])
                        ->execute();

                    continue;
                }


               // echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " Round 0 complete\n";

                // SET CONTEST ROUND = 1
                DB::update('contests')
                    ->value("current_round", 2)
                    ->where('id', '=', $contest['id'])
                    ->execute();



                // TO THE NEXT CONTEST
                continue;
                // END ROUND ZERO PROCESSING



                /*                 * * PROCESS ROUNDS 1 - 3 ** */
            } else if ($contest['current_round'] > 1 && $contest['current_round'] < 5) {


                // GET ALL ASSOCIATED VIDEOS (TO GET LIKES)
                $videorel = $this->getVideoRelations($contest['id'], $contest['current_round']);


               // echo date("H:i:s m/d/Y") . " Videos found for this round: " . count($videorel) . "\n";

                // IF THERE ARE VIDEOS IN THIS ROUND
                if (count($videorel) > 0) {

                    $votes = array();
                    // GO THRU EACH VIDEO ASSOC 
                    foreach ($videorel as $idx => $vrow) {

                        // GET VOTES FOR THE VIDEO
                        $votes = DB::query(
                                "SELECT SUM(vote) FROM videokes_votes WHERE video_id='" . $vrow['video_id'] . "' " .
                                " AND contest_id='" . $contest['id'] . "' " .
                                " AND round_id='" . $contest['current_round'] . "' "
                            )->execute()->as_array();



                        // ADD THE VIDEOS VOTES TO VIDEO ASSOC ROW (FOR LATER USE in sortByVotes)
                        $videorel[$idx]['votes'] = intval($votes[0]['SUM(vote)']);
                    }

                    // ALL VOTES GATHERED, SORTING TIME
                    ###$sorted = $this->sortByVotes($videorel);
                    ###print_r($sorted);
                    //$wincnt = $this->getWinnerCountByRound($contest['current_round']);
                    ##print_r($videorel);

                    $completed_vids = array();
                    $winner_arr = array();
                    $cnt = 0;

                    // GET TOP $wincnt WINNERS
                    foreach ($videorel as $vrow) {



                        // ALREADY COMPLETED
                        if (in_array($vrow['video_id'], $completed_vids)) {
                            continue;
                        }

                        $v = null;

                        foreach ($videorel as $vr) {
                            if ($vrow['paired_with'] == $vr['video_id']) {
                                $v = $vr;
                                break;
                            }
                        }


                        // VROW['paired_with'] must be 0, or partner not found
                        // VROW AUTOMATIC WINNER
                        if ($v == null) {

                            $vrow['winner'] = 'yes';


                           // echo date("H:i:s m/d/Y") . " Video #" . $vrow['video_id'] . " AUTOMATIC WINNER - No competition\n";

                            // MARK ASSOC RECORD AS WINNER
                            DB::update('contests_videos')
                                ->value("winner", "yes")
                                ->where('id', '=', $vrow['id'])
                                ->execute();




                            // ADD WINNER TO THE NEXT ROUND
                            if ($contest['current_round'] < 5) {

                                $newrow = array();
                                $newrow['contest_id'] = $vrow['contest_id'];
                                $newrow['video_id'] = $vrow['video_id'];
                                $newrow['round_id'] = $contest['current_round'] + 1;
                                if ($contest['current_round'] == 4) {
                                    $newrow['winner'] = 'yes';
                                }else{
                                    $newrow['winner'] = 'undetermined';
                                }
                                
                                list($insert_id, $rows_affected) = DB::insert('contests_videos')->set($newrow)->execute();

                                $winner_arr[] = array("id" => $insert_id, "video_id" => $vrow['video_id']);

                                // END OF CONTEST
                                if ($contest['current_round'] == 4) {

                                   // echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " END OF CONTEST - Winner is Video #" . $vrow['video_id'] . "\n";

                                    DB::update('contests')
                                        ->set(array(
                                            "winner" => $vrow['video_id'],
                                            "status" => "completed"
                                        ))
                                        ->where('id', '=', $contest['id'])
                                        ->execute();
                                }
                            }


                            $completed_vids[] = $vrow['video_id'];


                            // ELSE PARTNER WAS FOUND ($v != null)
                        } else {



                            // FIRST VIDEO WON, SECOND LOST
                            if ($vrow['votes'] > $v['votes']) {

                                $vrow['winner'] = 'yes';
                                $v['winner'] = 'no';

                                // TIE - TRY LIKE BASED TIE BREAKER, THEN RANDOM 
                            } else if ($vrow['votes'] == $v['votes']) {

                                //echo date("H:i:s m/d/Y") . " Tie between : Video#" . $vrow['video_id'] . " and Video#" . $v['video_id'] . ", Attempting tie breaker by LIKES...\n";

                                //         						$video1 = $this->getVideo($vrow['video_id']);
                                //         						$video2 = $this->getVideo($v['video_id']);

                                $video1_rating = $this->getVideoRating($vrow['video_id']);
                                $video2_rating = $this->getVideoRating($v['video_id']);

                                // V1 WINS
                                if ($video1_rating > $video2_rating) {

                                    $vrow['winner'] = 'yes';
                                    $v['winner'] = 'no';

                                    // ANOTHER TIE! RANDOM IT IS!
                                } else if ($video1_rating == $video2_rating) {

                                   // echo date("H:i:s m/d/Y") . " ANOTHER Tie between : Video#" . $vrow['video_id'] . " and Video#" . $v['video_id'] . ", fallback to Random\n";

                                    $rnum = rand(0, 1);

                                    // HEADS I WIN
                                    if ($rnum > 0) {

                                        $vrow['winner'] = 'yes';
                                        $v['winner'] = 'no';

                                        // TAILS YOU LOSE
                                    } else {
                                        $vrow['winner'] = 'no';
                                        $v['winner'] = 'yes';
                                    }
                                } else {

                                    $vrow['winner'] = 'no';
                                    $v['winner'] = 'yes';
                                }

                                // SECOND VIDEO WON, FIRST LOST
                            } else {

                                $vrow['winner'] = 'no';
                                $v['winner'] = 'yes';
                            }



                            // V1 WINNER!
                            if ($vrow['winner'] == 'yes') {




                               // echo date("H:i:s m/d/Y") . " Video #" . $vrow['video_id'] . " > #" . $v['video_id'] . " - Votes:" . $vrow['votes'] . " to " . $v['votes'] . "\n";

                                // MARK ASSOC RECORD AS WINNER
                                DB::update('contests_videos')
                                    ->value("winner", "yes")
                                    ->where('id', '=', $vrow['id'])
                                    ->execute();

                                // MARK OTHER VIDEO AS LOSER				
                                DB::update('contests_videos')
                                    ->value("winner", "no")
                                    ->where('id', '=', $v['id'])
                                    ->execute();



                                // ADD WINNER TO THE NEXT ROUND
                                if ($contest['current_round'] < 5) {

                                    $newrow = array();
                                    $newrow['contest_id'] = $vrow['contest_id'];
                                    $newrow['video_id'] = $vrow['video_id'];
                                    $newrow['round_id'] = $contest['current_round'] + 1;
                                    $newrow['winner'] = ($contest['current_round'] == 4) ? 'yes' : 'undetermined';
                                    list($insert_id, $rows_affected) = DB::insert('contests_videos')->set($newrow)->execute();

                                    $winner_arr[] = array("id" => $insert_id, "video_id" => $vrow['video_id']);

                                    // END OF CONTEST
                                    if ($contest['current_round'] == 4) {

                                       // echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " END OF CONTEST - Winner is Video #" . $vrow['video_id'] . "\n";

                                        DB::update('contests')
                                            ->set(array(
                                                "winner" => $vrow['video_id'],
                                                "status" => "completed"
                                            ))
                                            ->where('id', '=', $contest['id'])
                                            ->execute();

                                        $videoke = Model_Videoke::find($vrow['video_id']);
                                        list(, $userid) = Auth::get_user_id();
                                        if ($videoke) {
                                            $message = Model_Message::forge(array(
                                                    "from_user_id" => $userid,
                                                    "to_user_id" => $videoke->user_id,
                                                    "title" => "Contest Winner",
                                                    "detail" => "The videoke '" . $videoke->title . "' you uploaded is a winner for this month contest",
                                                    "status" => Model_Message::SENT,
                                                    "read_status" => Model_Message::UNREAD
                                            ));
                                            $message->save();
                                        }
                                    }
                                }

                                // V1 is LOSER! V2 is WINNER
                            } else {


                                //echo date("H:i:s m/d/Y") . " Video #" . $vrow['video_id'] . " < #" . $v['video_id'] . " - Votes:" . $vrow['votes'] . " to " . $v['votes'] . "\n";

                                // MARK ASSOC RECORD AS WINNER
                                DB::update('contests_videos')
                                    ->value("winner", "yes")
                                    ->where('id', '=', $v['id'])
                                    ->execute();

                                // MARK OTHER VIDEO AS LOSER				
                                DB::update('contests_videos')
                                    ->value("winner", "no")
                                    ->where('id', '=', $vrow['id'])
                                    ->execute();


                                // ADD WINNER TO THE NEXT ROUND
                                if ($contest['current_round'] < 5) {

                                    $newrow = array();
                                    $newrow['contest_id'] = $v['contest_id'];
                                    $newrow['video_id'] = $v['video_id'];
                                    $newrow['round_id'] = $contest['current_round'] + 1;
                                    $newrow['winner'] = ($contest['current_round'] == 4) ? 'yes' : 'undetermined';
                                    list($insert_id, $rows_affected) = DB::insert('contests_videos')->set($newrow)->execute();


                                    $winner_arr[] = array("id" => $insert_id, "video_id" => $v['video_id']);

                                    // END OF CONTEST
                                    if ($contest['current_round'] == 4) {

                                      //  echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " END OF CONTEST - Winner is Video #" . $v['video_id'] . "\n";

                                        DB::update('contests')
                                            ->set(array(
                                                "winner" => $v['video_id'],
                                                "status" => "completed"
                                            ))
                                            ->where('id', '=', $contest['id'])
                                            ->execute();
                                    }
                                }
                            }


                            if (isset($vrow['video_id']))
                                $completed_vids[] = $vrow['video_id'];
                            if (isset($v['video_id']))
                                $completed_vids[] = $v['video_id'];
                        } // END ELSE (V == null)
                    }

                    ##print_r($winner_arr);


                    if ($contest['current_round'] < 4) {
                        ## SHUFFLE AND PAIR UP THE NEXT ROUND
                        shuffle($winner_arr);

                        ## PAIR THEM UP
                        for ($x = 0; $x < count($winner_arr); $x += 2) {


                            if (isset($winner_arr[$x + 1])) {

                                DB::update('contests_videos')
                                    ->value("paired_with", $winner_arr[$x + 1]['video_id'])
                                    ->where('id', '=', $winner_arr[$x]['id'])
                                    ->execute();



                                DB::update('contests_videos')
                                    ->value("paired_with", $winner_arr[$x]['video_id'])
                                    ->where('id', '=', $winner_arr[$x + 1]['id'])
                                    ->execute();


                                // NO PARTNER, PAIR WITH NO ONE
                            } else {

                                DB::update('contests_videos')
                                    ->value("paired_with", 0)
                                    ->where('id', '=', $winner_arr[$x]['id'])
                                    ->execute();
                            }
                        }
                    }


                   // echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " Round " . $contest['current_round'] . " complete\n";

                    DB::update('contests')
                        ->value("current_round", $contest['current_round'] + 1)
                        ->where('id', '=', $contest['id'])
                        ->execute();


                    // IF THERE ARE NO VIDEOS IN THIS ROUND - CANCEL!
                } else {

                    //echo date("H:i:s m/d/Y") . " Contest#" . $contest['id'] . " CANCELLED - NO VIDEOS FOUND\n";

                    // CANCEL TEH CONTEST - NO VIDEOS SUBMITTED
                    DB::update('contests')
                        ->value("status", "cancelled")
                        ->where('id', '=', $contest['id'])
                        ->execute();



                    continue;
                } // END video count IF
            }// END ROUND IF
        } // END FOREACH(contest)
    }

// END FUNCTION computeround

    public static function hasVotedAlready($contest_id, $round, $video_id, $user_id) {

        $contest_id = intval($contest_id);
        $video_id = intval($video_id);
        $round = intval($round);
        $user_id = intval($user_id);


        $row = DB::query("SELECT id, vote FROM videokes_votes " .
                " WHERE video_id='" . $video_id . "' AND contest_id='" . $contest_id . "' AND round_id='" . $round . "' " .
                " AND user_id='" . $user_id . "' "
            )->execute()->as_array();

        if (count($row) > 0) {
            return array(intval($row[0]['id']), $row[0]['vote']);
        } else {
            return array(0, 0);
        }
    }

    public static function totalVotes($contest_id, $round, $video_id, $user_id) {

        $contest_id = intval($contest_id);
        $video_id = intval($video_id);
        $round = intval($round);
        $user_id = intval($user_id);


        $row = DB::query("SELECT id, vote FROM videokes_votes " .
                " WHERE video_id='" . $video_id . "' AND contest_id='" . $contest_id . "' AND round_id='" . $round . "' " 
                
            )->execute()->as_array();

        if (count($row) > 0) {
            return count($row);
        } else {
            return count($row);
        }
    }





    public static function getVideoContestVotes($contest_id, $round, $video_id) {

        $contest_id = intval($contest_id);
        $video_id = intval($video_id);
        $round = intval($round);

        $rating = DB::query("SELECT SUM(vote) AS sum_vote FROM videokes_votes " .
                " WHERE video_id='" . $video_id . "' AND contest_id='" . $contest_id . "' AND round_id='" . $round . "' "
            )->execute()->as_array();


        return intval($rating[0]['sum_vote']);
    }

    public function getVideoRating($video_id) {


        $rating = DB::query("SELECT SUM(videokes_ratings.rating) AS sum_rating FROM videokes_ratings " .
                " WHERE videoke_id='" . $video_id . "'  "
            )->execute()->as_array();


        return intval($rating[0]['sum_rating']);
    }

    public function postVote($contest_id, $round, $video_id, $user_id, $rating) {


        $newrow = array();
        $newrow['contest_id'] = $contest_id;
        $newrow['round_id'] = $round;
        $newrow['video_id'] = $video_id;
        $newrow['user_id'] = $user_id;
        $newrow['vote'] = 1;
        $newrow['timestamp'] = time();
        list($insert_id, $rows_affected) = DB::insert('videokes_votes')->set($newrow)->execute();

        return $insert_id;
    }

    /**
     * Get the number of winners a particular round has
     * @param unknown $round
     */
    private function getWinnerCountByRound($round) {
        switch ($round) {
            case 0:
            default:
                return 8;
            case 1:
                return 4;
            case 2:
                return 2;
            case 3:
                return 1;
            case 4:
                return 0; // ROUND 4 DOESNT REALLY EXIST, SINCE THERE IS ONLY ONE VIDEO	
        }
    }

    function shuffle_assoc($list) {
        if (!is_array($list))
            return $list;

        $keys = array_keys($list);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key)
            $random[$key] = $list[$key];

        return $random;
    }

    private function sortByLikes($videos) {

        $out = array();
        $votes = array();
        foreach ($videos as $idx => $video) {

            $votes[$idx] = $video['likes'];
        }

        array_multisort($votes, SORT_DESC, $videos);

        return $videos;
    }

    private function sortByVotes($videorel) {

        $out = array();
        $votes = array();
        foreach ($videorel as $idx => $vrow) {

            $votes[$idx] = $vrow['votes'];
        }

        array_multisort($votes, SORT_DESC, $videorel);


        return $videorel;
    }

}
