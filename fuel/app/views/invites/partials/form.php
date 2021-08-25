<a href="#invite-form-modal-container" role="button" class="button grey modal-button" data-target="#invite-form-modal" data-toggle="modal">
    <i class='icon icon-share-alt'></i> Share
</a>

<div id="invite-form-modal" class="modal hide fade rounded-corners" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header clearfix">
        <a href="#" class="close" data-dismiss="modal">&times;</a>
        <h3>Share with a Friend</h3>
    </div>
    <?php echo Form::open(array("action" => "invites/create_ajax", "id" => "modal-invite-form")); ?>
        <div class="modal-body">
             <?php echo Form::hidden('videoke_id', $videoke_id); ?>
            <p>
                <?php echo Form::input('emails', Validation::instance()->validated('emails'), array("placeholder" => "Email Addresses")); ?>
                <span class="notice">Please separate emails with a comma, <em>e.g. john@example.com, mary@site.org</em></span>
            </p>
            <p>
                <?php echo Form::textarea('message', Validation::instance()->validated('message'), array("placeholder" => "Message")); ?>
            </p>
        </div>
        <div class="modal-footer rounded-corners-bottom">        
            <p>
                <input type="button" class="button rounded-corners" value="Send" />
                <a href="#" class="button rounded-corners" data-dismiss="modal">Close</a>
            </p>
        </div>
    <?php echo Form::close(); ?>
</div>
