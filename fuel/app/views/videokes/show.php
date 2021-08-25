<div id="content-video-player-big">
<div id="right-left-content">
<div id="right-content">
<div id="main-player">
<div id="number-of-play">
    <div class="pull-left"><p>TITLE OF ARTIST - <?php echo $videoke->title; ?></p></div>
    <div class="clearfix"></div>
</div>

<?php if( $videoke->youtube_link == 1 ){ ?>

   <?php $parts = preg_split('/\s+/', $videoke->video); ?>

   <?php $ulink = "<iframe width='820' height='400' ".$parts[3]." frameborder='0' allowfullscreen></iframe>"; ?>
   <?php echo $ulink; ?>
    
<?php }else { ?>

<div id="flowplayer-container">
    <span id="videoke-info" data-view-counted="false" data-videoke-id="<?php echo $videoke->id; ?>"
          data-update-count="<?php echo Uri::create('videos/update_count'); ?>" data-attr="views"
          data-to-update="#video-views"></span>

    <div class="flowplayer  first-frame" data-swf="player/flowplayer.swf"
         data-key="$400714113257224"
         data-logo="http://www.hiphopraw.com/assets/img/hhr-logo-large.png">
        <video preload="none" height="100%" width="100%"
               poster="<?php echo $videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT); ?>">
            <?php foreach (Model_Videoke::get_formats() as $key => $value) { ?>
                <source src="<?php echo $videoke->get_video($value['extension']); ?>"
                        type="video/mp4" />
            <?php } ?>
        </video>
    </div>
</div>
<?php } ?>

    <div id="video-rating">
        <div>
            <div class="pull-left" id="profile-pic">
                <?php if ($current_user): ?>
                    <?php echo Html::anchor("users/show/" . $user->id, Html::img(Model_User::get_picture($user, "profile"), array('id' => 'profile-pic-img'))); ?>
                <?php else: ?>
                    <?php echo Html::anchor("pages/show_profile/" . $user->id, Html::img(Model_User::get_picture($user, "profile"), array('id' => 'profile-pic-img'))); ?>
                <?php endif; ?>
            </div>

            <div class="pull-left" id="name-follow">
                <p class="text-white"> <?php echo $user->username; ?> </p>
                <?php if ($current_user): ?>
                    <button id="button-follow" value="FOLLOW" url="<?php echo Uri::create('followers/follow'); ?>">
                        <?php if (Model_Follower::following_status($user->id, $current_user->id)) : ?>
                            FOLLOWING
                        <?php else: ?>
                            FOLLOW
                        <?php endif; ?>
                    </button>
                <?php endif; ?>
                <?php if (!$current_user): ?>
                    <button id="public-button-follow" value="FOLLOW">FOLLOW</button>
                <?php endif; ?>
            </div>

            <?php if ($current_user): ?>
                <?= Form::hidden('id', $user->id, array('id' => 'user-id')); ?>
                <?= Form::hidden('id', $current_user->id, array('id' => 'current-user-id')); ?>

            <div id="video-rating-lists" class="pull-left">
                <a href="#comment-Modal" data-toggle="modal" tabindex="-1"
                   href="#"><?php echo Asset::img('videoke/comment-counter.png', array('id' => 'comment-counter-img', 'class' => 'pull-left')); ?></a>
                <a href="#share-Modal" data-toggle="modal" tabindex="-1"
                   href="#"><?php echo Asset::img('videoke/share.png', array('id' => 'comment-counter-img', 'class' => 'pull-left')); ?></a>


                <div class="pull-left" id="total-views-wrapper" style="margin-right: 40px;">
                <p class="ctr" id="video-views"> <?php
                    if ($videoke->views < 1000) {
                        echo $videoke->views;
                    } else if ($videoke->views >= 1000 && $videoke->views < 1000000) {
                        echo $videoke->views / 1000 . 'K';
                    } else {
                        echo $videoke->views / 1000000 . 'M';
                    }
                    ?> </p>

                <div id="total-views" url="<?php echo Uri::create('comments/show'); ?>">
                    <p> TOTAL VIEWS </p>
                </div>
            </div>
            </div>
        </div>
        <div class="right-div">
            <div class="pull-left rate-ctr">
                <p class="pull-left">
                    <span class="red">RAW</span> <br/>
                    <span class="num">(<?php echo $videoke->likes; ?>)</span>
                </p>

                <p class="pull-left">
                    <span class="white-txt">WACK</span> <br/>
                    <span class="num">(<?php echo $videoke->dislikes; ?>)</span>
                </p>

                <p class="pull-left">
                    <span>TOTAL</span> <br/>
                    <span class="num">(<?php echo($videoke->likes - $videoke->dislikes); ?>)</span>
                </p>
            </div>

            <div class="dropdown pull-left">
                <?= Form::hidden('id', $videoke->id); ?>
                <button class="dropdown-toggle pull-left" data-toggle="dropdown" id="btn-rate" value="RATE"
                        url="<?php echo Uri::create('videos/rate'); ?>">RATE NOW
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                    <li class="rating" value="1"><a tabindex="-1"
                                                    href="#"><?= Form::radio('rating', 1, array('id' => 'rating')); ?>(R)
                            Raw &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            (1)</a></li>
                    <li class="rating" value="0"><a tabindex="-1"
                                                    href="#"><?= Form::radio('rating', 0, array('id' => 'rating')); ?>(A)
                            Alright&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(0)</a>
                    </li>
                    <li class="rating" value="-1"><a tabindex="-1"
                                                     href="#"><?= Form::radio('rating', -1, array('id' => 'rating')); ?>(W)
                            Wack&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(-1)</a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
            <?php if (!$current_user): ?>
            <div id="public-video-rating-lists" class="pull-left ">
                <a href="#" data-toggle="modal" tabindex="-1"
                   href="#"><?php echo Asset::img('videoke/comment-counter.png', array('id' => 'public-comment-counter-img', 'class' => 'pull-left public-comment')); ?></a>
                <a href="#" data-toggle="modal" tabindex="-1"
                   href="#"><?php echo Asset::img('videoke/share.png', array('id' => 'public-share-counter-img', 'class' => 'pull-left public-share')); ?></a>

                <div class="pull-left" id="public-total-views-wrapper">
                    <p class="ctr" id="video-views"> <?php
                        if ($videoke->views < 1000) {
                            echo $videoke->views;
                        } else if ($videoke->views >= 1000 && $videoke->views < 1000000) {
                            echo $videoke->views / 1000 . 'K';
                        } else {
                            echo $videoke->views / 1000000 . 'M';
                        }
                        ?> </p>

                    <div id="total-views" class = 'public-views' url="<?php echo Uri::create('comments/show'); ?>">
                        <p> TOTAL VIEWS </p>
                    </div>
                </div>
                <div class="ver-separtaor"></div>
                <div class="pull-left rate-ctr public-rate-ctr">
                    <p class="pull-left text-center">
                        <span class="red">RAW</span> <br/>
                        <span class="num">(<?php echo $videoke->likes; ?>)</span>
                    </p>

                    <p class="pull-left">WACK <br/> <span class="num">(<?php echo $videoke->dislikes; ?>)</span></p>

                    <p class="pull-left">TOTAL <br/> <span class="num">(<?php echo($videoke->likes - $videoke->dislikes); ?>
                            )</span></p>
                </div>
                <div class="dropdown pull-left">
                    <button class="dropdown-toggle pull-left" data-toggle="dropdown" id="public-btn-rate" value="RATE">RATE
                        NOW
                    </button>
                </div>
                <?php endif; ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>



    <?php if ($current_user): ?>
      <?php   if( $videoke->youtube_link == 1 ){ ?>
    <div id="video-detail">
        <div id="published-date">
            <p> PUBLISHED ON: <?php echo Date::forge($videoke->created_at)->format("%m %d, %Y"); ?>
                <span class="red">BY: <?php echo $user->username; ?> </span></p>

            <p id='hidden-element'><?php echo $user->city . ',' . $user->state; ?></p>

            <div id="left-separtor">
            </div>
            <div id="middle-text">
                <p id="show-more"> MORE </p>

                <p id="show-less"> LESS </p>
            </div>
            <div id="right-separtor">
            </div>
        </div>
        <div id="published-separator-yt">
        </div>
        <div id="short-description-yt">
            <h4>Short Desription:</h4>
            <?php if(Str::length($videoke->description) < 150): ?>
                 <p style="font-size:10px; color:#fff;"><?php echo $videoke->description; ?></p>
             <?php else: ?>
                    <p style="font-size:10px; color:#fff;"><?php echo Str::truncate($videoke->description,150); ?></p>
                     <p ><?php echo Html::anchor("#", "Read More...", array("id" => "sent-message-read-more-yt", 'onclick'=>'div_show_yt()')); ?> </p> 
             <?php endif; ?>    
        </div>
           <div onclick="check1(event)"  id="message-yt">
        
                  <a  id="close1"><?php echo Asset::img('close1.png') ?></a>
                  
                   <div id="enternal-popup">
                         <p style="font-size:10px; color:#fff;">
                                <?php echo $videoke->description; ?>        
                        </p>
                   </div>
                  
         
            </div>
    </div>
      <?php }else { ?>
    <div id="video-detail">
        <div id="published-date">
            <p> PUBLISHED ON: <?php echo Date::forge($videoke->created_at)->format("%m %d, %Y"); ?>
                <span class="red">BY: <?php echo $user->username; ?></span> </p>

            <p id='hidden-element'><?php echo $user->city . ',' . $user->state; ?></p>

            <div id="left-separtor">
            </div>
            <div id="middle-text">
                <p id="show-more"> MORE </p>

                <p id="show-less"> LESS </p>
            </div>
            <div id="right-separtor">
            </div>
        </div>
        <div id="published-separator">
        </div>
        <div id="short-description">
            <h4>Short Desription:</h4>
            <?php if(Str::length($videoke->description) < 150): ?>
			     <p style="font-size:10px; color:#fff;"><?php echo $videoke->description; ?></p>
			 <?php else: ?>
                    <p style="font-size:10px; color:#fff;"><?php echo Str::truncate($videoke->description,150); ?></p>
			         <p ><?php echo Html::anchor("#", "Read More...", array("id" => "sent-message-read-more", 'onclick'=>'div_show()')); ?> </p> 
             <?php endif; ?>    
        </div>
		 <div onclick="check(event)"  id="message">
		
                  <a  id="close"><?php echo Asset::img('close1.png') ?></a>
                  
                   <div id="enternal-popup">
                         <p style="font-size:10px; color:#fff;">
                                <?php echo $videoke->description; ?>        
                        </p>
                   </div>
                  
		 
		 </div>
    </div>
    <?php } endif; ?>



    <?php if (!$current_user): ?>

    <?php   if( $videoke->youtube_link == 1 ){ ?>

    <div id="video-detail">
        <div id="public-published-date">
            <p> PUBLISHED ON: <?php echo Date::forge($videoke->created_at)->format("%m %d, %Y"); ?>
                <span class="red">BY: <?php echo $user->username; ?> </span></p>

            <p id='hidden-element'><?php echo $user->city . ',' . $user->state; ?></p>

            <div id="left-separtor">
            </div>
            <div id="middle-text">
                <p id="show-more"> MORE </p>

                <p id="show-less"> LESS </p>
            </div>
            <div id="right-separtor">
            </div>
        </div>
        <div id="published-separator-yt">
        </div>
        <div id="short-description-yt">
            <h4>Short Desription:</h4>
             <?php if(Str::length($videoke->description) < 150): ?>
             <p style="font-size:10px; color:#fff;"><?php echo $videoke->description; ?></p>
             <?php else: ?>
             <p style="font-size:10px; color:#fff;"><?php echo Str::truncate($videoke->description,150); ?></p>
                <p ><?php echo Html::anchor("#", "Read More...", array("id" => "sent-message-read-more-yt", 'onclick'=>'div_show_yt()')); ?> </p>
             <?php endif; ?>
        </div>
        <div onclick="check1(event)"  id="message-yt">

                  <a  id="close1"><?php echo Asset::img('close1.png') ?></a>

                   <div id="enternal-popup">
                         <p style="font-size:10px; color:#fff;">
                             <?php echo $videoke->description; ?>
                         </p>
                   </div>


        </div>
    </div>

    <?php }else { ?>
    <div id="video-detail">
        <div id="public-published-date">
            <p> PUBLISHED ON: <?php echo Date::forge($videoke->created_at)->format("%m %d, %Y"); ?>
                <span class="red">BY: <?php echo $user->username; ?></span> </p>

            <p id='hidden-element'><?php echo $user->city . ',' . $user->state; ?></p>

            <div id="left-separtor">
            </div>
            <div id="middle-text">
                <p id="show-more"> MORE </p>

                <p id="show-less"> LESS </p>
            </div>
            <div id="right-separtor">
            </div>
        </div>
        <div id="published-separator">
        </div>
        <div id="short-description">
            <h4>Short Desription:</h4>
             <?php if(Str::length($videoke->description) < 150): ?>
			 <p style="font-size:10px; color:#fff;"><?php echo $videoke->description; ?></p>
			 <?php else: ?>
             <p style="font-size:10px; color:#fff;"><?php echo Str::truncate($videoke->description,150); ?></p>
				<p ><?php echo Html::anchor("#", "Read More...", array("id" => "sent-message-read-more", 'onclick'=>'div_show()')); ?> </p>
             <?php endif; ?>
        </div>
		<div onclick="check(event)"  id="message">

                  <a  id="close"><?php echo Asset::img('close1.png') ?></a>

                   <div id="enternal-popup">
                         <p style="font-size:10px; color:#fff;">
                             <?php echo $videoke->description; ?>
                         </p>
                   </div>


		 </div>
    </div>
    <?php }  endif; ?>
