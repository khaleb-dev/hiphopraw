<?php $idx = 0;?>
<?php foreach($videokes as $videoke){ ?>
    <?php echo View::forge('videokes/partials/single_item', array('index' => $idx, 'videoke' => $videoke));?>
    <?php $idx++;?>
<?php } ?>
