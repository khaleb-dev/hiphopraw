<div class="dialog-signup login-sign-up-container" id="sign-up-container" xmlns="http://www.w3.org/1999/html">
    <div id="title_bar">
        <span id="title-bar-left-text">Sign Up Now</span>
                        <span id="title-bar-right-text">hiphopraw.com<span class="white"> ...the new place for </span> hip hop <span
                                class="white">!</span></span>
    </div>
    <?php echo Asset::img("submit-wait.gif", array("class" => "submit-wait")); ?>
    <div id="join-hiphopraw">
        Join Hiphopraw.com today! It's <span class="red">easy</span> and <span class="red">free</span>
    </div>

    <div class="stripe1 light-gray-background signup-separator"></div>

    <!--    start sign up form-->
    <form action="<?php echo Uri::create('users/sign_up'); ?>" class="block-form with-boundary clearfix"
          id="sign-up-form" method="post">
        <div class="half">
            <p>
                <label for="first_name">First Name: &nbsp;</label>
                <input class="input-field first_name" name="first_name" placeholder="First Name" type="text">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter your first name</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="last_name">Last Name: &nbsp;</label>
                <input class="input-field last_name" name="last_name" placeholder="Last Name" type="text">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter your last name</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="username">Username: &nbsp;</label>
                <input class="input-field username" name="username" placeholder="User Name" type="text">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter a username</span>
                <span class="error red duplicate">User Name is already taken</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="stage_name">Stage Name: &nbsp;</label>
                <input class="input-field stage_name" name="stage_name" placeholder="Stage Name" type="text">
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="email">Email: &nbsp;</label>
                <input class="input-field email" name="email" placeholder="Email Address..." type="text">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red invalid-email">Please enter a valid email address</span>
                <span class="error red duplicate">Email address is associated with another account</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="password">Password: &nbsp;</label>
                <input class="input-field password" name="password" type="password">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter a password</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="confirm_password">Confirm: &nbsp;</label>
                <input class="input-field confirm_password" name="confirm_password" type="password">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red mismatch">Passwords do not match.</span>
            </p>

            <p>
                <label for="city">City: &nbsp;</label>
                <input class="input-field city" name="city" placeholder="City" type="text">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter the city you live in</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            </p>

            <p>
                <label for="state">State: &nbsp;</label>
                <select class="choose-state" name="state">
                    <?php
                    $states = Model_State::getStates();
                    for ($i = 1; $i <= sizeof($states); $i++) {
                        echo '<option value="' . $states[$i] . '">' . $states[$i] . "</option>";
                    }
                    ?>
                </select><span class="red" style="display: inline-block">&nbsp;&lowast;</span>
            </p>
            
            <p class="choose-state">
                <label for="state">Fan &nbsp;</label>
                <input type="checkbox" name="fan" value="fan"><span class="fan"> check if you are <strong>NOT</strong> a hiphop artist or model.</span>
            </p>

            <p class="explanation">
                <span class="with-margin"><span class="red" style="display: inline-block">&lowast;</span> indicates the field is required.</span>
            </p>
        </div>

        <div class="half text">
            <div id="hhr-logo-large">
                <?php echo Asset::img("hhr-logo-large.png"); ?>
            </div>
            <br/>

            <p>
                Join <span class="black inline">HipHopRaw.com</span> today & you can <span
                    class="black inline">connect</span> & <span class="black inline">chat</span> with
                friends & other members, <span class="black inline">upload videos</span> of your talent,
                <span class="black inline">be recognized</span> for your talent, & most importantly be able
                to <span class="black inline">enter your videos</span> in our video <span
                    class="black inline">contest</span> where you can win monthly <span
                    class="black inline">$$$</span> & <span class="black inline ">prizes</span>, & gain the
                exposure <span class="black inline">YOU</span> deserve!
            </p>
            <br/>

            <div style="text-align: center">
                <input type="submit" value="" id="sign-up-submit-button">
                <a id="cancel-signup" href="">Cancel Sign Up</a>
            </div>

        </div>

    </form>
    <!--    end sign up form-->

    <!--    start sign up success dialog-->
    <div class="dialog success-dialog" id="sign-up-form-success">
        <h4> A confirmation email has been sent to your email address. Please activate your account. <br/>If you dont find the email in your inbox, please check the spam folder.</h4>
    </div>
    <!--    end sign up success-->

    <!--    start sign up error dialog-->

    <div class="dialog error-dialog" id="sign-up-form-error">
        <h5>An error has occurred in the Sign up process. Please retry later or contact the system administrator.</h5>
    </div>
    <!--    end sign up error-->
</div>

