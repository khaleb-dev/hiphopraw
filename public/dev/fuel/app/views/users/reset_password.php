<div id="center">
    <div id="content" class="narrow">
        <div id="center-form-container" class="clearfix">
            <h2><span>Reset Password</span></h2>

            <div class="content-box">
                <?php echo Form::open(array("action" => "users/reset", "class" => "block-form with-boundary")) ?>

                <?php echo Form::input('username',  $username, array("class" => "text-field long", "hidden" => "hidden")); ?>
                <p>
                    <label for="password">New Password &nbsp;</label>
                    <?php echo Form::password('password',  '', array("class" => "text-field long")); ?>&lowast;
                    <span class="error"><?php echo Validation::instance()->error('password');?></span>
                </p>
                <p>
                    <label for="confirm_password">Confirm &nbsp;</label>
                    <?php echo Form::password('confirm_password',  '', array("class" => "text-field long")); ?>&lowast;
                    <span class="error"><?php echo Validation::instance()->error('confirm_password');?></span>
                </p>
                <p class="submit with-margin">
                    <?php echo Form::submit('', 'Reset Password', array("class" => "button rounded-corners")); ?>
                </p>

                <p class="explanation">
                    &lowast; indicates the field is required.
                </p>

                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
