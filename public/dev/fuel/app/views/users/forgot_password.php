<div id="center">
    <div id="content" class="narrow">
        <div id="center-form-container" class="clearfix">
            <h2><span>Forgot Password</span></h2>
            <p>Give us your email <span>for us to send you the reset email</span></p>
            <div class="content-box">
                <?php echo Form::open(array("action" => "users/forgot_password")) ?>

                <p>
                    <label for="email">Your email</label>
                    <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
                    <span class="error"><?php echo Validation::instance()->error('email');?></span>
                </p>

                <p class="submit with-margin">
                    <?php echo Form::submit('', 'Submit', array("class" => "button rounded-corners")); ?>
                    Not yet registered, <?php echo Html::anchor("users/sign_up", "Sign Up!"); ?>
                </p>

                <?php echo Form::close(); ?>
            </div>
        </div>

    </div>
</div>