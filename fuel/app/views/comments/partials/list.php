<?php foreach($comments as $comment) { ?>
    <?php if(isset($addReplyLink)) { ?>
		<?php echo View::forge("comments/partials/single", array("comment" => $comment, "addReplyLink" => $addReplyLink)); ?>
	<?php } else { ?>
		<?php echo View::forge("comments/partials/single", array("comment" => $comment)); ?>
	<?php } ?>
<?php } ?>