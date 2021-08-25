     <div class="videos-video1">
            <p><strong>VIDEO <span>4m</span></strong>
                    <span id="share-plus"><a href="#"> <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a
                            href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
            <a href="<?php echo Uri::create("pages/show") . "/" . $videoke->id; ?>" class = "videos-images1"> <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT)); ?></a>
            <h4><strong><?php echo $videoke->user->username; ?>: <?php echo $videoke->title; ?></strong></h4>

              <p><?php echo $videoke->description; ?></p>

            <p><strong>Previews &nbsp;22.4k &nbsp; &nbsp; Views &nbsp; 125.3k &nbsp; &nbsp;Comments &nbsp;
                    12.3k</strong></p>
    </div>