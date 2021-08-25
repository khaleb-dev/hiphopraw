<div class="wrapper">
    <div id="top-section" class="clearfix">
        <div id="top-section-content" class="clearfix">
            <div id="logo-container">
                <a href="<?php echo Uri::base(false);?>"><?php echo Asset::img('pages/home2/logo.png'); ?></a>
            </div>
            <div id="login-container" class="clearfix">
                <?php echo Form::open(array("action" => "users/login", "class" => "form-inline", "role" => "form")) ?>
                    <div class="username">
                        <p>Username:</p>
                        <input type="text" name="username" />
                    </div>
                    <div class="password">
                        <p>Password: <a href="<?php echo Uri::base(false) . 'users/forgot_password'; ?>">Forgot Password?</a></p>
                        <input type="password" name="password" />
                    </div>
                    <div class="login-btn-container">
                        <button name="btnLogin" type="submit">Login</button>
                    </div>
                <?php echo Form::close();?>
            </div>
        </div>
    </div>
    <div id="signup-container" class="clearfix">
        <div id="signup-content" class="clearfix">
            <div id="left-section-content" >
                <h3>Connect, Share Experiences, and Explore our Event/Vacation Packages. </h3>
                <p>WhereWeAllMeet.com is a social dating, event promotion and vacation discovery platform that provides a meeting place to interact with friends and meet new friends online.</p>
                <div class="more-text">
                    <p>Real online dating agents are here to assist the busy person that doesn't have time to search for their potential dream date!</p>
                    <p>Want to meet people but hate dating website? Whereweallmeet.com puts the fun back into dating!</p>
                </div>
                <p class="more-less-button"><a>Read More</a></p>
            </div>
            <div id="right-section-content" >
                <p id="get-started">Get started <span> - it's free.</span></p>
                <p id="registration-text">Registration takes less than 2 minutes.</p>
                <?php echo Form::open(array("action" => "users/sign_up", "class" => "")) ?>
                    <p class="full-name clearfix">
                        <input type="text" name="first_name" placeholder="First Name"  class="inline" />
                        <input type="text" name="last_name" placeholder="Last Name" class="inline lastname" />
                    </p>
                    <input type="text" name="email" placeholder="Email Address" class="full-row" />
                    <input type="text" name="username" placeholder="Username" class="full-row" />
                    <input type="password" name="password" placeholder="Password" class="full-row" />
                    <input type="password" name="confirm_password" placeholder="Confirm Password" class="full-row" />
                    <p class="gender">
                        <input type="radio" name="gender_id" value="1" checked><span>Male</span>
                        <input type="radio" name="gender_id" value="2"><span>Female</span>
                    </p>
                    <button name="submit" type="submit" class="">Sign Up Today For Free</button>
                    <p class="terms-text">By continuing, you agree to our terms of service and that you have read our User Agreement and  Privacy Policy</p>
                <?php echo Form::close();?>
            </div>
        </div>

    </div>
    <div id="get-started-container" class="clearfix">
        <div id="get-started-content">
            <?php echo Asset::img('pages/home2/color-small.jpg', array('class' => 'get-started-bgcolor')); ?>
            <h1>See How to get started...It’s easy!!!</h1>
            <div id="get-started-list" class="clearfix">
                <div>
                    <?php echo Asset::img('pages/home2/easy_to_join_bg.jpg'); ?>
                    <h3>Easy To Join</h3>
                    <p>Fill out a simple sign up form and become a free member.</p>
                    <a class="easy-to-join-btn" data-dialog="join">Learn More ></a>
                </div>
                <div>
                    <?php echo Asset::img('pages/home2/build_your_profile_bg.jpg'); ?>
                    <h3>Build Your Profile</h3>
                    <p>Complete your profile and tell others about yourself and your interest on the site.</p>
                    <a class="build-your-profile-btn" data-dialog="profile">Learn More ></a>
                </div>
                <div>
                    <?php echo Asset::img('pages/home2/my_dating_agent_bg.jpg'); ?>
                    <h3>My Dating Agent</h3>
                    <p>Offering exclusive dating agent service for the discerning gentleman or woman.</p>
                    <a class="my-dating-agent-btn" data-dialog="agent">Learn More ></a>
                </div>
                <div class="last-item">
                    <?php echo Asset::img('pages/home2/chat_instantly_bg.jpg'); ?>
                    <h3>Chat Instantly</h3>
                    <p>Use our instant messenger from real-time chat, to group chat to get to know new people.</p>
                    <a class="chat-instantly-btn" data-dialog="chat">Learn More ></a>
                </div>

            </div>
        </div>
    </div>

    <div id="footer-section">
        <div id="footer-content" class="clearfix">
            <p><a data-dialog="terms">Terms of Service</a></p>
            <p><a data-dialog="privacy">Privacy Policy</a></p>
            <p><a>Blog</a></p>
            <p class="right">All Rights Reserved: WhereWellAllMeet.com</p>
        </div>

        <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'footer-bottom')); ?>
    </div>

</div>


<!-- Modal build your profile -->
<div class="modal-container" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">Build Your Profile!!</h3>

            </div>
            <div class="modal-body">
                <h4>Profile Page</h4>
                <hr/>
                <p>Profile pages are the main focus points for daters as they search for mates.</p>
                <div class="more-text"> Members should put specific detail about wants and needs to ensure matches are truly authentic. The profile page has priority criteria that a member can rank based on importance for potential matches. The first step is filling out the quick signup form and joining WhereWeAllMeet.com.</div>
                <p class="more-less-button"><a>Read More</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal dating agent -->
<div class="modal-container" id="agent">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">My Dating Agent!!</h3>

            </div>
            <div class="modal-body">
                <h4>Concierge Dating Agents</h4>
                <hr/>In addition to the WhereWeAllMeet.com core services, we offer our personal concierge service to all of our subscribing members at anytime. Concierge Service for personalized date planning, personalized match searched based on personal survey. Stress-free so you can relax and have a wonderful dating experience on WhereWeAllMeet.com. Just fill out our free signup form to join our site.
            </div>
        </div>
    </div>
</div>

<!-- Modal join -->
<div class="modal-container" id="join">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">It’s Easy To Join!!</h3>

            </div>
            <div class="modal-body">
                <h4>Welcome to WhereWeAll Meet.com </h4>
                <hr/>
                You can join the site in less than 60 seconds by signing up today and filling out the form.

                All you need to do is enter the form information, and have a valid email address. Your first name, last name, and zip code of your billing address must match your credit card information in order to become a member of WhereWeAllMeet.com. We do this in order to authenticate all of our subscribing members.
            </div>
        </div>
    </div>
</div>

<!-- Modal chat -->
<div class="modal-container" id="chat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">Chat Instantly!!</h3>

            </div>
            <div class="modal-body">
                <h4>WhereWeAllMeet.com Chat System</h4>
                <hr/>
                <p>The live chat feature on WhereWeAllMeet.com is a one-on-one chat session with a friend. You can create a chat room with any friend and invite other friends to join in the conversation to create a group chat. Send a member a quick start conversation topic to break the ice. All this is easy to get started by filling out our quick signup form.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Privacy -->
<div class="modal-container" id="privacy">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Privacy Policy</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php echo View::forge("pages/privacy"); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal terms and agreement -->
<div class="modal-container" id="terms">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Terms of Use</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php echo View::forge("pages/agreement"); ?></p>
            </div>
        </div>
    </div>
</div>
