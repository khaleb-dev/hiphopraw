<div id="center" class="clearfix">
	<div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>            
    </div>
	<div id="content" class="with-sidebar-left profile">
		<div id="comments">
			<div class="content-box">
				<h3>Showing All Comments(3)</h3>
				<?php if( ! $current_user ) { ?>
					<p class="highlight-box">
						<?php echo Html::anchor(Router::get("login"), "Sign in"); ?> now to post a comment!
					</p>
				<?php } ?>
				
				<div class="comment-list">
					<?php if(count($comments) > 0) { ?>
						<?php echo View::forge("comments/partials/list", array("comments" => $comments, "addReplyLink" => true)); ?>
						<?php echo $pagination->render(); ?>
					<?php } else { ?>
						<p class="highlight-box">No comments found!</p>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>