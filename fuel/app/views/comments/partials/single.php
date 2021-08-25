<?php $comment_owner = \Model\Auth_User::find($comment->user_id); ?>
<div class="comment clearfix">
	<?php echo Html::anchor('users/show/' . $comment_owner->id, Html::img(Model_User::get_picture($comment_owner, "message")), array("class" => "commenter-thumb")); ?>
	<div class="comment-detail">
		<p class="commenter"><strong><?php echo $comment_owner->username; ?></strong> <em><?php echo Date::time_ago($comment->created_at); ?></em></p>
		<p class="detail"><?php echo $comment->detail; ?></p>
		<?php if(isset($addReplyLink)){ ?>
			<p class="reply"> 
				<?php echo Html::anchor("videokes/show/$comment->videoke_id", "Reply"); ?>
			</p>
		<?php } ?>
	</div>
</div>