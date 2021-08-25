<?php foreach($friends as $friend) { ?>
	<?php echo View::forge("friendships/partials/index_single", array("friend" => $friend)); ?>
<?php } ?>