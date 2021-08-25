
<div id="bottom_template-wrap">
    <div id="bottom_template">
        <div id="hhr-logo-footer">
          <a href = "#"><?php echo Asset::img('footer-hhr-logo.png', array('id' => 'hhr-logo-footer-img')); ?></a> 
        </div>
        <!--<div id="footer-upper-navigation">
            <ul>
                <li><a href="#">ABOUT</a> </li>  
                <li><a href="#">PRESS & BLOGS</a> </li>  
                <li><a href="#">COPYRIGHT</a> </li>  
                <li><a href="#">CREATORS & PARTNERS</a> </li>  
                <li><a href="#">ADVERTISING</a> </li>  
                <li><a href="#">DEVELOPERS</a> </li>                 
                           
            </ul>
        </div> -->
<div id="chat-base-url"><?php echo Uri::base(); ?></div>

<div id="logged-in-user-notification"><?php echo $current_user ? $current_user->username : ''; ?></div>


<div id="chat-request-dialog" class="dialog confirmation-dialog">
    <div class="dialog-header">
       <div id="lefties"> <?php echo Asset::img('user_chat.png'); ?></div>
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
        <div id="lefties"> <?php echo Asset::img('user_chat.png'); ?></div>
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
       <div id="lefties"> <?php echo Asset::img('user_chat.png'); ?></div>
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
       <div id="lefties"> <?php echo Asset::img('user_chat.png'); ?></div>
       <div id="lefties"><h3>New Chat Request</h3></div>
    </div>
    <div class="dialog-content">
        
        <div class="right-content">
            <?php //echo Asset::img('chat_03.png'); ?>
            <p class="username">You are sending a Chat Request to <span></span>!</p>
            <p>Do you want to send now?</p> 
            <a class="button chat yes-button confirm-send-chat" href="#" data-dialog = "chat-request-sent-dialog" data-username="">Yes</a>
            <a class="button no-button" href="#">No</a>
        </div>
    </div>
</div>

        <div id="footer-lower-navigation">
            <ul>
                <li><a href="#">PRIVACY</a> </li>  
                <li><a href="#">TERMS</a> </li>  
                <li><a href="#">SAEFTY</a> </li>  
                <li><a href="#">SEND FEEDBACK</a> </li>  
               <!-- <li><a href="#">TRY SOMEHING NEW!</a> </li>   -->
                           
            </ul>
        </div>
       <!-- <div id="footer-help">
         <a href = "#"><?php //echo Asset::img('footer-help.png', array('id' => 'footer-help-img')); ?></a>
        </div> -->
</div>
</div>