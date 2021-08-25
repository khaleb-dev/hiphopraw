<?php if (isset($notification)): ?>
    <div id="admin-notification-container">
        <?php echo Html::anchor(Asset::get_file('logo_slogan.png', 'img'), '', array("id" => "admin-notification", "rel" => "lightbox", "title" => $notification->notification)) ?>
    </div>
<?php endif; ?>
<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Users")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div id="users">
            <!--<h2><span>Users</span></h2>-->
            <div class="content-box">
                <div id="content-index">
                    <!--<p>Total Members (<?php //echo $total_users; ?>)</p>-->
					<h4 class="pull-left white">Viewing all users</h4>
                    <ul class="pull-left filter-section">
                        <li id="description">FILTER:</li>
                        <?php $alphas = range('A', 'Z'); ?>
                        <?php foreach ($alphas as $alpha) : ?>
                            <li><?php echo Html::anchor('admin/index/' . $alpha, $alpha); ?></li>
                        <?php endforeach; ?>
                        <li>|</li>
                    </ul>
					<div class="pull-left admin_user_search">
						<form class="form-inline" role="form">
						  <div class="form-group">
							<div class="input-group">
							  <input class="pull-left form-control" type="email" placeholder="Search...">
							  <div class="search-btn-wrap" ><button type="submit" value="" >
                                <?php echo Asset::img("red-search.png"); ?>
                              </button></div>
							  <div class="clear">&nbsp;</div>
							</div>
						  </div>
						</form>
					</div>

                    <div class="clear">&nbsp;</div>
                </div>

                <div class="items clearfix">
                    <?php if (count($users) > 0) { ?>
						<?php $ctr = 1; ?>
                        <?php foreach ($users as $user) : ?>
                            <div id="user-<?php echo $user->id; ?>" class="item">
							<div class="item-top">
                                <?php echo Html::anchor('users/show/' . $user->id, Html::img(Model_User::get_picture($user, "home_page"), array("class"=>"img-circle", "width" => "111", "height" => "99"))); ?>
                                <h3 class="model-name"><?php echo $user->username; ?></h3> 
								<p class="item-place gray model-name">
                                    <?php
                                     if ($user->facebook_link === '1'): ?>
                                          Fan - <?php echo $user->city . ", " . $user->state; ?>
                                     <?php else: ?>
                                            <?php
                                                 if (isset($user->category)) {
                                                        echo Model_Category::find($user->category)->name;
                                                     }
                                                ?>
                                             <?php echo $user->city . ", " . $user->state; ?>
                                     <?php endif; ?>




                                 </p>
								<p class="item-online gray">

                                 <?php 
                                    if($user->is_logged_in == 1){
                                            echo Asset::img('online_dot.png'); 
                                            echo "Online";
                                     }else{

                                            echo Asset::img('offline_dot.png');
                                            echo "Offline";
                                    } 
                                ?>


                                </p>
								<div class="clear">&nbsp;</div>
							</div>
                                <?php echo Form::open(array("id" => "admin-users-form-" . $user->id, "action" => "admin/manage_users")); ?>
                                <?= Form::hidden('id', $user->id); ?>
                                <div class="actions">
                                    <?php $button_text = (isset($user->is_blocked) && $user->is_blocked == 1) ? 'Unblock' : 'Block'; ?>
                                    <?php $button_action = (isset($user->is_blocked) && $user->is_blocked == 1) ? 'Unblock' : 'Block'; ?>
                                    
                                    <a class="item-block" href="#" data-user-id="<?php echo $user->id ?>" data-action=<?php echo $button_action; ?>>
                                        <span><?php echo $button_text; ?></span>
                                    </a>
									<a href="#" data-action="">
                                        <span>Delete</span>
                                    </a>									
                                </div>
                                <?php echo Form::close(); ?>
                            </div>	
							<?php 
							
							if($ctr%4==0)
								echo '<div class="clearfix item-divider"></div>';
							
							$ctr++; ?>							
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <p class="highlight-box">No Users!</p>
                    <?php } ?>
                </div>
                <?php if(count($users) < $category_count): ?>
                    <p class="view-more-container white-btn"><?php echo Html::anchor("admin/index/".$alphabet."/".$page, "View More Users"); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="clear">&nbsp;</div>
</div>
