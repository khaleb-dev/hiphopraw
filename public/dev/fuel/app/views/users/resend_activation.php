<div id="content">
    <div id="center-form-container" class="login">
        <h2>Account Activation</h2>
        <div>
            <p id="error-msg"><?php echo isset($error_message) ? $error_message : ""; ?></p>
            <?php echo Form::open(array("action" => "/users/send_activation", "class" => "clearfix")) ?>
            <p>
                <label for="email">Email:</label>
                <?php echo Form::input('email'); ?>
                <span class="error"><?php echo Validation::instance()->error('email'); ?></span>
            </p>
            <p class="submit">
                <input type="submit" name="btnSendActivation" value="Send Activation Code"/>
            </p>
            <?php echo Form::close(); ?>
        </div>
    </div>
</div>