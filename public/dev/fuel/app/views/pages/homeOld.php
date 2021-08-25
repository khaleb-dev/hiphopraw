<div id="social" class="clearfix">
    <div id="newsletter-signup">
        <form action="">
            <label for="email">Enter your Email to join Our Newsletter Today!</label>
            <input type="text" name="email">
            <input type="button" value="Join Now">
        </form>
    </div>
    <div id="social-links">
        <p class="clearfix">
            <span>Stay Connected</span> <?php echo Html::anchor("http://facebook.com", Asset::img("facebook_icon.png")); ?> <?php echo Html::anchor("http://twitter.com", Asset::img("twitter_icon.png")); ?>
        </p>
    </div>
</div>

<section id="home">
    <div class="background clearfix">
        <?php echo Html::anchor(Router::get('home'), Asset::img('logo_main.png'), array("id" => "logo")); ?>
        <span id="beta">BETA</span>
        <div id="promo-section">
            <p id="members-login">Already a Member?<br>
                <a href="" id="login-here" data-dialog="login">Login Here</a>
            </p>

            <div id="promo-video">

                <div id="signup-her-dialog" class="dialog">
                    <i class="close-dialog fa fa-times-circle-o"></i>
                    <?php echo Asset::img("pages/home/quick_sign_up_her.jpg"); ?>
                    <div class="image-overlay">
                        <?php echo Asset::img("pages/home/logo_sign_up.png"); ?>
                        <h3>Sign Up Now & Meet Your Dream Match</h3>

                        <p>Your first name, last name and zip code of your billing address must match your credit card
                            information in order to subscribe to whereweallmeet.com" &copy; </p>
                    </div>
                    <div>
                        <div class="dialog-header">
                            <h2>Create a Free Account</h2>
                        </div>
                        <div class="dialog-content">
                            <form method="post" action="<?php echo \Fuel\Core\Uri::create('users/sign_up') ?>">

                                <p class="clearfix">
                                    <label>Gender:</label>
                                    <select name="gender_id">
                                        <option value="1">male</option>
                                        <option value="2">female</option>
                                    </select>&#42;
                                </p>
                                <p>
                                    <label>Birth Date:</label>
                                    <select name="month">
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select name="day">
                                        <?php for ($i = 1; $i <= 31; $i++): ?>
                                            <option><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select name="year">
                                        <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                                            <option><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>&#42;
                                </p>
                                <p>
                                    <label>State:</label>
                                    <select name="state">
                                        <option value="">Please Select</option>
                                        <?php foreach ($state as $item) : ?>
                                            <option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>&#42;
                                </p>
                                <p class="clearfix">
                                    <label>Preferred Ages:</label>
                                    <select name="ages_from">
                                        <?php for ($i = 18; $i <= 99; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <?php $i = 18; ?>
                                    </select>
                                    <label class="inline">to</label>
                                    <select name="ages_to">
                                        <?php for ($i = 18; $i <= 99; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <?php $i = 18; ?>
                                    </select>&#42;
                                </p>
                                <p>
                                    <label for="first_name">First Name:</label>
                                    <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>&#42;
                                </p>
                                <p>
                                    <label for="last_name">Last Name:</label>
                                    <?php echo Form::input('last_name', Validation::instance()->validated('last_name')); ?>&#42;
                                </p>
                                <p>
                                    <label for="email">Email:</label>
                                    <?php echo Form::input('email', Validation::instance()->validated('email')); ?>&#42;
                                </p>

                                <p>
                                    <label for="username">Username:</label>
                                    <?php echo Form::input('username', Validation::instance()->validated('username')); ?>&#42;

                                <p>
                                    <label for="password">Password:</label>
                                    <?php echo Form::password('password', ''); ?>&#42;
                                </p>

                                <p>
                                    <label for="confirm_password">Confirm Password:</label>
                                    <?php echo Form::password('confirm_password', ''); ?>&#42;
                                </p>

                                <p class="submit">
                                    <span>By signing up you agree to the <a href="#">Terms of Use</a> and the <a
                                            href="#">Privacy Policy</a></span>
                                    <input type="submit" name="btnGetStartedHer" value="Get Started Now"/>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="signup-him-dialog" class="dialog">
                    <i class="close-dialog fa fa-times-circle-o"></i>
                    <?php echo Asset::img("pages/home/quick_sign_up_his.jpg"); ?>
                    <div class="image-overlay">
                        <?php echo Asset::img("pages/home/logo_sign_up.png"); ?>
                        <h3>Looking for the Man You Want?</h3>

                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
                            Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes. </p>
                    </div>
                    <div>
                        <div class="dialog-header">
                            <h2>Create a Free Account</h2>
                        </div>
                        <div class="dialog-content">
                            <form method="post" action="<?php echo \Fuel\Core\Uri::create('users/sign_up') ?>" id="login_form">
                                <input type="hidden" name="gender_id" value="1" />
                                <p class="clearfix">
                                    <label>Preferred Ages:</label>
                                    <select name="ages_from">
                                        <?php for ($i = 18; $i <= 99; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <?php $i = 18; ?>
                                    </select>
                                    <label class="inline">to</label>
                                    <select name="ages_to">
                                        <?php for ($i = 18; $i <= 99; $i++) { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                        <?php $i = 18; ?>
                                    </select>
                                </p>
                                <p class="clearfix">
                                    <label>Postal Code:</label>
                                    <input type="text" name="postal_code"/>
                                </p>

                                <p>
                                    <label for="first_name">First Name:</label>
                                    <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>&#42;
                                </p>

                                <p>
                                    <label for="last_name">Last Name:</label>
                                    <?php echo Form::input('last_name', Validation::instance()->validated('last_name')); ?>&#42;
                                </p>

                                <p>
                                    <label for="email">Email:</label>
                                    <?php echo Form::input('email', Validation::instance()->validated('email')); ?>&#42;
                                </p>

                                <p>
                                    <label for="username">Username:</label>
                                    <?php echo Form::input('username', Validation::instance()->validated('username')); ?>&#42;

                                <p>
                                    <label for="password">Password:</label>
                                    <?php echo Form::password('password', ''); ?>&#42;
                                </p>

                                <p>
                                    <label for="confirm_password">Confirm Password:</label>
                                    <?php echo Form::password('confirm_password', ''); ?>&#42;
                                </p>

                                <p class="submit">
                                    <span>By signing up you agree to the <a href="#">Terms of Use</a> and the <a
                                            href="#">Privacy Policy</a></span>
                                    <input type="submit" name="btnGetStartedHim" value="Get Started Now"/>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <p>
            Where We All Meet is a social dating community that offers single men and women a opportunity  to interact
            and connect with existing friends and meet new friends for a genuine dating experience.
        </p>
        <p>
            <em>Whereweallmeet.com</em> will help you meet new singles by creating a friend network with your existing
            friends to connect with you and communicate with various communication tools, such as messaging, chat and
            pictures to share your experiences. Whereweallmeet.com thinks the best way to meet new and interesting people
            are from referrals from your friends.
        </p>
        <a href="" id="signup-her" data-dialog="signup-her-dialog">Sign Up Now</a>

    </div>
</section>

<section id="welcome">
    <div class="background clearfix">
        <div id="welcome-text">
            <h1>Welcome</h1>

            <p class="sub-title">To our <em>Premier Dating</em> Site!</p>

            <p>WhereWeAllMeet.com is a destination where <strong>premium members</strong> can join and share their <em>interests,
                    lifestyle, goals</em>
                and more with other premium members on WhereWeAllMeet.com</p>

            <p>WhereWeAllMeet.com is a social dating platform created to <em>increase</em> your changes of finding that
                <em>perfect match</em> by
                providing a social environment to <strong>add friends, chat</strong> and <strong>refer people</strong>
                to other members which will
                enable you to <em>meet</em> more people that share your <em>interests.</em></p>
            <?php echo Html::anchor("#", "Sign Up Now", array("id" => "sign-up-now", "data-dialog" => "signup-her-dialog")); ?>
        </div>
    </div>
</section>

<section id="dating-agent">
    <div class="background clearfix">
        <div id="dating-agent-text">
            <h1>Sign up for your personal <em>Dating Agent</em>!</h1>

            <p>We know the world of online dating can be stressful and time consuming. If you're a successful, discreet,
                selectively single individual,
                chances are you're finding it difficult to meet the right person. It's obvious you have everything to
                offer, but you're not about to settle;
                and meeting someone at a bar or club isn't your style. So with limited time and access to the caliber
                you're looking for, how will you ever meet your
                ideal made?</p>

            <p>WhereWeAllMeet.com will provide our Dating Concierges to help you in your search for that match you
                want.</p>
            <?php echo Html::anchor("#", "Sign Up Now", array("id" => "sign-up-now", "data-dialog" => "signup-now")); ?>
            <div id="signup-now" class="dialog">
                <?php echo Asset::img("logo_dialog_header.jpg"); ?>
                <div>
                    <div class="dialog-header">
                        <h2>Create a Free Account</h2>
                    </div>
                    <div class="dialog-content">
                        <form method="post" action="users/sign_up" class="clearfix">
                            <p>
                                <label>Gender:</label>
                                <select name="gender_id">
                                    <?php foreach ($genders as $item) : ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Birth Date:</label>
                                <select name="month">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="day">
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                        <option><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="year">
                                    <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                                        <option><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </p>
                            <p>
                                <label>State:</label>
                                <select name="state">
                                    <option value="">Please Select</option>
                                    <?php foreach ($state as $item) : ?>
                                        <option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error with-margin"><?php echo Validation::instance()->error('state'); ?></span>
                            </p>
                            <p>
                                <label>Preferred Ages:</label>
                                <select name="ages_from">
                                    <?php for ($i = 18; $i <= 99; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <?php $i = 18; ?>
                                </select>
                                <label class="inline">to</label>
                                <select name="ages_to">
                                    <?php for ($i = 18; $i <= 99; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <?php $i = 18; ?>
                                </select>
                            </p>
                            <p>
                                <label for="first_name">First Name:</label>
                                <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>
                            </p>

                            <p>
                                <label for="last_name">Last Name:</label>
                                <?php echo Form::input('last_name', Validation::instance()->validated('last_name')); ?>
                            </p>

                            <p>
                                <label for="email">Email:</label>
                                <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
                            </p>

                            <p>
                                <label for="username">Username:</label>
                                <?php echo Form::input('username', Validation::instance()->validated('username')); ?>

                            <p>
                                <label for="password">Password:</label>
                                <?php echo Form::password('password', ''); ?>
                            </p>

                            <p>
                                <label for="confirm_password">Confirm Password:</label>
                                <?php echo Form::password('confirm_password', ''); ?>
                            </p>

                            <p class="submit clearfix">
                                <span>By signing up you agree to the <a href="#">Terms of Use</a> and the <a href="#">Privacy
                                        Policy</a></span>
                                <input type="submit" name="btnGetStartedHim" value="Get Started Now!"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="get-started">
    <div class="background clearfix">
        <h1>How to get started</h1>

        <div id="steps" class='clearfix'>
            <div>
                <?php echo Asset::img("pages/home/sign_up_icon.png"); ?>
                <div>
                    <h3>Easy to Join</h3>

                    <p>Fill out a simple form and become a free member</p>
                    <?php echo Html::anchor(Router::get('home'), "Learn More", array(
                        'id' => 'easy-to-join',
                        'data-dialog' => 'easy-to-join-dialog',
                    )); ?>
                </div>
            </div>
            <div>
                <?php echo Asset::img("pages/home/user_icon.png"); ?>
                <div>
                    <h3>Build Your Profile</h3>

                    <p>Complete your profile and tell others about yourseflf and your interst on the site.</p>
                    <?php echo Html::anchor(Router::get('home'), "Learn More", array('id' => 'build-your-profile',
                        'data-dialog' => 'build-your-profile-dialog',)); ?>
                </div>
            </div>
            <div>
                <?php echo Asset::img("pages/home/concierge_icon.png"); ?>
                <div>
                    <h3>My Concierge</h3>

                    <p>Offering exclusive dating agent service for the discerning gentlman or woman.</p>
                    <?php echo Html::anchor(Router::get('home'), "Learn More", array('id' => 'my-concierge',
                        'data-dialog' => 'my-concierge-dialog',)); ?>
                </div>
            </div>
            <div>
                <?php echo Asset::img("pages/home/chat_icon.png"); ?>
                <div>
                    <h3>Chat instantly</h3>

                    <p>Use our instant messenger for real-time, one-to-one chats or group chat to get to know new
                        people.</p>
                    <?php echo Html::anchor(Router::get('home'), "Learn More", array('id' => 'chat-instantly',
                        'data-dialog' => 'chat-instantly-dialog',)); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="sign-up" class="clearfix">
    <div id="offer-text">
        <p>Are you a woman or a man tired of looking online in the random pool of people with unsatisfactory
            results?</p>

        <p>Where We All Meet offers people the opportunity to meet people online that are looking for a quality date
            choice.</p>
        <?php echo Asset::img("pages/home/logo_alt.png", array("id" => "logo-alternate")); ?>
    </div>

    <div class="background clearfix">

        <div id="sign-up-text-and-form">

            <p id="question">Want to <em>Find Your Dream Mate</em>?</p>

            <h1>Sign Up for WhereWeAllMeet Now!</h1>

            <p id="sign-up-answer">At WhereWeAllMeet.com we are always striving to better your experience. You can
                contact us for Customer Care or Business
                Enquiries (Alliances, co-branding, advertising, event listings and any other question you may have about
                WhereWeAllMeet.com).</p>

            <?php echo Form::open(array("action" => "", "class" => "clearfix")) ?>
            <p>
                <label for="first_name">Your Name:</label>
                <?php echo Form::input('first_name', Validation::instance()->validated('first_name')); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('first_name'); ?></span>
            </p>

            <p>
                <label for="email">Your Email Address:</label>
                <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('email'); ?></span>
            </p>

            <p class="full">
                <label for="username">Messsage:</label>
                <?php echo Form::textarea('message', Validation::instance()->validated('username'), array("placeholder" => "Enter your message")); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('username'); ?></span>
            </p>

            <p class="submit">
                <?php echo Form::submit('', "Contact Us Today", array("class" => "contact-submit")); ?>
            </p>
            <?php echo Form::close(); ?>
        </div>

    </div>

</section>

<div id="easy-to-join-dialog" class="dialog how-to-get-started">
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>It's Easy To Join!</h2>
        <span><em>LIVE SUPPORT</em></span>
    </div>
    <div class="dialog-content">
        <h2>Welcome to Where We All Meet</h2>
        <div id="description">
            <p>
                You can join the site in less than 60 seconds by signing up today and filling out the form.
            </p>
            <p>
                All you need to do is enter the form information, and have a valid email address. Your first name, last name,
                and zip code of your billing address must match your credit card information in order to become a member of WhereWeAllMeet.com.
                We do this in order to authenticate all of our subscribing members.
            </p>
        </div>
    </div>
</div>

<div id="build-your-profile-dialog" class="dialog how-to-get-started">
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>Build Your Profile!</h2>
        <span><em>LIVE SUPPORT</em></span>
    </div>
    <div class="dialog-content">
        <h2>Profile Page</h2>
        <div id="description">
            <p>
                Profile pages are the main focus points on the site so you it is beneficial that you understand the information.
                And fill out the profile fields. The profile page has priority criteria that a member can rank in importance of their
                matches. The first step is filling out the quick signup form and joining WhereWeAllMeet.com
            </p>
        </div>
    </div>
</div>

<div id="my-concierge-dialog" class="dialog how-to-get-started">
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>My Concierge!</h2>
        <span><em>LIVE SUPPORT</em></span>
    </div>
    <div class="dialog-content">
        <h2>Concierge Dating Agents</h2>
        <div id="description">
            <p>
                In addition to the WhereWeAllMeet.com core services, we offer our personal concierge service to all of
                our subscribing members at anytime. Concierge Service for personalized date planning, personalized match
                searched based on personal survey. Stress-free so you can relax and have a wonderful dating experience on
                WhereWeAllMeet.com. Just fill out our free signup form to join our site.
            </p>
        </div>
    </div>
</div>


<div id="chat-instantly-dialog" class="dialog how-to-get-started">
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>Chat Instantly!</h2>
        <span><em>LIVE SUPPORT</em></span>
    </div>
    <div class="dialog-content">
        <h2>WhereWeAllMeet.com Chat System</h2>
        <div id="description">
            <p>
                The live chat feature on WhereWeAllMeet.com is a one-on-one chat session with a friend. You can create a
                chat room with any friend and invite other friends to join in the conversation to create a group chat. Send
                a member a quick start conversation topic to break the ice. All this is easy to get started by filling
                out our quick signup form.
            </p>
        </div>
    </div>
</div>