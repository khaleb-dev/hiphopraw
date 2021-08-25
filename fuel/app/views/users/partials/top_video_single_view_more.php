 <div class="video-gallery">
        <?php
        /*echo "<pre>";
        echo print_r($top_100_videos);
        echo "</pre>";*/
        $i=$counter-9;
        foreach ($top_100_videos as $video) {
            $top_video_view = View::forge("videokes/partials/single_item");
            $top_video_view->videoke = $video;
            echo "<div class='video-with-descrip'>";
            echo '<div class="top_vid_rank">';
            echo '#<span class="red">' . $i++ . '</span>';
            echo " </div>";

            echo $top_video_view;
            echo "</div >";
        }
        ?>

    </div>