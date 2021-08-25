<?php echo View::forge('partials/inner_header'); ?>
<?php echo View::forge('partials/blue_navigator', array('menu' => 'Personal Profile', 'is_completed' => $profile->is_completed)); ?>

<div class="container_main">
    <div  class="left-side-container_small"> 
        <div> 
            <div class="avatar-container">
                <p class="upper"><?php echo $username . ' Profile' ?></p>
                <?php if (!empty($thumbnail_2)): ?>
                    <img class="member-thumbnail" src="<?php echo UPLOADURL . $username . '/' . $thumbnail_2 ?>" />
                <?php else: ?>
                    <img class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($profile->gender == 'Female' ? 'woman2.jpg' : 'man2.jpg') ?>" />
                <?php endif; ?>
                
                <p class="lower"><a href="<?php echo BASEURL . '/profile/edit_profile'  ?> ">Edit Profile</a></p>
            </div>
            <?php echo View::forge('partials/profile_side_menu'); ?>
            <div id="left-separetor"> </div>
            <div id="dating-concierge">
                <div id="my-concierge"><?php echo Asset::img('my_concierge.png'); ?><p>My Concierge</p></div>
                <a href="<?php echo BASEURL . '/agent/index' ?>">
                    <?php echo Asset::img('signup/datingconceirgebg.png', array('class' => 'member-thumbnail')); ?>
                </a>
                <div id="consult-live-container">
                    <div id="consult-live-text"> 
                        <p>Join Now and Consult Live with your own online concierge</p>
                    </div>
                    <div id="consult-live-button">
                        <a  href="#" data-type="Man" data-dialog="sign-up">
                            <?php echo Asset::img('signup/online.png'); ?>
                            Online Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div  class="right-side-container_large"> 

        <div class="summary-container">
            <div class="title">
                <p> Activities </p>
                <a href="#"> View All</a>

            </div>
            <div class="separetor-line"></div>
            <div class="empty-message">
                <p>
                    No activities
                </p>
            </div>
        </div>

        <div class="summary-container">
            <div class="title">
                <p> Notifications </p>
            </div>
            <div class="separetor-line"></div>
            <div class="empty-message">
                <p>
                    No Notifications
                </p>
            </div>
        </div>
        <div class="summary-container"> 
            <div class="title">
                <p>Latest Friends </p>
                <a href="#"> View All</a>
            </div>
            <div class="separetor-line"></div>

            <div class="empty-message">
                <p>
                    No Latest Friends
                </p>
            </div>
        </div>
        <div class="summary-container"> 
            <div class="title">
                <p>Events</p>
            </div>
            <div class="separetor-line"></div>

            <div class="empty-message">
                <p>
                    No Events
                </p>
            </div>
        </div>
        <div class="summary-container">
            <div class="title">
                <p> Hellos </p>
                <a href="#"> View All</a>
            </div>
            <div class="separetor-line"></div>
            <?php if ($pending_hellos): ?>
                <div class="members-photo-container-middle">
                    <ul>
                        <?php foreach ($pending_hellos as $pending_hello): ?>
                            <li>
                                <div class="members-photo-middle"> 
                                    <?php if (!empty($pending_hello['avatar'])): ?>
                                        <a href= "<?php echo BASEURL . '/profile/public_profile/' . $pending_hello['member_id'] ?>">
                                            <img width="100" class="member-thumbnail" src="<?php echo UPLOADURL . $pending_hello['username'] . '/' . $pending_hello['avatar'] ?>" />
                                        </a>
                                    <?php else: ?>
                                        <a href= "<?php echo BASEURL . '/profile/public_profile/' . $pending_hello['member_id'] ?>">
                                            <img width="100" class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($pending_hello['gender'] == 'Female' ? 'woman.jpg' : 'man.jpg') ?>" />
                                        </a>                                
                                    <?php endif; ?>
                                    <div class="membername"><p><?php echo $pending_hello['my_caption']; ?> </p></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="empty-message">
                    <p>No Hellos</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="clear">&nbsp;</div>
</div>

<?php echo View::forge('partials/footer'); ?>
