<?php echo View::forge('member/signup_header'); ?>
<div id="content-full">
    <?php if (!empty($message)): ?>
        <?php if (!$success): ?>
            <div id="login-error">
                <h2>Resend Username Failed!</h2>            
                <p><?php echo $message; ?></p>
            </div>
        <?php else : ?>
            <div id="confirmation-message">
                <h2>Resend Username Successful</h2>
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="center-form">
        <h2>TMYW Username Resend</h2>
        <div id="request-activation">
            <form method="post" action="<?php echo BASEURL . '/member/resend_username'; ?>" >
                <p>
                    <input type="text" name="email" class="text-field long" />
                </p>
                <p>
                    <input class="submit_input" type="submit" src="" name="btnUsernameResend" value="Submit" />
                </p>
            </form>
        </div>
    </div>
</div>
<?php echo View::forge('partials/footer'); ?>