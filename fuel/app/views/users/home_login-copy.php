<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user, "friends" => $friends, "followers" => $followers)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $count)); ?>
        <?php } ?>
    </div>

    <div class="videokes-center content-box clearfix">
        <div class="vids">
            <div class="title">
                <p class="pull-left main-title">MY HOME</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
            <div class="video-list">
            <?php
            if (isset($videokes)) {
                //                echo "<pre>";
                //                print_r($videokes);
                //                echo "</pre>";
                if (sizeof($videokes) > 0) {
                    foreach ($videokes as $videoke) {
                        $view = View::forge('videokes/partials/single_item');
                        $view->videoke = $videoke;
                        echo $view;
                    }
                } else {
                    echo "No Videos uploaded yet";
                }
            } else {
                echo "No Videos uploaded yet";
            }
            ?>
             </div>
            <div class="clearfix"></div>
        </div>
        <!--
        <div class="comments">
            <div class="title">
                <p class="main-title">MY COMMENTS</p>
                <hr class="divider"/>
               <?php //echo "No Comments yet";?>
            </div>
        </div> -->

        <div class="comments">
            <div class="title">
                <p class="main-title">MY COMMENTS</p>
                <hr class="divider" />
            </div>
            <!-- first comment -->
            <div class="comment-inner">
                <div class="profile-pic pull-left">
                    <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/Comment-reply.jpg"); ?></a>
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <hr class="comment-inner-separator"/>
                    <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you improve the quality and quantity of your dates and maximize your online experience</p>
                </div>
                <div class="clearfix"></div>

                <hr class="comment-middle-separator"/>

                <div class="replied-comments">
                    <div class="profile-pic pull-left">
                        <?php  echo Asset::img("videoke/profile-pic2.jpg"); ?>
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="comment-inner-separator"/>
                        <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you</p>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="comment-reply-box">
                    <div class="profile-pic-reply pull-left">
                        <?php  echo Asset::img("videoke/profile-pic3.jpg"); ?>
                    </div>
                    <div class="pull-left reply-input">
                        <form>
                            <textarea class="pull-left" name="comment-reply"></textarea>
                            <button class="pull-left red-reply-btn" type="submit" name="comment-reply">Reply</button>
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

            <hr class="comment-large-separator"/>

            <!-- second comment -->
            <div class="comment-inner">
                <div class="profile-pic pull-left">
                    <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/Comment-reply.jpg"); ?></a>
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <hr class="comment-inner-separator"/>
                    <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you</p>
                </div>

                <div class="clearfix"></div>
            </div>
            <hr class="comment-large-separator"/>

            <p class="more-comment"><a href="#" class="more-comment red"> > VIEW OLDER COMMENTS</a></p>

        </div> <!-- end of comments -->

        <!-- messages page -->
        <div class="message-title">
            <div class="title">
                <p class="pull-left main-title">MY MESSAGES</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
        </div>
        <ul class="message-nav">
            <li><a class="active" href="#">Compose</a></li>
            <li><a href="#">Inbox (10)</a></li>
            <li><a href="#">Sent (10)</a></li>
            <li><a href="#">Drafts (10)</a></li>
            <li><a href="#">Trash (10)</a></li>
        </ul>
        <div class="clearfix"></div>
        <div class="message-container">
            <div class="message">
                <div class="profile-pic pull-left">
                    <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
                </div>
                <div class="message-right pull-left">
                    <div class="inner-message-title">
                        <span class="pull-right"><a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a></span>
                        <span class="msg-username red">Username Here</span>
                    </div>
                    <div class="message-text">
                        <p>So we back in the club with the bodies</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr class="msg-divider" />
            </div>

            <div class="message">
                <div class="profile-pic pull-left">
                    <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
                </div>
                <div class="message-right pull-left">
                    <div class="inner-message-title">
                        <span class="pull-right"><a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a></span>
                        <span class="msg-username red">Username Here</span>
                    </div>
                    <div class="message-text">
                        <p>So we back in the club with the bodies</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr class="msg-divider" />
            </div>

            <div class="message-bottom-btn">
                <button class="black-btn pull-right">Back</button>
                <button class="black-btn pull-right">Delete Conversation</button>
                <div class="clearfix"></div>
            </div>

        </div>
        <!-- end of messages page -->


        <!-- compose messages page -->
        <div class="message-title">
            <div class="title">
                <p class="pull-left main-title">COMPOSE NEW MESSAGE</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
        </div>
        <ul class="message-nav">
            <li><a class="active" href="#">Compose</a></li>
            <li><a href="#">Inbox (10)</a></li>
            <li><a href="#">Sent (10)</a></li>
            <li><a href="#">Drafts (10)</a></li>
            <li><a href="#">Trash (10)</a></li>
        </ul>
        <div class="clearfix"></div>
        <div class="message-container">
            <form class="compose-form">
                <p class="red pull-left compose-label">TO:</p>
                <input type="text" placeholder="Name of friend" class="compose-inp pull-left" />
                <div class="clearfix"></div>
                <p class="red pull-left compose-label">Subject:</p>
                <input type="text" placeholder="" class="compose-inp pull-left" />
                <div class="clearfix"></div>
                <textarea placeholder="write a message..."></textarea>
                <div class="pull-right frm-bottom">
                    <span class="pull-left gray">Check to send email&nbsp;&nbsp;</span>
                    <input class="pull-left" type="checkbox" />
                    <div class="pull-left vertical-sep"></div>
                    <button class="black-btn pull-left" type="submit">Send</button>
                </div>
            </form>
        </div>
        <!-- compose messages page -->


    </div>

    <div class="videokes-right content-box clearfix">
        <p class="header-text">VIDEO SUGGESTIONS</p>
        <hr class="divider"/>
        <?php
        if (isset($suggestions)) {
            //                echo "<pre>";
            //                print_r($videokes);
            //                echo "</pre>";
            if (sizeof($suggestions) > 0) {
                foreach ($suggestions as $video) {
                    $view = View::forge('videokes/partials/single_item');
                    $view->videoke = $video;
                    echo $view;
                    echo '<div class="clearfix"></div><hr class="thin-divider" />';
                }
            } else {
                echo "No Video Suggestions";
            }
        } else {
            echo "No Videos uploaded";
        }
        ?>
        <p><a class="red pull-right see-more-link" href="#">&gt; SEE MORE</a></p>
        <div class="clearfix"></div>

        <!-- advertisments -->
        <p class="header-text"><strong>SUGGESTED ADVERTISMENT</strong></p>
        <hr class="divider advert-divder"/>
        <?php  echo Asset::img("advert-1.jpg"); ?>
        <hr class="divider advert-divder"/>
        <?php  echo Asset::img("advert-2.jpg"); ?>
        <hr class="divider advert-divder"/>
        <?php  echo Asset::img("advert-3.jpg"); ?>

        <!-- end of advertisments -->
    </div>

    <div class="clearfix separator"></div>

</div>

