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
                <h2>Events Search Results</h2>
            </div>
            <div id="search-result-container">
                <?php if (isset($events) and $events !== false): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="event-list" id="event-1">
                            <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                                <?php if (empty($event['photo'])): ?>
                                    <img src="temp/event_thumb.jpg" />
                                <?php else: ?>
                                    <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_list_' . $event['photo'] ?>" />
                                <?php endif; ?>
                            </a>
                            <div id="events">
                                <div id="event-description">
                                    <h3><?php echo $event['title'] ?></h3>
                                    <span><?php echo $event['start_date'] ?></span>
                                    <p><?php echo $event['short_description'] ?></p>
                                </div>
                            </div>
                            <div class="learn-more-button">
                                <?php echo \Fuel\Core\Html::anchor('event/view/' . $event['slug'], 'Learn More', array('class' => 'button')); ?>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="nodata-message">
                        There is no event available for your search. Please retry with another search.
                    </p>
                <?php endif; ?>
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