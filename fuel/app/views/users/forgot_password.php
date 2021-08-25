<div class="main-container">
    <div class="inner-container">
        <div class="top-title">
            <p class="pull-left main-title">Request Password Reset</p>

            <div class="pull-right black-bg">
                <p><span class="red">HIPHOPRAW.COM</span>...THE NEW PLACE FOR <span class="red">HIPHOP</span>!</p>
            </div>
            <div class="clearfix"></div>
            <hr/>
        </div>
        <div class="reset-pass-container">
            <p class="title">Give us your <span class="red">Email</span> For Us To Send You <span class="red">The Reset Email</span>
            </p>

            <form action="<?php echo Uri::create("users/forgot_password") ?>" method="post" id="forget-password-form">
                <p class="input-holder">
                    <span class="pull-left gray">Email Address: </span>
                    <input type="text" name="email" id="email" value="<?php echo isset($email)?  $email:"";?>"/>
                    <span class="red pull-left astriek">*</span>
                    <span class="error red invalid-email">Please enter a valid email address</span>
                    <span class="error red too-long">Please enter an email address shorter than 255 characters</span>
                    <?php if(isset($email_not_registered)){
                        if($email_not_registered){?>
                        <span class="error red email-not-registered" style="display: block;">Your email is not registered. Please Sign Up to get a new account!</span>
                    <?php }} ?>
                <div class="clearfix"></div>
                </p>
                <button class="pull-left btn-black" type="submit">Submit</button>
                <span class="pull-left frm-bottom-label">Not yet registered, <a href="#" class="red signup-btn">Sign Up!</a></span>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>

<div class="bottom-white-wrap">
    <div class="container">
        <p class="pull-left"><span class="red">ARE YOU RAW?</span> UPLOAD YOUR VIDEO TO HHR AND FIND OUT!!
            <button class="btn-black" type="submit">Submit Your Video</button>
        </p>
    </div>
</div>

<!-- <div id="center">
    <div id="content" class="narrow">
        <div id="heading-with-ad" class="clearfix">
            <h2><span>Request Password Rest</span></h2>
            <div id="heading-ad">
                <h2>Give us your email <span>for us to send you the reset email</span></h2>
            </div>
        </div>
        <div class="content-box">
            <?php //echo Form::open(array("action" => "users/forgot_password")) ?>

            <p>
                <label for="email">Your email</label>
                <?php // echo Form::input('email', Validation::instance()->validated('email')); ?>
                <span class="error"><?php //echo Validation::instance()->error('email');?></span>
            </p>

            <p class="submit with-margin">
                <?php // echo Form::submit('', 'Submit', array("class" => "button rounded-corners")); ?>
                Not yet registered, <?php //echo Html::anchor(Router::get("sign_up"), "Sing Up!"); ?>
            </p>

            <?php //echo Form::close(); ?>
        </div>
    </div>
</div> -->