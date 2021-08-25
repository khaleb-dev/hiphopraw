<?php if(isset($notification)): ?>
    <div id="admin-notification-container">
        <?php echo Html::anchor(Asset::get_file('logo_slogan.png', 'img'), '', array("id" => "admin-notification", "rel" => "lightbox", "title" => $notification->notification)) ?>
    </div>
<?php endif; ?>

<div id="home-container">
    <input type="hidden" id="page" value="HOME" />
    <div id="home-background-container">
        <div id="home-black-container">

 <div id="home-top-playlist">
             <div class="main-video">
                    <div id="youtube-video">

                            
                    </div> 
                    <?php if($featured_videos){ ?>
                            <?php  $vcounter = 0;?>
                        <?php foreach ($featured_videos as $key => $value){ ?>

                                    <?php
                            $video = Model_Videoke::find($value['video_id']);
                    
                 if($video){
                                
                            if($vcounter==0){
                                        
                                        if($video) {
                                            $user = Model_User::find($video->user_id);
                                        }


                                    ?>
                    <?php if( $video->youtube_link == 1 ){ ?>
                       <?php   $parts = preg_split('/\s+/', $video->video);

                            $ulink = "<iframe width='650' height='400' ".$parts[3]." frameborder='0' allowfullscreen></iframe>";
                        ?>
                        <div id="first-u-video">
                         <?php echo $ulink; ?>
                        </div>
                         <?php $vcounter+=1;  ?>
    
                    <?php }else { ?>


                    <div id="basic-playlist" class="flowplayer  first-frame" style="background:  transparent no-repeat width: 100%;"
                         data-ratio="0.2567"
                         data-swf="player/flowplayer.swf"
                         data-key="$400714113257224"
                         data-logo="<?php echo $video->get_picture($video->user, Model_Videoke::THUMB_HOME);?>">
                         
                         
                                    <?php if($video && $user){?>


                                       <video id="video" preload="none" poster="<?php echo $video->get_picture($video->user, Model_Videoke::THUMB_HOME);?>">
                                             
                                            <source id="source" type="video/mp4" src="<?php echo 'http://hiphopraw.com/uploads/'.Model_User::clean_name($user->username).'/videokes/'.$video->video.'.mp4';?>">
                                            
                                      </video>
                                    <?php $vcounter+=1;  ?>
                                     
                            <?php } ?>
             
                    </div>

                    <?php } ?>
                    <?php  }?>
                                  
             <?php } } ?>
             <?php } ?>

                </div>

                <?php if($featured_videos): ?>
                <?php foreach ($featured_videos as $key => $value): ?>

                <div class="mini-video">
                           <?php            
                         $video = Model_Videoke::find($value['video_id']);
                            if($video){
                           echo View::forge("videokes/partials/single_item_home_player",array("videoke"=>$video));
                       }
                            ?>
                            <!-- <a href="#"><?php echo Asset::img("hhr-logo-large.png"); ?></a> -->
                </div>
                 <?php endforeach; ?>  
                  <?php endif; ?>              
            </div>


        </div>
    </div>
    </div>
 <div id="home-middle-playlist">
        <div>
            <p class="grey-line"></p>
            <p><span class="red-txt">&nbsp;&nbsp;&nbsp;FEATURED</span> PROFILES&nbsp;&nbsp;&nbsp;</p>
            <p class="grey-line"></p>
        </div>
        <div id="scroller-container">
            <div id="home-middle-left-scroller">
                <a href="#" data-direction="left"><?php echo Asset::img("home/home-middle-left-scroller.png"); ?></a>
            </div>
            <div id="visible-banners">
            <div id="banner-items" class="clearfix" data-left="0">
            <div id="home-middle-player">
               <?php if(count($banners) > 0): ?>
            <?php foreach ($banners as $banner) : ?>
                <div class="ad-image">
                <a href="<?php echo $banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($banner), array('width'=>'290', 'height' => '135')) ?></a>
                 </div>

             <?php endforeach; ?>
             <?php endif; ?>

               <!-- <?php //if($current_user) :?>          
                <div class="ad-image"><?php// echo Html::anchor("users/show/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>             
                <?php// else :?>
                <div class="ad-image"><?php// echo Html::anchor("pages/show_profile/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>              
                <?php// endif ;?> 
                <div class="ad-image"> <a href = "#"><?php// echo Asset::img('sammie2.jpg'); ?> </a></div> -->
            </div>                     
             </div>
             </div>
            
            <div id="home-middle-right-scroller">
                <a href="#" data-direction="right"><?php echo Asset::img("home/home-middle-right-scroller.png"); ?></a>
            </div>
        </div>
    </div>

