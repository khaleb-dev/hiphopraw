
<div id="bottom_template-wrap">
    <div id="bottom_template">


<div id="chat-base-url"><?php echo Uri::base(); ?></div>

<div id="logged-in-user-notification"><?php echo $current_user ? $current_user->username : ''; ?></div>
<i class="close-dialog fa fa-times-circle-o"></i>

<div id="chat-request-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
       <div id="lefties"> <?php //echo Asset::img('user_chat.png'); ?></div>
        <div id="lefties"> <h3>New Chat Request</h3></div>
    </div>
    <div class="dialog-content">
        <div id="profile_picture">
        <img src="" class="dialog-logo"/>
        </div>
        <div class="right-content">
            <?php //echo Asset::img('chat_03.png'); ?>
            <p class="username"><span class="sender"></span> has sent you a Chat Request.<span class="subject"></span></p>
            <p>Do you accept this invite?</p>
            <a class="button chat confirm-receive-chat" id="accept-chat" data-status="accept" href="#">Accept</a>
            <a class="button" id="decline-chat" data-status="decline" href="#">Decline</a>
        </div>
    </div>
</div>


<div id="chat-request-sent-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
        <div id="lefties"> <?php //echo Asset::img('user_chat.png'); ?></div>
        <div id="lefties"><h3>Chat Request Sent</h3></div>
    </div>
    <div class="dialog-content">
      <div id="profile_picture">
        <img src="" class="dialog-logo"/>
      </div>
        <div class="right-content">
            <?php //echo Asset::img('chat_03.png'); ?>
            <p class="username">You have sent <span></span> a chat request.</p>
            <a class="button no-button" href="#">OK</a>
        </div>
    </div>
</div>


<div id="chat-request-response-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
       <div id="lefties"> <?php //echo Asset::img('user_chat.png'); ?></div>
       <div id="lefties"> <h3>Chat Request Rejected</h3></div>
    </div>
    <div class="dialog-content">
      <div id="profile_picture">
        <img src="" class="dialog-logo"/>
      </div>
        <div class="right-content">
            <?php //echo Asset::img('chat_03.png'); ?>
            <p class="username"><span></span> has declined your chat request.</p>
            <a class="button no-button" href="#">OK</a>
        </div>
    </div>
</div>


<div id="chat-confirmation-dialog" class="dialog confirmation-dialog">
 
    <div class="dialog-header">
       <div id="lefties"> <?php //echo Asset::img('user_chat.png'); ?></div>
       <div id="lefties"><h3>Start a Chat</h3></div>
    </div>
    <div class="dialog-content clearfix">
        
        <div class="right-content">
            <?php //echo Asset::img('chat_03.png'); ?>
            <p class="username">You are sending a Chat Request to <span></span>!</p>
        </div>
    </div>
    <div class="dialog-footer">
            <p class="grey-txt">Do you want to send now?</p> 
            <a class="button chat yes-button confirm-send-chat" href="#" data-dialog = "chat-request-sent-dialog" data-username=""> <?php echo Asset::img('icons/startChat.png'); ?> Start a Chat</a>
            <a class="button no-button" href="#"><span>Cancel</span></a>
    </div>
</div>



    <div id="footer-wrapper">
        <div>
            <h4>CHANNELS</h4>
            <ul>
               <!--  <li><?php echo Html::anchor(Router::get('videos'), "Videos"); ?></li>
                <li><?php echo Html::anchor(Router::get('models'), "Models"); ?></li>
                <li><?php echo Html::anchor(Router::get('contest'), "Contest"); ?></li>
                <li><?php echo Html::anchor(Router::get('hhrnews'), "News"); ?></li>
 -->

                <li><a href="http://hiphopraw.com/blog/?page_id=26" target="_BLANK">Videos</a></li>
                <li><a href="http://hiphopraw.com/blog/?page_id=49" target="_BLANK">Models</a></li>
                <li><a href="http://hiphopraw.com/blog/?page_id=47" target="_BLANK">Contest</a></li>
                <li><a href="http://hiphopraw.com/blog/?cat=2" target="_BLANK">News</a></li>
            </ul>
        </div>
        <div>
            <h4>ABOUT HHR</h4>
            <ul>
                <li><a href=" http://hiphopraw.com/blog/?page_id=30" target="_BLANK">Terms of Service</a></li>
                <li><a href="http://hiphopraw.com/blog/?page_id=32" target="_BLANK">Privacy Policy</a></li>
                <li><a href="http://hiphopraw.com/blog/?page_id=28" target="_BLANK">How to Submit Videos</a></li>
                <li><a href="http://hiphopraw.com/blog/?page_id=20" target="_BLANK">About Our Ads</a></li>
            </ul>
        </div><div>
            <h4>FOLLOW US</h4>
            <ul> 
                <li><a href="https://www.facebook.com/officialhiphopraw" target="_BLANK">Facebook</a></li>
                <li><a href="https://www.twitter.com/hiphopraw" target="_BLANK">Twitter</a></li>
                <li><a href="https://instagram.com/hiphopraw" target="_BLANK">Instagram</a></li>
                <li><a href="https://www.youtube.com/user/hiphopraw" target="_BLANK">YouTube</a></li>
            </ul>
        </div><div>
            <h4>Advertise With Us!</h4>
            <p>
                 Contact HipHopRaw Team.
            </p>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>













