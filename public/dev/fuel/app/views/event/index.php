<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><b>Upgrade</b> to never see ads again. <b>Remove</b></p>
</div>

<div id="content" class="clearfix">
  <div class="inner-wrapper">
    <div class="section-title">
        <h3>Latest Events</h3>
        <p>Experience a night out with friends!</p>
        <div class="border-icon4"></div>
        <div class="clearfix"></div>
    </div>

    <div id="middle">
        <?php if (isset($active_events) and $active_events !== false): ?>
            <?php foreach ($active_events as $event): ?>
                <div class="content-item">
                    <div class="image pull-left">
                        <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                            <?php if (empty($event['photo'])): ?>
                                <img src="temp/event_thumb.jpg" />
                            <?php else: ?>
                                <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_list_' . $event['photo'] ?>" />
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="decription pull-left">
                        <p class="title"><?php echo $event['title'] ?></p>
                        <p class="location"><span class="gray">Located:</span><?php echo $event['city'] . ', '. $event['state']; ?></p>
                        <p class="date"><?php echo $event['start_date'] ?></p>
                        <p class="detail gray"><?php echo $event['short_description'];  ?></p>
                        <?php echo Html::anchor('event/view/' . $event['slug'], 'View Event', array('class' => 'btn-detail')); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php endforeach; ?>
            <div class="btn-holder"><a class="" href="#">More Events</a></div>
        <?php else: ?>
            <div class="event-list clearfix" id="no-event">
                No event found from your location.
            </div>
        <?php endif; ?>

    </div>

    <aside id="right-sidebar">

        <div class="upper">
            <?php echo Asset::img('temp/event-sidebar.jpg', array('class' => '')); ?>
            <div class="text">
                <h3>WhereWeAllMeet.com Events</h3>
                <p class="gray"><strong>Connect with others to go to plays, sporting events, concerts, etc. </strong></p>
                <br/>
                <p class="gray"><strong>Whatever they like and with someone who wants to do the same thing.</strong></p>
            </div>
            <div class="form">
                <h3 class="green">Find Your Perfect Event</h3>
                <form method="POST">
                    <select name="location">
                        <option value="" >Event Location:</option>
                    </select>
                    <input type="text" name="from" placeholder="From" />
                    <input type="text" name="to" placeholder="To" />

                    <input type="submit" name="search" value="Search" />
                </form>
            </div>
        </div>

        <div class="lower">
            <?php echo Asset::img('temp/event-operator.jpg', array('class' => '')); ?>
            <div class="inner-content">
                <p><strong>Let Us help</strong></p>
                <p class="sub-text"><strong>Upgrade to connect to our dating agents.</strong></p>
                <div class="btn-con"><a class="upgrade-btn pink-btn" href="#">Upgrade Now</a></div>
            </div>
        </div>
        
    </aside>
    <div class="clearfix"></div>
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
</div>

</div> <!-- end of content -->

<!-- The below code is to display detail  view of an event, i wrote it on this page cuz I dont know the VIEW file, 
please move it to its respective view file, and its CSS can be found on events.css at the bottom part (commented on CSS)-->
<!-- detail view of an event -->
<div id="content" class="detail-view clearfix">

  <div class="inner-wrapper">
        <div class="section-title">
            <h3>Latest Events</h3>
            <p>Experience a night out with friends!</p>
            <div class="border-icon4"></div>
            <div class="clearfix"></div>
        </div>

          <?php if (isset($active_events) and $active_events !== false): ?>
              <?php foreach ($active_events as $event): ?>
                  <div class="detail-content">
                      <div class="col1 pull-left">
                          <a href="<?php echo \Fuel\Core\Uri::create('event/view/' . $event['slug']) ?>">
                              <?php if (empty($event['photo'])): ?>
                                  <img src="temp/event_thumb.jpg" />
                              <?php else: ?>
                                  <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/events/event_detail_' . $event['photo'] ?>" />
                              <?php endif; ?>
                          </a>
                          <div class="inner-content">
                              <p>Who wants to go with me? </p>
                              <form method="POST">
                                  <select name="location">
                                      <option value="" >Select your friends from list</option>
                                  </select>
                                  <input type="submit" name="search" value="Send Invite" />
                              </form>
                          </div>
                      </div>
                      <div class="col2 pull-left">
                          <p class="title"><?php echo $event['title']; ?></p>
                          <p class="location"><span class="gray">LOCATED: </span><?php echo $event['city'] . ', '. $event['state']; ?></p>
                          <p class="date"><?php echo $event['start_date']; ?></p>
                          <p class="gray detail-text"><?php echo $event['long_description'];  ?></p>
                          <div class="book-btn-wrap green-bg">
                              <a href="#">BOOK EVENT</a>
                          </div>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <div class="event-list clearfix" id="no-event">
                  No event found from your location.
              </div>
          <?php endif; ?>

        <p class="go-back"><a href="<?php echo \Fuel\Core\Uri::create('event/view_all') ?>"><< back to all events</a>
   
    <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
   
   </div>
</div>
<!-- end of detail view of an event -->