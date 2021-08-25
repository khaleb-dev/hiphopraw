<div id="top-template-wrap">
    <div id="top-template">
        <!--        spacing to the left of the logo-->

        <!--        the hiphopraw logo-->
        <div id="hhr-logo-wrapper">
            <a>
                <?php echo Asset::img('logo.png', array('id' => 'hhr-logo')); ?>
            </a>
        </div>

        <!--        navigation bar-->
        <div id="top-navigation-wrapper">
            <div class="navigation" id="top-navigation-bar">
                <ul>
                    <li>
                        <?php echo Html::anchor(Router::get('home'), "Home"); ?>
                    </li>

                    <li>
                        <a href="#">
                            <span>&middot;</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <?php echo Html::anchor(Router::get('videos'), "VIDEOS"); ?>
                        </a>
                    </li>

                    <li>

                        <span>&middot;</span>

                    </li>

                    <li>
                        <a href="#">
                            <?php echo Html::anchor(Router::get('models'), "MODELS"); ?>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span>&middot;</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <?php echo Html::anchor(Router::get('contest'), "Contest winners"); ?>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span>&middot;</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <?php echo Html::anchor(Router::get('hhrnews'), "HHR NEWS"); ?>
                        </a>
                    </li>


                </ul>
            </div>
        </div>

        <div class="transparent-background" id="top-right-banner">
            <div>
                <?php echo Asset::img("top-right-banner.png"); ?>
            </div>
            <?php if (!Auth::check()): ?>
                <p class="sub-header">Already a member? <a href="<?php echo Uri::create("users/login"); ?>" id="login-btn">Login</a> or
                    <a class="signup-btn" href="#">
                        Sign Up Now
                    </a>
                </p>
            <?php else: ?>
                <p class="sub-header">
                    <a href="<?php echo Uri::create("users/home_login"); ?>" id="login-btn">Account</a> | 
                    <a href="<?php echo Uri::create("users/logout"); ?>" id="login-btn">Log Out</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
