 	<div class="videos-row">
            <?php
            $number_of_videos = 0;
            $displayed_videos=0;
            if ($random_videokes) {
                $number_of_videos = sizeof($random_videokes);
                $displayed_videos=0;
                foreach ($random_videokes as $videoke){
                    echo View::forge("videokes/partials/single_item",array("videoke"=>$videoke));

                    $displayed_videos++;
                    if($displayed_videos>$number_of_videos || $displayed_videos>=9)
                        break;
                }
            }
            ?>
            <div class="clearfix"></div>
        </div>


       