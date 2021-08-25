
<div class="clearfix divider"></div>
         <form id="upload-video-form" action = "<?php echo Uri::create('videos/update');?>" method = "post">

            <p class = "edit-title">
                <label for="title">Title:</label>
                <input value = "<?php echo $videoke->title;?>" name="title" type="text" id="title"/>
                <span class="error with-margin empty ">Please enter a title for the video</span>
            </p>
            <input id = "id-holder" type = "hidden" name = "videoke_id" value = "<?php echo $videoke->id;?>" url="<?php echo Uri::create('videos/update');?>">
            <p class = "edit-description">
                <label for="description">Description:</label>
                 <?php echo \Fuel\Core\Form::textarea('description',$videoke->description, array('id'=>'description'))?>
                <span class="error with-margin empty">Please enter a description for the video</span>
            </p>
           <?php $categories_video = Model_Category::find($videoke->category_id);?>
            <?php if($videoke->category_id == 1):?>
             <?php $categories_video_other = Model_Category::find(2) ;?>
              <?php else:?>
              <?php $categories_video_other = Model_Category::find(1) ;?>
              <?php endif;?>
            <p class = "edit-category">
                <label for="category_id">Category:</label>                
                <?php echo Form::select('category_id','none' ,array($categories_video->name => $categories_video->name,$categories_video_other->name => $categories_video_other->name),array('id'=>'category-select')); ?>
            </p>

            <p class = "edit-keyword">
                <label for="key_words">Key Words:</label>
                <input value = "<?php echo $videoke->key_words;?>" id="key_words" name="key_words"/>
                <span class="error with-margin empty">Please enter keywords for the video</span>
            </p>

            <p>
                <input id="submit" type="submit" value="Update" class="button rounded-corners with-margin update-button">
            </p>
        </form>