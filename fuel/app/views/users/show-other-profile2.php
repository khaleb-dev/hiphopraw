<div class="other-profile-container">
    
    <div class="main-profile-con">
        <div class = "profile-nav">
            <div class = "top-nav">
                <div class = "profile-picture">
                    <?php if ($current_user): ?>
                        <?php echo Html::anchor("users/show/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?> 
                    <?php else: ?>
                        <?php echo Html::anchor("pages/show_profile/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?>
                    <?php endif; ?>
                </div>
                <div class = "name">
                    <p> 
                    <?php echo $user->username; ?>
                    <?php 
                    if($user->is_logged_in == 1){
                            echo Asset::img('online_dot.png'); 
                            echo "<span class='grey-txt'>Online</span>";
                    }else{

                            echo Asset::img('offline_dot.png');
                            echo "<span class='grey-txt'>Offline</span>";
                        } ?>

                    </p> 

                </div>
                <div class = "location">
                    <?php if ($user->facebook_link === '1'): ?>
                        <p> <span>Fan</span> - <?php echo $user->city . ", " . $user->state; ?></p>
                    <?php else: ?>
                        <p> <span> <?php
                                if (isset($user->category)) {
                                    echo Model_Category::find($user->category)->name;
                                }
                                ?></span> - <?php echo $user->city . ", " . $user->state; ?></p>
                    <?php endif; ?>
                </div>
                
                <?php if (!$current_user) { ?>
                    <div class = "send-friend-request">
                        <button class = "public-button-request-container"><?php echo Asset::img('user/friend.png', array('class' => 'friend-img')); ?><?php echo Form::submit("#", "Send Friend Request", array("class" => "friend-request-actual-button")); ?></button>
                    </div>
                    <div class = "public-send-message">         
                        <a href="#" role="button" class="" data-target="#" data-toggle="modal"><i class='icon-envelope'></i> Send a Message</a>
                    </div>
                <?php } ?> 
            <div class = "line">
            </div>

           

            <div class="profile-option-btns" id="profile-option-btns">
            <?php if ($current_user) { ?>

            <?php if ($current_user->id != $user->id): ?>

            <?php if (!Model_Friendship::request_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    
    
                    <?php 
                        $sender = $current_user;
                        $reciever = $user;
                        $action =  "friendships/create"; 
                    ?>
                    <button class="red-btn" data-toggle="modal" data-target="#friend-request-modal">
                        <?php echo Asset::img("icons/friendRequest.png"); ?>
                        Friend Request
                    </button>
             <?php }else { ?>

                     <?php  echo View::forge("messages/partials/chat", array("sender" => $current_user, "receiver" => $user, "action" => "messages/start_chat")); ?>

                    
            <?php } ?>
                    <button class="blue-btn" data-toggle="modal" data-target="#send-message-modal">
                        <?php echo Asset::img("icons/sendMessage.png"); ?>
                        Send a Message
                    </button>
                   
            <?php endif; ?>
                <?php } ?> 

            <?php if (!$current_user) { ?>
                    <button class="red-btn" data-toggle="modal" data-target="#friend-request-modal">
                        <?php echo Asset::img("icons/friendRequest.png"); ?>
                        Friend Request
                    </button>
                    <button class="blue-btn" data-toggle="modal" data-target="#send-message-modal">
                        <?php echo Asset::img("icons/sendMessage.png"); ?>
                        Send a Message
                    </button>

                <?php } ?> 


 <?php if ($current_user) { ?>

        <?php if ($current_user->id != $user->id): ?>

            <?php if (!Model_Friendship::request_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>

                    <div class="modal fade" id="friend-request-modal" role="dialog" aria-labelledby="frmodallabel" aria-hidden="true">
                        
           
                    
                         <?php echo Form::open(array("id" => "friend-request-form", "action" => $action)); ?>
                         <?php echo Form::hidden('sender_id', $sender->id); ?>
                         <?php echo Form::hidden('receiver_id', $reciever->id); ?>
                         <?php echo Form::hidden('status', Model_Friendship::STATUS_SENT); ?>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="frmodallabel">
                                        Send Friend Request
                                    </h2>
                                </div>
                                <div class="modal-body">
                                    You have chosen to send a friend request to <?php echo $reciever->username;?>!
                                </div>
                                <div class="modal-footer">
                                    <p class="grey-txt">Are you sure you want to send this request?</p>

                                    <button class = "red-btn">
                                        <?php echo Asset::img('icons/profile_buttonsfriend.png', array('class' => 'friend-img')); ?>
                                        <?php echo Form::submit("#", "Send Request",array("class"=>"friend-request-actual-button")); ?>
                                    </button>
                                    
                                    <button type="button" class="cancel-btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>
                
                   
                    </div>
            <?php }
     endif; ?>
<?php } ?> 


                    <div class="modal fade" id="send-message-modal" role="dialog" aria-labelledby="smmodallabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="smmodallabel">
                                        Send a Message to <?php echo $user->username ?>
                                    </h2>
                                </div>
                                
                                <?php echo Form::open(array("id" => "modal-message-form", "action" => "messages/create_ajax")); ?>
                                        <div class="modal-body">
                                        <?php echo Form::hidden('from_user_id', $current_user->id); ?>
                                        <?php echo Form::hidden('to_user_id', $user->id); ?>
                                        <?php echo Form::hidden('status', Model_Message::SENT); ?>
                                        <?php echo Form::hidden('read_status', Model_Message::UNREAD); ?>

                                        <div class="form-group">
                                            <label for="sub">Subject:</label>
                                             <?php echo Form::input('title', Validation::instance()->validated('title'), array("placeholder" => "Title")); ?>
                                             <span class="error with-margin"><?php echo Validation::instance()->error('title'); ?></span>
                
                                        </div>
                                        <div class="form-group">
                                            <label for="msg">Message:</label>
                                            <?php echo Form::textarea('detail', Validation::instance()->validated('detail'), array("placeholder" => "Message")); ?>
                                            <span class="error with-margin"><?php echo Validation::instance()->error('detail'); ?></span>
                
                                        </div>
                                   
                                </div>
                                <div class="modal-footer">
                                    <p class="grey-txt">Are you sure you want to send this request?</p>
                                          <!-- <input type="button" class="pull-right button rounded-corners" value="Send Message" /> -->
                                     <button class="blue-btn" type="submit">

                                        <?php echo Asset::img("icons/profile_sendmessage.png"); ?>
                                        Send a Message
                                    </button>
                                    <button type="button" class="cancel-btn" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                             <?php echo Form::close(); ?>
                            </div>
                        </div>
                    </div>



                    
                </div> 
        </div>
            <div class = "bottom-nav">
                <h4 class="red">About Me</h4>
                <div class = "line-break">
                </div>
                <p>
                    <?php echo $user->about_me(); ?>
                </p>
                <div class="about-btn">
                    <button>
                        Read More
                        <?php echo Asset::img("icons/aboutReadMore.png"); ?>
                    </button>
                </div>
                <div class="profile-logo">
                        <?php echo Asset::img("profileLogo.png"); ?>                    
                </div>
            </div>
    </div>

        <div id = "white-container">
            <div class = "counter-nav">
                <div class = "top-list">
                    <ul>
                        <?php if ($current_user): ?>
                            <li class="active">
                                <div>
                                    <?php echo Asset::img('icons/play_icon.png'); ?>
                                    <a href="<?php echo Uri::create('users/show/' . $user->id); ?>" data-target="#profile-videos-tab">
                                    Videos<br>
                                    <span class="white-txt"><?php echo count($videokes); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileFriends.png'); ?>
                                    <a href="<?php echo Uri::create('users/friends/' . $user->id); ?>" data-target="#profile-friends-tab">
                                    Friends<br>
                                    <span class="white-txt"><?php echo count($friends); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileComments.png'); ?>
                                    <a href="<?php echo Uri::create('users/comment/' . $user->id); ?>" data-target="#profile-comments-tab">
                                    Comments<br>
                                    <span class="white-txt"><?php echo count($comments); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileFollowers.png'); ?>
                                    <a href="<?php echo Uri::create('users/followers/' . $user->id); ?>" data-target="#profile-followers-tab">
                                    Followers<br>
                                    <span class="white-txt"><?php echo count($followers); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <button class="profile-follow-btn"></button>
                                </div>
                            </li>
                <?php else: ?>
                    <li class="active">
                                <div>
                                    <?php echo Asset::img('icons/play_icon.png'); ?>
                                    <a href="<?php echo Uri::create('pages/show/' . $user->id); ?>" data-target="#profile-videos-tab">
                                    Videos<br>
                                    <span class="white-txt"><?php echo count($videokes); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileFriends.png'); ?>
                                    <a href="<?php echo Uri::create('pages/friends/' . $user->id); ?>" data-target="#profile-friends-tab">
                                    Friends<br>
                                    <span class="white-txt"><?php echo count($friends); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileComments.png'); ?>
                                    <a href="<?php echo Uri::create('pages/comment/' . $user->id); ?>" data-target="#profile-comments-tab">
                                    Comments<br>
                                    <span class="white-txt"><?php echo count($comments); ?></span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <?php echo Asset::img('icons/profileFollowers.png'); ?>
                                    <a href="<?php echo Uri::create('pages/followers/' . $user->id); ?>" data-target="#profile-followers-tab">
                                    Followers<br>
                                    <span class="white-txt"><?php echo count($followers); ?></span>
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!--
                <div class = "bottom-list">
                    <ul>
                        <?php if ($current_user): ?>
                            <li><a href="<?php echo Uri::create('users/show/' . $user->id); ?>"><?php echo $videokes_count; ?></a></li>
                            <li><a href="<?php echo Uri::create('users/friends/' . $user->id); ?>"><?php echo $friends_count; ?></a></li>
                            <li><a href="<?php echo Uri::create('users/followers/' . $user->id); ?>"><?php echo $followers_count; ?></a> </li>
                            <li><a href="<?php echo Uri::create('users/comment/' . $user->id); ?>"><?php echo $comments_counter; ?></a> </li>
                        <?php else: ?>
                            <li><a href="<?php echo Uri::create('pages/show_profile/' . $user->id); ?>"><?php echo $videokes_count; ?></a></li>
                            <li><a href="<?php echo Uri::create('pages/friends/' . $user->id); ?>"><?php echo $friends_count; ?></a></li>
                            <li><a href="<?php echo Uri::create('pages/followers/' . $user->id); ?>"><?php echo $followers_count; ?></a> </li>
                            <li><a href="<?php echo Uri::create('pages/comment/' . $user->id); ?>"><?php echo $comments_counter; ?></a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class = "link-active">
                    <?php echo Asset::img('user/active-line.png'); ?>
                </div>
                -->
                <?php if ($current_user): ?>
                    <?php if ($current_user->id != $user->id): ?>    
                        <?php if (!Model_Follower::follower_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                            <?php 
                                if (isset($user->category)){
                                    $user_type = Model_Category::find($user->category)->name;

                                    if($user_type == 'Hip Hop Artist'){
                                         ?>
                                        <?php echo View::forge("followers/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "Followers/create")); ?>
                            <?php
                                    }else {
                                        ?>
                                           <?php echo View::forge("followers/partials/form_model", array("sender" => $current_user, "receiver" => $user, "action" => "Followers/create")); ?> 

                                        <?php
                                     }


                                 }

                            ?>
                        <?php } ?> 
                    <?php endif; ?>
                <?php else: ?>
                    

                             <button class = "public-button-follower-container"><?php echo Asset::img('user/follow.png', array('class' => 'follower-img')); ?><?php echo Form::submit("#", "Follow This Artist", array("class" => "follow-request-actual-button")); ?></button>
                        
                    
                <?php endif; ?>
            </div>
            <div id="profile-videos-tab" class="profile-tabs">
                <div class="profile-title white-txt">
                    <h3>Viewing Videos</h3>
                </div>
                <hr>
                <?php
                if ($videokes) {
                    foreach ($videokes as $videoke) {
                        echo View::forge("videokes/partials/single_item", array('videoke' => $videoke));
                    }
                } else {
                    echo '<p class = "no-videos-data">No videos added yet!</p>';
                }
                ?>
                <div class = "clearfix"></div>
                <div class="profile-view-more">
                    <button class="white-btn">View More Videos</button>
                </div>
            </div>
            <div id="profile-friends-tab" class="profile-tabs hide">
                <div class="profile-title white-txt">
                    <h3>Viewing Friends</h3>
                </div>
                <hr>
                <div class="friends-div">
                            <?php
                                 $counter = 0; 
                                    if($friends){
                                         foreach ($friends as $friend):
                                          echo View::forge("users/partials/friends_single_item",array("friend" => $friend)); 
                                              $counter++;
                                         endforeach;
                                    }
                                    else{
                                    ?>
                                    <p class = "no-message-data">No friends added yet!</p>
                                <?php } ?>   
                    
                </div>

                <?php if($counter >= 25):?>
                    <a href = "#" id = "anchor-view"><?php echo Asset::img('user/view-picture.png'); ?> &nbsp;VIEW MORE FRIENDS</a>
                <?php endif;?> 

                <!-- <div class="profile-view-more">
                    <button class="white-btn">View More Videos</button>
                </div> -->
            </div>


            <div id="profile-comments-tab" class="profile-tabs hide">


                    <div class="comments">
            <!-- first comment -->
            
             <?php if(isset($comments)):?>
                
                <?php foreach($comments as $comment):                
                     $comment_by = Model_User::find($comment->user_id);
                ?>
            <div class="comment-inner" id="comment-<?php echo $comment->id?>">
                <div class="profile-pic pull-left">
                   <?php if($current_user): ?>
                  <?php echo Html::anchor("users/show/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?> 
                  <?php else:?>
                  <?php echo Html::anchor("pages/show_profile/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?>
                  <?php endif; ?>            
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $comment_by->username; ?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($comment->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                         <?php if($current_user): ?>
                           <a href="#" class = "reply-to-comment" id="reply-to-comment-<?php echo $comment->id?>"><?php  echo Asset::img("videoke/Comment-reply.jpg",array('id'=>"reply-image-$comment->id")); ?></a>                         
                           <?php if($current_user->id ==  $comment_by->id): ?>
                            <a href="<?php echo Uri::create('comments/remove/'.$comment->id)?>" class = "remove-comment" id="remove-comment-<?php echo $comment->id?>" url="0"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                           <?php endif; ?>
                           <?php endif; ?>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <hr class="comment-inner-separator"/>
                    <p class="comment-text"><?php echo $comment->detail; ?></p>
                </div>
                <div class="clearfix"></div>

                <?php 
                    $replies = Model_Comment::get_comment_replies($comment->id);
                    if(false !== $replies):
                    foreach($replies as $reply):                    
                    $reply_by = Model_User::find($reply->user_id);
                    ?>
                <hr class="comment-middle-separator"/>

                <div class="replied-comments" id="reply-<?php echo $reply->id?>">
                    <div class="profile-pic pull-left">
                        <?php if($current_user): ?>
                       <?php echo Html::anchor("users/show/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?> 
                       <?php else:?>
                       <?php echo Html::anchor("pages/show_profile/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                       <?php endif; ?>                         
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $reply_by->username;?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($reply->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                            <?php if($current_user): ?>
                            <?php if($current_user->id == $reply_by->id): ?>
                            <a href="<?php echo Uri::create('comments/remove/'.$reply->id)?>" class = "remove-comment" id="remove-comment-<?php echo $reply->id?>" url="1"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </span>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="comment-inner-separator"/>
                        <p class="comment-text"><?php echo $reply->detail; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                 <?php 
                    endforeach;
                    endif;
                    ?>
                    <?php if($current_user): ?>
                <div class="comment-reply-box" id="comment-div-<?php echo $comment->id;?>">
                    <div class="profile-pic-reply pull-left">
                       <?php echo Html::anchor("users/show/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile"))); ?>
                    </div>
                    <div class="pull-left reply-input">
                        <form class="comment-reply" id="comment-reply-<?php echo $comment->id;?>" action="<?php echo Uri::create('comments/show_replay/'.$user->id) ?>" method="post">
                            <textarea class="pull-left" id="reply-message-<?php echo $comment->id ?>" name="message"></textarea>
                            <input type="hidden" name="parent_comment_id" value="<?php echo $comment->id; ?>" />
                            <input type="hidden" name="comment_to" value="<?php echo $comment->id; ?>" />
                            <button class="pull-left red-reply-btn" type="submit" name="comment-reply" id="comment-reply-button-<?php echo $comment->id?>">Reply</button>                         
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <?php endif; ?>
            </div>

            <hr class="comment-large-separator"/>

             <?php endforeach;?>
                
                <?php 
               endif; ?>
             <?php if($comments_counter == 0):
                
               echo '<p class="nodata-comments">No comments to display!</p>';
               endif; ?>
            
            
             <?php if($comments_counter > 5):?>
            <p class="more-comment"><a href="#" class="more-comment red"> > VIEW MORE COMMENTS </a></p>
            <?php endif; ?>
        </div> <!-- end of comments -->







               <!--  <div class="profile-title white-txt">
                    <h3>Viewing Comments</h3>
                </div>
                <hr>                
                <div class="comments-div">
                    <div class="clearfix">
                        <div class="comment-pic">
                            <?php echo Asset::img('profile_friends.png');?>
                        </div>
                        <div class="comment-detail">
                            <p>
                                <span class="red">Sven</span>
                                <span class="grey-txt">commented on your page</span>
                                <span class="red">Jan 14,2014 at 11:20 pm</span>
                            </p>
                            <p>
                                Our personal Dating Concierge Agents take the work out of the 
                                online will us help you improve the quality and quantity of 
                                your dates and maximize your online experience.
                            </p>
                            <p class="grey-txt">
                                <?php echo Asset::img('icons/profileCommentsRed.png');?>
                                Reply
                            </p>
                        </div>
                    </div>
                    <div class="comment-followup clearfix">
                        <div class="clearfix">
                            <div class="comment-pic">
                                <?php echo Asset::img('profile_friends.png');?>
                            </div>
                            <div class="comment-detail">
                                <p>
                                    <span class="red">Sven</span>
                                    <span class="grey-txt">commented on your page</span>
                                    <span class="red">Jan 14,2014 at 11:20 pm</span>
                                </p>
                                <p>
                                    Our personal Dating Concierge Agents take the work out of the 
                                    online will us help you improve the quality and quantity of 
                                    your dates and maximize your online experience.
                                </p>
                                <p class="grey-txt">
                                    <?php echo Asset::img('icons/profileCommentsRed.png');?>
                                    Reply
                                </p>
                            </div>
                        </div>
                        <div class="comment-form">
                            <form>
                                <?php echo Asset::img('profile_friends.png');?>
                                <input type="text"/>
                                <input type="submit" value="Reply" class="red-btn" />
                            </form>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="comment-pic">
                            <?php echo Asset::img('profile_friends.png');?>
                        </div>
                        <div class="comment-detail">
                            <p>
                                <span class="red">Sven</span>
                                <span class="grey-txt">commented on your page</span>
                                <span class="red">Jan 14,2014 at 11:20 pm</span>
                            </p>
                            <p>
                                Our personal Dating Concierge Agents take the work out of the 
                                online will us help you improve the quality and quantity of 
                                your dates and maximize your online experience.
                            </p>
                            <p class="grey-txt">
                                <?php echo Asset::img('icons/profileCommentsRed.png');?>
                                Reply
                            </p>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="comment-pic">
                            <?php echo Asset::img('profile_friends.png');?>
                        </div>
                        <div class="comment-detail">
                            <p>
                                <span class="red">Sven</span>
                                <span class="grey-txt">commented on your page</span>
                                <span class="red">Jan 14,2014 at 11:20 pm</span>
                            </p>
                            <p>
                                Our personal Dating Concierge Agents take the work out of the 
                                online will us help you improve the quality and quantity of 
                                your dates and maximize your online experience.
                            </p>
                            <p class="grey-txt">
                                <?php echo Asset::img('icons/profileCommentsRed.png');?>
                                Reply
                            </p>
                        </div>
                    </div>
                </div>
                <div class="profile-view-more">
                    <button class="white-btn">View More Videos</button>
                </div> -->
            </div>
            <div id="profile-followers-tab" class="profile-tabs hide">                
                <div class="profile-title white-txt">
                    <h3 class="clearfix">
                        <p>Viewing Followers</p>
                        <span class="red">FILTER:</span>
                        <ul>
                            <li><a href="#">A</a></li>
                            <li><a href="#">B</a></li>
                            <li><a href="#">C</a></li>
                            <li><a href="#">D</a></li>
                            <li><a href="#">E</a></li>
                            <li><a href="#">F</a></li>
                            <li><a href="#">G</a></li>
                            <li><a href="#">H</a></li>
                            <li><a href="#">I</a></li>
                            <li><a href="#">J</a></li>
                            <li><a href="#">K</a></li>
                            <li><a href="#">L</a></li>
                            <li><a href="#">M</a></li>
                            <li><a href="#">N</a></li>
                            <li><a href="#">O</a></li>
                            <li><a href="#">P</a></li>
                            <li><a href="#">Q</a></li>
                            <li><a href="#">R</a></li>
                            <li><a href="#">S</a></li>
                            <li><a href="#">T</a></li>
                            <li><a href="#">U</a></li>
                            <li><a href="#">V</a></li>
                            <li><a href="#">W</a></li>
                            <li><a href="#">X</a></li>
                            <li><a href="#">Y</a></li>
                            <li><a href="#">Z</a></li>
                        </ul>
                        <span class="grey-txt">|</span>
                        <form>
                            <input type="text" placeholder="Search..."/>
                            <button type="submit" class="red-btn" />
                                <?php echo Asset::img('icons/searchIcon.png');?>
                            </button>
                        </form>
                    </h3>
                </div>
                <hr>

                <?php if($current_user): ?>
                    <?php if($current_user->id != $user->id): ?>    
                        <?php if (!Model_Follower::follower_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("followers/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "Followers/create")); ?>
                <?php } ?> 
             <?php endif; ?>
            <?php else:?>
                    <button class = "public-button-follower-container"><?php echo Asset::img('user/follow.png', array('class' => 'follower-img')); ?><?php echo Form::submit("#", "Follow This Artist",array("class"=>"follow-request-actual-button")); ?></button>
            <?php endif; ?>
   
                <div class="friends-div">
                    

                         <?php
                               $counter = 0; 
                                  if($followers){
                                        foreach ($followers as $follower):
                                             echo View::forge("users/partials/single_item",array("follower" => $follower,"user" => $user)); 
                                    $counter++;
                             endforeach;
                             }
                            else{
                                 ?>
                                     <p class = "no-message-data">No followers added yet!</p>
                             <?php } ?>
                </div>
    
                <?php if($counter >= 20):?>
                    <a href = "#" id = "anchor-view"><?php echo Asset::img('user/view-picture.png'); ?> &nbsp;VIEW MORE FOLLOWERS</a>
                <?php endif;?>

            </div>
        </div>
    </div>
    <div class = "clearfix"></div>
</div>
<?php if (!$current_user) { ?>
    <div id="upgrade-hello-dialog" class="public-profile-dialog-upgrade-common dialog">

        <div id="upgrade-content" class="clearfix">
            <h5>You must sign up inorder to interact with the members of the platform.</h5> 
        </div>         
    </div>
<?php } ?> 