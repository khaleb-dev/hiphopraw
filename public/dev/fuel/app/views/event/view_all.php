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
        <section id="events">
            <div id="latest">
                <h2>Where We All Meet Events</h2>
            </div>
            <?php
            $no_event = true;

            if (isset($active_events) and $active_events !== false):
                $no_event = false;
                foreach ($active_events as $event):
                    ?>
                    <div class="event-list clearfix" id="event-1">

                        <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                            <?php
                            if (empty($event['photo'])):
                                ?>
                                <img src="temp/event_thumb.jpg" />
                                <?php
                            else:
                                ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_list_' . $event['photo'] ?>" />
                            <?php
                            endif;
                            ?>

                        </a>
                        <div id="events">
                            <div id="event-description">
                                <h3><?php echo $event['title'] ?></h3>
                                <span><?php echo $event['start_date'] ?></span>
                                <p><?php echo $event['short_description'];//\Fuel\Core\Str::truncate($event['long_description'], 300)  ?></p>
                            </div>
                        </div>
                        <div class="learn-more-button">
                            <?php echo \Fuel\Core\Html::anchor('event/view/' . $event['slug'], 'Learn More', array('class' => 'button')); ?>
                        </div>
                    </div>
                    <hr>
                    <?php
                endforeach;

            endif;
            ?>

            <?php
            if ($no_event):
                ?>
                <div class="event-list clearfix" id="no-event">
                    No event found from your location.
                </div>
                <?php
            endif;
            ?>
        </section>

        <section id="event-search-section">
            <div class="section-heading"><h2>Find Your Perfect Event</h2></div>
            <div id="search-form-container">
                <?php echo Form::open(array('action' => 'event/search', 'method' => 'Post', 'enctype' => 'multipart/form-data')); ?>
                <p class="search-parameter">
                    <label class="label" for="destination">Event Location </label></br>
                    <select class="search-box" name="location" placeholder="Event Location" required >
                        <option></option>
                        <?php $event_states = Model_Event::get_distinct_event_states(); ?>
                            <?php if (($event_states !== false)): ?>
                                <?php foreach ($event_states as $event): ?>
                                    <option value= <?php echo $event['state']; ?> > <?php echo ucfirst($event['state']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                    </select>
                </p>
                <p class="search-parameter">
                    <label class="search_label" for="from_date"> From:</label>
                    <input id="from_date" type="text" name="from_date" placeholder="From Date (Optional)"  >
                    <label class="search_label to-date" for="to_date"> To:</label>
                    <input id="to_date" type="text" name="to_date" placeholder="To Date (Optional)"  >
                </p>
                <p class="search-parameter">    <input  class="search-button" type="submit" name="search" value="Search" required></p>
                <?php echo Form::close(); ?>
            </div>
        </section>
    </div>
    <aside id="right-sidebar">
        <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members, 'referd' => $referd, 'subscribed' => $subscribed)); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>