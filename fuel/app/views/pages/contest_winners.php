
<div id ="videos-container">
	<div id = "videos-all-hiphop" >
	  <p> <strong>TOP HIP HOP RAW AND MODEL VIDEO CONTEST WINNERS</strong>  &nbsp; <span><?php echo Asset::img("videos/videos-dropdown.png"); ?></span></p>
	</div>
	    <div id="home-middle-playlist">
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
	<div class="clearfix"></div>

	
	<div class='content'>

	<?php
		
      		$idx= 1;
      	  $iterate = count($videokes_hiphop);

      	  for($i=0; $i<$iterate; $i++){

      	  	  $id1 =$videokes_hiphop[$i];
      	  	  $id2 =$videokes_model[$i];
      	 	  $video1= Model_Videoke::find($id1);
      	 	  $video2= Model_Videoke::find($id2);
      	 	  ?>
      	  	  	<div id = "home-date">
	  			<p><strong><?php echo date("F, Y",$videokes_hiphop_month[$i]);?> Winners</strong></p>
        		<hr/>
				</div>
	
			<div id = "videos-videos-row">
	      	<div class = "videos-row">
		   	<div class="videos-video1">
              <p> <strong>VIDEO <span><?php echo $video1->title ?></span></strong>           
             <span id = "share-plus"><a href="#"> <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
               <div id="the_video"><?php echo View::forge("videokes/partials/single_item",array("videoke"=>$video1)); ?></div>
              
           </div>
           </div>
            <div class = "videos-row">
			<div class="videos-video2">
              <p> <strong>VIDEO <span ><?php echo $video2->title ?></span></strong>
              
              <span id = "share-plus"><a href="#" > <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
              <div id="the_video"> <?php echo View::forge("videokes/partials/single_item",array("videoke"=>$video2)); ?></div>
              
           </div>			
		</div>
        <div class="clearfix"></div>
		</div>
		<?php
      	  } ?>

	<?php
	     foreach($none_completed_contests as $notready){
	     	?>
	     	<div id = "home-date">
	  <p><strong><?php echo date("F, Y",$notready['start_time']);?></strong></p>
        <hr/>
	</div>
	
	<div id = "videos-videos-row">
	      <div class = "videos-row">
		   <div class="videos-video1">
              <p> <strong>VIDEO <span>4m</span></strong>            
             <span id = "share-plus"><a href="#"> <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
              <a href="#" id = "contest-images1"> <?php echo Asset::img("contest_winners/contest-winner.jpg"); ?></a>
               <h4><strong>This contest winner could be you&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Asset::img("contest_winners/time.png"); ?>&nbsp; 5:27</strong></h4>
           </div>
           </div>
            <div class = "videos-row">
			<div class="videos-video2">
              <p> <strong>VIDEO <span>10m</span></strong>
              <span id = "share-plus"><a href="#" > <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
              <a href="#" id = "contest-images2"> <?php echo Asset::img("contest_winners/contest-winner.jpg"); ?></a>
              <h4><strong>This contest winner could be you &nbsp;&nbsp;&nbsp;&nbsp;<?php echo Asset::img("contest_winners/time.png"); ?>&nbsp; 5:27</strong></h4>
           </div>			
	</div>
        <div class="clearfix"></div>
	</div>
<?php
	     }
	?>
	
	<div id = "videos-view-more">
			<p>
			<a href="#"><strong>VIEW MORE CONTEST WINNERS</strong></a>
			</p>
	</div>
</div>
</div>