    <div id="content" >

            <div id="center-form-container" class="sign-up">
                <?php if(isset($success)): ?>
                    <div id="confirmation">
                        <h2>Sign up successful</h2>
                        <div>
                            <p>A message has been sent to your email. Please use the link provided in your email to activate your account.</p>
                            <p>Please check your spam folder in your email if you don't see the authentication email in your inbox folder.</p>
                        </div>
                    </div>
                <?php  else: ?>
                    <h2>Create a Free Account</h2>
                    <div>
                        <?php echo Form::open(array("action" => "/users/sign_up", "class" => "clearfix")) ?>
                        <?php if (isset($error)) { ?>
                            <p class="error"><?php echo $error; ?></p>
                        <?php } ?>

                        <p>
                            <label for="first_name">First Name:</label>
                            <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('first_name'); ?></span>
                        </p>
                        <p>
                            <label for="last_name">Last Name:</label>
                            <?php echo Form::input('last_name', Validation::instance()->validated('last_name')); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('last_name'); ?></span>
                        </p>
                        <p>
                            <label for="email">Email:</label>
                            <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('email'); ?></span>
                        </p>
                        <p>
                            <label for="username">Username:</label>
                            <?php echo Form::input('username', Validation::instance()->validated('username')); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('username'); ?></span>
                        <p>
                            <label for="password">Password:</label>
                            <?php echo Form::password('password', ''); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('password'); ?></span>
                        </p>
                        <p>
                            <label for="confirm_password">Confirm Password:</label>
                            <?php echo Form::password('confirm_password', ''); ?>
                            <span class="error with-margin"><?php echo Validation::instance()->error('confirm_password'); ?></span>
                              
                                <?php echo Form::hidden('disable', Input::post('disable'), array('class' => 'error with-margin', 'placeholder'=>'Message status'));  ?>
                        </p>
                        <p>
                            <label>Gender:</label>
                            <select name="gender_id">
                                <?php foreach ($genders as $item) : ?>
                                    <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <p class="submit">
                            <span>By signing up you agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy Policy</a></span>
                            <input type="submit" name="btnGetStartedHim" value="Sign Up"/>
                        </p>
                        <p class="notice">
                            <em>&#42; All fields in this form are required.</em>
                        </p>
                        <?php echo Form::close(); ?>
                    </div>
                <?php endif; ?>
            </div>
    </div>