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
        <?php if (isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
        <?php }  ?>
            
    </div>

    <div class="videokes-center content-box clearfix">
        

         <!-- messages page -->
        <div class="message-title">
            <div class="title">
                <p class="pull-left main-title">MY MESSAGES</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
        </div>
        <input type="hidden" value="<?php echo $page_loaded; ?>" id="activeTab">
        <ul class="message-nav">
            <li id=""><a href="<?php echo Uri::create('messages/new')."/".$current_user->id;?> ">
                    <?php echo Asset::img("composeIcon.png"); ?>
                    Compose
                </a></li>
			<li id="inbox"><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::INBOX .'/'. $current_user->id;?> ">
                    <?php echo Asset::img("inboxIcon.png"); ?>
                    Inbox(<?php  echo $count_inbox; ?>)
                </a></li>
           <li id="sent"><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::SENT .'/'. $current_user->id;?> ">
                   <?php echo Asset::img("sentIcon.png"); ?>
                   Sent(<?php  echo $count_sent; ?>)
               </a></li>
        <!-- <li><a href="<?php //echo Uri::create('messages/index').'/'. Model_Message::DRAFT .'/'. $current_user->id;?> ">Drafts(<?php  //echo $count_draft; ?>)</a></li> -->   
          <li id="trash"><a href="<?php echo Uri::create('messages/index').'/'. Model_Message::TRASH .'/'. $current_user->id;?> ">
                  <?php echo Asset::img("trashIcon.png"); ?>
                  Trash(<?php  echo $count_trash; ?>)
              </a></li>
        </ul>
        
          <div class="pull-right frm-bottom delete-button" url = "<?php echo Uri::create('messages/destroy/')?>">
                     <?php echo Form::checkbox('deleter', true, array('class'=>"pull-left move-to-trash")); ?>
                    <button class="black-btn pull-left " id = 'message-delete' type="submit">Delete All</button>                    
           </div>
        <div class="clearfix"></div>        
        <div class="message-container">
            <?php if($messages) { ?>           
            <?php foreach($messages as $message) { ?>
             <?php $sender = Model_User::find($message->from_user_id); ?>
            <?php $receiver =  Model_User::find($message->to_user_id); ?>
            <div class="message" id="<?php echo $message->id; ?>">      
                <div class="profile-pic pull-left">
              <?php if($status == Model_Message::SENT) { ?>
              <?php echo Html::anchor("users/show/" . $receiver->id, Html::img(Model_User::get_picture($receiver, "message"))); ?>
            <?php } else { ?>
            <?php echo Html::anchor("users/show/" . $sender->id, Html::img(Model_User::get_picture($sender, "message"))); ?>
            <?php } ?>
                </div>
                
                
                <div class="message-right pull-left">
                <?php if($message->parent_message_id == 0){?>

                    <div class="inner-message-title">
                        

                        <input class="delete-each" data-message-id="<?php echo $message->id; ?>" data-user-id="<?php echo $current_user->id; ?>"  type="checkbox" />
                        <span class="pull-right"><a class="remove-message" href="<?php echo Uri::create('messages/destroy/'.$message->id.'/'.$current_user->id)?>" id="remove-message-<?php echo $message->id?>"><?php  echo Asset::img("videoke/comment-close.png"); ?></a></span>
                        <span class="msg-username red">
                        <?php if($status == Model_Message::SENT) { ?>
                         <?php echo substr($receiver->username, 0, 8).'...'; ?>
                        <?php } else { ?>
                        <?php echo substr($sender->username, 0, 8).'...'; ?>
                        <?php } ?>
                        </span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="grey-txt"> <?php echo date("d,m,Y, g:i a", $message->created_at); ?></span>
                        <hr>
                    <div class="message-text">
                       <?php if(strlen($message->detail) > 150): ?>
                        <?php if($message->read_status == Model_Message::UNREAD): ?>
                        <p><strong><?php echo Html::anchor("messages/show/$message->id" , substr($message->detail, 0, 150)).'...'; ?></strong></p>
                        <?php else: ?>
                        <p><?php echo Html::anchor("messages/show/$message->id" , substr($message->detail, 0, 150)).'...'; ?></p>
                        <?php endif; ?>
                       <?php else: ?>
                        <?php if($message->read_status == Model_Message::UNREAD): ?> 
                        <p><strong><?php echo Html::anchor("messages/show/$message->id" , $message->detail); ?></strong></p>                  
                        <?php else: ?>
                        <p><?php echo Html::anchor("messages/show/$message->id" , $message->detail); ?></p>
                        <?php endif; ?>  
                       <?php endif; ?>                       
                    </div>
                </div>

                        <?php }else{ 

                    $message_orginal = Model_Message::find($message->parent_message_id); ?>
                    <?php if($message_orginal){ ?>
                     <div class="inner-message-title">

                        <input class="delete-each" data-message-id="<?php echo $message_orginal->id; ?>" data-user-id="<?php echo $current_user->id; ?>"  type="checkbox" />
                        <span class="pull-right"><a class="remove-message" href="<?php echo Uri::create('messages/destroy/'.$message_orginal->id.'/'.$current_user->id)?>" id="remove-message-<?php echo $message_orginal->id?>"><?php  echo Asset::img("videoke/comment-close.png"); ?></a></span>
                        <span class="msg-username red">
                        <?php if($status == Model_Message::SENT) { ?>
                         <?php echo substr($receiver->username, 0, 8).'...'; ?>
                        <?php } else { ?>
                        <?php echo substr($sender->username, 0, 8).'...'; ?>
                        <?php } ?>
                        </span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="grey-txt"> <?php echo date("d,m,Y, g:i a", $message->created_at); ?></span>
                         <hr>

                        <div class="message-text">
                       <?php if(strlen($message_orginal->detail) > 150): ?>
                        <?php if($message_orginal->read_status == Model_Message::UNREAD): ?>
                        <p><strong><?php echo "<b>Re: </b>".Html::anchor("messages/show/$message_orginal->id" , substr($message->detail, 0, 150)).'...'; ?></strong></p>
                        <?php else: ?>
                        <p><?php echo "<b>Re: </b> ".Html::anchor("messages/show/$message_orginal->id" , substr($message->detail, 0, 150)).'...'; ?></p>
                        <?php endif; ?>
                       <?php else: ?>
                        <?php if($message_orginal->read_status == Model_Message::UNREAD): ?> 
                        <p><strong><?php echo "<b>Re: </b> ".Html::anchor("messages/show/$message_orginal->id" , $message->detail); ?></strong></p>                  
                        <?php else: ?>
                        <p><?php echo "<b>Re: </b> ".Html::anchor("messages/show/$message_orginal->id" , $message->detail); ?></p>
                        <?php endif; ?>  
                       <?php endif; ?>                       
                      </div>

                  </div>
                  <?php }  ?>

                <?php }?>
                     
                    
                </div>
                <div class="clearfix"></div>
                <hr class="msg-divider" />
            </div>

            <?php } ?>

            
             <div class="message-bottom-btn">
             <!-- <button class="black-btn pull-right">Back</button></div> -->
                <!--<button class="red-btn pull-right" id = "message-delete-selected">Reply to Message</button>-->
             </div>
             <div class="clearfix"></div>

        <?php } else { ?>
           <p class="highlight-box">No messages in your <?php echo $status; ?> folder.</p>
        <?php } ?>
        
        </div>
        <div class="more-div">
            <p class="short-grey-line"></p>
            <p>MORE</p>
            <p class="short-grey-line"></p>
        </div>

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
</div>

<div class="clearfix separator"></div>