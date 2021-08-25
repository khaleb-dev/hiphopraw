<?php echo View::forge('member/signup_header'); ?>
<div id="content-full">
    <?php if (!$success): ?>
        <div id="login-error">
            <h2>Login Failed!</h2>            
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>
    <div id="login-form">
        <form method="post" action= <?php echo BASEURL . "/member/login" ?>  id="login_form">
            <p>
                <label>Username:</label>
                <input type="text" name="username" class="text-field long"/>
            </p>
            <p>
                <label>Password:</label>
                <input type="password" name="password" />
                <span>(6-16 characters MUST include numbers no spaces)</span>
                <span>Forgot Your <a href="<?php echo BASEURL . '/member/password_reset' ?>">Password</a> / <a href="<?php echo BASEURL . '/member/resend_username' ?>">Username</a>?</span>
            </p>
            <p class="submit">
                <input type="submit" name="btnLogin" value="login"/>
            </p>
        </form>
    </div>
</div>

<?php echo View::forge('partials/footer'); ?>