<?php  //echo time(); echo "<br>"; echo $contest['start_time']+1800; ?> 
<div id="center" class="container">


    <?php if(count($banners) > 0): ?>
        <div class="header-slider">
            <div id="left">
                <a href="#" data-direction="left"><?php echo Asset::img('left-slide-arrow.png'); ?> </a>
            </div>
            <div id="visible-top-videos">
                <div id="top-videos-items" class="clearfix" data-left="0">
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('slide-image1.png'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "http://www.whereweallmeet.com">--><?php ////echo Asset::img('wwambanner.jpg'); ?><!-- </a>-->
<!--                        <a href = "#">--><?php ////echo Asset::img('hhr1.jpg'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('top100ad.jpg'); ?><!-- </a>-->
<!--                    </div>-->
                    <?php foreach ($banners as $banner) : ?>
                        <div id="main-image">
                            <a href="<?php echo $banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($banner)) ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="right">
                <a href="#" data-direction="right"><?php echo Asset::img('right-slide-arrow.png'); ?> </a>
            </div>
            <div></div>
        </div>
    <?php endif; ?>



   <div class="clearfix"> </div>
    <div id="content" style="margin-top: 30px;">

        <div class="title" id="before-selection">
                <p class="pull-left main-title">HHR <span class="red">CONTEST</span></p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
        </div>

        <div class="title" id="after-selection-hiphop">
            

                <p class="pull-left main-title">HIPHOP <span class="red">CONTEST</span></p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
        </div>

         <div class="title" id="after-selection-model">
                <p class="pull-left main-title">ELITE MODEL <span class="red">CONTEST</span></p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
        </div>

    <div class="clearfix">
   
            <div id ="videos-container">
                <div class="inner-wrapper">
                        <div class="vid-con pull-left">
                            <?php echo Asset::img("contest/hpr-vids.png",array("width" => "250", "height" => "250")); ?>
                            <a class="enter-link" id="hiphop-list" href="#">Enter</a>
                        </div>
                        <div class="model-con pull-left">
                            <?php echo Asset::img("contest/hhr-models.png", array("width" => "250", "height" => "250")); ?>
                            <a class="enter-link" id="model-list"  href="#">Enter</a>
                        </div>
                </div>
            </div>
    </div>

    <div class="clearfix"></div>

            <div class="info">
                    <p>Select Which Contest You Would Like To View above <span class="red">^</span> </p>
            </div>

            <div id="thedivider">
                     <hr class="divider"/>   
            </div>


        
<?php
          

 function renderVideo($current_user, $contest, $render_round = -1, $videoke = null, $this_user = null) {

       // $contest_id = $contest['category_id'];
         $contest_id = $contest['id'];


        // LOAD VIDEO FROM DATABASE
        if ($videoke != null) {

                $video = $videoke['video'][$videoke['video_id']];
            
?>

            <div class="content-box" >
                    <?php
                        $videousername = str_replace(' ', '', $video->user->username );
         
                        $video_url = "/uploads/" . $videousername . "/videokes/" . $video->video . ".mp4";

                        echo '<a href="#" onclick="showVideoInPopup(' . $video->id . ',' . $render_round . ',\'' . $video_url . '\',\'' . (($contest['current_round'] == $render_round && isset($current_user)) ? 'false' : 'true') . '\');return false;">';
        
                        echo View::forge("pages/partials/contest-single-view", array("videoke" => $video));
                    ?>

                <div class="votes-count">

                        <?php
                             list($has_voted, $vote) = Model_Contest::hasVotedAlready($contest_id, $render_round, $videoke['video_id'], $video->user->id);             
                        ?>
                         <!--  <span id="already_voted_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" class="vote-text" 
                                  <?php
                                      if ($has_voted <= 0) {
                                         echo ' class="nod" ';
                                        }
                                    ?>
                                >

                                <hr class="votedivider"/>

                                <?php 
                        
                                    $tvotes=Model_Contest::totalVotes($contest_id, $render_round, $videoke['video_id'], $video->user->id);
                                    
                                ?>

                                <b style="color:black; font-size:10px; ">  TOTAL VOTES: (<?php echo $tvotes; ?>)</b>

                                 </span> -->
                        <?php 
                           if (($contest['current_round'] == $render_round && isset($current_user))) 
                           {
                        ?>

                                <span id="voting_form_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" class="vote-btn" 
                                      <?php
                                            if($has_voted > 0){
                                                echo ' class="nod" ';
                                          }
                                ?>>
                                 
                                        <input type="button" value="VOTE For ME" onclick="voteOnVideo(<?php echo $contest_id ?>,<?php echo $videoke['video_id'] ?>,<?php echo $render_round; ?>, $('#vote_rating-<?php echo $videoke['video_id'] . '-' . $render_round; ?>').val())">
                                   
                                </span>

                                        <?php
                                             }
                                         ?>
                </div>
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
                            
                            list($has_voted, $vote) = Model_Contest::hasVotedAlready($contest_id, $render_round, $videoke['video_id'], $this_user);

                            $current_rating = Model_Contest::getVideoContestVotes($contest_id, $render_round, $videoke['video_id']);

                            if (($contest['current_round'] == $render_round && isset($current_user))) {
                                if ($vote <= 0){ ?>
                                        <span id="voting_form_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" 
                                            <?php
                                                if($has_voted <= 0){
                                                    echo ' class="nod" ';
                                                 }
                                            ?>>                                    
                                             &nbsp;&nbsp;

                                            <input type="button" value="VOTE" onclick="voteOnVideo(<?php echo $videoke['video_id'] ?>,<?php echo $render_round; ?>, $('#vote_rating-<?php echo $videoke['video_id'] . '-' . $render_round; ?>').val())">
                                        
                                        </span>
                                <?php }
                                else{?>
                                        <span id="already_voted_span-<?php echo $videoke['video_id'] . '-' . $render_round; ?>" 
                                
                                             <?php
                                                if ($has_voted > 0) {
                                                    echo ' class="nod" ';
                                                } 
                                             ?>>
                                              You voted for this round and gave this video <?php echo $vote; ?> point.

                                        </span>
                                        <?php
                                    }
                            } ?>
                        </td>
                        <td align="center">

                            Total Points: 
                                <span id="video_total_points-<?php echo $videoke['video_id'] . '-' . $render_round; ?>">
       
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
        } else {?>

            <div class="content-box" ><?php
                    echo Asset::img("contest/unknown.png");
                ?>
                    <br />
                    <span id="membername">To Be Determined</span><br />

                <?php
                /**    <span class="views">Views (0) By: Anonymous</span>
                  <span class="votes">Votes (2,887)</span>
                  <span style="float:right;padding-top:10px">
                  <?php echo Html::anchor("#", "VOTE", array("class" => "button votebutton rounded-corners")); ?>
                  </span>* */
                if ($contest['current_round'] < 1) {
                    ?>
                    <a href="<?php echo Uri::create('users/my_contest').'/'.$current_user->id;?>"><button class="button rounded-corners"> Join Contest! </button></a>

                    <?php //echo Html::anchor(Router::get("my_contests/join/:contest_id", array("contest_id" => $contest_id)), "Join Contest!", array("class" => "button rounded-corners"));
                }
                ?></div><?php
        }
    } // end of function Render




    $button_text = (!$current_user) ? "Join to Vote Now" : "View Contest";
    $base_link_to = (!$current_user) ? "sign_up" : "contest/view/";
    $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);
    $user_vote_arr = array();
    $video_votes_arr = array();


    foreach ($contest_videos as $video_rel) {

        $video_votes_arr[$video_rel['video_id']] = $model_contest->getVideoContestVotes($contest['id'], $contest['current_round'], $video_rel['video_id']);

        if ($current_user) {

            $user_vote_arr[$video_rel['video_id']] = $model_contest->hasVotedAlready($contest['id'], $contest['current_round'], $video_rel['video_id'], $current_user->id);
        
        } else {

            $user_vote_arr[$video_rel['video_id']] = array(0, 0);
        }
    }
