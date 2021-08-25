<div id="middle">
    <div id="content" class="full">
        <p>
            Please use this link to login and reset your password.
            <?php echo Html::anchor(Uri::create("users/reset_password/$reset_code"), "Reset Password") ?>
        </p>
    </div>
</div>
