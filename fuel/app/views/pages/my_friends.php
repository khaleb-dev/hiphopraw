<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>
    <div id="content" class="with-sidebar-left profile">
        
        <div id="friends" class="content-box">
            
            <h3 class="clearfix">
                <p>Showing All Friends (15)</p>
                <p class="pager">
                    <span>Search Name:</span> 
                    <?php for ($i = 65; $i <= 90; $i++) { ?>
                        <?php $letter = chr($i); ?>
                        <?php echo Html::anchor(Router::get("home"), $letter); ?> 
                        <?php echo $i < 90 ? "|" : ""; ?>
                    <?php } ?>
                </p>
            </h3>
            
            <div class="items friends clearfix">
                <?php for ($i = 1; $i < 16; $i++) { ?>
                    <div class="item <?php echo $i % 5 == 0 ? "last" : ""; ?>">
                        <?php echo Asset::img("members/member_" . $i . ".jpg", array("width" => "111", "height" => "99")); ?>
                        <h3>Member Name</h3>
                    </div>
                <?php } ?>
            </div>
            
            <p class="back"><?php echo Html::anchor(Router::get("profile"), "Back"); ?></p>
            <p class="more"><?php echo Html::anchor(Router::get("profile"), "Next"); ?></p>
        </div>
    </div>
</div>