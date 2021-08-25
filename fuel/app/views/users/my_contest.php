<div id="center" style="width:1100px;" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "followers" => $followers, "friends_count" => $friends_count, "followers_count" => $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>


    <div class="my-contest-gallery videokes-center contet-box clearfix">

            <div id="submit-video" class="before-selection clearfix">
                <a class="pull-left">Submit a video to <span class="red">current contest</span> </a>
               <!-- <a class="button1 pull-right">Join Contest</a>-->
                <p class="pull-right">August 13, 2014
                     </p>
            </div>
            <div id="submit-video" class="after-selection-model">
                <a>Submit a video to <span class="red">Model Contest</span> </a>
               <!-- <a class="button1 pull-right">Join Contest</a>-->
               <div class="pull-right">
               <input class="check-all-model"  type="checkbox" /><a class="check-all">Select All </a>
               
               <a class="red-btn" href="<?php echo Uri::create('videos/new'); ?>">Add Video</a>
               </div>
            </div>

            <div id="submit-video" class="after-selection-hiphop">
                <a>Submit a video to <span class="red">Hiphop Contest</span> </a>
               <!-- <a class="button1 pull-right">Join Contest</a>-->
               <div class="pull-right">
               <input class="check-all-hiphop"  type="checkbox" /><a class="check-all">Select All </a>
               
               <a class="red-btn" href="<?php echo Uri::create('videos/new'); ?>">Add Video</a>
               </div>
            </div>
         <div id="contest-time">
           <?php if(isset($active_time)){
            ?>
            <p style="text-align: center;" ><b>CONTEST VIDEO SUBMISSION TIME IS :
                <?php $s_time = $contest['start_time'];
                   echo date("d,m, Y", $s_time);
                 ?> to 
                <?php $e_time = $contest['start_time']+604800;
                    echo date("d,m,Y", $e_time);
                ?>
              </b>
            </p>

            <?php

             }else{

            ?>

               <p style="text-align: center;" >  <b> THERE IS NO ACTIVE CONTEST CURRENTLY AVAILABLE </b> </p>
            <?php
            } ?>
         </div>
            <div id ="videos-container">
            <div class="inner-wrapper">
            <div class="vid-con pull-left">
            <?php echo Asset::img("contest/hpr-vids.png"); ?>
            <a class="white-btn" id="vid-list" href="#">Enter</a>
            </div>
            <div class="model-con pull-left">
            <?php echo Asset::img("contest/hhr-models.png"); ?>
            <a class="white-btn" id="model-list"  href="#">Enter</a>
            </div>
            </div>
            </div>
        


       

            <div id="hiphop-list">
                    
                    <?php 
                $curtime = time();
                    // $curtime =  1423177211;

              
            
            if($curtime < ($contest['start_time']+604800)){

                          

                if (isset($hiphopv)) {

                    if (sizeof($hiphopv) > 0) {
                        

                        foreach ($hiphopv as $videoke) {
                           
                        ?>
                        <div class="item" >
                        <div >
                        <?php
                            echo Html::anchor("videos/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME))); 
                        ?>
                        <h3 class="model-name"><?php echo Html::anchor("videos/show/" . $videoke->id, $videoke->title); ?></h3>                     
                        </div>
                        <div >
                            <input class="check-each-hiphop"   name="check-for-contest" data-video-id="<?php echo $videoke->id; ?>" data-contest-id="<?php echo $contest['id']; ?>" type="checkbox" /><b> Enter Video in Contest </b>
                         </div>  
                        </div> 
                        <?php
                      
                        }
                        ?>
                        <div class="clearfix"> </div>                        
                        <button class = "button rounded-corners" id="hiphop-submit" url="<?php echo Uri::create('users/contest_join') ?>"> SUBMIT VIDEO ENTRIES </button>
                        <button id="back-hiphop"> Back </button>
                        <?php
                       
                        
                    } else {
                        echo "No Videos uploaded yet";
                    }
                } else {
                    echo "No Videos uploaded";
                }

           } 
           else{

            if(isset($active_time)){
                ?>

                   <p style="color: red; text-align: center;" ><b>The time of video submission for this contest has passed</b></p> 
              <?php
            }else{
                ?>

                  <p style="color: red; text-align: center;" ><b>There is no active contest to submit video to</b></p>
            <?php 
            } 

               }

                ?>
            
                
                
                
              

            </div>

            <div id="model-vid-list">
                     <?php

                     $curtime = time();
                // $curtime =  1423177211;

              
            
            if($curtime < ($contest1['start_time']+604800)){
                if (isset($modelv)) {
                    
                    if (sizeof($modelv) > 0) {

                        
                        foreach ($modelv as $videoke) {
                        ?>
                        <div class="item" >
                        <div >
                        <?php
                            echo Html::anchor("videos/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME))); 
                        ?>
                        <h3><?php echo Html::anchor("videos/show/" . $videoke->id, $videoke->title); ?></h3>                     
                        </div>
                        <div >
                            <input class="check-each-model"  data-video-id="<?php echo $videoke->id; ?>" data-contest-id="<?php echo $contest1['id']; ?>" type="checkbox" /><b> Enter Video in Contest </b>
                         </div>  
                        </div> 


                        <?php

                        }
                        ?>
                        <div class="clearfix"> </div>                        
                        <button class = "button rounded-corners" id="model-submit" url="<?php echo Uri::create('users/contest_join') ?>"> SUBMIT VIDEO ENTRIES </button>
                        
                        <button id="back-model"> Back </button>
                        <?php
                        


                    } else {
                        echo "No Videos uploaded yet";

                    }
                } else {
                    echo "No Videos uploaded";
                }

          }else{
            if(isset($active_time)){
                ?>

                   <p style="color: red; text-align: center;" ><b>The time of video submission for this contest has passed</b></p> 
              <?php
            }else{
                ?>

                  <p style="color: red; text-align: center;" ><b>There is no active contest to submit video to</b></p>
            <?php 
            } 
                
            }
             ?>
            </div>

            
       <div id="active-contests">
        <div class="clearfix"></div>
            <div id="submit-video"><a>my contest </a>
            </div>
        <?php foreach ($my_active_contests as $contest): ?>
           


            <div class="clearfix"></div>

            <div id="contest-details">
                <?php
            if ($contest->videokes) {
               
                
                ?>
            
                <table style="border:0;width:100%" class="my-contest-table">
                    <tr class="ful-details grey-txt" style="height: 35px;" >
                        <th>CONTEST TYPE</th>
                        <th>VIDEO TITLE</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        
                    </tr>
                    <?php
                        foreach ($contest->videokes as $videoke) { 

                          $rnd =1;
                          $result = DB::query("select status from contests_videos where video_id = $videoke->id AND round_id = $rnd")->as_assoc()->execute();                  

                          foreach ($result as $key => $value){
                              $status = $value['status'];
                          }
                    ?>
                    <tr style=" text-align: center; height: 25px;"> 
                    
                         
                                                
                       <td class="type"><?Php if($contest->category->id ==1){
                              echo Asset::img("contest/dot_white.png",array("width" => "7", "height" => "7"));   
                            }else{
                                echo Asset::img("contest/dot_red.png",array("width" => "7", "height" => "7"));
                                } ?> 
                       <b><?php echo $contest->category->name; ?></b></td>
                        <td style="color: red; text-decoration: underline;" class="title"><?php echo $videoke->title ?></td>
                        <td class="date"><b><?php echo date('m-d-Y', $contest->end_time); ?></b></td>
                        <td class="status"  style="color: green;"><b><?php echo $status; ?></b></td>
                    </tr>
                    <?php } ?>

                </table>
                <?php } ?>
            </div>
            
            
        
          <?php endforeach; ?>
    </div>
</div>

<div class="right-image">
    <div id="image1-right">
        <a>SUGGESTED ADVERTISEMENT</a>
    </div>
    <div id="image1-right1"><a><?php echo Asset::img('advert-1.jpg'); ?></a></div>
    <div id="image2-right1"><a><?php echo Asset::img('banckmarck.png'); ?></a></div>
    <div id="image3-right1"><a><?php echo Asset::img('advert-3.jpg'); ?></a></div>
</div>

</div>

