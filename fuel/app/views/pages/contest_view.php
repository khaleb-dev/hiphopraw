<div id="center" class="container">
    <div class="header-slider" style="background-color:#f1f1f1">

        <div id="left">
            <a href="#" data-direction="left"><?php echo Asset::img('left-slide-arrow.png'); ?> </a>
        </div>
        <div id="visible-top-videos">
            <div id="top-videos-items" class="clearfix" data-left="0">
                <div id="main-image">
                    <a href = "#"><?php echo Asset::img('slide-image1.png'); ?> </a>
                </div>
                <div id="main-image">
                    <a href = "http://www.whereweallmeet.com"><?php echo Asset::img('wwambanner.jpg'); ?> </a>
                    <a href = "#"><?php echo Asset::img('hhr1.jpg'); ?> </a>
                </div>
                <div id="main-image">
                    <a href = "#"><?php echo Asset::img('top100ad.jpg'); ?> </a>
                </div>
            </div>
        </div>
        <div id="right">
            <a href="#" data-direction="right"><?php echo Asset::img('right-slide-arrow.png'); ?> </a>
        </div>
        <div></div>
    </div>
    <?php

    /**
     * CONTEST VIEW
     *
     * ***
     * Variables populated from the controller:
     *
     * $model_contest	MODEL   Database interface to contests table
     * 							Example: $row = $model_contest->getByID($contest_id);
     *
     * $contests		ARRAY	array of all contests, old or new
     * 							Example: $contests[0]['id']  $contests[0]['name'] etcetc
     *
     * $contests_by_category	A complex sorted array of all contests, by category	///print_r($contests_by_category);
     * 							Example: $contests_by_category[CATEGORY ID][ARRAY INDEX 0+]['id']
     *
     * $contest			ARRAY	A database row containing the currently selected contest information
     * 							Example: $contest['name']
     *
     * */
    function renderVideo($current_user, $contest, $render_round = -1, $videoke = null) {

        $contest_id = $contest['id'];


        // LOAD VIDEO FROM DATABASE
        if ($videoke != null) {

            $video = $videoke['video'][$videoke['video_id']];
            // FIND IN VIDEO ARRAY!
            //contest_videos
            //echo "In progress";
            //$v = $videoke['video']->as_object();
            //print_r($videoke);return;
            ?><div class="content-box" >
            <?php
//            print_r($videoke);exit;
            ///print_r($videoke);
            //$video->id
            //"http://".$_SERVER['SERVER_NAME'].
            // The ../ is because of /contest/ folder
            $video_url = "/uploads/" . $video->user->username . "/videokes/" . $video->video . ".mp4";



            echo '<a href="#" onclick="showVideoInPopup(' . $video->id . ',' . $render_round . ',\'' . $video_url . '\',\'' . (($contest['current_round'] == $render_round && isset($current_user)) ? 'false' : 'true') . '\');return false;">';


            //echo Html::anchor("videokes/show/" . $video->id,
//            echo Html::img($video->get_picture($video->user, Model_Videoke::THUMB_CONTENT));
            echo View::forge("pages/partials/contest-single-view", array("videoke" => $video));
            ?>
                <div class="votes-count"><?php
                    list($has_voted, $vote) = Model_Contest::hasVotedAlready($contest_id, $render_round, $videoke['video_id'], $video->user->id);             
                    ?>
                    <span id="already_voted_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" class="vote-text"
                    <?php
                    if ($has_voted <= 0) {
                        echo 'class="nod" ';
                    }
                    ?>  >
                        
                            Total Votes: <?php echo $vote; ?>
                        </span>
                        <?php if (($contest['current_round'] == $render_round && isset($current_user))) {
                            ?><span id="voting_form_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" class="vote-btn" 
                            <?php
                                  if($has_voted > 0){
                                  echo 'class="nod" ';
                                  }
                                  ?>>
                                  <input type="button" value="VOTE" onclick="voteOnVideo(<?php echo $videoke['video_id'] ?>,<?php echo $render_round; ?>, $('#vote_rating-<?php echo $videoke['video_id'] . '-' . $render_round; ?>').val())">
                            </span><?php ?>

                            <?php
                        }
                        ?></div>
            </div>
            <div  id="view_video_dialog_<?php echo $videoke['video_id'] . '-' . $render_round; ?>" title="View Video" class="nod">

                <table border="0" width="100%" height="100%">
                    <tr valign="top">
                        <td align="center" colspan="2">



                            <div class="flowplayer first-frame"
                                 data-swf="player/flowplayer.swf"
                                 data-key="$400714113257224"
                                 data-logo="http://www.hiphopraw.com/assets/img/hhr-logo-large.png">

                                <video preload="none" width="700" height="393" controls poster="<?php
                                       echo $video->get_picture($video->user, Model_Videoke::THUMB_HOME);
                                       ?>" >
                                    <source src="<?php echo $video_url; ?>" type='video/mp4' />
                                </video>

                            </div>



                        </td>
                    </tr>
                    <tr>
                        <td align="center"><?php
                            ////'+((user_vote_arr[video_id][0] > 0)?' class="nod" ':'')+'>'+
                            /////+((user_vote_arr[video_id][0] <= 0)?' class="nod" ':'')+'>'+
                            // CHECK IF USER HAS VOTED
                            // CHECK IF THEY VOTED ON THIS VIDEO FOR THIS CONTEST, IN THIS ROUND
                            list($has_voted, $vote) = Model_Contest::hasVotedAlready($contest_id, $render_round, $videoke['video_id'], $video->user->id);

                            $current_rating = Model_Contest::getVideoContestVotes($contest_id, $render_round, $videoke['video_id']);

                            if (($contest['current_round'] == $render_round && isset($current_user))) {
                                ?><span id="voting_form_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" <?

                                      if($has_voted > 0){
                                      echo ' class="nod" ';
                                      }

                                      ?>>
                                      <select id="vote_rating-<?php echo $videoke['video_id'] . '-' . $render_round; ?>">
                                        <option value="blank">[Vote on Video]</option>
                                        <option value="2">LOVE IT (+2 pts)</option>
                                        <option value="1">Like it (+1 pts)</option>
                                        <option value="0">It\'s Okay (0 pts)</option>
                                        <option value="-1">Dislike it (-1 pts)</option>
                                        <option value="-2">HATE IT (-2)</option>
                                    </select>

                                    &nbsp;&nbsp;
                                    <input type="button" value="VOTE" onclick="voteOnVideo(<?php echo $videoke['video_id'] ?>,<?php echo $render_round; ?>, $('#vote_rating-<?php echo $videoke['video_id'] . '-' . $render_round; ?>').val())">
                                </span><?php ?><span id="already_voted_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" <?php
                                if ($has_voted <= 0) {
                                    echo ' class="nod" ';
                                }
                                ?>>

                                    You voted and gave this video <?php echo $vote; ?> points.

                                </span><?php
                            }
                            ?></td>
                        <td align="center">

                            Total Points: <span id="video_total_points-<?php echo $videoke['video_id'] . '-' . $render_round; ?>">
        <?php echo number_format($current_rating); ?>
                            </span>
                        </td>
                    </tr>
                </table>


            </div>
            <script>

                $(document).ready(function() {

                    $("#view_video_dialog_<?php echo $videoke['video_id'] . '-' . $render_round; ?>").dialog({
                        autoOpen: false,
                        width: 750,
                        height: 500,
                        modal: true,
                        draggable: true,
                        resizable: true
                    });


                });
            </script>
            <?php
        } else {
            ?><div class="content-box" ><?php
                echo Asset::img("contest/unknown.png");
                ?><br />
                <span id="membername">To Be Determined</span><br />



                <?php
                /** 	<span class="views">Views (0) By: Anonymous</span>
                  <span class="votes">Votes (2,887)</span>
                  <span style="float:right;padding-top:10px">
                  <?php echo Html::anchor("#", "VOTE", array("class" => "button votebutton rounded-corners")); ?>
                  </span>* */
                if ($contest['current_round'] < 1) {

                    echo Html::anchor(Router::get("my_contests/join/:contest_id", array("contest_id" => $contest_id)), "Join Contest!", array("class" => "button rounded-corners"));
                }
                ?></div><?php
        }
    }

    $button_text = (!$current_user) ? "Join to Vote Now" : "View Contest";
    $base_link_to = (!$current_user) ? "sign_up" : "contest/view/";

