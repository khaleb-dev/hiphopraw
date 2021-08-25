<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Banner Ads")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div id="banner-ads">
            <h2>Banner Ads</h2>
            <div class="content-box">
                <?php echo Form::open(array("action" => "admin/bannerAds", "enctype" => "multipart/form-data")); ?>
                <div class="items clearfix">
                    <p>
                        <?php echo Form::label('Title ', 'lblTitle'); ?>
                        <?php echo Form::input('title', '', array("class" => "text-field long","style"=>"width:300px;")); ?>
                    </p>
                    <p>
                        <?php echo Form::label('Banner ', 'lblBanner'); ?>
                        <?php echo Form::file('banner_image'); ?>
                    </p>
                    <p>
                        <?php echo Form::label('Page ', 'lblPage'); ?>
                        <?php
                        echo Form::select('page', '', array(
                            'Home' => 'Home',
                            'Videos' => 'Videos',
                            'Models' => 'Models',
                            'Top 100 videos' => 'Top 100 videos',
                            'News' => 'News'
                        ));
                        ?>
                    </p>
                    <p>
                        <?php echo Form::label('Position ', 'lblPosition'); ?>
                        <?php
                        echo Form::select('position', '', array(
                            'Left' => 'Left',
                            'Right' => 'Right',
                            'Top' => 'Top',
                            'Bottom' => 'Bottom'
                        ));
                        ?>
                    </p>
                    <p>
                        <?php echo Form::label('Web Address ', 'lblWebAddress'); ?>
                        <?php echo Form::input('web_address', '', array("class" => "text-field long","style"=>"width:300px;")); ?>
                    <span id="publish">
                        <?php echo Form::submit('btnPublishBanner', 'Publish New Banner', array("class" => "button")); ?>
                    </span>
                    </p>
                </div>
                <?php echo Form::close(); ?>
                <form style="margin:40px 0px 0px;" class="banner-form">
                    <table class="table contest-all-tbl">
                      <thead>
                        <tr>                          
                          <th width="30px"></th>
                          <th>BANNER TITLE</th>
                          <th>PAGE</th>
                          <th>POSITION</th>
                          <th>BANNER</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($bannerAds as $bannerAd) : ?>
                            <tr id="<?php echo $bannerAd->id; ?>">
                                <td><input class="banner-move-to-trash" data-banner-id="<?php echo $bannerAd->id; ?>" type="checkbox" /></td>
                                <td><?php echo $bannerAd->title; ?></td>
                                <td><?php echo $bannerAd->page; ?></td>
                                <td><?php echo $bannerAd->position; ?></td>
                                <td style="color:red"><?php echo $bannerAd->image; ?></td>
                            </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <center>
                    <!--<?php //echo Html::anchor("#", "Delete Selected", array("id" => "banner-delete", "url"=>"<?php echo Uri::create('admin/manage_banners')?>","class" => "button rounded-corners")); ?> -->
                    <a id="banner-delete" url="<?php echo Uri::create('admin/manage_banners')?>" class="button rounded-corners" href="#">Delete Selected</a>
                    </center>
                </form>
            </div>
        </div>
        <div id="notifications">
            <h2>Notifications</h2>
            <div class="content-box">
                <?php echo Form::open(array("action" => "admin/bannerAds", "enctype" => "multipart/form-data")); ?>
                <div class="items clearfix">
                    <p>
                        <?php echo Form::label('Title ', 'lblTitle'); ?>
                        <?php echo Form::input('title', '', array("class" => "text-field long", "placeholder"=>"Name of Your Contest")); ?>
                    </p>
                    <p>
                        <?php echo Form::label('Page ', 'lblPage'); ?>
                        <?php
                        echo Form::select('page', '', array(
                            'Home' => 'Home',
                            'Videos' => 'Videos',
                            'Models' => 'Models',
                            'News' => 'News'
                        ));
                        ?>
                    </p>
                    <p>
                        <?php echo Form::label('Notification ', 'lblNotification'); ?>
                        <?php echo Form::textarea('notification', '', array("style"=>"width:350px;", "placeholder"=>'Enter your notification here...')); ?>
                        <span id="publish2">
                            <?php echo Form::submit('btnPublishNotification', 'Publish', array("class" => "button")); ?>
                        </span>
                    </p>
                </div>
                <?php echo Form::close(); ?>                
                <form style="margin:40px 0px 0px;" class="banner-form">
                    <table class="table contest-all-tbl">
                      <thead>
                        <tr>                          
                          <th width="30px"></th>
                          <th>TITLE</th>
                          <th>PAGE</th>
                          <th>NOTIFICATION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($notifications as $notification) : ?>
                            <tr id="<?php echo $notification->id; ?>">
                                <td><input class="move-to-trash" data-notification-id="<?php echo $notification->id; ?>" type="checkbox" /></td>
                                <td><?php echo $notification->title; ?></td>
                                <td><?php echo $notification->page; ?></td>
                                <td><?php echo $notification->notification; ?></td>
                            </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                    <center>
                        <!-- <?php //echo Html::anchor("#", "Delete Selected", array("id" => "notification-delete","url"=>"<?php echo Uri::create('admin/manage_notifications')?>", "class" => "button rounded-corners")); ?>  -->
                        <a id="notification-delete" url="<?php echo Uri::create('admin/manage_notifications')?>" class="button rounded-corners" href="#">Delete Selected</a>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