</div>
    
</div>




<div id="other-videos">
    <p>
        <?php echo Asset::img("nav-icons.png"); ?>OTHER VIDEOS BY <?php echo strtoupper($user->username); ?></p>
</div>
<div class="single-video-playlist">
    <div id="main-playlist">
        <div id="left-scroller">
            <a href="#"
               data-direction="left"><?php echo Asset::img('videoke/left-scroller.png', array('id' => 'left-scroller-img')); ?></a>
        </div>
        <div id="visible-videos">
            <div id="video-items" class="clearfix" data-left="0">
                <?php
                if ($othervideos) {
                    foreach ($othervideos as $video) {
                        $view = View::forge('videokes/partials/others_single_item');
                        $view->videoke = $video;
                        echo $view;
                    }
                } else {
                    echo '<p class = "no-other-videos">No Other Videos</p>';
                }
                ?>
            </div>
        </div>
        <div id="right-scroller">
            <a href="#"
               data-direction="right"><?php echo Asset::img('videoke/right-scroller.png', array('id' => 'right-scroller-img')); ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- -  <div id = "comments">-->


<div class="comments">
    <div id="comments">
        <p class="title" id="comment-title">
            <?php echo Asset::img("home/commentsIcon.png"); ?>COMMENTS</p>
    </div>
    <!-- first comment -->

    <?php if ($comments): ?>

        <?php foreach ($comments as $comment):
            echo View::forge("videokes/partials/single_comment", array("comment" => $comment, "videoke" => $videoke));
            ?>
        <?php
        endforeach;
        //echo '<p class="more-comment"><a href="#" class="more-comment red"> > VIEW MORE </a></p>';
    else:
        echo '<p class="show-nodata-comments">No comments to display!</p>';
    endif;
    ?>

