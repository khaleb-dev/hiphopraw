<footer id="footer" class="clearfix">
    <div class="clearfix">
        <nav id="public-nav">
            <?php echo Html::anchor("#", "About"); ?>
            <?php echo Html::anchor("#", "FAQ"); ?>
            <?php echo Html::anchor("#", "Jobs"); ?>
            <?php echo Html::anchor("#", "Affiliates"); ?>
            <?php echo Html::anchor("#", "Terms of Use", array("id" => "terms-and-conditions", "data-dialog" => "terms-and-conditions-dialog")); ?>
            <?php echo Html::anchor("#", "Privacy Policy", array("id" => "privacy-policy", "data-dialog" => "privacy-policy-dialog")); ?>
            <?php echo Html::anchor("#", "Security"); ?>
        </nav>
        <div id="social-links-container">
            <?php echo Html::anchor("http://twitter.com", Asset::img("twitter_icon_color2.png")); ?>
            <?php echo Html::anchor("http://facebook.com", Asset::img("facebook_icon_color2.png")); ?>
        </div>
        <div class="clear">&nbsp;</div>
        <div id="copyright" class="clearfix">
            <p>
                © Copyright 2014 HowAboutWe, LLC. All rights reserved. Made in New York City.
            </p>
        </div>
    </div>
    <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'footer-bottom')); ?>
</footer>

<div id="login" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Login</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("action" => "users/login", "class" => "clearfix")) ?>
        <p class="clearfix">
            <label>Username:</label>
            <input type="text" name="username"/>
        </p>
        <p class="clearfix">
            <label>Password:</label>
            <input type="password" name="password" /><br/>
            <span>(6-16 characters MUST include numbers no spaces)</span>
        </p>
        <p class="clearfix"> 
            <span>Forgot Your <a href="<?php echo Uri::base() . 'users/forgot_password'; ?>">Password</a>?</span>
        </p>
        <p class="submit">
            <input type="submit" name="btnLogin" value="login"/>
        </p>
        <?php echo Form::close(); ?>

    </div>
</div>

<div id="interaction-icons-description">
    <p></p>
</div>

<div id="message-confirmation-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Send a Message</h2>
    </div>
    <div class="dialog-content clearfix">
        <img src="" class="dialog-logo"/>
        <div class="right-content">
            <?php echo Asset::img('messages_1.png'); ?>
            <p class="username">You are sending a Message to <span></span>!</p>
            <p>Do you want to send now?</p>
            <a class="button message yes-button confirm-send-message" href="#" data-dialog = "send-message-dialog" data-from-member-id = "" data-to-member-id = "">Yes</a>
            <a class="button no-button" href="#">No</a>
        </div>
    </div>
</div>

<div id="chat-confirmation-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>New Chat Request</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo">
        <div class="right-content">
            <?php echo Asset::img('chat_03.png'); ?>
            <p class="username">You are sending a Chat Request to <span></span>!</p>
            <p>Do you want to send now?</p>
            <a class="button chat yes-button confirm-send-chat" href="#" data-dialog = "chat-request-sent-dialog" data-username="">Yes</a>
            <a class="button no-button" href="#">No</a>
        </div>
    </div>
</div>

<div id="hello-confirmation-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Send a Hello</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo">
        <div class="right-content">
            <?php echo Asset::img('hello_01.png'); ?>
            <p class="username">You are sending a Hello to <span></span>!</p>
            <p>Do you want to send now?</p>
            <a class="button hello yes-button confirm-send-hello" href="#" data-dialog = "send-hello-dialog" data-from-member-id = "" data-to-member-id = "">Yes</a>
            <a class="button no-button" href="#">No</a>
        </div>
    </div>
</div>

<div id="favorite-confirmation-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Save as Favorite</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo">
        <div class="right-content">
            <?php echo Asset::img('favorite.png'); ?>
            <p class="username">You are saving <span></span> profile as Favorite!</p>
            <p>Do you want to save now?</p>
            <a class="button favorite yes-button confirm-save-favorite" href="#" data-dialog = "save-favorite-dialog" data-from-member-id = "" data-to-member-id = "">Yes</a>
            <a class="button no-button" href="#">No</a>
        </div>
    </div>
</div>

<div id="send-message-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Send Message</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "send-message-form", "action" => "message/create_ajax", "class" => "clearfix")) ?>
        <?php echo Form::hidden('from_member_id', 0); ?>
        <?php echo Form::hidden('to_member_id', 0); ?>
        <?php echo Form::hidden('message_status', Model_Message::STATUS_UNREAD); ?>
        <p class="clearfix">
            <label>To:</label><span class="readonly-text"></span>
        </p>
        <p class="clearfix">
            <label>Subject:</label>
            <input type="text" name="subject" /><br/>
        </p>
        <p class="clearfix">
            <label>Message:</label>
            <textarea name="body"></textarea><br/>
        </p>
        <p class="submit">
            <input type="submit" name="#" value="Send"/>
        </p>
        <?php echo Form::close(); ?>

    </div>
</div>

