<?php echo View::forge('partials/inner_header'); ?>
<?php echo View::forge('partials/blue_navigator', array('menu' => '', 'is_completed' => $profile->is_completed)); ?>
<section class="container_main" >
    <div id="profile_container">

        <div  class="profileleftsidecontainer"> 
            <div> 
                <div class="avatar-container">
                    <p class="upper"><?php echo $profile['username'] . ' Profile' ?></p>
                    <?php if (!empty($thumbnail_2)): ?>
                        <img class="member-thumbnail" src="<?php echo UPLOADURL . $profile['username'] . '/' . $thumbnail_2 ?>" />
                    <?php else: ?>
                         <img class="member-thumbnail"   src="<?php echo BASEURL . '/default_images/' . ($profile['gender'] == 'Female' ? 'woman2.jpg' : 'man2.jpg') ?>" />
                    <?php endif; ?>
                   <div id="lower"><a href="#">Active with in 24 Hours</a> </div>
                </div>
                <div id="basic-links">
                    <?php if ($friendship): ?>
                        <?php if ($friendship['status'] == 'pending'): ?>
                            <?php if ($current_user_id == $friendship['to_member_id']): ?> 
                                <a  href="<?php echo BASEURL . '/friend/friendship/accept/' . $friendship['id'] . '/' . $profile->id ?>">
                                    <div id="ligte-button"><?php echo Asset::img('hello.png'); ?> <h1>Accept Hello</h1></div>
                                </a>
                            <?php endif; ?>
                            <a  href="<?php echo BASEURL . '/friend/friendship/reject/' . $friendship['id'] . '/' . $profile->id ?>">
                                <div id="ligte-button"><?php echo Asset::img('hello.png'); ?> <h1>Reject Hello</h1></div>
                            </a>
                        <?php elseif ($friendship['status'] == 'accepted'): ?>
                            <a  href="<?php echo BASEURL . '/friend/friendship/reject/' . $friendship['id'] . '/' . $profile->id ?>">
                                <div id="ligte-button"><?php echo Asset::img('hello.png'); ?> <h1>Remove Hello</h1></div>
                            </a>
                        <?php endif; ?>
                    <?php elseif ($current_user_id != $profile->id) : ?>
                        <a  href="<?php echo BASEURL . '/friend/request/' . $profile->id ?>">
                            <div id="ligte-button"><?php echo Asset::img('hello.png'); ?> <h1>Send Hello</h1></div>
                        </a>
                    <?php endif; ?>
                    <a  href="<?php echo BASEURL . '/message/compose_message/' . $profile->id ?>">
                        <div id="ligte-button"><?php echo Asset::img('hello.png'); ?> <h1>Send Message</h1></div>
                    </a>
                    <a  href="#">
                        <div id="ligte-button"><?php echo Asset::img('comments.png'); ?> <h1>Send Invite</h1></div>
                    </a>
                    <a  href="#">
                        <div id="ligte-button"><?php echo Asset::img('myFavourites.png'); ?> <h1>Forward to Friend</h1></div>
                    </a>
                    <div id="contact-container">
                        <?php echo Asset::img('profile/contact-agent-bg.png', array('class' => 'member-thumbnail')); ?>

                        <div id="contact-text-container">
                            <P>Contact your own </P>
                            <p>Dating Agent</p>
                        </div>
                        <div id="click-here">
                            <a href="<?php echo BASEURL . '/agent/index' ?>">
                                <div id="agent-click-here" class="subscribe-now">Click here</div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div  id="profile-middle-side-container"> 
            <div id="tabbed_box_1" class="tabbed_area">
                <div id="tabs">
                    <ul class="tabs">  
                        <li class="active" data-tab-id="content_1">Profile</li>  
                        <li class="middle" data-tab-id="content_2">About <?php echo ($profile['gender'] == 'Female' ? 'Her' : 'Him') ?> </li>  
                        <li data-tab-id="content_3">About <?php echo ($profile['gender'] == 'Female' ? 'Her' : 'His') ?> Date</li>
                    </ul>
                </div>
                <div id="content_1" class="content">
                    <ul>
                        <li> <p>Age: </p><small><?php echo $age ?></small></li>
                        <li> <p> <span> Location:</span> </p><small><?php echo $profile['city'] ?></small></li>
                        <div id="separetor-line"></div>
                        <li><p>Seeking for:</p><small><?php echo $profile['preferred_ages_from'] . - $profile['preferred_ages_to'] . "  ". $profile['looking_for'] . " " . $profile['seeking_relationship'] ?></small></li>
                        <div id="separetor-line"></div>
                        <li><p>Occupation:</p><small><?php echo $profile['occupation'] ?></small></li>
                        <li><p>Relationship:</p><small><?php echo $profile['relationship'] ?></small></li>
                        <li><p>Have Kids:</p><small><?php echo $profile['have_kids'] ?></small></li>
                        <li><p>Want Kids:</p><small><?php echo $profile['want_kids'] ?></small></li>
                        <li><p>Ethnicity:</p><small><?php echo $profile['ethnicity'] ?></small></li>
                        <li><p>Body Type:</p><small><?php echo $profile['body_type'] ?></small></li>
                        <li><p>Height:</p><small><?php echo $profile['height'] ?></small></li>
                        <li><p>Religion:</p><small><?php echo $profile['religion'] ?></small></li>
                        <li><p>Smoke:</p><small><?php echo $profile['smoke'] ?></small></li>
                        <li><p>Drink:</p><small><?php echo $profile['drink'] ?></small></li>


                        <div id="separetor-line"></div>
                        <li><samp>Member Since :</samp><samp><?php echo $profile['date_created'] ?>  </samp>  </p></li>
                    </ul>
                </div>
                <div id="content_2" class="content">
                    <ul>
                        <li><p>About Me:</p><small><?php echo $profile['about_me'] ?></small></li>
                        <li><p>Interest:</p><small><?php echo $profile['interest'] ?></small></li>
                        <li><p>For Fun:</p><small><?php echo $profile['for_fun'] ?></small></li>
                        <li><p>Important Thing Looking for:</p><small><?php echo $profile['important_thing_looking_for'] ?></small></li>
                        <li><p>Favorite Things:</p><small><?php echo $profile['favorite_things'] ?></small></li>
                        <li><p>Last Book Read:</p><small><?php echo $profile['last_book_read'] ?></small></li>
                        <li><p>First Thing Noticeable:</p><small><?php echo $profile['first_thing_noticable'] ?></small></li>
                        <li><p>First Thing Noticeable:</p><small><?php echo $profile['first_thing_noticable'] ?></small></li>

                    </ul>
                </div>
                <div id="content_3" class="content">
                    <ul>
                        <li><p>Occupation:</p><small><?php echo $profile['seeking_occupation'] ?></small></li>
                        <li><p>Income:</p><small><?php echo $profile['seeking_income'] ?></small></li>
                        <li><p>Have kids?:</p><small><?php echo $profile['seeking_have_kids'] ?></small></li>
                        <li><p>want_kids?:</p><small><?php echo $profile['seeking_want_kids'] ?></small></li>
                        <li><p>Ethnicity:</p><small><?php echo $profile['seeking_ethnicity'] ?></small></li>
                        <li><p>Body type:</p><small><?php echo $profile['seeking_body_type'] ?></small></li>
                        <li><p>Height:</p><small><?php echo $profile['seeking_height'] ?></small></li>
                        <li><p>Faith:</p><small><?php echo $profile['seeking_faith'] ?></small></li>
                        <li><p>Smoke:</p><small><?php echo $profile['seeking_smoke'] ?></small></li>
                        <li><p>Drink:</p><small><?php echo $profile['seeking_drink'] ?></small></li>
                    </ul>
                </div>

            </div>

            <div id="photo-gallery"> <h1> Photo Gallery </h1> </div>
            <div id="profile-line"></div>
            <div>
                <?php if ($images): ?>
                    <div class="nav-container prev-nav-container"> <a href="javascript:moveLeft()"><?php echo Asset::img('profile/prev.png'); ?> </a> </div>
                    <div id="img-container">
                        <div style="margin-left: <?php echo 0 + 'px'; ?>"  id="slider">
                            <ul>
                                <?php foreach ($images as $img): ?>
                                    <li>
                                        <div class="photo-gallery">
                                            <?php echo Asset::img(BASEURL . '/uploads/' . $profile['username'] . '/' . $img['file_name'], array('class' => 'member-thumbnail')); ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-container next-nav-container"> <a href="javascript:moveRight(<?php echo count($images); ?>)"><?php echo Asset::img('profile/next.png'); ?> </a> </div>
                <?php else: ?>
                    <div class="nav-container prev-nav-container"> <a href="javascript:moveLeft()"><?php echo Asset::img('profile/prev.png'); ?> </a> </div>
                    <div id="img-container">
                        <div class="photo-gallery">
                            <a href= "<?php echo BASEURL . '/profile/public_profile/' . $profile['id'] ?>">
                                <img class="member-thumbnail" width="130" height="105"  src="<?php echo BASEURL . '/default_images/' . ($profile['gender'] == 'Female' ? 'woman2.jpg' : 'man2.jpg') ?>" />
                            </a>
                        </div>
                        <div class="photo-gallery">
                            <a href= "<?php echo BASEURL . '/profile/public_profile/' . $profile['id'] ?>">
                                <img class="member-thumbnail" width="130" height="105"  src="<?php echo BASEURL . '/default_images/' . ($profile['gender'] == 'Female' ? 'woman2.jpg' : 'man2.jpg') ?>" />
                            </a>
                        </div>
                        <div class="photo-gallery">
                            <a href= "<?php echo BASEURL . '/profile/public_profile/' . $profile['id'] ?>">
                                <img class="member-thumbnail" width="130" height="105"  src="<?php echo BASEURL . '/default_images/' . ($profile['gender'] == 'Female' ? 'woman2.jpg' : 'man2.jpg') ?>" />
                            </a>
                        </div>
                    </div>
                    <div class="nav-container next-nav-container"> <a href="javascript:moveRight(<?php echo count($images); ?>)"><?php echo Asset::img('profile/next.png'); ?> </a> </div>
                <?php endif; ?>
            </div>
            <div id="something-to-talk-container">
                <div class="profile-line-short"></div>
                <div id="something-to-talk-text"><h1>Something to Talk About</h1></div>
                <div class="profile-line-short"></div>
                <div id="choose-topic-text-container"> <h2>Choose a topic & get started on a friendly conversation!</h2></div>
                <div id="talk-left">
                    <div id="filter-checkbox">
                        <?php echo Asset::img('movies.png'); ?> 
                        <input type="checkbox" name="with_photos"/>
                        Favorite Movies:
                    </div>
                    <div id="filter-checkbox">
                        <?php echo Asset::img('politices.png'); ?> 
                        <input type="checkbox" name="with_photos"/>
                        Politics:
                    </div>
                    <div id="filter-checkbox">
                        <?php echo Asset::img('travel.png'); ?> 
                        <input type="checkbox" name="with_photos"/>
                        Loves To Travel:
                    </div>
                    <div id="filter-checkbox">
                        <?php echo Asset::img('fitness.png'); ?> 
                        <input type="checkbox" name="with_photos"/>
                        Fitness:
                    </div>
                </div>
                <div id="talk-right">
                    <input class="submit_input" type="submit" src="" name="btnSend" value="Let's Talk" />
                </div>
            </div>  
        </div>

        <div  class="profilerightsidecontainer"> 
            <div id="contact-all-members">
                <?php echo Asset::img('profile/all-members-bg.png', array('class' => 'member-thumbnail')); ?>

                <div id="contact-text-container2">
                    <h2>To Contact</h2>
                    <h1>All Members</h1>
                    <h2>And Use</h2>
                    <h1>All Our Features</h1>
                </div>
                <div id="subscribe-now2-container">
                    <a href="<?php echo BASEURL . '/agent/index' ?>">
                        <div class="subscribe-now2">SUBSCRIBE NOW</div>
                    </a>
                </div>
            </div>
            <div id="seeonline">
                <p>See Who is Online</p>
            </div>
            <div class="see-online-members-container">
                <?php if ($online_members): ?>
                    <?php // $images = array("browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png"); ?>
                    <ul>
                        <?php foreach ($online_members as $online_member): ?>
                            <li>
                                <div class="online-member"> 
                                    <div class="online-members-image"> 
                                        <?php if (!empty($online_member['avatar'])): ?>
                                            <a href= "<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?>">
                                                <img class="member-thumbnail" width="76" height="59"  src="<?php echo UPLOADURL . $online_member['username'] . '/' . $online_member['avatar'] ?>" />
                                            </a>
                                        <?php else: ?>
                                            <a href= "<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?>">
                                                <img class="member-thumbnail" width="76" height="59"  src="<?php echo BASEURL . '/default_images/' . ($online_member['gender'] == 'Female' ? 'woman.jpg' : 'man.jpg') ?>" />
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="online-members-info">
                                        <div class="membername"><p><?php echo $online_member['username']; ?> </p></div>
                                        <div id="memberaddress2"><p><?php echo calculate_age($online_member['birth_date'])   . " YEARS OLD " . $online_member['gender'];  ?></p></div>
                                        <div id="memberaddress2"><p><?php echo $online_member['city'] != '' ? ($online_member['city'] . ', ' . $online_member['state']) : $online_member['state']; ?></p></div>

                                        <div class="dotted-line"> </div>
                                        <div class="linkbuttonscontainer">
                                            <div id="view-profile2"> 
                                                <span>+</span>
                                                <a href= "<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?>">
                                                     View Profile
                                                </a>
                                                <a href="#"></a>
                                            </div> 
                                            <div id="say-hello2"> 
                                                <span>+</span> <a href="#">View Photo</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="empty-message">
                        <p>
                            No online members
                        </p>
                    </div>
                <?php endif; ?>

                <div id="view-all"> 
                    <div id="separetor-line"></div>
                    <a href="#"> View all online members</a>
                </div>
            </div>

        </div>
        <div class="clear">&nbsp;</div>
    </div>
</section>
<?php echo View::forge('partials/footer'); ?>