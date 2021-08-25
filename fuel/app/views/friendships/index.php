<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if(isset($current_user) && $user->id == $current_user->id){ ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $videokes_count)); ?>
        <?php } ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>
    <div id="content" class="with-sidebar-left profile">
        
            
            <div id="manage-friends" class="content-box clearfix">
                <h3 class="clearfix">
                    <p>Showing <?php echo $user->username; ?>'s Friends (<span class="friends-count"><?php echo $count; ?></span>)</p> 
                </h3>

                <div class="items friends clearfix">
                    <?php if (count($friends) > 0) { ?>
                        <?php echo View::forge("friendships/partials/index_alt_list", array("friends" => $friends)); ?>
                        <div class="paging">
                            <?php echo $pagination->render(); ?>
                        </div>
                    <?php } else { ?>
                        <p class="highlight-box">No Friends added yet!</p>
                    <?php } ?>
                </div>

            </div>
            
    </div>
</div>