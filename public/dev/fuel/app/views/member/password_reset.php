<?php echo View::forge('member/signup_header'); ?>
<div id="content-full">
    <?php if (!empty($message)): ?>
        <?php if (!$success): ?>
            <div id="login-error">
                <h2>Password Reset Failed!</h2>            
                <p><?php echo $message; ?></p>
            </div>
        <?php else : ?>
            <div id="confirmation-message">
                <h2>Password Reset Successful</h2>
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="center-form">
        <h2>TMYW Password Reset</h2>
        <div id="request-activation">
            <form method="post" action="<?php echo BASEURL . '/member/password_reset'; ?>" >
                <p>
                    <input type="text" name="email" class="text-field long" />
                </p>
                <p>
                    <input class="submit_input" type="submit" src="" name="btnPasswordReset" value="Submit" />
                </p>
            </form>
        </div>
    </div>
</div>
<?php echo View::forge('partials/footer'); ?>