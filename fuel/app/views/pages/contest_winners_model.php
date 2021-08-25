<div id ="videos-container">
	<div id = "videos-all-hiphop" >
	  <p> <strong>TOP MODEL CONTEST WINNERS</strong>  &nbsp; <span><?php echo Asset::img("videos/videos-dropdown.png"); ?></span></p>
	</div>
	<div id = "home-middle-playlist">
		<div id = "scroller-container">
		  <div id = "home-middle-left-scroller">
			 <a href="#" data-direction="left"><?php echo Asset::img("home/home-middle-left-scroller.png"); ?></a>
		  </div>
		  <div id="visible-banners">
           <div id="banner-items" class="clearfix" data-left="0">
		  <div id = "home-middle-player">
			 <div class="ad-image"><a target="_blank" href = "https://www.youtube.com/watch?v=BdE__NmHcrw"><?php echo Asset::img("home/home-middle-playlist1.png"); ?></a></div>
			 <div class="ad-image"><a target="_blank" href = "http://artistecard.com/samie#!/videos/43028"><?php echo Asset::img("home/home-middle-playlist2.png"); ?></a></div>
			 <div class="ad-image"><a target="_blank" href = "https://www.youtube.com/watch?v=ch8vuNbM988"><?php echo Asset::img("home/home-middle-playlist3.png"); ?></a></div>
		  </div>
		  </div>
          </div>
		  <div id = "home-middle-right-scroller">
			 <a href="#" data-direction="right"><?php echo Asset::img("home/home-middle-right-scroller.png"); ?></a>
		  </div>
		</div>	
	</div>
	<div class="clearfix"></div>

<?php
	foreach ($completed_contests_model as $model_winner){

            $videokes_model[] = Model_Videoke::find($model_winner['winner']);
        }
 ?>
	<div id = "home-date">
	  <p><strong>November 1, 2014</strong></p>
      <hr/>
	</div>
	
	<div id = "videos-videos-row">
	     <div class = "videos-row">
		   <div class="videos-video1">
              <p> <strong>VIDEO <span>4m</span></strong>            
             <span id = "share-plus"><a href="#"> <?php echo Asset::img("home/home-share.png"); ?></a>&nbsp;<a href="#"> <?php echo Asset::img("home/home-plus.png"); ?></a></span></p>
              <a href="#" id = "contest-images1"> <?php echo Asset::img("contest_winners/contest-winner.jpg"); ?></a>
               <h4><strong>This contest winner could be you&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Asset::img("contest_winners/time.png"); ?>&nbsp; 5:27</strong></h4>
               <!--<p>Diddy's 'Big Homie' Video With Snoop And Ross Will
                  Make You Want Famous Friends Too, A$AP Rocky, Meek Mill, 2 Chainz and more!</p>
               <p><strong><?php //echo Asset::img("contest_winners/preview-icon.png"); ?>&nbsp;Previews &nbsp;22.4k &nbsp; &nbsp; <?php //echo Asset::img("contest_winners/views-icon.png"); ?>&nbsp;Views &nbsp; 135.3k &nbsp; &nbsp;Comments &nbsp; 12.3k</strong></p> -->
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
	<div id = "home-date">
	  <p><strong>October, 2014</strong></p>
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
	<div id = "home-date">
	  <p><strong>September, 2014</strong></p>
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
              <h4><strong>This contest winner could be you&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Asset::img("contest_winners/time.png"); ?>&nbsp; 5:27</strong></h4>
           </div>			
	</div>
        <div class="clearfix"></div>
  </div>
	<div id = "videos-view-more">
			<p>
			<a href="#"><strong>VIEW MORE CONTEST WINNERS</strong></a>
			</p>
	</div>
</div>