<div class="home-white-wrapper">
<!-- <div id="home-date">
    <?php $date = Date::forge(strtotime("now"))->format("%m,%d,%Y"); ?>
     <?php 
     $str_num = explode(",",$date);
     if($str_num[0] === '01'){
      $str = 'JAN';
     }elseif($str_num[0] === '02'){
      $str = 'FEB';
     }elseif($str_num[0] === '03'){
      $str = 'MAR';
     }elseif($str_num[0] === '04'){
      $str = 'APR';
     }elseif($str_num[0] === '05'){
      $str = 'MAY';
     }elseif($str_num[0] === '06'){
      $str = 'JUN';
     }elseif($str_num[0] === '07'){
      $str = 'JUL';
     }elseif($str_num[0] === '08'){
      $str = 'AUG';
     }elseif($str_num[0] === '09'){
      $str = 'SEP';
     }elseif($str_num[0] === '10'){
      $str = 'OCT';
     }elseif($str_num[0] === '11'){
      $str = 'NOV';
     }else{
      $str = 'DEC';
     }
     ?>
        <p><span class="red-line"></span><strong><?php echo $str.', '.$str_num[2];?></strong></p>
</div> -->
<div id = "videos-videos-row">
    <?php
        $number_of_videos = 0;
        $displayed_videos = 0;
        if ($random_videokes) {
            $number_of_videos = sizeof($random_videokes);
            $displayed_videos=0;
            foreach ($random_videokes as $videoke){
                   
                echo View::forge("videokes/partials/single_item",array("videoke"=>$videoke));
                $displayed_videos++;
                  
                if ($displayed_videos > $number_of_videos || $displayed_videos >= 8)
                    break;
            }
        }

        else {
            echo '<p class = "no-videos-data">No videos found!</p>';
        }

    ?>
	</div>
    <div class="clearfix"></div>
    <div id="home-banners-row">
        <div id="banner-container">

                     
                        <div id="home-banners-row">
                         <div id="banner-container">
                          <?php if(isset($first_left_banner)): ?>
                             <div id="banner-gitar">
                                <a href="<?php echo $first_left_banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($first_left_banner)) ?></a>
                                </div>
                             <?php endif; ?>
                        <?php if(isset($first_right_banner)): ?>
                                <div id="banner-coca">
                                <a href="<?php echo $first_right_banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($first_right_banner)) ?></a>
                    </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                         </div>

                        </div>
                        
            </div>

     </div>
     <?php if($displayed_videos >= 8): ?>
        <div id="videos-view-more">
            <p  id = "view-more-anchor" url = "<?php echo Uri::create('users/hhrnews_logged_show_more'); ?>" data-page-no="2"><strong>VIEW MORE VIDEOS</strong>
            </p>
        </div>
    <?php endif; ?>
 </div>
</div>
<div class="home-middle-playlist">
    <h4><span class="red-txt">Featured</span> Partners</h4>
    <div class="scroller-container" id="scroller-container">
        <div class="home-middle-left-scroller">
            <div class="home-bottom-left-scroller">
            <a href="#" data-direction="left"  onclick="return false;"><?php echo Asset::img("home/home-middle-left-scroller.png"); ?></a>
            </div>
        </div>
        <div class="visible-banners">
            <div class="banner-items" class="clearfix" data-left="0">
                <div class="home-middle-player">
                    <div class="home-bottom-player">
                    <?php if(count($sponsors) > 0): ?>
                        <?php foreach ($sponsors as $sponsor) : ?>
                            <div class="ad-image-2">
                                <a href=" " target="_blank"><?php echo Asset::img(Model_Sponsor::get_sponsor($sponsor), array('width'=>'160', 'height' => '130')) ?></a>
                            </div>


                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                    <!-- <?php //if($current_user) :?>
                <div class="ad-image"><?php// echo Html::anchor("users/show/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>
                <?php// else :?>
                <div class="ad-image"><?php// echo Html::anchor("pages/show_profile/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>
                <?php// endif ;?>
                <div class="ad-image"> <a href = "#"><?php// echo Asset::img('sammie2.jpg'); ?> </a></div> -->
                </div>
            </div>
        </div>

        <div class="home-middle-right-scroller">
            <div class="home-bottom-right-scroller">
            <a href="#" data-direction="right"  onclick="return false;"><?php echo Asset::img("home/home-middle-right-scroller.png"); ?></a>
            </div>
        </div>
    </div>
</div>