</div>
<!-- end of comments -->
<div class="full-width">
    <div class="more-div">
        <p class="short-grey-line"></p>
        <p>MORE</p>
        <p class="short-grey-line"></p>
    </div>
</div>
</div>
<div id="left-content">
    <div id="video-suggestions">
        <p>VIDEO SUGGESTIONS</p>
    </div>
    <div class="video-container">

        <?php
        if ($suggestions) {
            if (sizeof($suggestions) > 0) {
                foreach ($suggestions as $video) {
                    $view = View::forge('videokes/partials/single_item_suggestion');
                    $view->videoke = $video;
                    echo $view;
                    echo '<div class="clearfix"></div><hr class="thin-divider" />';
                }
            } else {
                echo "No Video Suggestions";
            }
        } else {
            echo "No Video Suggestions";
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
</div>
<!-- comment Modal -->
<div id="comment-Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">

    <div class="modal-body">
        <p class="comment-modal-title">Write a comment</p>

        <p class="red comment-sub-title">Comment on this video</p>

        <div class="pull-left comment-profile-pic">
            <?php echo Asset::img('videoke/comment-pro-pic.jpg'); ?>
        </div>
        <div class="pull-left comment-form">
            <form id="post-comment" action="<?php echo Uri::create('comments/create'); ?>" method="post">
                <textarea id="comment-message" name="message"></textarea>
                <br/>
                <input type="hidden" id="comment-to" name="comment_to" value="<?php echo $videoke->id ?>"/>
                <button id="button-follow-comment" value="Submit">Submit</button>
            </form>
        </div>

        <div class="clearfix"></div>
    </div>

</div>

<!-- share Modal -->
<div id="share-Modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">

    <div class="modal-body">
        <p class="comment-modal-title">Share with a friend</p>

        <div class="share-form">
            <form action="<?php echo Uri::create('invites/create_ajax'); ?> " id="modal-invite-form" method="post">
                <p class="gray">Email Address:</p>
                <input id="form_emails" name="emails" type="text"/>

                <p class="sub-text">Please separate emails with comma, e.g. john@example.com, mary@site.org</p>

                <p class="gray">Messages:</p>
                <textarea id="form_message" name="message"></textarea>
                <?php echo Form::hidden('videoke_id', $videoke->id); ?>
                <button type="button" class="pull-right btn-close" data-dismiss="modal" aria-hidden="true">Close
                </button>
                <button class="btn-send" id="button-follow" value="Send"
                        url="<?php echo Uri::create('videokes/rate'); ?>">Send
                </button>

            </form>
        </div>

        <div class="clearfix"></div>
    </div>

</div>

<div id="upgrade-hello-dialog" class="public-profile-dialog-upgrade-common dialog">

    <div id="upgrade-content" class="clearfix">
        <h5>You must sign up inorder to interact with the platform.</h5>
    </div>
</div>
