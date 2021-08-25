<?php echo Form::open(array("id" => "message-form","action" => "users/". $current_user->id . "/messages/update/" . $message->id)); ?>
    <?php echo Form::hidden('from_user_id', $current_user->id); ?>
    <p>
        <label for="user_id">Member:</label>
        <?php echo Form::select('to_user_id', $message->to_user_id, $users); ?>
        <span class="error with-margin"><?php echo Validation::instance()->error('to_user_id');?></span>
    </p>
    <p>
        <label for="title">Title:</label>
        <?php echo Form::input('title', $message->title); ?>
        <span class="error with-margin"><?php echo Validation::instance()->error('title');?></span>
    </p>
    <p>
        <label for="description">Message:</label>
        <?php echo Form::textarea('detail', $message->detail); ?>
        <span class="error with-margin"><?php echo Validation::instance()->error('detail');?></span>
    </p>
    <p>
        <label for="description">Draft:</label>
        <?php echo Form::checkbox('is_draft', true); ?>
    </p>
    <p class="submit with-margin">
        <?php echo Form::submit('', 'Send', array("class" => "button rounded-corners")); ?>
    </p>
<?php echo Form::close(); ?>