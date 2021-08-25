<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile_name">
                    <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?>
                </div>
                <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
            </div>
        </div>

<!--        --><?php //echo View::forge("datingAgent/partials/agent_nav"); ?>
        <?php echo View::forge("profile/partials/profile_nav"); ?>

        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">

        <section id="friends">
            <div class="latest">
                <h2>About Me <a class="view-all" href="#">Edit</a></h2>
            </div>

            <div id="photos">
            	<?php echo $current_profile->about_me ?>
            </div>
        </section>
        <section id="latest-members">
            <div class="latest">
                <h2>Latest Members</h2>
            </div>
				<div id="photos" class="content">

                    <?php
                    if(isset($latest_members)):
                        $counter = 0;
                        echo '<div class="separate"></div>';
                        foreach($latest_members as $member):
                            $counter++;  ?>
                            <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>
                            <?php
                            if($counter % 4 === 0){
                                echo '<div class="separate"></div>';
                            }
                        endforeach;
                    else:
                        ?>
                        <p class="nodata-message">Suggested Matches Not Found.</p>
                    <?php
                    endif;
                    ?>
           </div>
		<div class="link"><a href='<?php echo Uri::create('agent/view_all_profile')?>'>View All Members</a></div>
        </section>
		
        <section id="comments">
            <div class="latest">
                <h2>Comments</h2><a href="#comments"></a>
            </div>
            <div class="event-list">
               
            <div class="comments">
                <?php if(isset($comments)):?>
                
                <?php foreach($comments as $comment):                
	                $comment_by = Model_Profile::find($comment->comment_from);
                ?>
                	<div class="comment" id="comment-<?php echo $comment->id?>">
                		<?php echo Html::anchor(Uri::create(''), Html::img(Model_Profile::get_picture($comment_by->picture, $comment_by->user_id, "members_medium")));?>
                			<span class="comment-info"><?php echo $comment_by->first_name.' '.$comment_by->last_name ?> 
                			sent you a comment on <?php echo date('M d, Y', $comment_by->created_at)?>
                             <a title="Remove" id="remove-comment-<?php echo $comment->id?>" class="delete remove-comment" href="<?php echo \Fuel\Core\Uri::create('comment/remove_comment/'.$comment->id)?>">
                                 <i class="fa fa-times-circle-o"></i>
                             </a>
                			</span>
                			<p class="content"><?php echo $comment->comment ?>
                			
                			</p>
                	<?php 
                	$replies = Model_Comment::get_comment_replies($comment->id);
                	if(false !== $replies):
                	foreach($replies as $reply):                	
                	$reply_by = Model_Profile::find($reply->comment_from);
                	?>
                	<div class="separate" id="separate-<?php echo $reply->id ?>"></div>
                	<div class="reply" id="comment-<?php echo $reply->id?>">
                		<?php echo Html::anchor(Uri::create(''), Html::img(Model_Profile::get_picture($reply_by->picture, $reply_by->user_id, "members_medium")));?>
                			<span class="comment-info">
                                <a title="Remove" id="remove-comment-<?php echo $reply->id?>"
                                   class="delete remove-comment" href="<?php echo \Fuel\Core\Uri::create('comment/remove_comment/'.$reply->id)?>">
                                    <i class="fa fa-times-circle-o"></i>
                                   </a>
                            </span>
                			<p class="content"><?php echo $reply->comment ?>

                			</p>

                	</div>
                	
                	<?php 
                	endforeach;
                	endif;
                	?>
                	
                	<form class="comment-reply" id="comment-reply-<?php echo $comment->id;?>" action="<?php echo \Fuel\Core\Uri::create('comment/create') ?>" method="post">
                    <p>
                        <?php echo Html::anchor(Uri::create('profile/public_profile/' . $current_profile->id),
                            Html::img(Model_Profile::get_picture($current_profile->picture, $current_user->id, "members_medium"))); ?>
                        <textarea id="reply-message-<?php echo $comment->id ?>" name="message" cols="130"></textarea>
                        <button type="submit" class="reply-button" id="comment-reply-button-<?php echo $comment->id?>" class="button">Reply!</button>
                    </p>
                    <input type="hidden" name="parent_comment_id" value="<?php echo $comment->id ?>" />
                    <input type="hidden" name="comment_to" value="<?php echo $current_profile->id ?>" />
                	</form>


                    </div>
                <div class="separate" id="separate-<?php echo $comment->id ?>"></div>
                <?php endforeach;?>
                
                <?php 
                
                else:
                		echo '<p class="nodata-message">No comments to display!</p>';
                endif; ?>
                </div>
            </div>
        </section>
		
    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

