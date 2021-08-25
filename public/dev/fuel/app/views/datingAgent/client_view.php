<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile_name">
                    <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?>
                </div>
                <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
            </div>
        </div>

<!--        --><?php //echo View::forge("datingAgent/partials/agent_nav"); ?>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">

        <section id="friends">
            <div id="photos">
			<div class="bio">
					<h1><?php echo $client_profile->first_name.' '.$client_profile->last_name; ?></h1>
					<h3><?php echo $client_profile->city.', '.$client_profile->state ?></h3>					
					<h3>Seeking:<?php echo ($client_profile->gender_id == 1) ? ' Woman ' : ' Man' ?></h3>
					<h3>Ages: <?php echo $client_profile->ages_from.'-'.$client_profile->ages_to ?></h3>
			</div>
			
			<div class="pic">
					<span><?php echo Html::img(Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "profile_medium")) ?></span>
					<span>

                        <?php echo Html::anchor("#", '<i class="fa fa-comment"></i> Start a Chat', array("id" => "start-chat-talk", "class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($client_profile->user_id), "data-full-name" => Model_Profile::get_username($client_profile->user_id), "data-profile-picture" => Model_Profile::get_picture($client_profile->picture, $client_profile->user_id, "members_list"))); ?>

                    </span>
					<span><a href="<?php echo Uri::create('profile/public_profile/'.$client_profile->id) ?>" id="full_profile">View Full Profile</a></span>
			</div>
            	
            </div>
        </section>
        <section id="latest-members">
				<h2>Suggested Matches</h2>
				<div id="photos" class="content">

                    <?php
                    if(isset($matches)):
                    $counter = 0;
                        foreach($matches[0] as $member):
                        if ($member['group_id'] != 5 && ! Model_Profile::is_dating_agent($member['id'])):
                        $counter++; ?>

                            <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>

                            <?php
                            if($counter % 4 === 0){
                                echo '<div class="separate"></div>';
                            }
                            endif;
                        endforeach;
                    else:
                        ?>
                        <p class="nodata-message">Suggested Matches Not Found.</p>
                    <?php
                    endif;
                    ?>

           </div>
		<div class="link"><a href='#'>View All Members</a></div>   
        </section>
		
<!--        <section id="dating-package-section">-->
<!--		<h2>Suggested Dating Packages</h2>-->
<!--            <div class="dating-package dating-package-2">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna -->
<!--                </div><br>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!--            </div>-->
<!--            <div class="dating-package dating-package-2">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna -->
<!--                </div><br>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!--            </div>-->
<!--			<div class="dating-package dating-package-2">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna -->
<!--                </div><br>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!--            </div>-->
<!--			<div class="dating-package dating-package-2">-->
<!--                <div>-->
<!--                    --><?php //echo \Fuel\Core\Asset::img(array('temp/event_thumb.jpg'));?>
<!--                    <span class="dating-package-title">Romantic Dinner Package Includes..</span>-->
<!--                    usmod tempor incididunt ulaib-->
<!--                    ore etedolore et magna -->
<!--                </div><br>-->
<!--                <p><strong>Name of Package </strong> <br/><small>Short Description</small> </p>-->
<!--                <a href="#" class="button">Read More</a>-->
<!--            </div>-->
<!--        -->
<!--             -->
<!--        </section>-->
		
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

