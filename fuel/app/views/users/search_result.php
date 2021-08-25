<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_video_side_nav", array("current_user" => $current_user, "menu" => "Videokes")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div id="users">
            <h2><span>Search Results <p></span> </h2>

            <div class="content-box">
               </div>
        </div>
    </div>
    <div class="clear">&nbsp</div>
</div>
