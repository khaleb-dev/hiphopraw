<div id="home-container">
 	<div class="clearfix"></div>


<div id = "home-middle-playlist">
	<div id = "scroller-container">
	  <div id = "home-middle-left-scroller">
	     <a href="#" data-direction="left"><?php echo Asset::img("home/home-middle-left-scroller.png"); ?></a>
	  </div>
	  <div id="visible-banners">
      <div id="banner-items" class="clearfix" data-left="0">
	  <div id = "home-middle-player">
         <?php if($current_user) :?>          
         <div class="ad-image"><?php echo Html::anchor("users/show/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>             
          <?php else :?>
          <div class="ad-image"><?php echo Html::anchor("pages/show_profile/" . 98, Asset::img("home/home-middle-playlist1.png")); ?> </div>              
          <?php endif ;?> 
          <div class="ad-image"> <a href = "#"><?php echo Asset::img('sammie2.jpg'); ?> </a></div>
	  </div>
	  </div>
      </div>
	  <div id = "home-middle-right-scroller">
	     <a href="#" data-direction="right"><?php echo Asset::img("home/home-middle-right-scroller.png"); ?></a>
	  </div>
	  </div>
	</div>


    <div id="home-upload-wrap">
	  <div class="center-main">
	  <div id="white-privacy">
	  <div id="lines" >
	   <span class="red-line"> Sponsors </span>
	  </div>
	   <div id="privacy-idea">
	   <br>
	  <p>If you would like to sponser a contest on HipHopRaw.com </p><br>
			 <p>benefits <br> 
	 			 <p>&nbsp; &nbsp; &nbsp;  1.Partinership with the new, coolest website in Social Networking
	 		</p>
	 		 <p>&nbsp; &nbsp; &nbsp;   2.Get your brand seen by the very some people that buy your products and/or services. No more "blind advertising" where you don't know if<br>
	 		 the people that are watching you ads would even use or care about the product.
	 		</p>
	 		 <p>&nbsp; &nbsp; &nbsp;  3. If you sponser a contest, your Ad will not be intrusive or "bother" any bady. people will watch your Ad because they know you've put your <br>
   			energy behind them by sponsering a contest	  
	 		</p>
	 		<p> &nbsp; &nbsp; &nbsp;  4.Give back and show appreciation to the people that buy & use your products and/or services.
	 		</p>	 		
	 		</p>
	  		</div>
	  		
	  	  </div>
	  
	  </div>
	  </div>
	  </div>
<br>
    <div id="home-upload">
        <p><span>ARE YOU RAW?</span> UPLOAD YOUR VIDEO TO HHR AND FIND OUT!!
            <span><button  type="button" id = "upload-button"><strong>Submit Your Video</strong></button></span></p>
    </div>
    </div>
</div>
