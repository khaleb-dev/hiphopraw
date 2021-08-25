<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_" . (in_array('upload_videoke', $route) ? '' : 'alt_') . "control", array("user" => $current_user,"friends" => $friends,"followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
    </div>

    <div id="content" class="with-sidebar-left profile">
      <div id="settings" class="content-box">
        <div class="white-back">
        <!--
          <div class="alert alert-success rounded-corners" id="upload-complete-confirmation">
              <h4>Success</h4>
              <p>Video successfully uploaded!</p>
          </div>
          -->
          <div id="upload-video-container" class ="youtube">
              <div id="upload-ur-video-header" class="title" style="padding-top:10px;">
                <p class="pull-left middle-title-setting">UPLOAD A YOUTUBE VIDEO</p>
                <p class="pull-right middle-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span></p>
                <br>
                <hr style="height:1px;border:none;background-color:#000; margin-top:5px;width:772px;clear:both;"/>
              </div>              

              <?php if($user_id == 5){?>
                <form id="youtube-video-form" class="settings-form" action="<?php echo Uri::create('videos/save_youtube_video');?>" enctype="multipart/form-data" method="post" >
                     <p class="red"><b>Embed a Youtube Video Here:</b></p>
                     <div id="progress-bar-yb-container" class="with-margin">
                          <div id="progress-bar-yb" ></div>
                     </div>
                         <p><span id="percent" class="with-margin"></span></p>
                         <p><span style="color:red;  font-weight:bold; " id="wait" class="with-margin"></span></p>
                      <p>
                      <label for="title">Title</label>
                      <input name="title" type="text" id="title"/>
                       <span class="error with-margin empty">Please enter a title for the video</span>
                      </p>
                      <p>
                      <label for="description">Description</label>
                      <textarea name="description" id="description"></textarea>
                       <span class="error with-margin empty">Please enter a description for the video</span>
                      </p>
                      <p>
                          <label for="key_words">Key Words</label>
                          <input id="key_words" name="key_words" type="text" />
                           <span class="error with-margin empty">Please enter keywords for the video</span>
                      </p>   
                      <p>
                      <label for="youtube-video"> Youtube embed link</label>
                        <?php echo \Fuel\Core\Form::input('youtube_video',null, array('size'=>'120'))?>
                         <span class="error with-margin empty">Please enter a url for this video</span>
                      </p>
                      <p class="upload-btn" style="margin-top: 20px;">
                          <input id="submit" type="submit" value="Upload Your Video" class="button rounded-corners with-margin">
                      </p>
                </form>

                <?php } ?>

          </div>
          <div class="space"></div>
          <div class="title" style="padding-top:10px;">
            <p class="pull-left middle-title-setting">ADD NEW VIDEO</p>
            <p class="pull-right middle-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span></p>
            <br>
            <p> <hr style="height:1px;border:none;background-color:#000; margin-top:5px;clear:both;width:772px;"/></p>
          </div>
          <form id="upload-video-form" class="settings-form" action="<?php echo Uri::create('videos/ajax_create');?>" enctype="multipart/form-data" method="post">
            
              <p class="video-size">
                  <label for="form_video">Video File</label><input name="video" type="file" id="video" style="font-style:italic;"/>
                  <span class="error with-margin empty">Please choose a video file to upload</span>
                  <span class="with-margin ">Maximum Upload Size is <em><span class="red">750MB,</em></span> allowed video formats are <span class="red"> <em>webm</span>,<span class="red">ogg</span>, <span class="red">mov</span>, <span class="red">wmv</span>, <span class="red">flv</span>
                          and <span class="red">mp4</span></em></span>
                  <div id="progress-bar-container" class="with-margin">
                      <div id="progress-bar" ></div>
                  </div>
                  <p><span id="percent" class="with-margin"></span></p>
                  <p><span style="color:red;  font-weight:bold; " id="wait" class="with-margin"></span></p>
              </p>  
              <p>
                  <label for="title">Title</label>
                  <input name="title" type="text" id="title"/>
                  <span class="error with-margin empty">Please enter a title for the video</span>
              </p>

              <p>
                  <label for="description">Description</label>
                  <textarea name="description" id="description"></textarea>
                  <span class="error with-margin empty">Please enter a description for the video</span>
              </p>              
              <div id="location-settings4" class="section">
                    <p style="float:left;">
                        <label for="state">Category</label>

                        <div id="select6">
                            <?php
                              if($user_id != 5){ 
                               echo Form::select('category_id',$categories[1] ,$categories); 
                              }
                              else{
                                echo Form::select('category_id',$ncategory[3] ,$ncategory);
                              }
                              ?>
                            <button class="select-red-btn" type="button"></button>
                        </div>
                    </p>
                </div>
                <p>
                    <label for="key_words">Key Words:</label>
                    <input id="key_words" name="key_words" type="text" />
                    <span class="error with-margin empty">Please enter keywords for the video</span>
                </p>
                <div class="video-thumbnail">
                  <p class="grey-txt">VIDEO THUMBNAIL</p>
                </div>
              <p class="upload-btn" style="margin-top: 20px;">
                  <input id="submit" type="submit" value="Upload Your Video" class="button rounded-corners with-margin">
              </p>
          </form>

                  <!--<form id="select-thumbnail-form" action="<?php //echo Uri::create('videos/manage_thumbnails');?>" enctype="multipart/form-data" method="post"> -->
                  <div id="select-thumbnail" url="<?php echo Uri::create('videos/manage_thumbnails/');?>" >
                      <div id="upload-ur-video-header">
                              <span style="float: left;" class="uppercase"> Video Thumbnails</span>
                              <br>
                      </div> 
                      <div id="thumb-choose">
                       Please Choose which thumbnail you would like to select for your video upload! 
                        </div>
                          
                          <div id= "thumbnails">
                         
                            <div id= "thumb1"  class="thumbs" >
                                <div  id="thumb1_check" class="checkbox-inner">
                                </div>
                                              
                            </div>
                            <div id= "thumb2"  class="thumbs" >
                                <div   id="thumb2_check" class="checkbox-inner">
                                </div>          
                            </div>
                            <div id= "thumb3"  class="thumbs" >
                                  <div  id="thumb3_check" class="checkbox-inner">
                                </div>            
                            </div>
                            <div id= "thumb4"  class="thumbs"  >
                                   <div  id="thumb4_check" class="checkbox-inner">
                                </div>           
                            </div>
                            
                          </div>
                          <button id="select-thumb" type="submit"  class="button rounded-corners with-margin">Upload Your Video </button>
                          
                   </div>

                  <!--    <p>
                          <input id="submit" type="submit" value="Upload Your Video" class="button rounded-corners with-margin">
                      </p>
                  </form> -->

                     
                          <div id="selected-thumb" url="<?php echo Uri::create('uploads/');?>">
                                  <div id='thumb-image' class="thumb-set">
                                  </div>
                                  <div id="thumb-info" class="thumb-set"  >
                                  </div>

                          </div>
          </div>
        </div>
      </div>
    </div>
</div>