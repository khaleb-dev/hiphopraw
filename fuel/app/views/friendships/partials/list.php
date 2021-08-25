<?php foreach($friends as $friend) { ?>
	<?php echo View::forge("friendships/partials/single", array("friend" => $friend, "action" => $action)); ?>
<?php } ?>