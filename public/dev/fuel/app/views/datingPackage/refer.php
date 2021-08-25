<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>



    <div id="middle">
        <section id="detailed-dating-package-section">

            <?php $datingpackages = Model_Datingpackage::get_dating_package($id); ?>
            <?php
            if ($datingpackages !== false):
                foreach ($datingpackages as $datingpackage):
                    ?>
                    <div id="package"> <h2>Dating Package</h2></div>
                    <div id="detailed-dating-package">
                        <?php
                        if (empty($datingpackage['picture'])):
                            ?>
                            <?php echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                            <?php
                        else:
                            ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $datingpackage['picture'] ?>" />
                        <?php
                        endif;
                        ?>
                        <div id="top">
                            <?php
                            //the following code converts mysql date format which is yyyy-mm-dd to the desired formats
                            $event_date = $datingpackage['event_date'];
                            // converts the date to time and format it as January 03, 2014
                            $event_date = date('M d, Y', strtotime($event_date));
                            // returns the day as Monday 
                            $event_day = $day = date('l', strtotime($event_date));
                            // converts the time to php time
                            $time_from = strtotime($datingpackage['time_from']);
                            $time_to = strtotime($datingpackage['time_to']);

                            $event_end_date = date('M d, Y', strtotime($datingpackage['event_end_date']));
                            $event_end_day = date('l', strtotime($datingpackage['event_end_date']));
                            $event_end_text = strtotime($datingpackage['event_end_date']) ? " - $event_end_day, $event_end_date" : "";
                            ?>
                            <div id="title">
                                <?php echo ucfirst($datingpackage['title']); ?> 
                            </div>
                            <h3> <?php echo "$event_day, $event_date" . $event_end_text ?> </h3>
                            <p><strong> Time:  <?php echo date("h:i A.", $time_from) . " - " . date("h:i A.", $time_to) . " | @ " . $datingpackage['event_venue'] . ", " . $datingpackage['city'] . " " . $datingpackage['state'] ?> </strong> </p>  
                            <p class="dating-package-description"> <?php echo $datingpackage['short_description'] ?></p>
                        </div>

                    </div>

                    <?php
                endforeach;
                ?>
            </section>


            <section id="detailed-dating-package-section">
                <?php echo Form::open(array('action' => 'datingPackage/invite_a_friend/' . $datingpackage['id'], 'method' => 'Post', 'enctype' => 'multipart/form-data')); ?>

                <div id="schedule"><h2> Schedule your dating package </h2></div>
                <div id="detailed-dating-package">
                    <div id="schedule-left">

                        <p>
                            <label class="checkin-time-label" for="checkin_time">Booking Time:</label></br>
                            <select class="checkin-time" name="checkin_time" required >
                                <?php
                                $time_from = strtotime($datingpackage['time_from']);
                                $time_to = strtotime($datingpackage['time_to']);
                                if ($time_from > $time_to):
                                    //when the dating package moves to the next day after midnight
                                    for ($i = $time_from; $i < $time_to + 86400; $i+=1800):
                                        ?><option>
                                            <?php
                                            $endTime = date("h:i A.", $i);
                                            //$i=$endTime;
                                            echo ($endTime);
                                            ?></option>
                                        <?php
                                    endfor;
                                else:
                                    //when the dating package finishes in a single day
                                    for ($i = $time_from; $i < $time_to; $i+=1800):
                                        ?><option>
                                                <?php
                                                $endTime = date("h:i A.", $i);
                                                //$i=$endTime;
                                                echo ($endTime);
                                                ?></option>
                                        <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                        </p> 
                        <p class="description-label">
                            Dating Package Information:
                        </p>
                        <p class="description">
                            <?php echo $datingpackage['long_description']; ?>
                        </p>

                        <div id="send-invitation-button">
                            <a href="#invite">Send Invite</a>
                        </div>

                        <div class="price">
                            <?php echo "Price: $" . number_format($datingpackage['price'], 2) ?>
                        </div>

                    </div>

                    <div id="schedule-right">
                        <div id="datepicker" ></div>
                        <input type="hidden" name="checkin_date"  />
                        <div id="book-me-link">
                            <?php $url = strpos($datingpackage['url'], '://') == false ? 'http://' . $datingpackage['url'] : $datingpackage['url']; ?>
                            <a href="<?php echo $url; ?>" target="_blank">Book Me!</a>
                        </div>
                    </div>

                    <div id="invite">
                        <section id ="invitation-dialog">

                            <header>
                                DATE REQUEST INVITATION   <a href="#close" title="Close" class="back">X</a> 
                            </header>

                            <div class="invite-content">

                                <?php
                                foreach ($datingpackages as $datingpackage):
                                    ?>
                                    <div id="picture">
                                        <?php
                                        if (empty($datingpackage['picture'])):
                                            ?>
                                            <?php echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                                            <?php
                                        else:
                                            ?>
                                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $datingpackage['picture'] ?>" />
                                        <?php
                                        endif;
                                        ?>
                                        <div id="title">
                                            <strong><small><?php echo $datingpackage['title'] ?> </small></strong>
                                        </div>
                                        <div id="short-description" >
                                            <?php echo ucfirst(\Fuel\Core\Str::truncate(ucfirst($datingpackage['long_description']), 400)) ?>
                                            <hr class="hr-line">
                                        </div>
                                        <input type="hidden" name="dp_checkin_date" value="<?php echo $datingpackage['event_date'] ?>">
                                    </div>
                                    <?php
                                endforeach;
                                ?>
                            </div>
                            <div class="invite-form">
                                <h2>Invite a Friend to this Date </h2>

                                <select class="invite-name" name="to_member_id" required >
                                    <option></option>
                                    <?php
                                    $friend_list = Model_Friendship::get_friends($current_profile->id);
                                    if (($friend_list !== false)):
                                        foreach ($friend_list as $friend):
                                            ?>

                                            <option value= <?php echo $friend['id']; ?> > <?php echo ucfirst($friend['first_name']) . "&nbsp" . ucfirst($friend['last_name']); ?></option>
                                            <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </select>

                                <input  class="invite-button" type="submit" name="invite" value="Send Date Invite" > 
                                <a href="#close" title="Close" class="back">X</a>
                            </div>
                        </section>

                    </div> 
                    <?php echo Form::close(); ?>
                </div>
            </section>

            <?php
        else:
            ?>

            <section id="detailed-dating-package-none">
                No featured dating package found from your location.
            </section>
            </section>
        <?php
        endif;
        ?>


        <section id="detailed-dating-package-section">
            <div id="refere"> <h2>Refer A Friend</div>
            </h2>
            <div id="detailed-dating-package">
                <?php
                if ($datingpackages !== false):
                    foreach ($datingpackages as $datingpackage):
                        ?>
                        <?php
                        echo Form::open(array('action' => 'datingPackage/refer_a_friend/' . $datingpackage['id'], 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                        ?> 

                        <p>
                            <label class="form-label" for="email">Email:</label><br />
                            <input class="inputbox-email" id="email" type="email" name="email" required> 
                        </p>
                        <p>
                            <label class="form-label" for="message">Message:</label><br />
                            <textarea class="inputbox-message" id="message" name="message" cols="130"></textarea>
                        </p>
                        <p>

                        <p class="search-para"> 
                            <input  class="button" type="submit" name="invite" value="Refer a Friend Now!" > 
                        <p>
                            <?php echo Form::close(); ?>
                            <?php
                        endforeach;
                    endif;
                    ?>
            </div> 
        </section>
    </div>



</div>

</div>

<script>

    $(function() {
        var event_date = new Date("<?php echo date("F d, Y G:i:s", strtotime($datingpackage['event_date'])); ?>");
        event_date.setHours(0, 0, 0, 0);

        $("#datepicker").datepicker({
            inline: true,
            showOtherMonths: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            onSelect: function(dateText, inst) {
                $("input[name='checkin_date']").val(dateText);
            }
        });
        $("#datepicker").datepicker("setDate", event_date);

    });
</script>


