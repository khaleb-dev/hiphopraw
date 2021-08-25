<div id="content">
    <?php if(isset($success)): ?>
        <div id="activation" class="success">
            <h2>Activation successful</h2>
            <p>Your account has been successful activated. <?php echo Html::anchor(Uri::base(false), "Click here") ?> to login.</p>
        </div>
    <?php  else: ?>
        <div id="activation" class="error">
            <h2>Account Activation Error!</h2>
            <p><?php echo $error; ?></p>
        </div>
    <?php endif; ?>
</div>