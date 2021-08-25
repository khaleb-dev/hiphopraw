<script type="text/javascript">

    function checkAll(checkId){
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == "checkbox" && inputs[i].id == checkId) {
                if(inputs[i].checked == true) {
                    inputs[i].checked = false ;
                } else if (inputs[i].checked == false ) {
                    inputs[i].checked = true ;
                }
            } 
        } 
    }

</script>


<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array('class' => 'white')); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>
</div>

<div id="content" class="clearfix">

    <div id="middle">

        <div id="messages_header"> 
            <h2 class="pull-left">Messages</h2>
            <p class="pull-right">
                <span class="small"><u>Want to start a converstaion?</u></span>
                <button class="compose"><i class="compose-icon"></i>Compose</button>
            </p>
            <div class="clearfix"></div>
        </div>

        <div class="sub-nav">
        <ul  class="nav nav-pills">
            <li><?php echo \Fuel\Core\Html::anchor('message/index', '<i class="inbox-icon"></i> Inbox',array('class' => 'active')) ?>   </li>
            <li><?php echo \Fuel\Core\Html::anchor('message/sent', '<i class="sent-icon"></i> Sent') ?></li>
            <li ><?php echo \Fuel\Core\Html::anchor('message/trash_total', '<i class="trash-icon"></i> Trash') ?></li>
        </ul>
            <div class="clearfix"></div>
        </div>

        <div class="message-wrapper inbox-wrapper">
            <div class="message">
                <div class="pull-left online-status">
                    <?php echo Asset::img('online_dot.png', array('class' => '')); ?>
                </div>
                <div class="pull-left user-avatar">
                    <?php echo Asset::img('defaults/profile_pic_2.jpg', array('class' => '')); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name">JohnFromWhereWe...</p>
                    <p class="sub">30, F, Straight</p>
                    <p class="bottom gray">Brooklyn, NY</p>
                </div>
                <div class="pull-left vertical-separtor">  </div>
                <div class="pull-left message-intro">
                    <p class="message-subject"><a href="#">Welcome to Where We All Meet!!</a></p>
                    <p class="gray">Hi julzdesigner24,</p><br/><br/>
                    <p class="gray">Hey!! How are you doing? I was checking out...</p>
                </div>
                <div class="pull-left vertical-separtor"></div>
                <div class="pull-left message-date">
                    <p class="date">Aug 7, 2014</p>
                    <p class="time gray">2:28pm</p>
                </div>
                <div class="pull-right message-del">
                    <?php echo Asset::img('del.png', array('class' => '')); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="message">
                <div class="pull-left online-status">
                    <?php echo Asset::img('online_dot.png', array('class' => '')); ?>
                </div>
                <div class="pull-left user-avatar">
                    <?php echo Asset::img('defaults/profile_pic_2.jpg', array('class' => '')); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name">JohnFromWhereWe...</p>
                    <p class="sub">30, F, Straight</p>
                    <p class="bottom gray">Brooklyn, NY</p>
                </div>
                <div class="pull-left vertical-separtor">  </div>
                <div class="pull-left message-intro">
                    <p class="message-subject"><a href="#">Welcome to Where We All Meet!!</a></p>
                    <p class="gray">Hi julzdesigner24,</p><br/><br/>
                    <p class="gray">Hey!! How are you doing? I was checking out...</p>
                </div>
                <div class="pull-left vertical-separtor"></div>
                <div class="pull-left message-date">
                    <p class="date">Aug 7, 2014</p>
                    <p class="time gray">2:28pm</p>
                </div>
                <div class="pull-right message-del">
                    <?php echo Asset::img('del.png', array('class' => '')); ?>
                </div>
                <div class="clearfix"></div>
            </div>            
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>

    </div>
</div>

<center><h2>Temporary: I have coded the messsage details page Below, please move it to its respectve view file.</h2></center>

