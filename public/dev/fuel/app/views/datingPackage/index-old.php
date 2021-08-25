<div id="content" class="clearfix">


    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="profile-pic"> <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>


    <!-- access should be via the controller. However I am not able to get the datingpackages via the controller
        There fore direct call to the model is used. Any body who understands why could improve this code-->

    <div id="middle">
        <section id="dating-package-section">
            <div id="package"><h2>Dating Package</h2></div>
            <div id="check-invitation-button">
                <a id="Check-invite" href="#confirm_booking">Confirm Booking</a>
            </div>
            <div id="check-invitation-button">
                <a id="Check-invite" href="#reply_invite">My Dating Invitations</a>
            </div>


        </section>
        <section id="featured-dating-package-section">
        <?php
        $featureddatingpackages = Model_Datingpackage::get_random_featured_dating_packages();
        if (isset($featureddatingpackages) && $featureddatingpackages !== false):
        ?>
                <?php foreach ($featureddatingpackages as $datingpackage): ?>
                    <div id="featured-dating-package">
                        <div id="top">
                            <?php if (empty($datingpackage['picture'])): ?>
                                <?php echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $datingpackage['picture'] ?>" />
                            <?php endif; ?>
                            <div id="dating-package">
                                <div class="dating-package-description">
                                    <strong>  <?php echo ucfirst($datingpackage['title']); ?> <br/> </strong>
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
                                    <small> <?php echo "$event_day, $event_date" . $event_end_text ?> <br/><br/></small>
                                    <p><?php echo $datingpackage['short_description']; ?></p>
                                </div>
                            </div>
                            <div id="send-invitation-button">
                                <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $datingpackage['id'], 'Learn More') ?>

                            </div>


                        </div>


                    </div>
                    <?php
                endforeach;
                ?>
            
            <?php
        endif;
        ?>


        <?php
        $datingpackages = Model_Datingpackage::get_random_active_dating_packages(8);
        if (isset($datingpackages) && $datingpackages !== false): ?>
                <?php foreach ($datingpackages as $datingpackage): ?>
                    <div id="featured-dating-package">
                        <div id="top">
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
                            <div id="dating-package">
                                <div class="dating-package-description">
                                    <strong>  <?php echo ucfirst($datingpackage['title']); ?> <br/> </strong>
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
                                    <small> <?php echo "$event_day, $event_date" . $event_end_text ?> <br/><br/></small>
                                    <p><?php echo $datingpackage['short_description']; ?></p>
                                </div>
                            </div>
                            <div id="send-invitation-button">
                                <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $datingpackage['id'], 'Learn More') ?>
                            </div>
                        </div>

                    </div>
                    <?php
                endforeach;
                ?>
            
            <?php
        elseif ($featureddatingpackages !== false):


        else:
            ?>
           
                <div id="detailed-dating-package-none">
                    No Active Dating Package Available
                </div>
            
        <?php
        endif;
        ?>
