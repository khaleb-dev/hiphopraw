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
	  			 <span class="red-line">Term of Service</span>
	  		</div>
	   		<div id="privacy-idea">
	   			<br>
	   
	  			<p> Hip Hope Raw hereby grants you permission to access & use its Sevice as set forth in these Terms of Service, Provide that :</p>
 	 			<ul style="padding-left:40px;">
				<li>* &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you agree not to access Content through any technology or means other than the video playback pages of the Service it self</li><br> 
	     		<li>* &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You agree not to alter or modify any part of the Service</li>
		  		</ul>
       			</p>
     			<p>HIp Hop Raw reserves the right to Discontinue any aspects of the Service at any time.
	 			</p>
	 			<p>The content of Hip Hop Raw and the trade markets, Service, marks, & logos on the service are owned by or licensed to HIp Hop raw, subject to <br>copyright and other intellectual property rights under the law.   	 </p>
      			<p>You agree not to circumvent, disable, or otherwise interfere with security-related features of the service<br>
        		As a HIP HOP Raw account holder you may submit Content to the service. You understand that HIP HOP Raw does not guarantee any confidenti<br>
				ality with respect to the Content you submit.
	  			</p>
      			<br>
        		<p>You shell be solely responsible for you own content, and the consequences of submitting and publishing your Content on the service   </p>
				<br><p>You retain all of your ownership rights in your Content. However, by submitting Content to Hip HOP Raw, you hereby grant Hip Hop Raw a world wide  </p>			
	 		</div>
	  	 </div>	  
	  </div>

    <div id="home-upload">
        <p><span>ARE YOU RAW?</span> UPLOAD YOUR VIDEO TO HHR AND FIND OUT!!
            <span><button  type="button" id = "upload-button"><strong>Submit Your Video</strong></button></span></p>
    </div>

 </div>