<!-- message detail page, please move to its respective view file -->
<div id="content" class="clearfix">

    <div id="middle">

        <div id="messages_header"> 
            <h2 class="pull-left">Messages</h2>
            <p class="pull-right">
                <span class="small"><u>Want to start a converstaion?</u></span>
                <button class="compose"><i class="compose-icon"></i>Compose</button>
            </p>
            <div class="clearfix"></div>
        </div>

        <div class="sub-nav">
        <ul  class="nav nav-pills">
            <li><?php echo \Fuel\Core\Html::anchor('message/index', '<i class="inbox-icon"></i> Inbox',array('class' => 'active')) ?>   </li>
            <li><?php echo \Fuel\Core\Html::anchor('message/sent', '<i class="sent-icon"></i> Sent') ?></li>
            <li ><?php echo \Fuel\Core\Html::anchor('message/trash_total', '<i class="trash-icon"></i> Trash') ?></li>
        </ul>
            <div class="clearfix"></div>
        </div>

        <div class="message-wrapper message-detail-wrapper inbox-wrapper">
            <div class="message">
                <div class="pull-left online-status">
                    <?php echo Asset::img('online_dot.png', array('class' => '')); ?>
                </div>
                <div class="pull-left user-avatar">
                    <?php echo Asset::img('defaults/profile_pic_2.jpg', array('class' => '')); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name">JohnFromWhereWe...</p>
                    <p class="sub">30, F, Straight</p>
                    <p class="bottom gray">Brooklyn, NY</p>
                </div>
                <div class="pull-left vertical-separtor">  </div>
                <div class="pull-left full-message">
                    <p class="message-subject">Welcome to Where We All Meet!!</p>
                    <p class="gray">Hi julzdesigner24,</p><br/><br/>
                    <p class="gray">Welcome. I'm Jess, the Community Director at WhereWeAllMeet, 
                    and I'm here to help you get offline on real dates, in the real world.
                    <br/><br/>
                    Here are some quick tips to get you up and running: 1. Upload a 
                    photo and post a date idea if you haven't already. 2. Browse dates 
                    and message the people you like. 3. Make plans and get offline.
                    <br/><br/>
                    We've designed WhereWeAllMeet to be easy and fun to use. If you 
                    have any questions, don't hesitate to reach out on our Contact Us 
                    page.
                    <br/><br/>
                    Have a lovely time!
                    <br/><br/>
                    John</p>
                </div>
                <div class="pull-left vertical-separtor"></div>

                <div class="pull-right message-date">
                    <p class="date">Aug 7, 2014</p>
                    <p class="time gray">2:28pm</p>
                    <div class="message-del"><?php echo Asset::img('del.png', array('class' => '')); ?></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="message message-reply">

                <div class="pull-left user-avatar">
                    <?php echo Asset::img('defaults/profile_pic_2.jpg', array('class' => '')); ?>
                </div>
                <div class="pull-left user-info">
                    <p class="name">julzdesigner24...</p>
                    <p class="sub">25, M, Straight</p>
                    <p class="bottom gray">Brooklyn, NY</p>
                </div>
                <div class="pull-left vertical-separtor">  </div>
                <div class="pull-left full-message">
                    <p class="message-subject">Re: Welcome to Where We All Meet!!</p>
                    <p class="gray">Tahnk You!</p>
                </div>
                <div class="pull-left vertical-separtor"></div>

                <div class="pull-right message-date">
                    <p class="date">Aug 7, 2014</p>
                    <p class="time gray">2:28pm</p>
                    <div class="message-del"><?php echo Asset::img('del.png', array('class' => '')); ?></div>
                </div>
                <div class="clearfix"></div>
            </div>            
           
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
        
    </div>
    <div class="reply-box">
        <h2 class="">Send a Reply</h2>
        <div class="reply-form-wrapper">
            <form method="post" class="reply-form">
                <p class="pull-left label">Your Message</p>
                <p class="pull-left inputs">
                    <input name="" placeholder="Type your message here..."type="text" /> 
                    <input class="organge-btn" type="submit" name="" value="Send" />
                </p>
                <div class="pull-left right-option">
                    <a class="add-person" href="#"><?php echo Asset::img('profile/addperson.jpg'); ?></a>
                    <div class="pull-left vertical-sep"></div>
                    <button class="submit-btn"><?php echo Asset::img('profile/submit-post.jpg'); ?></button>
                </div>
                <div class="clearfix"></div>
            </form>
            
        </div>
    </div>

</div>
<!-- end of message detail -->