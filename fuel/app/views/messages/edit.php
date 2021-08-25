<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <h2 class='clearfix'><span><?php echo $heading; ?></span></h2>
        <div id="messages" class="content-box">
            <?php echo View::forge("messages/partials/message_menu"); ?>
            
            <?php echo View::forge("messages/partials/draft_form", array("users" => $users, "message" => $message)); ?>
            
            <p class="back"><?php echo Html::anchor(Router::get("users/show/$current_user->id"), "&laquo;  Back"); ?></p>       
        </div>
    </div>
    <?php echo Asset::img("logo_slogan.png", array("class" => "logo-slogan")); ?>
</div>