<div id="send-hello-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Send Hello</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "send-hello-form", "action" => "hello/send", "class" => "clearfix")) ?>
        <?php echo Form::hidden('from_member_id', 0); ?>
        <?php echo Form::hidden('to_member_id', 0); ?>
        <div id="send-hello-content" class="clearfix">
            <p>Send Hello to <span class="readonly-text"></span></p>
            <p class="submit">
                <input type="submit" name="#" value="Send Hello"/>
            </p>
        </div>
        <?php echo Form::close(); ?>
        <p class="message">A Hello is already sent for <span class="readonly-text"></span>.</p>
    </div>
</div>

<div id="save-favorite-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Save as Favorite</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "save-favorite-form", "action" => "favorite/save", "class" => "clearfix")) ?>
            <?php echo Form::hidden('member_id', 0); ?>
            <?php echo Form::hidden('favorite_member_id', 0); ?>
            <div id="save-favorite-content" class="clearfix">
                <p>Save <span class="readonly-text"></span> as your favorite</p>
                <p class="submit">
                    <input type="submit" name="#" value="Save as Favorite"/>
                </p>
            </div>
        <?php echo Form::close(); ?>
        <p class="message"><span class="readonly-text"></span> is already saved as your Favorite.</p>
    </div>
</div>

<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>

<div id="chat-request-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>New Chat Request</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo"/>
        <div class="right-content">
            <?php echo Asset::img('chat_03.png'); ?>
            <p class="username"><span class="sender"></span> has sent you a Chat Request.<span class="subject"></span></p>
            <p>Do you accept this invite?</p>
            <a class="button chat confirm-receive-chat" id="accept-chat" data-status="accept" href="#">Accept</a>
            <a class="button" id="decline-chat" data-status="decline" href="#">Decline</a>
        </div>
    </div>
</div>

<div id="chat-request-sent-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Chat Request Sent</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo"/>
        <div class="right-content">
            <?php echo Asset::img('chat_03.png'); ?>
            <p class="username">You have sent <span></span> a chat request.</p>
            <a class="button no-button" href="#">OK</a>
        </div>
    </div>
</div>

<div id="chat-request-response-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <?php echo Asset::img('pages/home2/mini.png'); ?>
        <h2>Chat Request Rejected</h2>
    </div>
    <div class="dialog-content">
        <img src="" class="dialog-logo"/>
        <div class="right-content">
            <?php echo Asset::img('chat_03.png'); ?>
            <p class="username"><span></span> has declined your chat request.</p>
            <a class="button no-button" href="#">OK</a>
        </div>
    </div>
</div>

<div id="privacy-policy-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>WhereWeAllMeet.com Privacy Policy</h2>
    </div>
    <div class="dialog-content">
        <?php echo View::forge("pages/privacy"); ?>
    </div>
</div>

<div id="terms-and-conditions-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>WhereWeAllMeet.com Terms of Use</h2>
    </div>
    <div class="dialog-content">
        <?php echo View::forge("pages/agreement"); ?>
    </div>
</div>

<div id="dating-agent-accept-invitation-dialog" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>You have a dating agent invitation request</h2>
    </div>
    <div class="dialog-content">
        <p><span></span> has invited you to join their chat. By accepting this request you will enable the chat feature.</p>
        <div id="buttons">
            <a id="decline-chat" data-status="decline">Decline</a>
            <a id="accept-chat" data-status="accept">Accept</a>
        </div>
    </div>
</div>

<?php
    if(isset($dating_agent_invitation)):
        $dating_agent = Model_Profile::find($dating_agent_invitation->dating_agent_profile);
?>

<div id="dating-agent-invitation-dialog" class="dialog" style="width: 600px;border: none;padding: 0;">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header" style="padding: 10px 15px;background-color: #000;">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo','style'=>'float: left;
margin-right: 20px;')) ?>
        <h2 style="margin: 0px;padding: 0px;border: medium none;color: #FFF;font-size: 25px;line-height: 40px;">
            Dating agent invitation!</h2>
    </div>
    <div class="dialog-content">
        <div id="left-floated-picture" style="float: left;padding: 0 5px 0 10px;">
            <?php echo Html::img(Model_Profile::get_picture($dating_agent->picture, $dating_agent->user_id, "profile_medium")) ?>
            <br />
            <?php echo $dating_agent->first_name.' '.$dating_agent->last_name ?>
        </div>
        <div id="right-floated-text" style="padding-right: 10px;float: right; width: 390px;">
            <?php echo $dating_agent->about_me ?>

        </div>
        <div class="clearfix"></div>

        <form id="dating-agent-invitation-reply" style="overflow: hidden;padding: 10px;background-color: #E8E8E8;margin: 10px 10px 20px 10px;">
            <a class="dating-agent-invitation-reply" id="accept" style="border-radius: 3px;
color: #FFF;
text-decoration: none;
padding: 10px;
float: left;
background-color: #0C58A4;
border: 1px solid #004793;
font-weight: bolder;
font-size: 18px;
text-align: left;" href="<?php echo \Fuel\Core\Uri::create('agent/accept_invitation/'.$dating_agent_invitation->id) ?>">I'm Interested</a>
            <a class="dating-agent-invitation-reply"  id="reject" style="border-radius: 3px;
