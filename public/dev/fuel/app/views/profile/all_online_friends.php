<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
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
        <section id="latest-members"> 
            <div id="online"><h2>All Online Members</h2></div>
            <?php if ($online_members): ?>
                <div class="content clearfix">                                                  
                    <?php foreach ($online_members as $memberdata): ?>
                     <?php if ($memberdata['group_id'] != 5): ?>
                      <?php if (!Model_Profile::is_deleted_account($memberdata['id'])): ?> 
                     <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>          
                      <?php if ((!Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id']))) || (Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?> 
                       <?php echo View::forge("profile/partials/member_thumb", array("member" => $memberdata)); ?>
                      <?php endif; ?>           
                       <?php else: ?>
                     <?php if ((Model_Setting::is_set_privacy($memberdata['id']) && !Model_Profile::is_premium_member($memberdata['id']) && !Model_Profile::is_dating_agent($memberdata['id'])) || !Model_Setting::is_set_privacy($memberdata['id']) || (Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id'])) && Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?>                                                                  
                        <?php echo View::forge("profile/partials/member_thumb", array("member" => $memberdata)); ?>
                         <?php endif; ?> 
                         <?php endif; ?> 
                         <?php endif; ?> 
                         <?php endif; ?>                
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="nodata-message">No Online Members!</p>
            <?php endif; ?>
        </section>      
    </div>
    <aside id="right-sidebar">       
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>
