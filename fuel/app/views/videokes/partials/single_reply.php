
<?php $reply_by = Model_User::find($reply->user_id);?>
<div class="replied-comments" id="reply-<?php echo $reply->id?>">
                    <div class="profile-pic pull-left">
                       <?php if ($current_user):?>
                        <?php echo Html::anchor("users/show/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                       <?php endif;?>
                        <?php if (!$current_user):?>
                        <?php echo Html::anchor("pages/show_profile/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                       <?php endif;?>
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $reply_by->username;?></span> <span class="dark">commented on this</span> <span class="red"><?php echo Date::forge($reply->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <?php if ($current_user):?>
                        <span class="pull-right" id = "reply-id-holder" url = "<?php echo Uri::create('comments/show_comment_reply')?>">
                             <?php if ($current_user->id == $reply_by->id):?>
                            <a href="<?php echo Uri::create('comments/remove/'.$reply->id)?>" class = "remove-comment" id="remove-comment-<?php echo $reply->id?>" url="1"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                            <?php endif;?>
                        </span>
                        <?php endif;?>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="comment-inner-separator"/>
                        <p class="comment-text"><?php echo $reply->detail; ?></p>
                    </div>
                 <div class="clearfix"></div>
 </div>
