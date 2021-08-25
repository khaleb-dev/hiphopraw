<?php echo View::forge('member/signup_header'); ?>
<div id="content-full">
    <?php if ($status == "activated"): ?>
        <div id="confirmation">
            <h2>Account Activated</h2>
            <p>Your account has been successful activated. <a href="<?php echo BASEURL; ?>">Click here</a> to login</p>
        </div>
    <?php elseif ($status == "resent"): ?>
        <div id="confirmation">
            <h2>Activation Code Sent</h2>
            <p>Your account activation code has been sent to your email. 
                Please use the link forwarded in your email to activate your account.</p>
        </div>
    <?php elseif ($status == "error"): ?>
        <div id="account-activation-error">
            <h2>Account Activation Error!</h2>            
            <p><?php echo $error; ?>To <strong>resend</strong> your activation code, please fill in your email address below.</p>
            <p></p>
            <div id="request-activation">
                <form method="post" action="<?php echo BASEURL . '/member/activation_confirmation'; ?>" >
                    <p>
                        <input type="text" name="email" class="text-field long" />
                    </p>
                    <p>
                        <input class="submit_input" type="submit" src="" name="btnResend" value="Resend" />
                    </p>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php echo View::forge('partials/footer'); ?>
