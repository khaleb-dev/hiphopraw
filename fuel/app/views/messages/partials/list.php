<?php foreach($messages as $message) { ?>
    <?php echo View::forge("messages/partials/single", array("message" => $message, "status" => $status)); ?>
<?php } ?>