<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>
    <div id="content" class="with-sidebar-left profile">
        
            
            <div id="new-friends" class="content-box clearfix">
                <h3 class="clearfix">
                    <p>Showing New Friend Requests (<span class="pending-count"><?php echo count($new_friends); ?></span>)</p> 
                </h3>
                <div class="items friends clearfix">
                    <?php if (count($new_friends) > 0) { ?>
                        <?php echo View::forge("friendships/partials/index_list", array("friends" => $new_friends)); ?>
                    <?php } else { ?>
                        <p class="highlight-box">No new Friend Requests sent yet!</p>
                    <?php } ?>
                </div>
            </div>
            
            
            <div id="manage-friends" class="content-box clearfix">
                <h3 class="clearfix">
                    <p>Showing All Friends (<span class="friends-count"><?php echo count($friends); ?></span>)</p> 
                </h3>

                <div id="edit-friends-button-container" class="clearfix <?php echo count($friends) < 0 ? "hidden" : ''; ?>">
                    <a href="#" class="button rounded-corners">
                        <i class="icon-edit"></i> Edit Friends
                    </a>
                </div>

                <div class="items friends clearfix">
                    <?php if (count($friends) > 0) { ?>
                        <?php echo View::forge("friendships/partials/index_alt_list", array("friends" => $friends)); ?>
                    <?php } else { ?>
                        <p class="highlight-box">No Friends added yet!</p>
                    <?php } ?>
                </div>                
            </div>
            
    </div>
</div>