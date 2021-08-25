<?php echo Form::open(array("id" => "comment-form", "action" => "users/" . $current_user->id . "/comments/create", "class" => "clearfix")); ?>
	<div id="commenter-thumb"> 
		<?php echo Html::anchor('users/show/' . $current_user->id, Html::img(Model_User::get_picture($current_user, "message")), array("class" => "commenter-thumb")); ?>
	</div>	
	<div id="comment-form-fields">
		<?php echo Form::hidden('videoke_id', $videoke->id); ?>
		<?php echo Form::hidden('user_id', $current_user->id); ?>
		<p>
			<?php echo Form::textarea('detail', ''); ?>
		</p>
		<p class="submit comment">
			<?php echo Form::submit('', 'Submit', array("class" => "button rounded-corners")); ?>
		</p>
	</div>
<?php echo Form::close(); ?>