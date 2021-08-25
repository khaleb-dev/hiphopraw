<?php if (isset($current_user) && $videoke->user_id == $current_user->id) { ?>
    <?php echo Form::open(array("id" => "videoke-form-" . $videoke->id, "action" => "videos/delete")); ?>
    <?= Form::hidden('id', $videoke->id); ?>
    <div class="actions">
        <a class="grey-btn edit-video" href="#" data-text="Edit video" data-id="<?= $videoke->id ?>"
           url="<?php echo Uri::create('videos/edit'); ?>">
            <span>Edit</span>
        </a>

        <a class="grey-btn cancel-delete" href="#" data-text="Cancel Delete Video" data-id="<?= $videoke->id ?>">
            <span>Cancel</span>
        </a>

        <a class="grey-btn delete-video" href="#" data-text="Delete video" data-id="<?= $videoke->id ?>"
           data-state="ready">
            <span>Delete</span>
        </a>
    </div>
    <?php echo Form::close(); ?>
<?php } ?>
