<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php if(isset($current_user) && $user->id == $current_user->id){ ?>
			<?php echo View::forge("users/partials/profile_alt_control", array("user" => $user)); ?>
		<?php } else { ?>
			<?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" =>$count)); ?>
		<?php } ?>
	</div>
	
	<div class="videokes-center content-box clearfix">
		<div class="vids">
			<div class="title">
				<p class="pull-left main-title">MY HOME</p>
				<p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span></p>
				<div class="clearfix"></div>
				<hr class="divider" />
			</div>
			<?php 
			for($i=0; $i<6; $i++) {
			echo View::forge("videokes/partials/single_item"); } ?>
			<div class="clearfix"></div>
		</div>
		<div class="comments">
			<div class="title">
				<p class="main-title">MY COMMENTS</p>
				<hr class="divider" />
			</div>
		</div>
	</div>
	
	<div class="videokes-right content-box clearfix">
			<p class="header-text">VIDEO SUGGESTIONS</p>
			<hr class="divider"/>
			<?php 
			for($i=0; $i<6; $i++) {
			echo View::forge("videokes/partials/single_item"); 
			echo '<div class="clearfix"></div><hr class="thin-divider" />';} 
			?>
			<p><a class="red pull-right see-more-link" href="#">&gt; SEE MORE</a></p>
	</div>
	
	<div class="clearfix separator"></div>
	
	
	<div id="content" class="videos with-sidebar-left profile">
		<h2  class="clearfix labeled-heading">
            <span>Videokes</span> 
            <?php if(isset($current_user) && $user->id == $current_user->id){ ?>
                <p><?php echo Html::anchor("videokes/new", "<i class='icon-play-circle'></i> Add a Videoke", array("class" => "button rounded-corners")); ?> </p>
            <?php } ?>
        </h2>
		
		
        <div id="videokes" class="content-box clearfix">
            
            <div id="manage-videokes">
                
                <h3 class="clearfix">
                    <p>Showing All Videos (<span class="count"><?php echo $count; 	?></span>)</p>
                </h3>

                <?php if(isset($current_user) && $user->id == $current_user->id){ ?>
                    <div id="edit-videokes-button-container" class="clearfix <?php echo $count < 0 ? "hidden" : ''; ?>">
                        <a href="#" class="button rounded-corners">
                            <i class="icon-edit"></i> Edit Videokes
                        </a>
                    </div>
                <?php } ?>

                <div class="items videos clearfix">
                    <?php if (count($videokes) > 0) : ?>
                        <?php echo View::forge("videokes/partials/index_list", array("videokes" => $videokes)); ?>
                        <?php echo $pagination->render(); ?>
                    <?php else : ?>
                        <p class="highlight-box">No videokes uploaded yet!</p>
                    <?php endif;?>
                </div>

                <p class="back"><?php echo Html::anchor("users/show/$user->id", "Back"); ?></p>
            </div>
		</div>
	</div>
</div>