?>


 <script>

        var video_votes = new Array();
        var user_vote_arr = new Array();

    <?php
        foreach ($video_votes_arr as $video_id => $votes) {
    ?>
            video_votes[<?php echo $video_id; ?>] = <?php echo intval($votes); ?>;
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

                
        function voteOnVideo(contest_id,video_id, round, rating) {

                    //alert("video: "+video_id+" "+rating);

                    //if (rating == "blank") {
                    //  alert("Select a rating first!");
                    //  return;
                     //  }

                    // AJAX POST THE VOTE
                    //""

            $.ajax({
                type: "POST",
                url: 'index.php?bypass_fuel_mode=1&contest_id='+ contest_id +'&round='+round+'&video_id=' + video_id + '&rating=' + rating,
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

                        $('#already_voted_span-' + video_id + '-' + round).html('You vote and gave this video a point.');
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

        }


</script>






<div id="hiphop-contest-list">
<?php

    if($contest['status']=='active'){

?>
            <p style="color: black; text-align: center;" >
                <b>The deadline to submit videos to this contest ends : 
                
                         <?php $e_time = $contest['start_time']+604800;
                         echo "12:00pm ".date("d.m.Y", $e_time);?>
                </b>
            </p>
    <?php
    }else{

    ?>
             <p style="color: black; text-align: center;" >
                <b>There is no active Hiphop contest running currently.
                
                </b>
             </p>
    <?php
    }

    ?>
              
                    <!--Contest: <?php //echo $contest['name']; ?> -->
                         
                            <!--<span id="roundtext">Round (&nbsp;<?php //echo $contest['current_round'] ?>&nbsp;)</span><br >-->
                <!--    <div style="font-size:12px">
                Next Round: <?php
               // echo date("m/d/Y", $round_time);
                ?>
            </div>-->
    
    <?php
        if ($contest['current_round'] > 1) {

            $x = 0;
    ?>
                            
            <div id="advert-description">

                <p>HIPHOP <span> Contest &nbsp; (round 1)</span> 
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>

                Contest Round Time:
                    <?php $s_time = $contest['start_time']+604800;
                        echo date("d,m, Y", $s_time);
                    ?> - 
                    <?php $e_time = $contest['start_time']+1209600;
                        echo date("d,m,Y", $e_time);
                    ?>

            </div>
                
            <table style="border:0px; width:960px; margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php

                                    if (isset($round[2][$x][0])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x][0], $this_user);
                                    } else {

                                        echo "No partner.";
                                    }
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?>
                                </td>
                                <td align="center" >
                                    <?php
                                    if (isset($round[2][$x][1])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x++][1], $this_user);
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
                                    if (isset($round[2][$x][0])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x][0], $this_user);
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
                                    if (isset($round[2][$x][1])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x++][1], $this_user);
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
                                    if (isset($round[2][$x][0])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x][0], $this_user);
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
                                    if (isset($round[2][$x][1])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x++][1], $this_user);
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
                                    if (isset($round[2][$x][0])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x][0], $this_user);
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
                                    if (isset($round[2][$x][1])) {

                                        renderVideo($current_user, $contest, 2, $round[2][$x++][1], $this_user);
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


        
            <?php
            //print_r($round[2]);exit;


            $x = 0;
            ?>

                                                        <!--<h2><span>hip hop contest <p>(round 2)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
    <div id="advert-description">
            <p>HIPHOP <span> Contest &nbsp; (round 2)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
            </p>
            Contest Round Time:
                <?php $s_time = $contest['start_time']+1209600;
                   echo date("d,m, Y", $s_time);
                 ?> - 
                <?php $e_time = $contest['start_time']+1814400;
                    echo date("d,m,Y", $e_time);
                ?>
    </div>
            <table style="border:0px;width:100%;  margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 3) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[3][$x][0])) {

                                            renderVideo($current_user, $contest, 3, $round[3][$x][0], $this_user);
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

                                            renderVideo($current_user, $contest, 3, $round[3][$x++][1], $this_user);
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
                                    if ($contest['current_round'] < 3) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[3][$x][0])) {

                                            renderVideo($current_user, $contest, 3, $round[3][$x][0], $this_user);
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

                                            renderVideo($current_user, $contest, 3, $round[3][$x++][1], $this_user);
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
                <p>HIPHOP <span> Contest &nbsp; (round 3)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
                 Contest Round Time:
                <?php $s_time = $contest['start_time']+1814400;
                   echo date("d,m, Y", $s_time);
                 ?> - 
                <?php $e_time = $contest['start_time']+2419200;
                    echo date("d,m,Y", $e_time);
                ?>

            </div>
            <table style="border:0px;width:550px;  margin: 0 auto 40px;">
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

                                            renderVideo($current_user, $contest, 4, $round[4][$x][0], $this_user);
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
                                    if ($contest['current_round'] < 4) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[4][$x][1])) {

                                            renderVideo($current_user, $contest, 4, $round[4][$x++][1], $this_user);
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
                <p>HIPHOP <span> Contest &nbsp; (round 4)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
                 Contest Round Time:
                <?php $s_time = $contest['start_time']+2419200;
                   echo date("d,m, Y", $s_time);
                 ?> - 
                <?php $e_time = $contest['end_time'];
                    echo date("d,m,Y", $e_time);
                ?>
            </div>
            <table style="border:0px;width:250px;  margin: 0 auto 40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table width="100%" align="center" style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest['current_round'] < 5) {

                                        renderVideo($current_user, $contest);
                                    } else {
                                        if (isset($round[5][$x][0])) {
                                            echo "<p><b>The Winner Video for this Contest is </b> </p> </br>";
                                            renderVideo($current_user, $contest, 19934734, $round[5][$x][0], $this_user);
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
                <p>HIPHOP <span> Contest</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;  margin-bottom:40px;">
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
                <p>HIPHOP <span> Contest</span>
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
                <p>HIPHOP <span> Contest</span>
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
                <p>HIPHOP <span> Contest</span>
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
          ?>



            </div>


     <div id="model-contest-list" >

        <?php
     if($contest1['status']=='active'){

     ?>
        <p style="color: black; text-align: center;" >
                <b>The deadline to submit videos to this contest ends : 
                
                <?php $e_time = $contest1['start_time']+604800;
                    echo "12:00pm ".date("d.m.Y", $e_time);
                ?>
              </b>
        </p>
        <?php
    }else{

    ?>
        <p style="color: black; text-align: center;" >
                <b>There is no active Model contest running currently.
                
              </b>
        </p>
    <?php
    }

        ?>

                <!--    <h2>
                    Contest: <?php //echo $contest1['name']; ?>
                         &nbsp;&nbsp;
                            <span id="roundtext">Round (&nbsp;<?php// echo $contest1['current_round'] ?>&nbsp;)</span><br >
                    <div style="font-size:12px">
                Next Round: <?php
               // echo date("m/d/Y", $round_time);
                ?>
            </div>-->
    
        <?php
        if ($contest1['current_round'] > 1) {

            $x = 0;
            ?>
                            
            <div id="advert-description">
                <p>MODEL ELITE <span> Contest &nbsp; (round 1)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
                
                <table style="border:0px; width:960px;  margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php

                                    if (isset($round1[2][$x][0])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x][0], $this_user);
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
                                    if (isset($round1[2][$x][1])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x++][1], $this_user);
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
                                    if (isset($round1[2][$x][0])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x][0], $this_user);
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
                                    if (isset($round1[2][$x][1])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x++][1], $this_user);
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
                                    if (isset($round1[2][$x][0])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x][0], $this_user);
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
                                    if (isset($round1[2][$x][1])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x++][1], $this_user);
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
                                    if (isset($round1[2][$x][0])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x][0], $this_user);
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
                                    if (isset($round1[2][$x][1])) {

                                        renderVideo($current_user, $contest1, 2, $round1[2][$x++][1], $this_user);
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


        
            <?php
            //print_r($round[2]);exit;


            $x = 0;
            ?>

                                                        <!--<h2><span>hip hop contest <p>(round 2)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>MODEL ELITE <span> Contest &nbsp; (round 2)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;  margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest1['current_round'] < 3) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[3][$x][0])) {

                                            renderVideo($current_user, $contest1, 3, $round1[3][$x][0], $this_user);
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
                                    if ($contest1['current_round'] < 3) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[3][$x][1])) {

                                            renderVideo($current_user, $contest1, 3, $round1[3][$x++][1], $this_user);
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
                                    if ($contest1['current_round'] < 3) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[3][$x][0])) {

                                            renderVideo($current_user, $contest1, 3, $round1[3][$x][0], $this_user);
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
                                    if ($contest1['current_round'] < 3) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[3][$x][1])) {

                                            renderVideo($current_user, $contest1, 3, $round1[3][$x++][1], $this_user);
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
                <p>MODEL ELITE <span> Contest &nbsp; (round 3)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%; margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table width="100%" align="center" style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest1['current_round'] < 4) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[4][$x][0])) {

                                            renderVideo($current_user, $contest1, 4, $round1[4][$x][0], $this_user);
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
                                    if ($contest1['current_round'] < 4) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[4][$x][1])) {

                                            renderVideo($current_user, $contest1, 4, $round1[4][$x++][1], $this_user);
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
                <p>MODEL ELITE <span> Contest &nbsp; (round 4)</span>
                    <ins>HHR - The <span>New</span> place for <span>Hip Hop</span></ins>
                </p>
            </div>
            <table style="border:0px;width:100%;  margin-bottom:40px;">
                <tr>
                    <td align="center"  class="graybox">

                        <table width="100%" align="center" style="text-align:center;border:0px;margin:8px">
                            <tr valign="middle">
                                <td align="center">
                                    <?php
                                    if ($contest1['current_round'] < 5) {

                                        renderVideo($current_user, $contest1);
                                    } else {
                                        if (isset($round1[5][$x][0])) {

                                            echo "<p><b>The Winner Video for this Contest is </b> </p></br>";

                                            renderVideo($current_user, $contest1, 19934734, $round1[4][$x][0], $this_user);
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
                <p>MODEL ELITE <span> Contest</span>
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
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
                <p>MODEL ELITE <span> Contest</span>
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                            </tr>
                        </table>


                    </td>

                </tr>
            </table>


                                                        <!--<h2><span>hip hop contest <p>(round 3)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>MODEL ELITE <span> Contest</span>
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                                <td align="center" id="vspng"><?php
                                    echo Asset::img("vs.png");
                                    ?></td>
                                <td align="center" >
                                    <?php
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>


                                                        <!--<h2><span>hip hop contest <p>(round 4)</p></span><div class="text-right">HHR - The <div class="red">New</div> place for <div class="red">Hip Hop</div></div></h2>-->
            <div id="advert-description">
                <p>MODEL ELITE <span> Contest</span>
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
                                    renderVideo($current_user, $contest1);
                                    ?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table><?php
        }
          ?>



            </div>








 </div>
 </div>