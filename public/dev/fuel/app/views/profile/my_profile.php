<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			 <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
            <div id="profile-pic"> <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <?php echo Html::anchor(Uri::create('profile/edit'), "Edit Profile", array("id" => "edit-profile")); ?>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">
        <div id="view-profile">
            <div id="profile-header">
                <ul class="tab-header">
                    <li class="active" data-detail="my-profile">Profile</li>
                    <li data-detail="about-me">A Little About Me</li>
                    <li data-detail="about-my-match">About My Match</li>
                    <div>
                        <?php echo Html::anchor(Uri::create("profile/public_profile"), "See what they see!"); ?>
                    </div>
                </ul>
            </div>
            <div id="profile-detail">
                <div id="my-profile" class="active clearfix">
                    <div class="left-content">
                        <p><span>Age:</span><?php echo $profile->birth_date == null ? '' : Model_Profile::get_age($profile->birth_date) ?></p>
                        <p><span>State:</span><?php echo $profile->state ?></p>
                        <p><span>Zip Code:</span><?php echo $profile->zip ?></p>
                        <p><span>Relationship:</span><?php echo $relationship_status == null ? '' : $relationship_status->name ?></p>
                        <p><span>Want Kids:</span><?php echo $profile->want_kids ?></p>
                        <p><span>Ethnicity:</span><?php echo $ethnicity == null ? '' : $ethnicity->name ?></p>
                        <p><span>Eye Color:</span><?php echo $eye_color == null ? '' : $eye_color->name ?></p>
                        <p><span>Religion:</span><?php echo $religion == null ? '' : $religion->name ?></p>
                        <p><span>Drink:</span><?php echo $drink == null ? '' : $drink->name ?></p>
                    </div>
                    <div class="right-content">
                        <p><span>Gender:</span><?php echo $gender == null ? '' : $gender->name ?></p>
                        <p><span>City:</span><?php echo substr($profile->city,0,23)?></p>
                        <p><span>Occupation:</span><?php echo $occupation == null ? '' : $occupation->name ?></p>
                        <p><span>Have Kids:</span><?php echo $profile->have_kids ?></p>
                        <p><span>Body Type:</span><?php echo $body_type == null ? '' : $body_type->name ?></p>
                        <p><span>Height:</span><?php echo $profile->height ?></p>
                        <p><span>Hair Color:</span><?php echo $hair_color == null ? '' : $hair_color->name ?></p>
                        <p><span>Smoke:</span><?php echo $smoke == null ? '' : $smoke->name ?></p>
                    </div>
                </div>
                <div id="about-me" class="clearfix">
                    <div>
                        <h2>About Me</h2>
                        <p><?php echo $profile->about_me?></p>
                    
                    </div>
                    <div>
                        <h2>What I'm Looking For</h2>
                        <p><?php echo $profile->things_looking_for ?></p>
                    </div>
                    <div>
                        <h2>What I'm Looking For</h2>
                        <p><?php echo $profile->first_thing_noticable ?></p>
                    </div>
                    <div>
                        <h2>Interest</h2>
                        <p><?php echo $profile->interest ?></p>
                    </div>
                    <div>
                        <h2>Friends Descibed Me As</h2>
                        <p><?php echo $profile->friends_describe_me ?></p>
                    </div>
                    <div>
                        <h2>For Fun</h2>
                        <p><?php echo $profile->for_fun ?></p>
                    </div>
                    <div>
                        <h2>Favorite Things</h2>
                        <p><?php echo $profile->favorite_things ?></p>
                    </div>
                    <div>
                        <h2>Last Book I Read Was</h2>
                        <p><?php echo $profile->last_book_read ?></p>
                    </div>
                </div>
                <div id="about-my-match" class="clearfix">
                    <div class="left-content">
                        <p><span>Ages:</span><?php echo $profile->ages_from . ' to ' . $profile->ages_to ?></p>
                        <p><span>Location:</span><?php echo $profile->seeking_location ?></p>
                        <p><span>Relationship:</span><?php echo $seeking_relationship_status == null ? '' : $seeking_relationship_status->name ?></p>
                        <p><span>Want Kids:</span><?php echo $profile->seeking_want_kids ?></p>
                        <p><span>Ethnicity:</span><?php echo $seeking_ethnicity == null ? '' : $seeking_ethnicity->name ?></p>
                        <p><span>Eye Color:</span><?php echo $seeking_eye_color == null ? '' : $seeking_eye_color->name ?></p>
                        <p><span>Religion:</span><?php echo $seeking_religion == null ? '' : $seeking_religion->name ?></p>
                        <p><span>Drink:</span><?php echo $seeking_drink == null ? '' : $seeking_drink->name ?></p>
                    </div>
                    <div class="right-content">
                        <p><span>Looking For:</span><?php echo $seeking_gender == null ? '' : $seeking_gender->name ?></p>
                        <p><span>Occupation:</span><?php echo $seeking_occupation == null ? '' : $seeking_occupation->name ?></p>
                        <p><span>Have Kids:</span><?php echo $profile->seeking_have_kids ?></p>
                        <p><span>Body Type:</span><?php echo $seeking_body_type == null ? '' : $seeking_body_type->name ?></p>
                        <p><span>Height:</span><?php echo $profile->seeking_height . ' to ' . $profile->seeking_height_to ?></p>
                        <p><span>Hair Color:</span><?php echo $seeking_hair_color == null ? '' : $seeking_hair_color->name ?></p>
                        <p><span>Smoke:</span><?php echo $seeking_smoke == null ? '' : $seeking_smoke->name ?></p>
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div id="priority-matches">
                        <h3>These are the top 5 priority matches for my match</h3>
                        <div>
                            <?php
                                $priority_1 = Model_Priorityfield::find($profile->priority_1)==null ? '' : Model_Priorityfield::find($profile->priority_1)->name;
                                $priority_2 = Model_Priorityfield::find($profile->priority_2)==null ? '' : Model_Priorityfield::find($profile->priority_2)->name;
                                $priority_3 = Model_Priorityfield::find($profile->priority_3)==null ? '' : Model_Priorityfield::find($profile->priority_3)->name;
                                $priority_4 = Model_Priorityfield::find($profile->priority_4)==null ? '' : Model_Priorityfield::find($profile->priority_4)->name;
                                $priority_5 = Model_Priorityfield::find($profile->priority_5)==null ? '' : Model_Priorityfield::find($profile->priority_5)->name;
                            ?>
                            <?php if($priority_1 != ''): ?>
                                <span><?php echo $priority_1 . ':'  ?><i>1</i></span>
                            <?php endif; ?>
                            <?php if($priority_2 != ''): ?>
                                <span><?php echo $priority_2 . ':'  ?><i>2</i></span>
                            <?php endif; ?>
                            <?php if($priority_3 != ''): ?>
                                <span><?php echo $priority_3 . ':'  ?><i>3</i></span>
                            <?php endif; ?>
                            <?php if($priority_4 != ''): ?>
                                <span><?php echo $priority_4 . ':'  ?><i>4</i></span>
                            <?php endif; ?>
                            <?php if($priority_5 != ''): ?>
                                <span><?php echo $priority_5 . ':'  ?><i>5</i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section id="photo-gallery">
            <div id="collection"><h2>Photo Gallery</h2></div>
            <div id="photo-container" class="clearfix">
                <?php if ($latest_photos || $current_profile->picture != ""): ?>
                    <div class="left-scroller">
                        <a href="#" data-direction="left"><?php echo Asset::img("profile/left_scroller.jpg"); ?></a>
                    </div>
                    <div id="visible-photos">
                        <div id="photo-items" class="clearfix" data-left="0">
                            <?php foreach ($latest_photos as $photo): ?>
                                <div class="photo-item">
                                    <?php echo Html::anchor(Model_Profile::get_picture($photo['file_name'], $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($photo['file_name'], $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $photo['description'] )); ?>
                                    <p title="<?php echo $photo['description']; ?>"><?php echo Str::truncate($photo['description'], 17 ) ?></p>
                                </div>
                            <?php endforeach; ?>
                            <?php if($current_profile->picture != ""): ?>
                                <div class="photo-item">
                                    <?php echo Html::anchor(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>
                                    <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="right-scroller">
                        <a href="#" data-direction="right"><?php echo Asset::img("profile/right_scroller.jpg"); ?></a>
                    </div>
                <?php else: ?>
                    <p>No photos added yet!</p>
                <?php endif; ?>
            </div>
            <div class="view-all">
                <a href="#">View All</a>
            </div>
        </section>
        <section id="something-to-chat">
            <h2>Something to Chat About</h2>
            <div class="header">
                <p>Choose a topic & get started on a friendly conversation</p>
            </div>
            <div class="detail clearfix">
                <div class="left">
                    <p>
                        <?php echo Asset::img('movies.png'); ?>
                        <input type="checkbox" name="with_photos" data-text="Favorite Movie"/>
                        Favorite Movie:
                    </p>
                    <p>
                        <?php echo Asset::img('travel.png'); ?>
                        <input type="checkbox" name="with_photos" data-text="Loves To Travel"/>
                        Loves To Travel:
                    </p>
                </div>
                <div class="center">
                    <p>
                        <?php echo Asset::img('politices.png'); ?>
                        <input type="checkbox" name="with_photos" data-text="Politics"/>
                        Politics:
                    </p>
                    <p>
                        <?php echo Asset::img('fitness.png'); ?>
                        <input type="checkbox" name="with_photos" data-text="Fitness"/>
                        Fitness:
                    </p>
                </div>
                <div class="right">
                    <a id="lets-talk" href="#" data-dialog = "lets-talk-dialog" data-username = "<?php echo Model_Profile::get_username($current_profile->user_id) ?>"><?php echo Asset::img('lets_talk.png'); ?>  Let's Talk</a>
                </div>
            </div>
        </section>

        <section id="dating-package-section">
            <section id="latest">
                <h2>Dating Packages</h2>
            </section>
            <?php if (isset($featured_datingPackages) && $featured_datingPackages !== false): ?>
                <?php foreach ($featured_datingPackages as $featured_datingPackage): ?>
                    <div class="dating-package">
                        <?php if (empty($featured_datingPackage['picture'])):
                            echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg')); ?>
                        <?php else: ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $featured_datingPackage['picture'] ?>" />
                        <?php endif; ?>
                        <p>
                            <span class="dating-package-title"><?php echo ucfirst(substr($featured_datingPackage['title'], 0, 20)) . '...' ?> <br/> </span>
                            <?php echo ucfirst(substr($featured_datingPackage['long_description'], 0, 350)) ?>
                        </p>
                        <div id="read-more">
                            <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $featured_datingPackage['id'], 'Read More') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div id="no-package">
                    No Dating Package found from your location.
                </div>
            <?php endif; ?>
        </section>
    </div>
    <aside id="right-sidebar">
        <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members,'referd' => $referd,'subscribed' => $subscribed)); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

<div id="lets-talk-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Let's Talk</h2>
    </div>
    <div class="dialog-content clearfix">
        <p>
            <label>Friends:</label>
            <select id="friends-list">
                <?php foreach ($my_friends as $friend) : ?>
                    <?php $friend_username = Model_Profile::get_username($friend->user_id) ?>
                    <option value="<?php echo $friend_username; ?>"><?php echo $friend_username; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p class="confirmation">Do you want to send chat request now?</p>
        <p class="confirmation-buttons">
            <a class="button chat yes-button confirm-lets-talk" href="#" data-username = "">Yes</a>
            <a class="button no-button" href="#">No</a>
        </p>
    </div>
</div>
