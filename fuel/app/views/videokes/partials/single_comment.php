          
           <?php $comment_by = Model_User::find($comment->user_id);?>
           <div class="comment-inner" id="comment-<?php echo $comment->id?>">
                <div class="profile-pic pull-left">
                     <?php if ($current_user):?>                   
                    <?php echo Html::anchor("users/show/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?>
                    <?php endif;?>
                     <?php if (!$current_user):?>                   
                    <?php echo Html::anchor("pages/show_profile/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?>
                    <?php endif;?>
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $comment_by->username; ?></span> <span class="dark">commented on this</span> <span class="red"><?php echo Date::forge($comment->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                         <?php if ($current_user):?>
                        <span class="pull-right">
                          <a href="#" class = "reply-to-comment" id="reply-to-comment-<?php echo $comment->id?>"><?php  echo Asset::img("videoke/Comment-reply.jpg",array('id'=>"reply-image-$comment->id")); ?></a>
                           <?php if ($current_user->id == $comment_by->id):?> 
                            <a href="<?php echo Uri::create('comments/remove/'.$comment->id)?>" class = "remove-comment" id="remove-comment-<?php echo $comment->id?>" url="0"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>                                                     
                           <?php endif;?>
                        </span>
                         <?php endif;?>
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
                	echo View::forge("videokes/partials/single_reply", array("reply" => $reply));
                	?>
                <hr class="comment-middle-separator"/>

                
                
                
                
                 <?php 
                	endforeach;
                	endif;
                	?>
                <?php if ($current_user):?>
                <div class="comment-reply-box" id="comment-div-<?php echo $comment->id;?>">
                    <div class="profile-pic-reply pull-left">
                       <?php echo Html::anchor("users/show/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile"))); ?>
                    </div>
                    <div class="pull-left reply-input">
                        <form class="comment-reply" id="comment-reply-<?php echo $comment->id;?>" action="<?php echo Uri::create('comments/video_replay') ?>" method="post">
                            <textarea class="pull-left message-text" id="reply-message-<?php echo $comment->id ?>" name="message"></textarea>
                            <input type="hidden" name="parent_comment_id" value="<?php echo $comment->id; ?>" />
                            <input type="hidden" name="comment_to" value="<?php echo $videoke->id ?>" />
                            <button class="pull-left red-reply-btn" type="submit" name="comment-reply" id="comment-reply-button-<?php echo $comment->id?>">Reply</button>                         
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <?php endif;?>
            </div>
