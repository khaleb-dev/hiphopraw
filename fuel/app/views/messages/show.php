
<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user)) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
        <?php }  ?>
            
    </div>

    <div class="videokes-center content-box clearfix">
        

         <!-- messages page -->
        <div class="message-title">
            <div class="title">
                <p class="pull-left main-title">MESSAGE DETAIL</p>
                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
        </div>
        <div class="clearfix"></div>        
        <div class="message-container">
            <?php if($message) { ?>           
            <div class="message" id="<?php echo $message->id; ?>">      
                <div class="profile-pic pull-left">
            <?php echo Html::anchor("users/show/" . $sender->id, Html::img(Model_User::get_picture($sender, "message"))); ?>
                </div>
                
                
                <div class="message-right pull-left">
                    <div class="inner-message-title clearfix">    
                        <span class="pull-left">
                            <span class="msg-username red"><?php echo $sender->username; ?></span>
                        </span>                    
                        <span class="pull-right">
                            <a class="remove-message" href="<?php echo Uri::create('messages/destroy/'.$message->id.'/'.$current_user->id)?>" id="remove-message-<?php echo $message->id?>"><?php  echo Asset::img("videoke/comment-close.png"); ?></a>
                        </span>                        
                    </div>
                    <div class="message-text">
                        <p><?php echo $message->detail; ?></p>                   
                    </div>
                </div>
                  <div class="clearfix"></div>

                <?php 
                    $replies = Model_Message::get_message_replies($message->id);
                    if(false !== $replies):
                    foreach($replies as $reply):                    
                    $reply_by = Model_User::find($reply->from_user_id);
                    ?>
                <hr class="comment-middle-separator"/>

                <div class="replied-comments" id="reply-<?php echo $reply->id?>">
                    <div class="profile-pic pull-left">
                        <?php echo Html::anchor("users/show/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $reply_by->username;?></span> <span class="dark">reply</span> <span class="red"><?php echo Date::forge($reply->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                            <a class="remove-reply-message" href="<?php echo Uri::create('messages/destroy/'.$reply->id.'/'.$current_user->id)?>" id="remove-message-<?php echo $reply->id?>"><?php  echo Asset::img("videoke/comment-close.png"); ?></a></span>
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

                <div class="message-reply-box" id="comment-div-<?php echo $message->id;?>">
                    
                    <div class="clearfix"></div>
                    <div class="pull-left reply-input">
                        <form class="comment-reply" id="comment-reply-<?php echo $message->id;?>" action="<?php echo Uri::create('messages/message_reply') ?>" method="post">
                            <textarea class="pull-left" id="reply-message-<?php echo $message->id ?>" name="message_detail"></textarea>
                            <input type="hidden" name="orginal_id" value="<?php echo $message->id; ?>" />
                            <input type="hidden" name="title" value="re-<?php echo $message->title; ?>" />
                            <input type="hidden" name="parent_message_id" value="<?php echo $message->id; ?>" />
                            <input type="hidden" name="to_user_id" value="<?php echo $message->from_user_id; ?>" />
                            <input type="hidden" name="from_user_id" value="<?php echo $current_user->id; ?>" />
                            <button class="pull-right red-reply-btn" type="submit" name="comment-reply" id="comment-reply-button-<?php echo $message->id?>">Reply</button>                         
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>


                <div class="clearfix"></div>
                <hr class="msg-divider" />
            </div>


            
             <div class="message-bottom-btn">
                 <button class="black-btn pull-left"><?php echo Html::anchor("messages/index/". Model_Message::INBOX .'/'. $current_user->id, "&laquo;  Back"); ?></button>
             <!-- <button class="black-btn pull-right">Back</button></div> -->
                 <a class="red-btn pull-right reply-to-comment" id="reply-to-comment-<?php echo $message->id?>">Reply to Message</a>
             </div>           
                 <div class="clearfix"></div>
             

        </div>

        <?php } else { ?>
           <p class="highlight-box">No message clicked to show its detail</p>
        <?php } ?>
        
        

    </div>

</div>

<div class="clearfix separator"></div>