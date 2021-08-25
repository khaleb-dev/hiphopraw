<?php echo View::forge('member/signup_header'); ?>
<?php if ($success): ?>
    <div id="confirmation">
        <p><h2>Registration Successful</h2></p>
    <p>A message has been sent to your email. Please use the link provided in your email to activate your account.</p>
    <p><a href="<?php echo BASEURL; ?>">Login</a></p>
    </div>
    <div class="clear">&nbsp;</div>
<?php else: ?> 
    <div class="container_main" >
        <div  class="leftside_main"> 
            <div class="join-today">
                <h1>Join TheManYouWant Today!</h1>
                <div class="separetor-line"></div>
                <h2> <span>The man you want</span> is the primary online dating service that pairs some of the most Premier and Successful men from around the world.with the most interesting beautiful women from around the world</h2>
                <h3>Other Benefit of becoming a member</h3>
                <u>
                    <li> <a href="#">First benefit of becoming a member </a></li>
                    <li> <a href="#">Second benefit of becoming a member</a></li>
                    <li> <a href="#">Third benefit of becoming a member</a></li>
                </u>
            </div>
            <div id="left-separetor"> </div>
            <div class="dating-concierge-container">
                <div id="dating-text"> <p>Sign Up for your Dating Concierge </p></div>
                <a href="<?php echo BASEURL . '/agent/index' ?>">
                    <?php echo Asset::img('signup/datingconceirgebg.png', array('class' => 'member-thumbnail')); ?>
                </a>
                <div id="text-info"> <h2>Text info goes here in this area text info goes here in this area text info goes here</h2></div>
                <div class="signup-container">
                    <div class="sign-up-text">
                        <a href="<?php echo BASEURL . '/member/signup' ?>">Sign up Now!</a>
                    </div>
                </div>
            </div>
        </div>
        <div  class="rightside_main"> 
            <div id="signup-title"> 
                <div id="join-text">
                    <p>JOIN NOW AND SEE MORE OF YOUR TOP MATCHES! </p>
                </div>
                <div id="complete-signup-text">
                    <p>Complete the 30 seconds sign up form below. </p>
                </div>
            </div>

            <?php if ($members): ?>
                <div class="members-photo-container">

                    <ul>
                        <?php foreach ($members as $i => $member): ?>
                            <li>
                                <div class="members-photo <?php echo $i < 4 ? "with-r-margin" : ""; ?>"> 
                                    <?php if (!empty($member['avatar'])): ?>
                                        <img class="member-thumbnail" src="<?php echo UPLOADURL . $member['username'] . '/' . $member['avatar'] ?>" />
                                    <?php else: ?>
                                        <!--<a href= "<?php echo BASEURL . '/profile/public_profile' ?>">-->
                                        <img class="member-thumbnail" src=" <?php echo BASEURL . '/default_images/' . ($member['gender'] == 'Female' ? 'woman.jpg' : 'man.jpg') ?>" />
                                        <!--</a>-->
                                    <?php endif; ?>
                                    <div class="membername"><p><?php echo $member['username']; ?> </p></div>
                                    <div class="memberaddress"><p><?php echo $member['city'] != '' ? ($member['city'] . ', ' . $member['state']) : $member['state']; ?></p></div>
                                    <div class="linkbuttonscontainer">
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('email.png'); ?> </a>
                                        </div> 
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('chat.png'); ?> </a>
                                        </div>
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('star.png'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            <?php else: ?>
                <div class="quick-search-message">
                    <p>
                        The Quick Search returns no result.Click <a href="<?php echo BASEURL ?>">here</a> to try again
                    </p>
                </div>
            <?php endif; ?>

            <div id="account-information-container">
                <?php if (!$success): ?>
                    <?php if ($errors): ?>

                        <div id="message" class="error">
                            <p> The following errors have occurred:</p>
                            <ul class="error-message">
                                <?php foreach ($errors as $key => $value): ?>
                                    <li><?php echo $value; ?></li>
                                <?php endforeach; ?>
                            </ul>                        
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <form method="post" action="#" id="signup_form" enctype="multipart/form-data">
                    <div class="title">
                        <p> Your Account Info </p>
                    </div>
                    <div class="separetor-line"></div>
                    <div id="personal-detail-container">
                        <div class="photo-uploader">
                            <div class="profile-photo"> 
                                <div class="photos">
                                    <?php if ($Iam): ?>
                                        <img class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($Iam == 'Woman' ? 'signup-woman.png' : 'signup-man.png') ?>" />
                                    <?php endif; ?>
                                </div>
                                <div id="link-buttons-container">
                                    <input hidden="true" type="file" name="avatar" size="1"/>
                                    <a class="upload-button">Add Photo</a>
                                </div>
                            </div>
                        </div>
                        <div class="verylong-input"> 
                            <p>
                                <label>Your Email Address</label>
                                <input type="text" name="email"/>
                            </p>
                            <p>
                                <label>First Name:</label>
                                <input type="text" name="first_name" />
                            </p>
                            <p>
                                <label>Last Name:</label>
                                <input type="text" name="last_name" />
                            </p>
                            <p>
                                <label>Choose a Username</label>
                                <input type="text" name="username"/>
                            </p>
                            <p>
                                <label>Password:</label>
                                <input type="password" name="password" />
                            </p>
                            <p>
                                <label>Confirm Password:</label>
                                <input type="password" name="confirm_password" />
                            </p>
                        </div>

                    </div>
                    <div class="full-bottom-line"></div>
                    <div class="title">
                        <p> Personal Details </p>
                    </div>
                    <div class="separetor-line"></div>
                    <div id="personal-detail-container">

                        <div id="personal-detail-left-columen">
                            <div class="long-input">
                                <label>My Caption/Greeting:</label>
                                <input type="text" name="my_caption"/>
                            </div>
                            <div class="medium-input">
                                <label>Birthday:</label>
                                <?php $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"); ?>
                                <select name="month">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $month_names[$i - 1]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="short-input">
                                <?php $days = range(1, 31); ?>
                                <select name="day">
                                    <?php foreach ($days as $day) : ?>
                                        <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="medium-input">
                                <?php $years = range(date('Y'), 1900); ?>
                                <select name="year">
                                    <?php foreach ($years as $year) : ?>
                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="long-input">
                                <label>City:</label>
                                <input type="text" name="city"/>
                            </div>
                            <div class="long-select">
                                <label>State:</label>
                                <?php echo View::forge('partials/states_list'); ?>
                            </div>
                            <div class="long-input">
                                <label>Zip:</label>
                                <input type="text" name="zip"/>
                            </div>
                        </div>
                        <div id="personal-detail-right-columen">
                            <div class="long-select">
                                <label>Gender:</label>
                                <select name="gender">
                                    <?php foreach ($genders as $gender) : ?>
                                        <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="long-select">
                                <label>Height:</label>
                                <select name="height" class="long">
                                    <option value="<152 cm"><152 cm</option>
                                    <option value="152-154 cm">152-154 cm</option>
                                    <option value="154-157 cm">154-157 cm</option>
                                    <option value="157-160 cm">157-160 cm</option>
                                    <option value="160-162 cm">160-162 cm</option>
                                    <option value="162-165 cm">162-165 cm</option>
                                    <option value="165-167 cm">165-167 cm</option>
                                    <option value="167-170 cm">167-170 cm</option>
                                    <option value="170-172 cm">170-172 cm</option>
                                    <option value="172-175 cm">172-175 cm</option>
                                    <option value="175-177 cm">175-177 cm</option>
                                    <option value="177-180 cm">177-180 cm</option>
                                    <option value="180-182 cm">180-182 cm</option>
                                    <option value="182-185 cm">182-185 cm</option>
                                    <option value="185-187 cm">185-187 cm</option>
                                    <option value="187-190 cm">187-190 cm</option>
                                    <option value="190-193 cm">190-193 cm</option>
                                    <option value="193-195 cm">193-195 cm</option>
                                    <option value=">193 cm">>193 cm</option>
                                </select>
                            </div>
                            <div class="long-select">
                                <label>Body Type:</label>
                                <select name="body_type">
                                    <?php foreach ($body_types as $body_type) : ?>
                                        <option value="<?php echo $body_type; ?>"><?php echo $body_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="long-select">
                                <label>Eye Color:</label>
                                <select name="eye_color">
                                    <?php foreach ($eye_colors as $eye_color) : ?>
                                        <option value="<?php echo $eye_color; ?>"><?php echo $eye_color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="long-select">
                                <label>Hair Color:</label>
                                <select name="hair_color">
                                    <?php foreach ($hair_colors as $hair_color) : ?>
                                        <option value="<?php echo $hair_color; ?>"><?php echo $hair_color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="long-select">
                                <label>Ethnicity:</label>
                                <select name="ethnicity">
                                    <?php foreach ($ethnicities as $ethnicity) : ?>
                                        <option value="<?php echo $ethnicity; ?>"><?php echo $ethnicity; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div id="personal-detail-submit-container">
                            <input class="submit_input" type="submit" src="" name="btnSignup" value="SEE YOUR TOP MATCHES NOW!" />
                            <p>* By clicking the "SEE YOUR TOP MATCHES NOW" button above you confirm that you accept our Terms & Conditions</p>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="clear">&nbsp;</div>
    </div>
<?php endif; ?>
<?php echo View::forge('partials/footer'); ?>