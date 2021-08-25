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
            <li><?php echo \Fuel\Core\Html::anchor('message/index', '<i class="inbox-icon"></i> Inbox') ?>   </li>
            <li><?php echo \Fuel\Core\Html::anchor('message/sent', '<i class="sent-icon"></i> Sent') ?></li>
            <li ><?php echo \Fuel\Core\Html::anchor('message/trash_total', '<i class="trash-icon"></i> Trash',array('class' => 'active')) ?></li>
        </ul>
            <div class="clearfix"></div>
        </div>

        <div class="message-wrapper trash-wrapper">
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

