<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			 <div id="profile_name">   <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
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
        <section id="my-photos">
		  <div id="myphoto">
            <h2>My Photos</h2>
               </div>
            <div class="content clearfix">
                <?php echo Form::open(array("action" => "profile/upload_photo", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
                    <div id="upper-content">
                        <p>Upload Photo</p>
                        <p id="profile-photo-select">
                            <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                            <a id="profile-upload-button" class="upload-button">Browse</a>
                            <span>No file selected</span>
                        </p>
                    </div>
                    <div id="lower-content">
                        <p>Description</p>
                        <textarea name="description" placeholder="Title of Photo Caption..."></textarea>
                    </div>
                    <div id="upload-button">
                        <input class="submit_input" type="submit" value="Upload" />
                    </div>
                <?php echo Form::close(); ?>

                <div class="photo-list clearfix">
                    <?php if ($images || $current_profile->picture != ""): ?>
                        <?php foreach ($images as $image): ?>
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($image['file_name'], $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $image['description'] )); ?>
                                <p title="<?php echo $image['description']; ?>"><?php echo Str::truncate($image['description'], 17 ) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if($current_profile->picture != ""): ?>
                            <div class="photo">
                                <?php echo Html::anchor(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Profile Picture" )); ?>
                                <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>No photos added yet!</p>
                    <?php endif; ?>
                </div>
                <div id="manage-photo-link">
                    <?php echo Html::anchor("profile/manage_photos", "Manage"); ?>
                </div>

            </div>
        </section>
    </div>
    <aside id="right-sidebar">
        <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members,'referd' => $referd,'subscribed' => $subscribed)); ?>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>
