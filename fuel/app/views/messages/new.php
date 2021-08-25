<!-- <div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php //echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <h2 class='clearfix'><span><?php //echo $heading; ?></span></h2>
        <div id="messages" class="content-box">
            <?php //echo View::forge("messages/partials/message_menu"); ?>
            
            <?php //echo View::forge("messages/partials/form", array("users" => $users)); ?>
            
            <p class="back"><?php //echo Html::anchor(Router::get("users/show/$current_user->id"), "&laquo;  Back"); ?></p>       
        </div>
    </div>
    <?php //echo Asset::img("logo_slogan.png", array("class" => "logo-slogan")); ?>
</div>

<!--<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php //echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

        <?php //echo View::forge("pages/partials/enter_your_videoke"); ?>            
    </div>
    <div id="content" class="videos with-sidebar-left profile">
        <div id="messages">
            <h2 class="clearfix"><span><?php //echo $heading; ?></span> <p>Total Messages (<em class="messages-count"><?php //echo $count; ?></em>) <?php //echo Html::anchor("#", "Delete Selected", array("id" => "message-delete", "class" => "button rounded-corners")); ?> </p></h2>
            <div class="content-box">
                <?php //echo View::forge("messages/partials/message_menu"); ?>
                <?php //if($messages) { ?>
                    <?php //echo View::forge("messages/partials/list", array("messages" => $messages, "status" => $status)); ?>
                    <?php //echo $pagination->render(); ?>
                <?php //} else { ?>
                    <p class="highlight-box">No messages in your <?php //echo $status; ?> folder.</p>
                <?php //} ?>
            </div>
        </div>
    </div>
</div> -->


<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user)) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $count)); ?>
        <?php } ?>
    </div>

    <div class="videokes-center content-box clearfix">
        
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
          <li class="active"><a href="<?php echo Uri::create('messages/new')."/".$current_user->id;?> "><?php echo Asset::img("composeIcon.png"); ?>Compose</a></li>
		  <li><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::INBOX .'/'. $current_user->id;?> "><?php echo Asset::img("inboxIcon.png"); ?>Inbox(<?php  echo $count_inbox; ?>)</a></li>
          <li><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::SENT .'/'. $current_user->id;?> "><?php echo Asset::img("sentIcon.png"); ?>Sent(<?php  echo $count_sent; ?>)</a></li>
         <!-- <li><a href="<?php //echo Uri::create('messages/index').'/'. Model_Message::DRAFT .'/'. $current_user->id;?> ">Drafts(<?php  //echo $count_draft; ?>)</a></li> -->
          <li><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::TRASH .'/'. $current_user->id;?> "><?php echo Asset::img("trashIcon.png"); ?>Trash(<?php  echo $count_trash; ?>)</a></li>
        </ul>
        <div class="clearfix"></div>
        <div class="message-container">
        
        
        
            <?php echo Form::open(array('class'=>"compose-form", "id" => "message-form","action" => "messages/create")); ?>
              <?php echo Form::hidden('from_user_id', $current_user->id); ?>
                <p class="red pull-left compose-label">TO:</p>

                <?php echo Form::select('to_user_id', Validation::instance()->validated('to_user_id'), $users); ?>
                <span class="error with-margin"><?php echo Validation::instance()->error('to_user_id');?></span>

                <div class="clearfix"></div>
                <p class="red pull-left compose-label">Subject:</p>
                <input name = "title" type="text" placeholder="" class="compose-inp pull-left" />
                <div class="clearfix"></div>
                <textarea name = "detail" placeholder="write a message..."></textarea>
                <div class="pull-right frm-bottom">
                    <span class="pull-left gray">Check to send email&nbsp;&nbsp;</span>
                     <?php echo Form::checkbox('is_draft', true, array('class'=>"pull-left" )); ?>
                    <div class="pull-left vertical-sep"></div>
                    <button class="black-btn pull-left" type="submit">Send</button>
                </div>
           <?php echo Form::close(); ?>
        </div>
        
        
        <!-- end compose messages  -->


    </div>

    <div class="videokes-right content-box clearfix">
        
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