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
        <section id="featured-dating-package-section">
            <h2>Dating Package Search Results
            </h2>
            <?php
            if (isset($datingpackages) && $datingpackages !== false):
                foreach ($datingpackages as $datingpackage):
                    ?>
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
                            <p>
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
                                ?>
                                <small> <?php echo $event_day . ", &nbsp" . $event_date ?> <br/><br/></small>

                            <?php echo ucfirst(\Fuel\Core\Str::truncate($datingpackage['long_description'], 260)) ?>
                            </p>

                            <div id="send-invitation-button">
                                <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $datingpackage['id'], 'Learn More') ?>

                            </div>

                        </div>   


                    </div>
                    <?php
                endforeach;
                ?>
            </section>
            <?php
        else:
            ?>
            <div id="featured-dating-package-none">
                There is no dating package available for your search. Please retry with another search.
            </div>
            </section>
        <?php
        endif;
        ?>
    </div>


    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online");     ?>
        
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



