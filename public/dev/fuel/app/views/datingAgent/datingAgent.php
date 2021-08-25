<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array()); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>
</div>

<div id="content" class="clearfix">

    <div id="middle">

        <section id="latest-members">
          <div class="header-section">
              <p class="header-text">About WhereWeAllMeets Dating agents</p>
          </div>
            
            <div class="content">
            	<div id="description">
                    <p>
                        Our personal Dating Concierge Agents take the work out of the online dating process.
                        Let us help you improve the quality and quantity of your dates and maximize your online experience.
                    </p>
                    <p>
                        Our Dating Concierge Agents are socially on point savvy women and men highly educated in communication
                        and the art of online dating. We are dedicated to helping you put your best foot forward and helping
                        you navigate through the often scary world of online dating.
                    </p>
            	</div>

            </div>
        </section>   

        <section class="agent-listing">
          <div class="header-section">
              <p class="header-text">Current Dating Agents</p>
          </div>
            
            <div class="content">
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("online_dot.png"); ?>
                        online
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("offline_dot.png"); ?>
                        offline
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("online_dot.png"); ?>
                        online
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("offline_dot.png"); ?>
                        offline
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>    
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("online_dot.png"); ?>
                        online
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("offline_dot.png"); ?>
                        offline
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("online_dot.png"); ?>
                        online
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>
                <div class="agent">
                    <div class="online-status">
                        <?php echo Asset::img("offline_dot.png"); ?>
                        offline
                    </div>
                    <div class="agent-image"><?php echo Asset::img("temp/dating-agent-1.jpg"); ?></div>
                    <div class="agent-caption">
                        <p class="name">Dating Agent 3</p>
                        <p class="location">San Francisco, California</p>
                    </div>
                </div>                                                            
                <div class="clearfix"></div>
            </div>

            <div class="link"><a href="#">View All Agents</a></div>
        </section>      

        <div class="get-started">
            <h2>Sit back and relax, let our dating agents do the work for you.</h2>  
            <div class="btn-wrap gold-bg">
                    <a href="#">SELECT A DATING AGENT TO GET STARTED</a>
            </div>    
        </div>          
        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
    </div>

    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/events-sidebar.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/date-idea-sidebar.jpg"); ?></a>
        </div>

    </aside>
</div>


<div id="upgrade" class="dialog">
    <p>You must <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), 'upgrade'); ?> your account to see a dating agent profile.</p>
</div>