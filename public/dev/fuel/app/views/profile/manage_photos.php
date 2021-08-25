<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			  <div id="profile_name">  <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="profile-pic">   <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>

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
            <div id="myphoto"><h2>My Photos</h2></div>
            <div class="content clearfix">
                <?php echo Form::open(array("action" => "profile/manage_photos", "class" => "clearfix")) ?>
                <table>
                    <?php if ($my_photos): ?>
                        <thead>
                        <tr class="section-heading">
                            <td class="first-column"><input type="checkbox" name="select-all" id="select-all" /></td>
                            <td class="second-column">Photo</td>
                            <td class="third-column">Description</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($my_photos as $my_photo): ?>
                            <tr>
                                <td><input class="checkbox-item" type="checkbox"  name="image_items[]" value="<?php echo $my_photo->id; ?>" /></td>
                                <td>
                                    <a class="gallery-image" href="<?php echo Model_Profile::get_picture($my_photo['file_name'], $current_profile->user_id, "slimbox") ?>" rel="lightbox-photos" title="<?php echo $my_photo->description ?>" >
                                        <?php echo Html::img(Model_Profile::get_picture($my_photo['file_name'], $current_profile->user_id, "members_medium")); ?>
                                    </a>
                                    <a class="gallery-image" href="#" title="<?php echo $my_photo->description ?>" ></a>
                                </td>
                                <td><?php echo $my_photo->description; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if($current_profile->picture != ""): ?>
                            <tr>
                                <td><input class="checkbox-item" type="checkbox"  name="image_items[]" value="<?php echo 'profile' ?>" /></td>
                                <td>
                                    <a class="gallery-image" href="<?php echo Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "slimbox") ?>" rel="lightbox-photos" title="<?php echo $my_photo->description ?>" >
                                        <?php echo Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_medium")); ?>
                                    </a>
                                    <a class="gallery-image" href="#" title="Profile Picture" ></a>
                                </td>
                                <td><?php echo "Profile Picture" ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr  class="pager-top">
                            <td colspan="4">
                            </td>
                        </tr>
                        </tfoot>
                    <?php else: ?>
                        <tr>
                            <td>No <strong>image</strong> has been uploaded.</td>
                        </tr>
                    <?php endif; ?>
                </table>
                <div id="delete-photo-container">
                    <input class="submit_input" type="submit" src="" name="btnRemovePhoto" value="Remove" />
                </div>
                <?php echo Form::close(); ?>
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

