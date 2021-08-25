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
    <div id="middle">
        <section id="event-detail">
           <div id="detail"> <h2>Event Detail Title</h2></div>

            <div class="event-list" id="event-1">
                <?php
                if(empty($event['photo'])):
                    ?>
                    <img src="temp/event_thumb.jpg" />
                <?php
                else:
                    ?>
                    <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_detail_'.$event['photo'] ?>" />
                <?php
                endif;
                ?>

                    <h3><?php echo $event['title'] ?></h3>

                    <span>
                        <?php echo $event['start_date'] ?>
                    </span>
                    <br/>
                    <br/>
                    <strong>
                        Time: <?php echo $event['start_time'] ?> - <?php echo $event['end_time'] ?> | @ <?php echo $event['venue'];?>
                    </strong>
                    <p>
                        <?php echo Str::truncate($event['short_description'],300) ?>

                    </p>

                <?php
                    if( ! Model_Rsvp::is_going($event['id'])):
                ?>
                        <button class="button" id="rsvp" data-dialog="send-rsvp">RSVP</button>
                <?php
                    else:
                        ?>
                        <button class="button" disabled="disabled">RSVP Sent</button>
                <?php
                endif;
                ?>
                <button class="button" data-dialog="send-rsvp" onclick="window.open('<?php echo $event['url']; ?>');">Tickets</button>

            </div>

        </section>

        <section id="event-detail-more">
           <div id="more-about-event"> <h2>More About This Event</h2></div>

            <div class="event-list long-description" id="event-1">
                <p>
                    <?php echo $event['long_description'];?>
                </p>
            </div>
        </section>

        <section id="refer-friend">
            <div id="refer"><h2>Refer a Friend</h2></div>
            <div class="event-list">

                <form id='refer-friend-form' action="<?php echo \Fuel\Core\Uri::create('event/refer_a_friend') ?>" method="">
                    <p>
                        <label for="email">Email:</label><br />
                        <input id="email" type="text" name="email">
                    </p>
                    <p>
                        <label for="message">Message:</label><br />
                        <textarea id="message" name="message" cols="130"></textarea>
                    </p>
                    <p>
                        <button type="submit" id="refer-a-friend" class="button">Refer a Friend Now!</button>
                    </p>
                    <input type="hidden" value="<?php echo $event['id'] ?>" name="event_id" />
                </form>
            </div>

        </section>




    </div>
</div>


<div id="send-rsvp" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>RSVP Request</h2>
    </div>
    <div class="dialog-content">
        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_rsvp_'.$event['photo'] ?>" />
        <div id="send-rsvp-content" class="clearfix">
            <p><?php echo '<span class="title">'.$event['title'].'</span> : <span class="date">'.$event['start_date'].'</span>' ?>
            <br />
            <span class="time">Time:  <?php echo $event['start_time'].' - '.$event['end_time'] ?></span>
            <hr/>
            <?php echo \Fuel\Core\Str::truncate($event['long_description'], 185) ?>
            </p>
        </div>
        <form class="clearfix" id="rsvp-form" action="<?php echo \Fuel\Core\Uri::create('event/rsvp') ?>" method="post">
            <input type="hidden" id="event_id" name="event_id" value="<?php echo $event['id'] ?>">
            <button class="button button-left" type="submit">RSVP NOW</button>
            <button class="button button-right" id="cancel-rsvp" type="reset">No Thanks</button>
        </form>
    </div>
</div>