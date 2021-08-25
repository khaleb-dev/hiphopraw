<div class="member">
    <?php echo Html::anchor(Uri::create('profile/public_profile/' . $member['id']), Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
    <p><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
    <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>

    <?php echo Form::open(array("id" => "friendship-form", "action" => "friendship/update", "class" => "clearfix")) ?>
        <?php echo Html::anchor("#", "ACCEPT", array("class" => "accept", "data-sender-id" => $member['id'], "data-friendship-status" => Model_Friendship::STATUS_ACCEPTED)); ?>
        <?php echo Html::anchor("#", "DECLINE", array("class" => "decline", "data-sender-id" => $member['id'], "data-friendship-status" => Model_Friendship::STATUS_REJECTED)); ?>
    <?php echo Form::close(); ?>

</div>

<div id="upgrade-communication-accept-dialog" class="public-profile-dialog-upgrade-common dialog">
        
            <?php echo Form::open(array("id" => "upgrade-accept-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
            <div id="upgrade-content" class="clearfix">
               <h5>To accept this member as a friend, 
                <span>Upgrade Now</span></h5>               
                <p>As soon as you upgarde you can accept this member as a friend and many others. </p>
                <p class="submit">
                     <button type="submit"  name="#" class="button">UPGRADE</button>
                </p>
            </div>
            <?php echo Form::close(); ?>
     
  
</div>

<div id="upgrade-communication-decline-dialog" class="public-profile-dialog-upgrade-common dialog">
        
            <?php echo Form::open(array("id" => "upgrade-decline-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
            <div id="upgrade-content" class="clearfix">
               <h5>To reject this member as a friend, 
                <span>Upgrade Now</span></h5>               
                <p>As soon as you upgarde you can decline friend request of this member and many others. </p>
                <p class="submit">
                     <button type="submit"  name="#" class="button">UPGRADE</button>
                </p>
            </div>
            <?php echo Form::close(); ?>
     
  
</div>