</section>




        <section id="featured-dating-package-section">
            <div id="find-your-perfect"> <h2>Find Your Perfect Date</h2></div>
            <div id="featured-dating-package">
                <?php
                echo Form::open(array('action' => 'datingPackage/view', 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                ?> 
                <p class="search-para">
                    <label class="label" for="destination">Hotel or Destination </label></br>
                    <select class="search-box" name="destination" placeholder="Destination or Hotel" required >
                        <option></option>
                        <?php
                        $destination_list = Model_Datingpackage::get_distinct_package_destinations();
                        if (($destination_list !== false)):
                            foreach ($destination_list as $destination):
                                ?>

                                <option value= <?php echo $destination['state']; ?> > <?php echo ucfirst($destination['state']); ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </p>
                <p class="search-para">
                    <label class="search_label" for="checkin"> Checkin:</label>
                    <input id="checkin" type="text" name="checkin" placeholder="Check In (Optional)"  >
                    <label class="search_label" for="Checkout"> Checkout:</label>
                    <input id="checkout" type="text" name="checkout" placeholder="Check out (Optional)"  >
                </p>


                <p class="search-para">    <input  class="search-button" type="submit" name="search" value="Search" required></p>
                <?php echo Form::close(); ?>
            </div>
        </section>


    </div>


    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online");        ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2new.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3new.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>



</div>   

<div id="confirm_booking">
    <?php
    $userid = $current_profile->id;
    $pendingdatingpackages = Model_Datingpackage::get_pendingInvitations($userid);
    if (isset($pendingdatingpackages) && $pendingdatingpackages !== false):
        ?>

        <section id = "invitation-dialog">
            <header>
                Confirm Your Booking For The Dating Invitation  <a href="#close" title="Close" class="back">X</a>

            </header>

            <div class = "invite-content">

                <?php
                foreach ($pendingdatingpackages as $pendingdatingpackage):
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
                    </div>

                    <div id="short-description" >
                        <?php echo $pendingdatingpackage['short_description'] ?>
                        <hr class="hr-line">
                    </div>

                    <div id="title">
                        <strong><?php echo ucfirst($pendingdatingpackage['title']) ?></strong>
                    </div>

                    <div id="price">
                        <?php echo 'Total price: $' . ucfirst($pendingdatingpackage['price']) ?> 
                    </div>



                    <div id="sender">
                        <?php
                        $friend_list = Model_datingpackage::get_user_name($pendingdatingpackage['to_member_id']);
                        if (isset($friend_list) && $friend_list != false) {
                            if (ucfirst($pendingdatingpackage['status']) == "Accept") {
                                echo ucfirst($friend_list[0]['first_name']) . " " . ucfirst($friend_list[0]['last_name']) . " has accepted your invitation.</br> Click confirm booking. Payment follows.";
                            } elseif (ucfirst($pendingdatingpackage['status']) == 'Reject') {
                                echo ucfirst($friend_list[0]['first_name']) . " " . ucfirst($friend_list[0]['last_name']) . " can not attend to your invitation. </br> Click cancel to remove this invitation. </br>Click confirm booking to proceed anyways.";
                            } else {
                                echo ucfirst($friend_list[0]['first_name']) . " " . ucfirst($friend_list[0]['last_name']) . " has not yet replied your invitation. </br> Click cancel to remove the invitation or click confirm booking to proceed anyways.";
                            }
                        } else {
                            echo $pendingdatingpackage['from_member_id'] . " has not yet replied to your invitation.";
                        }
                        ?>

                    </div>

                <?php endforeach; ?>
            </div>

            <div class="invite-form">

                <?php
                if (isset($pendingdatingpackage)):
                    //  echo print_r($inviteddatingpackage);
                    echo Form::open(array('action' => 'datingPackage/cancel_booking/' . $pendingdatingpackage['invitation_id'], 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                    ?>

                    <input  class="cancel_invitation-button" type="submit" name="cancel_booking" value="Cancel Booking" > 

                    <?php
                    echo Form::close();
                    echo Form::open(array('action' => 'datingPackage/confirm_booking/' . $pendingdatingpackage['invitation_id'], 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                    ?>

                    <input  class="confirm-invitation-button" type="submit" name="confirm_booking" value="Confirm booking" > 

                    <?php
                    echo Form::close();

                endif;
                ?>

            </div>
        </section>
    </div>  
    <?php
else:
    ?>
    <section id = "invitation-dialog">
        <header>
            Confirm Your Booking For The Dating Invitation <a href="#close" title="Close" class="back">X</a>

        </header>

        <div class = "invite-content">
            <div id="sender">
                There is no pending invitation sent out.

            </div>
        </div>
    </section>

<?php
endif;
?>
</div>







<div id="reply_invite">
    <?php
    $userid = $current_profile->id;
    $inviteddatingpackages = Model_Datingpackage::get_invitation($userid);
    if (isset($inviteddatingpackages) && $inviteddatingpackages !== false):
        ?>

        <section id = "invitation-dialog">
            <header>
                DATE REQUEST INVITATION  <a href="#close" title="Close" class="back">X</a>

            </header>

            <div class = "invite-content">

                <?php
                foreach ($inviteddatingpackages as $inviteddatingpackage):
                    ?>
                    <div id="sender">
                        <?php
                        $friend_list = Model_datingpackage::get_user_name($inviteddatingpackage['from_member_id']);
                        if (isset($friend_list) && $friend_list != false) {
                            echo $friend_list[0]['first_name'] . " " . $friend_list[0]['last_name'] . " has sent you an invite to attend this date";
                        } else {
                            echo $inviteddatingpackage['from_member_id'] . " has sent you an invite to attend this date";
                        }
                        ?>

                    </div>
                    <div id="picture">
                        <?php
                        if (empty($datingpackage['picture'])):
                            ?>
                            <?php echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                            <?php
                        else:
                            ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $inviteddatingpackage['picture'] ?>" />
                        <?php
                        endif;
                        ?>
                    </div>

                    <div id="short-description" >
                        <?php echo ucfirst(\Fuel\Core\Str::truncate($inviteddatingpackage['long_description'], 400)) ?>
                        <hr class="hr-line">
                    </div>

                    <div id="title">
                        <strong><?php echo 'Title:' . ucfirst($inviteddatingpackage['title']) ?> </br></strong>
                        <?php
                        //the following code converts mysql date format which is yyyy-mm-dd to the desired formats
                        $event_date = $inviteddatingpackage['event_date'];
                        // converts the date to time and format it as January 03, 2014
                        $event_date = date('M d, Y', strtotime($event_date));
                        // returns the day as Monday 
                        $event_day = $day = date('l', strtotime($event_date));
                        // converts the time to php time
                        $time_from = strtotime($inviteddatingpackage['time_from']);
                        $time_to = strtotime($inviteddatingpackage['time_to']);

                        ?>

                        <?php echo 'Date:' . $event_day . ", &nbsp" . $event_date . '</br>' ?> 
                        <?php echo 'Time: &nbsp' . date("h:i A.", $time_from) . " - " . date("h:i A.", $time_to) . "&nbsp&nbsp|&nbsp &nbsp @&nbsp " . $inviteddatingpackage['event_venue'] . ", " . $inviteddatingpackage['city'] . " " . $inviteddatingpackage['state'] ?> </strong> </p>  

                    </div>
                    <div id="price">
                        <?php echo 'Total price: $' . ucfirst($inviteddatingpackage['price']) ?> 
                    </div>

                <?php endforeach; ?>




            </div>
            <div class="invite-form">

                <?php
                if (isset($inviteddatingpackage)):
                    //  echo print_r($inviteddatingpackage);
                    echo Form::open(array('action' => 'datingPackage/accept_invite/' . $inviteddatingpackage['invitation_id'], 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                    ?>

                    <input  class="accept_invite-button" type="submit" name="decline_invite" value="Accept Date Request" > 

                    <?php
                    echo Form::close();
                    echo Form::open(array('action' => 'datingPackage/reject_invite/' . $inviteddatingpackage['invitation_id'], 'method' => 'Post', 'enctype' => 'multipart/form-data'));
                    ?>

                    <input  class="decline_invite-button" type="submit" name="decline_invite" value="No Thanks" > 

                    <?php
                    echo Form::close();
                endif;
                ?>
            </div>
        </section>
    </div>  
    <?php
else:
    ?>
    <section id = "invitation-dialog">
        <header>
            DATE REQUEST INVITATION <a href="#close" title="Close" class="back">X</a>

        </header>

        <div class = "invite-content">
            <div id="sender">
                There is no pending invitation sent for you.

            </div>
        </div>
    </section>

<?php
endif;
?>
</div>


<script>
    $(function() {
        var event_date = new Date();
        event_date.setHours(0, 0, 0, 0);

        $("#checkin").datepicker({
            inline: true,
            showOtherMonths: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        });
        $("#checkout").datepicker({
            inline: true,
            showOtherMonths: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        });

    });
</script>