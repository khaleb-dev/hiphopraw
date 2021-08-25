<div id="middle">
    <div id="content" class="full">
        <h1>Account Activation!</h1>
        <p>This account activation email was sent because you recently signed up for using WHEREWEALLMEET.Confirm your registration by clicking the link below.</p>
        <p>
            <?php echo Html::anchor(Uri::base(false)."/users/activate/$activation_code", "Click here to activate your account!") ?>
        </p>
        <p>
            Click <?php echo Html::anchor(Uri::base(false), "here") ?> to visit WHEREWEALLMEET.
        </p>
    </div>
</div>
