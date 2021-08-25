<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "friends_count" => count($friends), "followers" => $followers, "followers_count" => count($followers))); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>
    <div id="content" class="with-sidebar-left profile">

        <div id="my_contests" class="my-contest-gallery videokes-center contet-box clearfix">
            <div id="submit-video">
                <a>Submit a video to <span class="red">hip hop contest</span> </a>
                <a class="button1 pull-right">Join Contest</a>
                
            </div>
            <div class="clearfix"> </div>
            <?php
            switch ($page_mode) {
                default:
                    ?><h2>Active Contests</h2><?php
                    $link_to = "my_contests/join/:contest_id";
                    $button_text = "Join Contest";

                    $displayed_contest_cnt = 0;
                    //print_r($contests_by_category);
                    ?><div class="items clearfix" style="margin-bottom:10px"><?php
                    if (isset($contests_by_category[1]) && count($contests_by_category[1]) > 0) {
                        ?><div class="item content-box" style="margin:10px">
                                <div style="font-weight:bold;padding-bottom:3px">Singers</div><?php
                                echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[1][0]['id'])), $model_contest->getCategoryImage(1), array("class" => ""));
                                ?><div style="font-size:10px;text-align:center">
                                <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[1][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[2]) && count($contests_by_category[2]) > 0) {
                            ?><div class="item content-box" style="margin:10px">
                                <div style="font-weight:bold;padding-bottom:3px">Rappers</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[2][0]['id'])), $model_contest->getCategoryImage(2), array("class" => "")); ?>

                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[2][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div><?php
                                    ?></div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[3]) && count($contests_by_category[3]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Dancers</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[3][0]['id'])), $model_contest->getCategoryImage(3), array("class" => "")); ?>

                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[3][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?
                            $displayed_contest_cnt++;

                            }

                            if(isset($contests_by_category[4]) && count($contests_by_category[4]) > 0){
                            ?><div class="item content-box" style="margin:10px">
                                <div style="font-weight:bold;padding-bottom:3px">Musicians/Bands</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[4][0]['id'])), $model_contest->getCategoryImage(4), array("class" => "")); ?>

                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[4][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[6]) && count($contests_by_category[6]) > 0) {
                            ?><div class="item content-box" style="margin:10px">
                                <div style="font-weight:bold;padding-bottom:3px">Dj's</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[6][0]['id'])), $model_contest->getCategoryImage(6), array("class" => "")); ?>

                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[6][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[7]) && count($contests_by_category[7]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Lip Sync</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[7][0]['id'])), $model_contest->getCategoryImage(7), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[7][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[8]) && count($contests_by_category[8]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Kids Talent</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[8][0]['id'])), $model_contest->getCategoryImage(8), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[8][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }



                        if (isset($contests_by_category[9]) && count($contests_by_category[9]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Rants &amp; Statements</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[9][0]['id'])), $model_contest->getCategoryImage(9), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[9][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }


                        if (isset($contests_by_category[11]) && count($contests_by_category[11]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Comedians</div>
                                <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[11][0]['id'])), $model_contest->getCategoryImage(11), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[11][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[10]) && count($contests_by_category[10]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Judges</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[10][0]['id'])), $model_contest->getCategoryImage(10), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[10][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if (isset($contests_by_category[5]) && count($contests_by_category[5]) > 0) {
                            ?><div class="item content-box" style="margin:10px">

                                <div style="font-weight:bold;padding-bottom:3px">Spoken Word</div><?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[5][0]['id'])), $model_contest->getCategoryImage(5), array("class" => "")); ?>
                                <div style="font-size:10px;text-align:center">
                                    <?php echo Html::anchor(Router::get($link_to, array("contest_id" => $contests_by_category[5][0]['id'])), $button_text, array("class" => "button rounded-corners")); ?>
                                </div>
                            </div><?php
                            $displayed_contest_cnt++;
                        }

                        if ($displayed_contest_cnt == 0) {
                            ?><br>
                            <i><center>No contests found, that are able to be joined at this time.</center></i><?php
                        }
                        ?></div><?php
                            ///print_r($my_contest_videos);
                            ///print_r($model_contest->filterVideoByRound($my_contest_videos,  ));
                            ?><h2>My Contests</h2>

                    <?php
                    /* <table style="border:0;width:100%">
                      <tr>
                      <th>Contest:</th>
                      <td></td>
                      <th>Current Round:</th>
                      <td></td>
                      </tr>
                      <tr>
                      <th>Category:</th>
                      <td></td>
                      <th>Next Round:</th>
                      <td></td>
                      </tr>
                      </table>
                      <?php * */

                    $contestid_arr = array();

                    foreach ($my_contest_videos as $vid) {

                        if (!in_array($vid['contest_id'], $contestid_arr)) {
                            $contestid_arr[] = $vid['contest_id'];
                        }
                    }


                    // GET ALL THE CONTESTS FOR THE VIDEOS
                    $contest_arr = array();

                    foreach ($contestid_arr as $cid) {

                        $contest_arr[$cid] = $model_contest->getByID($cid);
                    }


                    ///print_r($model_contest->filterVideoByRound($my_contest_videos, $contest_arr ));
                    //print_r($categories);

                    foreach ($contest_arr as $cid => $contest) {

                        $round_time = $contest['start_time'] + ($contest['current_round'] * 604800);
                        ?><table style="border:0">
                            <tr>
                                <td width="150"><div style="font-weight:bold;padding-bottom:3px"><?php echo $contest['name']; ?></div><?php
                                    echo Html::anchor(Router::get($link_to, array("contest_id" => $cid)), $model_contest->getCategoryImage($contest['category_id']), array("class" => ""));
                                    ?></td>
                                <td>
                                    <table style="border:0;width:100%">
                                        <tr>
                                            <th align="right">Category:</th>
                                            <td><?php
                                                echo $categories[$contest['category_id']];
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th align="right">Started:</th>
                                            <td><?php echo date("m/d/Y", $contest['start_time']); ?></td>
                                        </tr>
                                        <tr>
                                            <th align="right">Current Round:</th>
                                            <td><?php
                                                switch ($contest['current_round']) {
                                                    case 0:
                                                        echo "Signup";
                                                        break;
                                                    case 1:
                                                        echo "First Round";
                                                        break;
                                                    case 2:
                                                        echo "Second Round";
                                                        break;
                                                    case 3:
                                                        echo "Final Round";
                                                        break;
                                                    case 4:
                                                        echo "Finished";
                                                        break;
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <th align="right">Next Round:</th>
                                            <td><?php echo date("m/d/Y", $round_time); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top">

                                    <table style="border:0;width:100%">
                                        <tr>
                                            <th >Submissions</th>
                                        </tr><?php
                                        foreach ($my_contest_videos as $vid) {

                                            if ($vid['contest_id'] != $cid || $vid['round_id'] != $contest['current_round'])
                                                continue;
                                            ?><tr>
                                                <td align="center">
                                                    <?php
                                                    echo '#' . $vid['video_id'];
                                                    ?>
                                                </td>
                                            </tr><?php
                                        }
                                        ?></table>
                                </td>
                            </tr>
                        </table><?php
                        //echo "<br />";
                    }
                    ?><h2>My Past Contests</h2><?php
                    $contestid_arr = array();

                    foreach ($my_completed_contest_videos as $vid) {

                        if (!in_array($vid['contest_id'], $contestid_arr)) {
                            $contestid_arr[] = $vid['contest_id'];
                        }
                    }


                    // GET ALL THE CONTESTS FOR THE VIDEOS
                    $contest_arr = array();

                    foreach ($contestid_arr as $cid) {

                        $contest_arr[$cid] = $model_contest->getByID($cid);
                    }


                    ///print_r($model_contest->filterVideoByRound($my_contest_videos, $contest_arr ));
                    //print_r($categories);

                    foreach ($contest_arr as $cid => $contest) {

                        //print_r($contest);
                        ?><table style="border:0">
                            <tr>
                                <td width="150"><div style="font-weight:bold;padding-bottom:3px"><?php echo $contest['name']; ?></div><?php
                                    echo Html::anchor(Router::get($link_to, array("contest_id" => $cid)), $model_contest->getCategoryImage($contest['category_id']), array("class" => ""));
                                    ?></td>
                                <td>
                                    <table style="border:0;width:100%">
                                        <tr>
                                            <th align="right">Category:</th>
                                            <td><?php
                                                echo $categories[$contest['category_id']];
                                                ?></td>
                                        </tr>

                                        <tr>
                                            <th align="right">Contest Ended:</th>
                                            <td><?php
                                                echo date("m/d/Y", $contest['end_time']);
                                                ?></td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table><?php
                    }










                    break;


                case 'joined': ## PAGE 3 - FINISHED JOINING
                    ?><h2>Thank for your submission!</h2>
                    <br />
                    <h4>
                        Thanks for submitting your video! We will be in touch with any updates to let you know if your videoke wins the contest.
                    </h4>


                    <table style="border:0;width:100%">
                        <tr>
                            <td align="center"><?php
                                echo Html::anchor(Router::get("my_contests"), "Submit More", array("class" => "button rounded-corners"));
                                ?></td>
                            <td align="right"><?

                                echo Asset::img("smv_logo.png", array('width'=>325));
                                ?></td>
                        </tr>
                    </table><?php
                    break;

                case 'join':
                    ?><script>

                                function toggleVidCheck(vid) {
                                    if ($('#vidchk-' + vid).prop('checked') == true) {
                                        $('#vidchk-' + vid).prop('checked', false);
                                    } else {
                                        $('#vidchk-' + vid).prop('checked', true);
                                    }

                                }

                    </script>


                    <h3>Join Contest</h3>

                    <?php echo Form::open(array("action" => "my_contests/join/" . $contest['id'], "method" => "post")); ?>

                    <input type="hidden" name="joining_contest" value="<?php echo $contest['id']; ?>">

                    <table style="border:0;width:100%">
                        <tr>
                            <th>Contest Name:</th>
                            <td><?php echo $contest['name'] ?></td>
                            <th>Contest Start:</th>
                            <td><?php echo date("m/d/Y", $contest['start_time']); ?></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td><?php echo $categories[$contest['category_id']] ?></td>
                            <th>Contest Ends:</th>
                            <td><?php echo date("m/d/Y", $contest['end_time']); ?></td>
                        </tr>
                    </table><?php ?><div class="items clearfix" style="margin:10px"><?php
                        $cnt = 0;
                        $skipcnt = 0;

                        if (count($videokes) > 0) {



                            foreach ($videokes as $videoke) {


                                // SEE IF THE VIDEO IS ALREADY ENTERED INTO THIS CONTEST AND SKIP IT
                                foreach ($contest_videos as $vrel) {

                                    if ($vrel['video_id'] == $videoke->id) {
                                        $skipcnt++;
                                        continue 2;
                                    }
                                }
                                ?><div class="item content-box" style="margin:10px">
                                <?php echo Html::anchor("videokes/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT))); ?>
                                    <h3><?php echo Html::anchor("videokes/show/" . $videoke->id, $videoke->title); ?></h3>
                                    <p class="views">Views(<?php echo $videoke->views; ?>) By: <?php echo $videoke->user->username; ?></p>
                                    <br /><br />
                                    <input type="checkbox" name="video_id[]" id="vidchk-<?php echo $videoke->id; ?>" value="<?php echo $videoke->id; ?>" />
                                    <span class="hand" onclick="toggleVidCheck(<?php echo $videoke->id; ?>);
                                            return false">Select Videoke</span>
                                </div><?php
                                $cnt++;
                            }

                            /*                             * ?><div class="pager">
                              <?php echo $pagination; ?>
                              </div><?php* */
                        } else {

// 				echo "<div style=\"width:100%;padding-top:25px;text-align:center;font-style:italic\">".
// 						"You don't appear to have any Videokes in the '".$categories[$contest['category_id']]."' Category".
// 						"</div>";
                        }
                        ?></div>

                    <table style="border:0;width:100%">
                        <tr>
                            <td class="back"><?php
                                echo Html::anchor(Router::get("my_contests"), "Back");
                                ?></td>
                            <td><?php
                                // IF YOU HAVE VIDEOS TO SUBMIT
                                if ($cnt > 0) {

                                    echo Form::submit('', 'Submit', array("class" => "button rounded-corners"));
                                } else {

                                    echo "<i>You don't have any videos in this category to submit";

                                    if ($skipcnt > 0) {

                                        echo ",<br>that haven't already been entered";
                                    }
                                    echo ".</i>";
                                }
                                ?></td>
                        </tr>
                    </table><?php
                    echo Form::close();

                    break;
            }
            ?></div>
    </div>
</div>