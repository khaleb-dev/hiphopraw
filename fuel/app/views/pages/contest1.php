<div id ="videos-container">
  <div class="contest-winner">
  <div id="row-winer"><a>hip hop contest winners</a><a style="margin-left:10px;"><?php echo Asset::img('dropdown.png'); ?></a></div>
  </div>
  <div class="slide-show">
  
   <div id="left-arrow-contest"><a href="#" data-direction="left"><?php echo Asset::img('left-arrow-contest.png'); ?></a> </div>
   
   <div id="visible-banners-contest">
   <div id="banner-contest-items" class="clearfix" data-left="0">
   <div class="all-image">
   <?php if($current_user) :?>          
   <div class="scrolling-image" id="left-image"><?php echo Html::anchor("users/show/" . 98, Asset::img("left-image-contest.png")); ?> </div>             
   <?php else :?>
    <div class="scrolling-image" id="left-image"><?php echo Html::anchor("pages/show_profile/" . 98, Asset::img("left-image-contest.png")); ?> </div>              
    <?php endif ;?> 
    <div class="scrolling-image"> <a href = "#"><?php echo Asset::img('sammie2.jpg'); ?> </a></div>
   </div>
   </div>
   </div>
   
   <div id="right-arrow-contest"> <a href="#" data-direction="right"><?php echo Asset::img('right-arrow-contest.png'); ?></a> </div>
   
  </div>

  <div class="contest-gallery">
  <div class="date-gallery">
    <div id="date"><a><span class="red">|</span>JANUARY 1, 2015</a></div>
	  <?php for($i=1; $i<7; $i++): ?>
	 <div class="winner-share-gallery">
	 <div class="winner-share"><a id="left">hip hop contest winner</a><a id="right"><?php echo Asset::img('share-icon.png'); ?>share</a></div>
	<div id="gallery"><?php echo Asset::img('hhr-contest-winner.png'); ?></div>
	<div id="ready"><a>Get Ready...This Contest Winner could be you!!!</a></div>
	</div>
	<?php if($i%2==0 && $i!=4 && $i!=6 ): ?>
	<div id="date"><a><span class="red">|</span> FEBRUARY 1, 2015</a></div>
	<?php endif; ?>
	 	<?php if($i!=2 && $i!=6 && $i==4): ?>
		 <div id="date"><a><span class="red">|</span> MARCH 1, 2015</a></div>
		  
	<?php endif; ?>
	<?php endfor; ?>
	<!--<div id="contest-more"><a>view more contest winner &or;</a></div> -->
	</div>
	
  </div>
  

</div>