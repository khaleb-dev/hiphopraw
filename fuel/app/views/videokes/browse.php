<?php if (isset($notification)): ?>
    <div id="admin-notification-container">
        <?php echo Html::anchor(Asset::get_file('logo_slogan.png', 'img'), '', array("id" => "admin-notification", "rel" => "lightbox", "title" => $notification->notification)) ?>
    </div>
<?php endif; ?>
<div id="center" class="clearfix">
    <div id="sidebar-left">
        <div class="sidebar-content content-box">
            <h3>Select Category</h3>
            <div id="category-search-form" class="content clearfix">
                <?php echo Form::open(array("action" => "videokes/browse", "method" => "get")); ?>
                <p>
                    <?php echo Form::input('search_term', $search_term, array("placeholder" => "Search")); ?>
                    <?php if ($search_term != '') { ?>
                        <span class="searched">Searched term: <?php echo $search_term; ?></span>
                    <?php } ?>						
                </p>
                <p>
                    <?php echo Form::select('category_id', $category_id, $categories); ?>	
                </p>				
                <?php echo Form::submit('', 'Go', array("class" => "button")); ?>
                <?php echo Form::close(); ?>
            </div>
        </div>
        <div class="sidebar-content content-box winners-ad">
            <h3>Category Winners</h3>
            <div class="content">
                <?php if (isset($contest_winners) && count($contest_winners) > 0): ?>
                    <?php foreach ($contest_winners as $contest_winner): ?>
                        <?php $videoke = Model_Videoke::find($contest_winner['winner']) ?>
                        <div id="contestant-<?php echo $videoke->user->id ; ?>" align="center">
                            <?php echo Html::anchor('users/show/' . $videoke->user->id, Html::img(Model_User::get_picture($videoke->user, "home_page"))); ?>
                            <h3><?php echo $videoke->user->username; ?></h3>    
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo Asset::img("defaults/placeholder_thumb.jpg"); ?>
                <?php endif; ?>
                <p class="winner-name">This could be you!</p>
                <?php echo Html::anchor(Router::get("contest"), "Enter Now To Join!", array("class" => "button rounded-corners")); ?>
            </div>
        </div>
        <p class="view-all"><?php echo Html::anchor(Router::get("contest_winners"), "View All"); ?>

        <div class="sidebar-content">
            <h4 class="big-cropper-star">
				Like us on Facebook
            </h4>
            <div class="facebook-fan content-box">
                <p>Become a fan of Hip Hop Raw
				on facebook now! Its easy just
				click the like us button below.</p>
                <?php echo Html::anchor("http://www.Facebook.com/hiphopraw", Asset::img("facebook_like.jpg")); ?>
            </div>
        </div>
    </div>
    <div id="content" class="with-sidebar-left">
        <h2>Latest <?php echo $title; ?> <span>See what star would vote for you!</span></h2>
        <div class="items browse clearfix">
            <?php if (count($videokes) > 0) { ?>
                <?php foreach ($videokes as $videoke) { ?>
                    <div class="item content-box">
                        <?php echo Html::anchor("videokes/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT))); ?>
                        <h3><?php echo Html::anchor("videokes/show/" . $videoke->id, $videoke->title); ?></h3>
                        <p class="views">Views(<?php echo $videoke->views; ?>) By: <?php echo $videoke->user->username; ?></p>
                    </div>
                <?php } ?>
                <div class="paging">
                    <?php echo $pagination->render(); ?>
                </div>
            <?php } else { ?>
                <p class="highlight-box">No videokes found in your search!</p>
            <?php } ?>
        </div>

        <?php echo View::forge("pages/partials/join_ad"); ?>
    </div>
</div>