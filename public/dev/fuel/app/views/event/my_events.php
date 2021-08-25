<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			   <div id="profile_name"><?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
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
        <section id="events">
            <div id="latest"><h2>My Events </h2></div>

            <?php
            $no_event = true;

            if(isset($active_events) and $active_events !== false):
                $no_event = false;
                foreach($active_events as $event):
                    ?>
            <div class="event-list" id="event-1">

                <a href="<?php echo \Fuel\Core\Uri::create('event/view/'.$event['slug']) ?>">
                    <?php
                    if(empty($event['photo'])):
                    ?>
                        <img src="temp/event_thumb.jpg" />
                    <?php
                    else:
                    ?>
                        <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$event['photo'] ?>" />
                    <?php
                    endif;
                    ?>

                </a>
                    <h3 style="text-decoration: underline;-moz-text-decoration-color: #b10759;"><?php echo $event['title'] ?></h3>

                    <span><?php echo $event['start_date'] ?></span>
                    <p><?php echo \Fuel\Core\Str::truncate($event['long_description'], 250)//echo substr($event->short_description, 0, 400).'...' ?></p>
                    <?php echo \Fuel\Core\Html::anchor('event/view/'.$event['slug'], 'Learn More', array('class' => 'button')) ;?>

            </div>
                    <hr>
            <?php

                endforeach;

            endif;

            ?>

            <?php

            if(isset($past_events) and $past_events !== false):
                $no_event = false;
                $event = null;
                foreach($past_events as $event):
                    ?>
                    <div class="event-list" id="event-1">

                        <a href="<?php echo \Fuel\Core\Uri::create('event/view/'.$event['slug']) ?>">
                            <?php
                            if(empty($event['photo'])):
                                ?>
                                <img src="temp/event_thumb.jpg" />
                            <?php
                            else:
                                ?>
                                <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_list_'.$event['photo'] ?>" />
                            <?php
                            endif;
                            ?>

                        </a>
                        <h3 class="past-event"><?php echo $event['title'] ?> (Past Event)</h3>

                        <span><?php echo $event['start_date'] ?></span>
                        <p><?php echo \Fuel\Core\Str::truncate($event['short_description'], 250)//echo substr($event->short_description, 0, 400).'...' ?></p>
                        <?php echo \Fuel\Core\Html::anchor('event/view/'.$event['slug'], 'Learn More', array('class' => 'button')) ;?>

                    </div>
                    <hr>
                <?php

                endforeach;

            endif;

            ?>

            <?php
            if($no_event):
            ?>
            <div class="event-list" id="no-event">
                You haven't sent RSVP to any event.
            </div>
            <?php
            endif;
            ?>

            <a class='next' href="#">Next &raquo;</a>

        </section>
        <div class="notify">
            <p><span>You must have an approved profile to be invited to most events.</span> <a href="#">See your profile status</a></p>
        </div>

<!--        <section id="dating-package-section">-->
<!--           <section id="latest"><h2>Dating Packages</h2></section>-->
<!--            <div class="dating-package dating-package-1">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna aliqiut-->
<!--                    an. Ut enim ad minim veniami-->
<!--                    quist nostrud exercitation.Lore-->
<!--                    iipsui dolim dolor sit.-->
<!--                </div>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!---->
<!--            </div>-->
<!--            <div class="dating-package dating-package-2">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna aliqiut-->
<!--                    an. Ut enim ad minim veniami-->
<!--                    quist nostrud exercitation.Lore-->
<!--                    iipsui dolim dolor sit.-->
<!--                </div>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!--            </div>-->
<!---->
<!--            <a class='next' href="#">Show More &raquo;</a>-->
<!--        </section>-->

        <section id="dating-package-section">
            <section id="latest">
                <h2>Dating Packages</h2>
            </section>
            <?php $i = 0; ?>
            <?php if (isset($active_datingPackages) && $active_datingPackages !== false): ?>
                <?php foreach ($active_datingPackages as $active_datingPackage): ?>
                    <div class="my-dating-package">
                        <?php if (empty($active_datingPackage['picture'])): ?>
                            <?php echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                        <?php else: ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $active_datingPackage['picture'] ?>" />
                        <?php endif; ?>
                        <p>
                            <span class="dating-package-title"><?php echo ucfirst(substr($active_datingPackage['title'], 0, 20)) . '...' ?> <br/> </span>
                            <?php echo ucfirst(substr($active_datingPackage['long_description'], 0, 350)) ?>
                        </p>
                        <div id="read-more">
                            <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $active_datingPackage['id'], 'Read More') ?>
                        </div>
                    </div>
                    <?php $i++; ?>
                    <?php if($i >= 2) break; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div id="no-package">
                    No Dating Package found from your location.
                </div>
            <?php endif; ?>
        </section>
    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>