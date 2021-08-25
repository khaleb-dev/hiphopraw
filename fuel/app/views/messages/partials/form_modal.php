<a href="#message-form-modal" role="button" class="" data-target="#message-form-modal" data-toggle="modal">
    <i class='icon-envelope'></i> Send a Message</a>

<div id="message-form-modal" class="modal hide fade rounded-corners" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix">
        <a href="#" class="close" data-dismiss="modal">&times;</a>
        <h3>Send a Message to <?php echo $user->username ?></h3>
    </div>
    <?php echo Form::open(array("id" => "modal-message-form", "action" => "messages/create_ajax")); ?>
        <div class="modal-body">
            <?php echo Form::hidden('from_user_id', $current_user->id); ?>
            <?php echo Form::hidden('to_user_id', $user->id); ?>
            <?php echo Form::hidden('status', Model_Message::SENT); ?>
            <?php echo Form::hidden('read_status', Model_Message::UNREAD); ?>
            
            <p>
                <?php echo Form::input('title', Validation::instance()->validated('title'), array("placeholder" => "Title")); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('title'); ?></span>
            </p>
            <p>
                <?php echo Form::textarea('detail', Validation::instance()->validated('detail'), array("placeholder" => "Message")); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('detail'); ?></span>
            </p>            
        </div>
        <div class="modal-footer rounded-corners-bottom">        
            <p>
                <a href="#" class="pull-right button rounded-corners" data-dismiss="modal">Close</a>
                <input type="button" class="pull-right button rounded-corners" value="Send Message" />

            </p>
        </div>
    <?php echo Form::close(); ?>
</div>
