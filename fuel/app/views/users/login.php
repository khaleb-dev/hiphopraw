
<div class="main-container" id="login-container" xmlns="http://www.w3.org/1999/html">
    <div class="login-inner-con inner-container">
        <div class="top-title">
            <p class="pull-left main-title">Login</p>
            <div class="pull-right black-bg">
                <p><span class="red">HIPHOPRAW.COM</span>...THE NEW PLACE FOR <span class="red">HIPHOP</span>!</p>
            </div>
            <div class="clearfix"></div>
            <hr/>
        </div>
   <div class="content-box" style="padding-top: 40px;">

        <form action="<?php echo Uri::create('users/login'); ?>" class="block-form with-boundary clearfix" id="login-form" method="post">
            <?php if(isset($wrong_credentials) && $wrong_credentials){?>
                <span class="error red" id="wrong-credentials" style="display: block">Wrong username/password combination. Please try again</span>
            <?php }?>
            <?php if(isset($account_blocked) && $account_blocked){?>
                <span class="error red" id="user-blocked" style="display: block">Your account is blocked. Please contact Hip Hop Raw admin for solution.</span>
            <?php }?>
            <?php if(isset($account_inactive) && $account_inactive){?>
                <span class="error red" id="user-inactive" style="display: block">Your account is awaiting activation. Please use the link in your confirmation email to activate your account.</span>
            <?php }?>

            <div>
                <p>
                    <label for="username">Username: &nbsp;</label>
                    <input class="input-field username" name="username"  placeholder="User Name" type="text">
                    <span class="red" style="display: inline-block">&lowast;</span>
                    <span class="error red empty" >Please enter your username</span>
                </p>

                <p>
                    <label for="password">Password: &nbsp;</label>
                    <input class="input-field password" name="password"  type="password">
                    <span class="red" style="display: inline-block">&lowast;</span>
                    <span class="error red empty">Please enter your password</span>
                </p>

                <p class="submit with-margin">
                    <input type="submit" value="Login" class="button rounded-corners"/>
                    Not yet registered, <a class="signup-btn" href="#">
                        Sign Up Now
                    </a>
                </p>

                <p class="submit with-margin">
                    <?php echo Html::anchor("users/forgot_password", "Forgot your password?"); ?>
                </p>

                <p class="explanation">
                    <span class="with-margin"><span class="red" style="display: inline-block">&lowast;</span> indicates the field is required.</span>
                </p>

            </div>
        </form>
    </div>
    </div>
</div>