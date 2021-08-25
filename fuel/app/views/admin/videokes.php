<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_video_side_nav", array("current_user" => $current_user, "menu" => "Videokes")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div id="users">
            <h2 class="white-txt">Viewing all Videos </h2>

            <div class="content-box">

                <div class="items clearfix">
                    <div class="check-button" url = "<?php echo Uri::create('admin/manage_featured_videos/')?>"> </div>



                    <?php if (count($videokes) > 0) : ?>
                        <?php $idx = 0; ?>
                        <?php foreach ($videokes as $videoke) { ?>
                            <div class="item" id="videoke-<?= $videoke->id ?>">
                                   
                                <?php echo Form::open(array("id" => "videoke-form-" . $videoke->id, "action" => "admin/manage_videos")); ?>
                                <?= Form::hidden('id', $videoke->id); ?>

                                <?php if($videoke->youtube_link == 1) { ?>
                                    <?php echo Html::anchor("videos/show/" . $videoke->id, Html::img($videoke->get_youtube_picture($videoke->user,$videoke->thumb_name), array("width" => "235", "height" => "139"))); ?>

                                <?php }else{ ?>
                                <?php echo Html::anchor("videos/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_ADMIN_VIDEO))); ?>    
                                <?php } ?>
                                <span class="play">
                                    <?php echo Asset::img("playIcon.png"); ?>
                                    
                                </span>                      
                                <div class="like-reader">
                                    <p> <?php echo Asset::img("user/like.png"); ?>
                                        0</p>
                                </div>
                                <div class="preview-reader">
                                    <p><?php echo $videoke->views; ?> 
                                        <?php echo Asset::img("user/preview.png"); ?>

                                        </p>
                                </div>
                                <p class="model-name"><?php echo Html::anchor("videos/show/" . $videoke->id, $videoke->title); ?></p>
                                <p class="user-name-duration">
                                    <span class="user-name">By: <?php echo $videoke->user->username; ?> 

                <?php

                $upload_timestamp_seconds = $videoke->created_at;
                $upload_date = new DateTime();
                $upload_date->setTimestamp($upload_timestamp_seconds);
                //echo $upload_date->format('Y-m-d H:i:s') . "<br />";

                $now = new DateTime();
                //echo $now->format('Y-m-d H:i:s') . "<br />";
                $diff = $now->diff($upload_date);
                if ($diff->y == 1) {
                    echo $diff->y . " year ago";
                } elseif ($diff->y > 1) {
                    echo $diff->y . " years ago";
                } elseif ($diff->m == 1) {
                    echo $diff->m . " month ago";
                } elseif ($diff->m > 1) {
                    echo $diff->m . " months ago";
                } elseif ($diff->d == 1) {
                    echo $diff->d . " day ago";
                } elseif ($diff->d > 1) {
                    echo $diff->d . " days ago";
                } elseif ($diff->h == 1) {
                    echo $diff->h . " hour ago";
                } elseif ($diff->h > 1) {
                    echo $diff->h . " hours ago";
                } elseif ($diff->i == 1) {
                    echo $diff->i . " minute ago";
                } elseif ($diff->i > 1) {
                    echo $diff->i . " minutes ago";
                } elseif ($diff->s == 1) {
                    echo $diff->s . " second ago";
                } else {
                    echo $diff->s . " seconds ago";
                }
                ?>




                                     </span>
                                    <!-- <span class="how-long">7 days ago</span> -->
                                </p>

                                

                                
                                <!-- <div class="checkbox-inner">
                                    <input class="check-each" data-video-id="<?php echo $videoke->id; ?>" type="checkbox" />
                                </div> -->

                                <!-- <div id="nonscript">
                                    <?php echo Html::anchor("videos/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME))); ?>
                                    <h3><?php echo Html::anchor("videos/show/" . $videoke->id, $videoke->title); ?></h3>
                                    <p class="views">Views(<?php echo $videoke->views; ?>) By: <?php echo $videoke->user->username; ?></p>

                                </div> -->

                                <div class="actions clearfix" id="script">
                                    <?php $button_text = ($videoke->is_blocked == 1) ? 'Unblock videoke' : 'Block videoke'; ?>
                                    <?php $button_action = ($videoke->is_blocked == 1) ? 'Unblock' : 'Block'; ?>
                                    <a href="#"  class="black-btn" data-video-id="<?php echo $videoke->id ?>" data-action=<?php echo $button_action; ?>>
                                        <span><?php echo $button_action; ?></span>
                                    </a>
                                    <a href="#" class="delete-btn" data-text="Delete video" data-video-id="<?= $videoke->id ?>" data-action="Delete">
                                        <span> Delete </span>
                                    </a>
                                    <p class="white-txt">
                                        <?php if($videoke->category_id==1){ ?>
                                            HIP HOP
                                        <?php } ?>
                                        <?php if($videoke->category_id == 2){ ?>
                                            MODEL
                                        <?php } ?>
                                        <?php if($videoke->category_id == 3){ ?>
                                            NEWS
                                        <?php } ?>


                                    </p>
                                </div>


                                <div class="selector">
                                    <div class="checkbox-inner">
                                            <input class="check-each" data-video-id="<?php echo $videoke->id; ?>" type="checkbox" />
                                    </div>
                                    <select  class="select-each" id = "single_select_<?php echo $videoke->id; ?>" data-page-id="<?php echo $videoke->id; ?>" name="select-<?= $videoke->id ?>" >
                                        <option value="home" selected="home">Home</option>
                                        <option value="hhrnews">News</option>
                                        <option value="models">Models</option>

                                    </select>
                                </div>
                                <?php echo Form::close(); ?>
                            </div>
                            <?php $idx++; 
                            if($idx%3 == 0){
                                echo "<hr>";
                            }
                            ?>
                        <?php } ?>



                    <?php else : ?>
                        <p class="highlight-box">No videos uploaded yet!</p>
                    <?php endif; ?>
                </div>
                <br>
                <h2>
                    <button class id ="video-save-selected" >Submit Selected Videos</button>
                </h2>

            

            <div id="featured-videos-popup" onclick="check(event)">
                <div id="manage-featured-videos">

                    <a  id="close"><?php echo Asset::img("close1.png"); ?></a>

                    <div id="pop-fv-header">
                      <div id="page-title" >
                        HOME PAGE
                       </div>
                
                    </div>
                    <div id="feature-content">
                        
                        <?php if (count($featured_videos_home) > 0) : ?>
                            <?php $idx = 1; ?>
                            <table style="margin: 0 auto;"  height="auto" width="auto">
                            <?php foreach ($featured_videos_home as $video_home) {
                                if($idx==1){?>
                             <tr > 
                             <td colspan="4" align="right" id="video-select-all" >      
                             Select All <input class="check-each" id="select_all_home" type="checkbox" />
                             <br>
                            </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tbody class="check_feature_<?php echo $video_home->id; ?>">
                                <tr style="border-bottom: 1px solid #343434;"  >
                                  
                                    <td align="left" >
                                         <?php
                                        $video = Model_Videoke::find($video_home->video_id);
                                             ?>        
                                        <span id="number">
                                        <?php echo $idx.". "?>
                                        </span>
                                    </td>
                                    <td id="video-title">
                                        <?php if(isset($video->title)){ if (strlen($video->title)>30){ ?>
                                           <?php echo substr($video->title,0,30).'...' ;?>
                                        
                                        <?php }else echo $video->title; }?>
                                    </td>
                                    <td align="right" >                            
                                        <span id="select">Select</span>
                                    </td>
                                    <td> 
                                        <input  id="check-feature" data-value="<?= $video_home->id ?>" type="checkbox" />                            
                                    </td>
                                  
                                </tr>
                            </tbody> 
                            <?php  $idx++; } endif; ?>
                        </table>
                        
                        <button class="delete-features" id="black-btn" url="delete_featured_videos" >DELETE </button>
                        
                        
                    </div>

             </div>
            </div>

            <div id="featured-videos-popup1" onclick="check1(event)">
                <div id="manage-featured-videos">

                    <a  id="close1"><?php echo Asset::img("close1.png"); ?></a>

                    <div id="pop-fv-header">
                      <div id="page-title" >
                        MODELS PAGE
                       </div>
                
                    </div>
                    <div id="feature-content">
                        
                        <?php if (count($featured_videos_models) > 0) : ?>
                            <?php $idx = 1; ?>
                            <table style="margin: 0 auto;"  height="auto" width="auto">
                            <?php foreach ($featured_videos_models as $video_models) {
                                if($idx==1){?>
                             <tr height="45"> 
                             <td colspan="2" align="right" id="video-select-all">      
                             Select All <input class="check-each" id="select_all_models" type="checkbox" />
                             <br>
                            </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tbody class="check_feature_<?php echo $video_models->id; ?>">
                                <tr style="border-bottom: 1px solid #343434;" height="30">                                   
                                    <td align="left" >
                                         <?php
                                        $video = Model_Videoke::find($video_models->video_id);
                                             ?>        
                                        <span id="number">
                                        <?php echo $idx.". "?>
                                        </span>
                                    </td>
                                    <td id="video-title">
                                        <?php if(isset($video->title)){ if(strlen($video->title)>30){ ?>
                                           <?php echo substr($video->title,0,30).'...' ;?>
                                        <?php }else echo $video->title; }?>
                                    </td>
                                    <td align="right" >                            
                                        <span id="select">Select</span>
                                    </td>
                                    <td> 
                                        <input  id="check-feature" data-value="<?= $video_models->id ?>" type="checkbox" />                            
                                    </td>
                                  
                                </tr>
                            </tbody> 
                            <?php  $idx++; } endif; ?>
                        </table>
                        
                       <button class="delete-features" id="black-btn" url="admin/delete_featured_videos" >DELETE </button>
                        
                        
                    </div>

             </div>
            </div>


            <div id="featured-videos-popup2" onclick="check2(event)">
                <div id="manage-featured-videos">

                    <a  id="close2"><?php echo Asset::img("close1.png"); ?></a>

                    <div id="pop-fv-header">
                      <div id="page-title" >
                        NEWS PAGE
                       </div>
                
                    </div>
                    <div id="feature-content">
                        
                        <?php if (count($featured_videos_news) > 0) : ?>
                            <?php $idx = 1; ?>
                            <table style="margin: 0 auto;"  height="auto" width="auto" >
                            <?php foreach ($featured_videos_news as $video_news) {
                                if($idx==1){?>
                             <tr height="45"> 
                             <td colspan="2" align="right" id="video-select-all">      
                             Select All <input class="check-each" id="select_all_news" type="checkbox" />
                             <br>
                            </td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tbody class="check_feature_<?php echo $video_news->id; ?>">
                                <tr style="border-bottom: 1px solid #343434;" height="30">
                                  
                                  <td align="left" >
                                         <?php
                                        $video = Model_Videoke::find($video_news->video_id);
                                             ?>        
                                        <span id="number">
                                        <?php echo $idx.". "?>
                                        </span>
                                    </td>
                                    <td id="video-title">
                                        <?php if(isset($video->title)){ if (strlen($video->title)>30){ ?>
                                           <?php echo substr($video->title,0,30).'...' ;?>
                                        <?php }else echo $video->title; }?>
                                    </td>
                                    <td align="right" >                            
                                        <span id="select">Select</span>
                                    </td>
                                    <td> 
                                        <input  id="check-feature" data-value="<?= $video_news->id  ?>" type="checkbox" />                            
                                    </td>
                                  
                                </tr>
                            </tbody> 
                            <?php  $idx++; } endif; ?>
                        </table>
                        
                        <button class="delete-features" id="black-btn" url="admin/delete_featured_videos" >DELETE </button>
                        
                        
                    </div>


             </div>
            </div>




                <!--<a class="black-btn" href="<?php //secho Uri::create('admin/admin_new'); ?>">Upload Videos</a>-->

                <!--</form>-->
                <?php if(count($videokes) < $total_videos): ?>
                    <p class="view-more-container">
                        <?php echo Html::anchor("admin/videokes/".$page, "View More"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="clear">&nbsp</div>
</div>