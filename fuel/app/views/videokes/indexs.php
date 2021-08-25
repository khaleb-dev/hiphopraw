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

    <!-- video show page -->
    <div class="clearfix"></div>

    <div class="video-detail-center">

        <div class="video-wrapper">
            <div class="title">
                <p class="left-title">TITLE OF THE ARTIST - NAME OF VIDEO</p>
                <div class="right-title"><p> <?php echo Asset::img("videoke/video-detail-circle.jpg"); ?> 315.7K</p></div>
            </div>
            <div class="clearfix"></div>
            <div class="video-inner">
                <?php echo Asset::img("videoke/video-detail.jpg"); ?>
             </div>

        </div>

        <div class="other-video-wrap">
            <div class="title">
                <p class="main-title">OTHER VIDEOS BY USERNAME</p>
                <hr class="divider" />
             </div>
              <div class="scroller">
                    <div class="left-scroll"><?php echo Asset::img("videoke/left-scroller.png"); ?> </div>
                    <div class="other-videos"><?php echo Asset::img("videoke/sample-other-video.jpg"); ?> </div>
                    <div class="right-scroll"><?php echo Asset::img("videoke/right-scroller.png"); ?> </div>
                    <div class="clearfix"></div>

              </div>
        </div>

        <div class="comment">
            <div class="title">
                <p class="main-title">COMMENTS</p>
                <hr class="divider" />
            </div>
        </div>

    </div>
    <div class="videokes-right content-box clearfix">
        <p class="header-text">VIDEO SUGGESTIONS</p>
        <hr class="divider"/>
        <?php
        for($i=0; $i<3; $i++) {
            echo View::forge("videokes/partials/single_item");
            echo '<div class="clearfix"></div><hr class="thin-divider" />';}
        ?>
        <p><a class="red pull-right see-more-link" href="#">&gt; SEE MORE</a></p>
    </div>
    <!-- end video show page -->
	
	<div class="clearfix separator"></div>

</div>
