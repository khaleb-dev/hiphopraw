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

        <section id="latest-members">
            <div class="latest">
                <h2>Latest Members <?php echo isset($latest_members)? ("(". count($latest_members) .")") : "" ?></h2>
            </div>
				<div id="photos" class="content">

                    <?php
                    if(isset($latest_members)):
                        $counter = 0;
                        echo '<div class="separate"></div>';
                        foreach($latest_members as $member):
                            $counter++;
                            ?>
                            <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>
                            <?php
                            if($counter % 4 === 0){
                                echo '<div class="separate"></div>';
                            }
                        endforeach;
                    else:
                        ?>
                        <p class="nodata-message">No data to show.</p>
                    <?php
                    endif;
                    ?>
           </div>
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

