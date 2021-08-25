<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <?php echo Html::anchor('#', Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <?php echo Html::anchor("#", $current_user->username, array("id" => "profile-link")); ?>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">
        <section id="event-detail">
            <h2>Dating Package Title</h2>

            <div class="event-list" id="event-1">
                <img src="">
                    <h3>Title of Date Package Will Go Here...</h3>
                    <span>Wednesday, November 20, 2013</span>
                    <br/><br/><strong>Time: 6:00pm - 8:00pm | @ Event Venue Name</strong>
                    <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sedo eiusmod tempor inc
                        ididunt ut labore et dolore magna alitqua. Ut enim ad minim veniam, quis nostrude
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duit aute iru
                        redolorin reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        Excepteur sint occaecat..."Lorem ipsum dolor sit amet, consectetur adipisicing eliti,
                        sedoeiusmod tempor incididunt ut labore et dolore magna alitqua.</p>

                    <a class="button" href="#">SEND INVITE</a>
            </div>
        </section>

        <section id="event-detail-more">
            <h2>More Details About This Date</h2>

            <div class="event-list" id="event-1">
                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quistinostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequate. Duis aute irure dolor in reprehenderit in voluptate velit esse cillume
                    dolore eute fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proidient, sunt in culpa qui officia deserunt mollit anim id est laborum.""Lorem ipi
                    sum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et doloret magna aliqua. Ut enim ad minim veniam, quis nost
                    riud exercitation ullamcoe laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in repret henderit in voluptate velit esse cillum dolore et
                    su fugiat nulla pariatur. Excepteuri sint occaecat.</p>

                <p>
                    "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quistinostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequate. Duis aute irure dolor in reprehenderit in voluptate velit esse cillume
                    dolore eute fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proidient, sunt in culpa qui officia deserunt mollit anim id est laborum.""Lorem ipi
                    sum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et doloret magna aliqua. Ut enim ad minim veniam, quis nost
                    riud exercitation ullamcoe laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in repret henderit in voluptate velit esse cillum dolore et
                    su fugiat nulla pariatur. Excepteuri sint occaecat.
                </p>
            </div>
        </section>

        <section id="refer-friend">
            <h2>Refer a Friend</h2>
            <div class="event-list">

                <form action="" method="">
                    <p>
                        <label for="email">Email:</label><br />
                        <input type="text" name="email">
                    </p>
                    <p>
                        <label for="message">Message:</label><br />
                        <textarea name="message" cols="130"></textarea>
                    </p>
                    <p>
                        <a href="#" class="button">Refer a Friend Now!</a>
                    </p>
                </form>
            </div>

        </section>


    </div>
</div>