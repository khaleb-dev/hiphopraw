<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("admin/partials/admin_side_nav", array("current_user" => $current_user, "menu" => "Videokes")); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div class="alert alert-success rounded-corners" id="upload-complete-confirmation">
        <h4>Success</h4>
        <p>Video successfully uploaded!</p>
    </div>
    <div id="upload-video-container">
        <div id="upload-ur-video-header">
            <span style="float: left;" class="uppercase">Upload Your Video</span>
            <span>HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span> </span>
        </div>

        <form id="upload-video-form" action="<?php echo Uri::create('videos/ajax_create');?>" enctype="multipart/form-data" method="post">
            <p>
                <label for="form_video">Video File:</label><input name="video" type="file" id="video"/>
                <span class="error with-margin empty">Please choose a video file to upload</span>
                <span class="error with-margin file-too-large">Maximum Upload Size is <em>250MB</em></span>
                <span class="error with-margin unsupported-format">Allowed video formats are <em>webm,ogg, mov, wmv, flv
                        and mp4</em></span>

            <div id="progress-bar-container" class="with-margin">
                <div id="progress-bar" ></div>
            </div>

            <p><span id="percent" class="with-margin"></span></p>
            </p>
            <p>
                <label for="title">Title:</label>
                <input name="title" type="text" id="title"/>
                <span class="error with-margin empty">Please enter a title for the video</span>
            </p>

            <p>
                <label for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
                <span class="error with-margin empty">Please enter a description for the video</span>
            </p>

            <p>
                <label for="category_id">Category:</label>
                <?php echo Form::select('category_id',$categories[1] ,$categories); ?>
            </p>

            <p>
                <label for="key_words">Key Words:</label>
                <input id="key_words" name="key_words"/>
                <span class="error with-margin empty">Please enter keywords for the video</span>
            </p>

            <p>
                <input id="submit" type="submit" value="Upload" class="button rounded-corners with-margin">
            </p>
        </form>
    </div>

</div>

</div>
