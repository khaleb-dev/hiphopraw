<div id="content">
    <div id="center-form-container" class="login">
        <h2>Login</h2>
        <div>
            <?php echo Form::open(array("action" => "/users/login", "class" => "clearfix")) ?>
            <p>
                <label for="username">Username:</label>
                <?php echo Form::input('username', Validation::instance()->validated('username')); ?>
                <span class="error"><?php echo Validation::instance()->error('username'); ?></span>
            <p>
                <label for="password">Password:</label>
                <?php echo Form::password('password', ''); ?>
                <span class="error"><?php echo Validation::instance()->error('password'); ?></span>
            </p>

            <p class="submit">
                <span>Forgot Your <a href="<?php echo Uri::base() . 'users/forgot_password'; ?>">Password</a>?</span>
                <input type="submit" name="btnLogin" value="login"/>
            </p>
            <p class="notice">
                <em>&#42; All fields in this form are required.</em>
            </p>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>