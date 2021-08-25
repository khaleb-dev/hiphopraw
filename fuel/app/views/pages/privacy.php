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
	   				<span class="red-line">Privacy Policy</span>
	  			</div>
	   			<div id="privacy-idea">
	   				<br>
	  				<p>We here at Hip Hope Raw want to earn your trust by being as transparent as possible about how Hip Hop Raw works .'</p><br>
	  				<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Hip Hope Raw is designed to be a way  for you to connect with friends, share photos & videos with those friends, & win gifts and prizes. you<br> 
	 				 decide how match how much you feel comfortable sharing and control how it's distributed in your privacy setting. you can change your privacy setting at any<br>
        			time	  </p>
     				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Hip Hope Raw is a free service supported primarily by advertising. we will not share your information with advertisers without your consent.
	 				</p>
	 				<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. when you sign up for the Hip Hope Raw, you provide us with your Name, you "Performer" Name, and email address, you are also able to add a <br>
	 				picture of your self to your profile, and of course videos of you and your talent. You can, at any time access your account to add or remove any <br>
	  				information about your self.
	 				</p>
	 				
	  			</div>
	  	  </div>
	  
	  </div>
    <div id="home-upload">
        <p><span>ARE YOU RAW?</span> UPLOAD YOUR VIDEO TO HHR AND FIND OUT!!
            <span><button  type="button" id = "upload-button"><strong>Submit Your Video</strong></button></span></p>
    </div>
    
</div>