<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			  <div id="profile_name"><?php echo Html::anchor(Uri::create('profile/public_profile'),$current_user->username, array("id" => "profile-link")); ?></div>
                  <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($dating_agent->picture, $dating_agent->user_id, "profile_medium"))); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
				   </div>
        </div>

        <?php echo View::forge("datingAgent/partials/client_nav", $dating_agent); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">

        <section id="friends">
             <div id="latest">   <h2>About Me</h2></div>
            
            <div id="photos">
            	<?php echo $dating_agent->about_me ?>
            </div>
        </section>
        <section id="friends">
           <div id="latest"> <h2>Comments</h2></div>
            <div class="event-list">
               <form id="post-comment" action="<?php echo \Fuel\Core\Uri::create('comment/create') ?>" method="post">
                    <p>
                        <textarea id="comment-message" name="message" cols="130"></textarea>
                    </p>
                    <p>
                        <button type="submit" id="post-comment-button" class="button">Post a Comment!</button>
                    </p>
                    <input type="hidden" name="comment_to" value="<?php echo $dating_agent->id ?>" />
                </form>
            <div class="comments">
                <?php if(isset($comments)):?>
                
                <?php foreach($comments as $comment):                
	                $comment_by = Model_Profile::find($comment->comment_from);
                ?>
                	<div class="comment" id="<?php echo $comment->id?>">
                		<?php echo Html::anchor(Uri::create(''), Html::img(Model_Profile::get_picture($comment_by->picture, $comment_by->user_id, "members_medium")));?>
                			<span class="comment-info"><?php echo $comment_by->first_name.' '.$comment_by->last_name ?> 
                			posted a comment on <?php echo date('M d, Y', $comment_by->created_at)?>
                			</span>
                			<p class="content"><?php echo $comment->comment ?>
                			
                			</p>
                	</div>
                	<?php 
                	$replies = Model_Comment::get_comment_replies($comment->id);
                	if(false !== $replies):
                	foreach($replies as $reply):                	
                	$reply_by = Model_Profile::find($reply->comment_from);
                	?>
                	<div class="separate"></div>
                	<div class="reply">
                		<?php echo Html::anchor(Uri::create(''), Html::img(Model_Profile::get_picture($reply_by->picture, $reply_by->user_id, "members_medium")));?>
                			
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
                    <input type="hidden" name="comment_to" value="<?php echo $dating_agent->id ?>" />
                	</form>
                	
                
                <div class="separate"></div>
                <?php endforeach;?>
                
                <?php 
                
                else:
                		echo '<p class="nodata-message">No comments to display!</p>';
                endif; ?>
                </div>
            </div>
			<div class="link"><a href="#">View All</a></div>
        </section>
    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

          <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_new_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad_new.jpg"); ?></a>
        </div>
    </aside>
</div>


<div id="upgrade" class="dialog">
    <p>You must be a client to get services of a dating agent. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), 'Book Now'); ?> for a dating agent.</p>
</div>

<div id="report-me-dialog" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Report Me To Administrator</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "report-me-form", "action" => "agent/report_me", "class" => "clearfix")) ?>
        <?php echo Form::hidden('dating_agent_id', $dating_agent->id); ?>
        <p class="clearfix">
            <label>Message:</label>
            <textarea name="message"></textarea><br/>
        </p>
        <p class="submit">
            <input type="submit" name="#" value="Send"/>
        </p>
        <?php echo Form::close(); ?>

    </div>
</div>


<div id="refer-me-dialog" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo')) ?>
        <h2>Dating Agent Invitation</h2>
    </div>
    <div class="dialog-content">
        <div id="left-floated-picture">
            <?php echo Html::img(Model_Profile::get_picture($dating_agent->picture, $dating_agent->user_id, "profile_medium")) ?>
            <br />
            <?php echo $dating_agent->first_name.' '.$dating_agent->last_name ?>
        </div>
        <div id="right-floated-text">
            <?php echo $dating_agent->about_me ?>

        </div>
        <div class="clearfix"></div>

        <form id="refer-me" action="<?php echo \Fuel\Core\Uri::create('agent/send_invitation') ?>" method="POST">
            <input type="hidden" id="dating_agent_profile" name="dating_agent_profile" value="<?php echo $dating_agent->id ?>" />
            <div class="blue-text">Invite a friend to this dating agent!</div>
            <select name="profile_to" id="profile_to">
                <option value="" selected></option>
                <?php
                $friends = Model_Friendship::get_friends($current_profile->id);
                foreach($friends as $friend):
                    if($dating_agent->id !== $friend->id):
                ?>
                <option value="<?php echo $friend->id ?>"><?php echo $friend->first_name.' '.$friend->last_name ?></option>
                <?php
                endif;
                endforeach;
                ?>
            </select>
            <input id="send-refer-me" type="submit" class="button" value="Send Dating Agent Invitation" />
        </form>
    </div>
</div>