color: #FFF;
text-decoration: none;
padding: 10px;
float: right;
background-color: #212121;
border: 1px solid #5d5d5d;
font-weight: bolder;
font-size: 18px;
" href="<?php echo \Fuel\Core\Uri::create('agent/reject_invitation/'.$dating_agent_invitation->id) ?>">No thanks</a>
        </form>
    </div>
</div>
<?php
    endif;
?>

<?php
    if(isset($refer_friend)):
        $refered_friend_profile = Model_Profile::find($refer_friend->refered_id);
	
?>

<div id="refer_friend-invitation-dialog" class="dialog" style="width: 600px;border: none;padding: 0;">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header" style="padding: 10px 15px;background-color: #000;">
        <?php echo \Fuel\Core\Asset::img(array('logo_color.png'), array('class'=>'logo','style'=>'float: left;
margin-right: 20px;')) ?>
        <h2 style="margin: 0px;padding: 0px;border: medium none;color: #FFF;font-size: 25px;line-height: 40px;">
            Refer a friend invitation!</h2>
    </div>
    <div class="dialog-content">
        <div id="left-floated-picture" style="float: left;padding: 0 5px 0 10px;">
            <?php echo Html::img(Model_Profile::get_picture($refered_friend_profile->picture,$refered_friend_profile->user_id, "profile_medium")) ?>
            <br />
            <?php echo $refered_friend_profile->first_name.' '.$refered_friend_profile->last_name ?> 
        </div>
        <div id="right-floated-text" style="padding-right: 10px;float: right; width: 390px;">
            <?php echo $refered_friend_profile->about_me ?>

        </div>
        <div class="clearfix"></div>

        <form id="refer_friend-invitation-reply" style="overflow: hidden;padding: 10px;background-color: #E8E8E8;margin: 10px 10px 20px 10px;">
            <a class="refer_friend-invitation-reply" id="accept" style="border-radius: 3px;
			color: #FFF;
			text-decoration: none;
			padding: 10px;
			float: left;
			background-color: #0C58A4;
			border: 1px solid #004793;
			font-weight: bolder;
			font-size: 18px;
			text-align: left;
			" href="<?php echo \Fuel\Core\Uri::create('profile/accept_invitation/'.$refer_friend->id) ?>">I'm Interested</a>
            
			<a class="refer_friend-invitation-reply"  id="reject" style="border-radius: 3px;
			color: #FFF;
			text-decoration: none;
			padding: 10px;
			float: right;
			background-color: #212121;
			border: 1px solid #5d5d5d;
			font-weight: bolder;
			font-size: 18px;
			" href="<?php echo \Fuel\Core\Uri::create('profile/reject_invitation/'.$refer_friend->id) ?>">No thanks</a>
        </form>
    </div>
</div>
<?php
    endif;
?>

<div id="upgrade-message-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-message-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To send this message to this member,
            <span>Upgrade Now</span></h5>
        <p>As soon as you upgrade you can send and receive messages to and from this member and many others. </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>


</div>

<div id="upgrade-chat-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-chat-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To start a chat with this member,
            <span>Upgrade Now</span></h5>
        <p>As soon as you upgrade you can start a chat talk with this member and many others. </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>


</div>

<div id="upgrade-hello-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-hello-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To send this hello to this member,
            <span>Upgrade Now</span></h5>
        <p>As soon as you upgrade you can send and receive hellos to and from this member and many others. </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>


</div>

<div id="upgrade-favorite-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-favorite-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To save this member as a favorite,
            <span>Upgrade Now</span></h5>
        <p>As soon as you upgrade you can save this member and many others as a favorite. </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>


</div>

<div id="upgrade-refer-friend-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-refer-friend-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To refer a friend, <span>Upgrade Now</span></h5>
        <p>As soon as you upgrade you can refer a friend. </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>
</div>

<div id="upgrade-refer-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-chat-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To refer a member, <span>Upgrade Now</span></h5>
        <p>
            As soon as you upgrade you can refer a member.
        </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>
</div>

<div id="upgrade-book-dialog" class="public-profile-dialog-upgrade-common dialog">

    <?php echo Form::open(array("id" => "upgrade-chat-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To book a member, <span>Upgrade Now</span></h5>
        <p>
            As soon as you upgrade you can book a member.
        </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>
</div>

<div id="upgrade-report-dialog" class="public-profile-dialog-upgrade-common dialog">
    <?php echo Form::open(array("id" => "upgrade-chat-form","action" => "Membership/upgrade", "class" => "clearfix")) ?>
    <div id="upgrade-content" class="clearfix">
        <h5>To report to a member, <span>Upgrade Now</span></h5>
        <p>
            As soon as you upgrade you can report to a member.
        </p>
        <p class="submit">
            <button type="submit"  name="#" class="button">UPGRADE</button>
        </p>
    </div>
    <?php echo Form::close(); ?>
</div>