##print_r($contest);
##print_r($videos);

    $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);



//print_r( $current_user);exit;
//echo $current_user->id;exit;

    $user_vote_arr = array();

    $video_votes_arr = array();

//print_r($contest_videos);
    foreach ($contest_videos as $video_rel) {

        $video_votes_arr[$video_rel['video_id']] = $model_contest->getVideoContestVotes($contest['id'], $contest['current_round'], $video_rel['video_id']);

        if ($current_user) {

            $user_vote_arr[$video_rel['video_id']] = $model_contest->hasVotedAlready($contest['id'], $contest['current_round'], $video_rel['video_id'], $current_user->id);
        } else {
            $user_vote_arr[$video_rel['video_id']] = array(0, 0);
        }
    }


//print_r($user_vote_arr);
    ?>
    <script>

        var video_votes = new Array();
        var user_vote_arr = new Array();
<?php
foreach ($video_votes_arr as $video_id => $votes) {
    ?>video_votes[<?php echo $video_id; ?>] = <?php echo intval($votes); ?>;
    <?php
}

foreach ($user_vote_arr as $video_id => $arr) {
    ?>
            user_vote_arr[<?php echo $video_id; ?>] = new Array();
            user_vote_arr[<?php echo $video_id; ?>][0] = <?php echo $arr[0]; ?>;
            user_vote_arr[<?php echo $video_id; ?>][1] = <?php echo $arr[1]; ?>;
    <?php
}
?>



        function voteOnVideo(video_id, round, rating) {

            //alert("video: "+video_id+" "+rating);

            if (rating == "blank") {
                alert("Select a rating first!");
                return;
            }


            // AJAX POST THE VOTE
            //""

            $.ajax({
                type: "POST",
                url: 'index.php?bypass_fuel_mode=1&contest_id=<?php echo $contest['id']; ?>&round=<?php echo $contest['current_round'] ?>&video_id=' + video_id + '&rating=' + rating,
                error: function() {

                    alert("Error saving data. Please contact support.");
                },
                success: function(msg) {


                    //alert(msg);

                    // PARSE RESPONSE
                    var arr = msg.split(":", 4);

                    // arr[0] IS THE SUCCESS/FAILURE TO VOTE STATUS (1 = success, anything else is failure)
                    // arr[1] IS CURRENT RATING OF VIDEO (OR RATING AFTER VOTING)
                    // arr[2] IS "Error" or "Success", FOR VOTING STATUS
                    // arr[3] IS THE VERBOSE ERROR OR SUCCESS MESSAGE

                    //alert(arr[0]+" - "+arr[1]+" - "+arr[2]+" - "+arr[3]);

                    // SUCCESS
                    if (arr[0] == 1) {
                        // ALERT THE SUCCESS AND STATUS
                        alert(arr[2] + "! " + arr[3]);

                    } else {

                        alert(arr[2] + "! " + arr[3]);

                    }

                    // POPULATE video_total_points WITH NEW VALUE (arr[1])

                    user_vote_arr[video_id][0] = 1;
                    user_vote_arr[video_id][1] = rating;
                    video_votes[video_id] = arr[1];


                    if (arr[0] == 1) {
                        // HIDE VOTE PANEL
                        $('#voting_form_span-' + video_id + '-' + round).hide();


                        // UPDATE AND SHOW MY VOTE

                        $('#already_voted_span-' + video_id + '-' + round).html('You voted and gave this video ' + user_vote_arr[video_id][1] + ' points.');
                        $('#already_voted_span-' + video_id + '-' + round).show();
                    }


                    $('#video_total_points-' + video_id + '-' + round).html(arr[1]);
                }
            });


        }

        function showVideoInPopup(video_id, round, video_url, skip_voting) {

            //view_video_dialog_
            var objname = 'view_video_dialog_' + video_id + '-' + round;

            $('#' + objname).dialog("open");



            /**var html =
             '<table border="0" width="100%" height="100%">'+
             '<tr valign="top"><td align="center" colspan="2">'+
             
             '<div class="flowplayer first-frame" data-swf="player/flowplayer.swf"
             data-key="$400714113257224"
             data-logo="http://www.hiphopraw.com/assets/img/hhr-logo-large.png">'+
             '<video preload="none" width="622" height="375" controls autoplay >'+
             '<source src="'+video_url+'" type="video/mp4" />'+
             '</video>'+
             '</div>'+
             '</td></tr>'+
             '<tr><td align="center">'+
             
             ((skip_voting != 'true')?
             '<span id="voting_form_span" '+((user_vote_arr[video_id][0] > 0)?' class="nod" ':'')+'>'+
             '<select id="vote_rating">'+
             '<option value="blank">[Vote on Video]</option>'+
             '<option value="2">LOVE IT (+2 pts)</option>'+
             '<option value="1">Like it (+1 pts)</option>'+
             '<option value="0">It\'s Okay (0 pts)</option>'+
             '<option value="-1">Dislike it (-1 pts)</option>'+
             '<option value="-2">HATE IT (-2)</option>'+
             '</select>'+
             
             '&nbsp;&nbsp;<input type="button" value="VOTE" onclick="voteOnVideo('+video_id+', $(\'#vote_rating\').val())">'+
             '</span>':
             ''
             )+
             '<span id="already_voted_span" '+((user_vote_arr[video_id][0] <= 0)?' class="nod" ':'')+'>'+
             
             'You voted and gave this video '+user_vote_arr[video_id][1]+' points.'+
             
             '</span>'+
             '</td>'+
             '<td align="center">'+
             
             'Total Points: <span id="video_total_points">'+video_votes[video_id]+'</span>'+
             
             
             
             '</td>'+
             '</tr>'+
             '</table>';
             
             
             $('#'+objname).html(html);
             ****/


            //var player;
            //setTimeout('player = flowplayer();alert(player);', 1000);


            // 					var player = flowplayer(
            // 						    "flowplayer", "http://releases.flowplayer.org/swf/flowplayer-3.2.16.swf", video_url
            // 						);

            //alert(player);

            //var player = flowplayer('flowplayer');

            //  					var player = $(".flowplayer:first").data("flowplayer");
            //alert(player);

            //  					player.unload();

            //  					player.load(video_url);

            //player.play();
            // 				    player.bind("resume", function(){
            // 				        var view_counted = $("#videoke-info").data("view-counted");

            // 				        if(view_counted === false){
            // 				            var vid = $("#videoke-info").data("videoke-id");
            // 				            var url = $("#videoke-info").data("update-count");
            // 				            var attr = $("#videoke-info").data("attr");
            // 				            var to_update = $("#videoke-info").data("to-update");

            // 				            $("#videoke-info").data("view-counted", "true");

            // 				            $.post(url, {id: vid, attr: attr}, function(data) {
            // 				                if (data.status) {
            // 				                    $(to_update).html(data.count);
            // 				                }
            // 				            }, 'json');
            // 				        }

            // 				        return true;
            // 				    });




            //
            //  alert(video_url);

            //  alert(player.
        }




    </script>

    <div class="clearfix"></div>
    <div id="content">
        <h2>
            Contest: <?php echo $contest['name']; ?>
            &nbsp;&nbsp;
            <span id="roundtext">Round (&nbsp;<?php echo $contest['current_round'] ?>&nbsp;)</span><br >
            <div style="font-size:12px">
                Next Round: <?php
                echo date("m/d/Y", $round_time);
                ?>
            </div>
        </h2>

        <?php
        if ($contest['current_round'] > 0) {

            #print_r($round);exit;

            $x = 0;


            //print_r($round[1]);exit;
            ?>
                            <!--<h2><span>hip hop contest <p>(round 1)</p></span></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest &nbsp; (round 1)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>


            <table style="border:0px; width:960px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php

                                    if (isset($round[1][$x][0])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x][0]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                                                
                                    if (isset($round[1][$x][1])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x++][1]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:40px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if (isset($round[1][$x][0])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x][0]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if (isset($round[1][$x][1])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x++][1]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if (isset($round[1][$x][0])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x][0]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if (isset($round[1][$x][1])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x++][1]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:40px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if (isset($round[1][$x][0])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x][0]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if (isset($round[1][$x][1])) {

                                        renderVideo($current_user, $contest, 1, $round[1][$x++][1]);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
            </table>





            <hr />
            <?php
            //print_r($round[2]);exit;


            $x = 0;
            ?>

                                                        <!--<h2><span>hip hop contest <p>(round 2)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest &nbsp; (round 2)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 2) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[2][$x][0])) {

                                            renderVideo($current_user, $contest, 2, $round[2][$x][0]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if ($contest['current_round'] < 2) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[2][$x][1])) {

                                            renderVideo($current_user, $contest, 2, $round[2][$x++][1]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:60px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 2) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[2][$x][0])) {

                                            renderVideo($current_user, $contest, 2, $round[2][$x][0]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if ($contest['current_round'] < 2) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[2][$x][1])) {

                                            renderVideo($current_user, $contest, 2, $round[2][$x++][1]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
            </table>

            <?php
            $x = 0;
            ?>
                                                        <!--<h2><span>hip hop contest <p>(round 3)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest &nbsp; (round 3)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;">
                <tr>
                    <td align="center"  class="graybox">

                        <table width="100%" align="center" style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 3) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[3][$x][0])) {

                                            renderVideo($current_user, $contest, 3, $round[3][$x][0]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    if ($contest['current_round'] < 3) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[3][$x][1])) {

                                            renderVideo($current_user, $contest, 3, $round[3][$x++][1]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>



            <?php
            $x = 0;
            ?>
                                                        <!--<h2><span>hip hop contest <p>(round 4)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest &nbsp; (round 4)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;">
                <tr>
                    <td align="center"  class="graybox">

                        <table width="100%" align="center" style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 4) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[4][$x][0])) {

                                            renderVideo($current_user, $contest, 19934734, $round[4][$x][0]);
                                        } else {

                                            echo "No partner.";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php
        } else {
            ?>
            <!--<h2><span>hip hop contest <p>(round 1)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:60px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:60px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
            </table>





            <hr />

                                                        <!--<h2><span>hip hop contest <p>(round 2)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width:60px">&nbsp;</td>
                    <td align="center" class="graybox">


                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
            </table>


                                                        <!--<h2><span>hip hop contest <p>(round 3)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>

            <table style="border:0px;" align="center" >
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>


                                                        <!--<h2><span>hip hop contest <p>(round 4)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>HHR <span>RAW Contest</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;" align="center" >
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    renderVideo($current_user, $contest);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table><?php
        }

        // ROUND ZERO
        /*         * }else{


          ?>Contest open to new contestants!<br />
          <?php

          echo Html::anchor(Router::get("my_contests/join/:contest_id", array("contest_id"=>$contest['id'])), "Join Contest!", array("class" => "button rounded-corners"));

          ##echo Html::anchor(Router::get("my_contests/join/:contest_id", array("contest_id"=>$contest['id']), "Join Contest!", array("class" => "button rounded-corners")));


          }* */
        ?>
        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
