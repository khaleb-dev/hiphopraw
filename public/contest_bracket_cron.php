<?php

$host = 'localhost';
$username = 'root';
$pass = '';
$db = 'hiphopraw';

$conn = new mysqli($host, $username, $pass, $db);

$sql ="SELECT * FROM contests WHERE status='active' ";

$result_contests = $conn->query($sql);

if(count($result_contests) > 0){
        foreach ($result_contests as $contest){
            $videos = array();
            $sorted = array();
            $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);
            $curtime = time();

            //$fround =$contest['start_time'] +600;
            //echo "hello";

            if ($curtime < $round_time ) {
    
             echo " Submit your video for this contest";               
             continue;
            }
            
            if ($contest['current_round'] == 1) {

                $sql1 = "SELECT * FROM contests_videos WHERE contest_id ='".$contest['id']."' AND round_id='1'";
                $result_videorel =   $conn->query($sql1);

                if (count($result_videorel) > 0) {
                    
                    $wherestr = " AND (";
                    $x = 0;
                    foreach ($result_videorel as $vrow) {
                        if ($x++ > 0)
                            $wherestr.= " OR ";
                        $wherestr .= "videokes.id='" . $vrow['video_id'] . "'";
                    }
                    $wherestr.= ") ";

                    $sql2 = "SELECT videokes.*, SUM(videokes_ratings.rating) AS sum_rating FROM videokes " .
                        " LEFT JOIN videokes_ratings ON videokes_ratings.videoke_id = videokes.id " .
                        " WHERE 1 $wherestr " .
                        " GROUP BY videokes.id " .
                        " ORDER BY `sum_rating` DESC " .
                        "LIMIT 8";
                    
                    $videos_result = $conn->query($sql2);

                    $videos = [];
                    while($video = mysqli_fetch_array($videos_result))
                    {
                        $videos[] = $video;
                    }
                 
                   foreach ($videos as  $idx=>$vid){

                        $videos[$idx]['sum_rating'] = intval($vid['sum_rating']);
                   }

                    if (count($videos) < 8) {
                        
                       $sql3 = "UPDATE contests SET status='cancelled' WHERE id='".$contest['id']."'";
                       $conn->query($sql3);
                        
                        continue;
                    }
              
                    shuffle($videos);
                    
                    for ($x = 0; $x < count($videos); $x+=2) {
                        if (isset($videos[$x + 1])) {
                            $videos[$x]['paired_with'] = $videos[$x + 1]['id'];
                            $videos[$x + 1]['paired_with'] = $videos[$x]['id'];
                        } else {
                            $videos[$x]['paired_with'] = 0;
                        }
                    }

                    foreach ($result_videorel as $vrow) {
                        $is_winner = false;
                        $video_idx = -1;
        
                        foreach ($videos as $vidx => $video) {
                            if ($video['id'] == $vrow['video_id']) {
                                $is_winner = true;
                                $video_idx = $vidx;
                                break;
                            }

                        }

                        if ($is_winner == true) {
                            $sql4 = "UPDATE contests_videos SET winner='yes', status ='QUALIFY' WHERE id='".$vrow['id']."'";
                            $conn->query($sql4);
                           
                            
                            $sql5 = "INSERT INTO contests_videos (contest_id, video_id, round_id, paired_with, winner) VALUES ('". $vrow['contest_id']."','".
                                    $vrow['video_id']."','2','".$videos[$video_idx]['paired_with']."','undetermined')";

                            $conn->query($sql5);
                            
                            
                        } else {
                          
                          $sql6 = "UPDATE contests_videos SET winner='no', status='FAIL' WHERE id='".$vrow['id']."'";
                          $conn->query($sql6);
                        }
                    }
                } else {

                        $sql7 = "UPDATE contests SET status='cancelled' WHERE id='".$contest['id']."'";
                        $conn->query($sql7);
                        continue;
                }

                    $sql8 = "UPDATE contests SET current_round='2' WHERE id='".$contest['id']."'";
                    $conn->query($sql8);
                    continue;
                    
            } else if ($contest['current_round'] > 1 && $contest['current_round'] <= 4) {
               
                $sql9 = "SELECT * FROM contests_videos WHERE contest_id ='".$contest['id']."' AND round_id='".$contest['current_round']."'";
                $result_videorel =   $conn->query($sql9);
                if (count($result_videorel) > 0) {

                    $videorels = array();

                    while($videorel = mysqli_fetch_array($result_videorel))
                            {
                             $videorels[] = $videorel;
                            }

                    $votes = array();
                    
                    foreach ($videorels as $idx => $vrow) {
                        $sqlvote= "SELECT SUM(vote) FROM videokes_votes WHERE video_id='" . $vrow['video_id'] . "' AND contest_id='" . $contest['id'] . "' AND round_id='" . $contest['current_round'] . "' ";
                        echo $sqlvote;
                        $result_vote = $conn->query($sqlvote);

                         while($vote = mysqli_fetch_array($result_vote))
                            {
                             $votes[] = $vote;
                            }
                           
                        $videorels[$idx]['votes'] = intval($votes[0]['SUM(vote)']);
                    
                    }
                    
                    $completed_vids = array();
                    $winner_arr = array();
                    $cnt = 0;
                    
                    foreach ($videorels as $vrow) {
                       
                        if (in_array($vrow['video_id'], $completed_vids)) {
                            continue;
                        }
                        $v = null;
                        foreach ($videorels as $vr) {
                            if ($vrow['paired_with'] == $vr['video_id']) {
                                $v = $vr;
                                break;
                            }
                        }
            
                        if ($v == null) {
                           $vrow['winner'] = 'yes';
                           $sql10 = "UPDATE contests_videos SET winner='yes' WHERE id='".$vrow['id']."'";
                           $conn->query($sql10);
                            
                            if ($contest['current_round'] <= 4) {

                                if($contest['current_round'] == 4){
                                    $win = 'yes';
                                }
                                else{
                                    $win = 'undetermined';
                                }
                                $rnd=intval($contest['current_round']) + 1;  
                                $sql11 = "INSERT INTO contests_videos (contest_id, video_id, round_id, winner) VALUES ('". $vrow['contest_id'].
                                   "','".$vrow['video_id']."','".$rnd."','".$win."')";
                                
                                $conn->query($sql11);

                                $winner_arr[] = array("id" => mysql_insert_id(), "video_id" => $vrow['video_id']);
                             
                                if ($contest['current_round'] == 4) {
                                
                                    $sql12 = "UPDATE contests SET winner='".$vrow['video_id']."', status='completed' WHERE id='".$contest['id']."'";
                                    $conn->query($sql12);
            
                                }
                            }
                            $completed_vids[] = $vrow['video_id'];
                            
                        } else {
                           echo $vrow['votes'];
                           echo $v['votes'];
                            if ($vrow['votes'] > $v['votes']) {
                                $vrow['winner'] = 'yes';
                                $v['winner'] = 'no';
                               
                            } else if ($vrow['votes'] == $v['votes']) {
                                
                              
                               $sql13 = "SELECT SUM(videokes_ratings.rating) AS sum_rating FROM videokes_ratings " .
                                 " WHERE videoke_id='" . $vrow['video_id'] . "' ";
                                $sql14 = "SELECT SUM(videokes_ratings.rating) AS sum_rating FROM videokes_ratings " .
                                 " WHERE videoke_id='" . $v['video_id'] . "' ";

                                $rating1_result= $conn->query($sql13);
                                $rating2_result= $conn->query($sql14);

                                $rating1 = array();
                                $rating2 = array();

                                if(count( $rating1_result)>0){
                                     while($rate = mysqli_fetch_array($rating1_result)){
                                        $rating1[] = $rate;
                                        }
                                         
                                        foreach ($rating1 as $idx => $rating){

                                        $video1_rating = intval($rating[0]);

                                        }
                                }else{
                                    $video1_rating = 0;
                                }

                                if(count($rating2_result)>0){

                                    while($rate = mysqli_fetch_array($rating2_result)){
                                        $rating2[] = $rate;
                                     }
                                     foreach ($rating2 as $idx => $rating){
                                
                                         $video2_rating = intval($rating[0]);
                                    } 

                                }else{

                                    $video2_rating = 0;
                                }
                                
                                if ($video1_rating > $video2_rating) {
                                    $vrow['winner'] = 'yes';
                                    $v['winner'] = 'no';
                                   
                                } else if ($video1_rating == $video2_rating) {
                                  
                                    $rnum = rand(0, 1);
                                    
                                    if ($rnum > 0) {
                                        $vrow['winner'] = 'yes';
                                        $v['winner'] = 'no';
                                      
                                    } else {
                                        $vrow['winner'] = 'no';
                                        $v['winner'] = 'yes';
                                    }
                                } else {
                                    $vrow['winner'] = 'no';
                                    $v['winner'] = 'yes';
                                }
                               
                            } else {
                                $vrow['winner'] = 'no';
                                $v['winner'] = 'yes';
                            }
                            
                            if ($vrow['winner'] == 'yes') {
                               
                                 $sql15 = "UPDATE contests_videos SET winner='yes' WHERE id='".$vrow['id']."'";
                                 $conn->query($sql15);

                                 $sql16 = "UPDATE contests_videos SET winner='no' WHERE id='".$v['id']."'";
                                 $conn->query($sql16);

                                            
                                if ($contest['current_round'] <= 4) {
                                    if($contest['current_round'] == 4){
                                         $win = 'yes';
                                    }
                                    else{
                                        $win = 'undetermined';
                                    }
                                    $rnd=intval($contest['current_round']) + 1;  
                                      echo "About to Insert data";          
                                    $sql17 = "INSERT INTO contests_videos (contest_id, video_id, round_id, winner) VALUES ('". $vrow['contest_id']."','".
                                    $vrow['video_id']."','".$rnd."','".$win."')";
                                           
                                    $conn->query($sql17);

                                    $winner_arr[] = array("id" => mysqli_insert_id($conn), "video_id" => $vrow['video_id']);
                                 

                                    if ($contest['current_round'] == 4) {

                                        $sql18 = "UPDATE contests SET winner='".$vrow['video_id']."', status='completed' WHERE id='".$contest['id']."'";
                                        $conn->query($sql18);
                                        
                                        $sql19 = "SELECT * FROM videokes WHERE id ='".$vrow['video_id']."'";
                                        $videoke_result=$conn->query($sql19); 

                                        $videokes = array();

                                        while($video = mysqli_fetch_array($videoke_result)){
                                            $videokes[] = $video;
                                        }

                                        foreach($videokes as $video){
                                             $videoke = $video[0];
                                        }
                                    }
                                }
                                
                            } else {

                                $sql20 = "UPDATE contests_videos SET winner='yes' WHERE id='".$v['id']."'";
                                $conn->query($sql20);
                                
                                $sql21 = "UPDATE contests_videos SET winner='no' WHERE id='".$vrow['id']."'";
                                $conn->query($sql21);
                               
                                if ($contest['current_round'] <= 4) {
                                    if($contest['current_round'] == 4){
                                         $win = 'yes';
                                    }
                                    else{
                                         $win = 'undetermined';
                                    }
                                    $rnd=intval($contest['current_round']) + 1;  

                                    echo "About to Insert data"; 
                                    $sql22 = "INSERT INTO contests_videos (contest_id, video_id, round_id, winner) VALUES ('". $v['contest_id']."','".
                                    $v['video_id']."','".$rnd."','".$win."')";
                                        
                                    echo $sql22;

                                    $conn->query($sql22);

                                    $winner_arr[] = array("id" => mysqli_insert_id($conn), "video_id" => $v['video_id']);

                                    if ($contest['current_round'] == 4) {

                                        $sql23 = "UPDATE contests SET winner='".$v['video_id']."', status='completed' WHERE id='".$contest['id']."'";
                                        $conn->query($sql23);
                                    }
                                }
                            }
                            if (isset($vrow['video_id']))
                                $completed_vids[] = $vrow['video_id'];
                            if (isset($v['video_id']))
                                $completed_vids[] = $v['video_id'];
                        } 
                    }
    
                    if ($contest['current_round'] < 4) {                        
                        shuffle($winner_arr);                       
                        for ($x = 0; $x < count($winner_arr); $x += 2) {
                            if (isset($winner_arr[$x + 1])) {
                                $sql24 = "UPDATE contests_videos SET paired_with='".$winner_arr[$x + 1]['video_id']."' WHERE id='".$winner_arr[$x]['id']."'";
                                $conn->query($sql24);

                                $sql25 = "UPDATE contests_videos SET paired_with='".$winner_arr[$x]['video_id']."' WHERE id='".$winner_arr[$x + 1]['id']."'";
                                $conn->query($sql25);
                            } else {

                                $sql26 = "UPDATE contests_videos SET paired_with='0' WHERE id='".$winner_arr[$x]['id']."'";
                                $conn->query($sql26);
        
                            }
                        }
                    }
                    $rnd = intval($contest['current_round'])+1;
                    $sql27 = "UPDATE contests SET current_round='".$rnd."' WHERE id='".$contest['id']."'";
                    $conn->query($sql27);
                } else {
                    $sql28 = "UPDATE contests SET status='cancelled' WHERE id='".$contest['id']."'";
                    $conn->query($sql28);
                    continue;
                } 
            }
            
    }
$conn->close();

}
?>
