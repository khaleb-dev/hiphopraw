<div class="item" id="videoke_<?=$videoke->id?>">
    <?php echo Html::anchor("videokes/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT))); ?>
    <h3><?php echo Html::anchor("videokes/show/" . $videoke->id, $videoke->title); ?></h3>
    <p class="views">Views(<?php echo $videoke->views; ?>) By: <?php echo $videoke->user->username; ?></p>
    <?php echo View::forge("videokes/partials/action_buttons", array("videoke" => $videoke)); ?>
</div>
