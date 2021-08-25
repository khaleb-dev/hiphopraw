<!doctype html>
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Artist Landing page</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <?php echo Asset::css('pages/artist_landing.css'); ?>
    <?php echo Asset::css('bootstrap.min.css'); ?>
    <?php //echo Asset::css('users/sign_up.css'); ?>
    <?php //echo Asset::css('tools/datepicker.css'); ?>
    <?php //echo Asset::css('tools/bootstrap-datetimepicker.min.css'); ?>
    <?php //echo Asset::css('font-awesome.min.css'); ?>
    <?php //echo Asset::css('font-awesome-ie7.min.css'); ?>
    <?php //echo Asset::css('flowplayer/minimalist.css'); ?>
    <?php //echo Asset::css('smoothness/jquery-ui-1.10.3.custom.min.css'); ?>
    <?php //echo Asset::css('slimbox2.css'); ?>
    <?php //echo Asset::css('style.css'); ?>
    <?php //echo isset($template_css) ? Asset::css($template_css) : ""; ?>
    <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>
    <?php echo Asset::js('modernizr-2.6.2.min.js'); ?>
    <?php echo Asset::js('jquery-1.11.1.min.js'); ?>
    <?php echo Asset::js('jquery-ui-1.10.3.custom.min.js'); ?>
    <?php echo Asset::js('jquery.form.min.js'); ?>
    <?php echo Asset::js('bootstrap.min.js'); ?>
    <?php echo Asset::js('tools/bootstrap-datepicker.js'); ?>
    <?php echo Asset::js('tools/bootstrap-datetimepicker.min.js'); ?>


    <?php echo Asset::js('users/sign_up.js'); ?>
     <!--    -->
	<?php echo Asset::js('jsmvk.js'); ?>
    <!--    -->
	<?php echo Asset::js('flowplayer/flowplayer.js'); ?>
    <!--    -->
	<?php echo Asset::js('slimbox2.js'); ?>
    <?php echo Asset::js('featured_videos.js'); ?>

    <?php echo isset($template_js) ? Asset::js($template_js) : ""; ?>
    <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>

	<script type="text/javascript">
      window.heap=window.heap||[],heap.load=function(t,e){window.heap.appid=t,window.heap.config=e;
        var a=document.createElement("script");
        a.type="text/javascript",a.async=!0,a.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";
        var n=document.getElementsByTagName("script")[0];
        n.parentNode.insertBefore(a,n);
    for(var o=function(t){return function(){heap.push([t].concat(Array.prototype.slice.call(arguments,0)))}},p=["clearEventProperties","identify","setEventProperties","track","unsetEventProperty"],c=0;
        c<p.length;
        c++)heap[p[c]]=o(p[c])};
      heap.load("777704730");
	</script> 
   
</head>

<body>

<div id="notification-container">
    <div class="detail">
        <h3></h3>

        <p></p>
        <i class="icon-remove-circle"></i>
    </div>
</div>


	<header>
	<div class="container">
	   <div class="header">
	
			<div class="logo" style=" padding-left:12%;"><?php echo Asset::img("artist_landing/logo.png"); ?></div>
			<div class="center-top" style=" padding-right:2%;"><?php echo Asset::img("artist_landing/center-top-logo.jpg", array('width'=>'350', 'height' => '50')); ?></div>
			<div class="win-right" style=" padding-left:7%;"><?php echo Asset::img("artist_landing/win-right.png", array('width'=>'255', 'height' => '50')); ?></div>
		</div>
	</div>
	</header>
	
	<div class="container">
	<div class="row2">
	<div class="container">
	<div class="left-banner">
	<div class="left-top-text">
	<h4>Create Your Profile & Gain Exposure</h4>
		</div>
	 
  <div class="follow-container">
	<div class="bg-rapper" >
	<div class="social-media"><?php echo Asset::img("artist_landing/rapper.jpg", array('width'=>'80', 'height' => '80')); ?></div>
	</div>
	
<div class="follow-button">
 <div class="container" style=" padding-left:2%;">
 
 <div class="artist-name">
 <strong>Kavii Jugg</strong> </div>  

<div class="follow" style=" padding-top:0.5%;"> 
<a href="#" class="btn btn-danger btn-md" style=" padding-right:0%;">FOLLOW</a>
		
		</div>
		</div>
		</div>
</div>
	
	
<div class="transparent-bar" style=" padding-right:40%;">

 <p><h3>Are you an Row Artist?</h3>
  <h3>Discover New Opportunities</h3>
 
</p>
</div>

</div>

<div class="content" style=" padding-left:65%;">

<div class="signup-right">
	<!-- <h3>SIGN UP NOW</h3> -->
	<form class="sign-up-form" style = "display: block !important;" action="<?php echo Uri::create('pages/sign_up_artist'); ?>"  method="post">
		<div class="col-md-12">

		
		<h3><strong>SIGN UP NOW</strong></h3>
		<h5><strong>Complete the fields below to create your profile & start Showcasing your elitenes today!</strong></h5>
		
			 <div class="form-group">
			 
			    <input type="text" class="input-field first_name"  id="first_name" name="first_name"  tabindex="1" placeholder="First Name:">
             	<span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter your first name</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
               <div class="form-group">
                <input type="text" class="input-field last_name" id="last_name" name="last_name"  tabindex="1" placeholder="Last Name:">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter your last name</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
              <div class="form-group">
                <input type="text" class="input-field username" id="username" name="username"  tabindex="1" placeholder="User Name:">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter a username</span>
                <span class="error red duplicate">User Name is already taken</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
               <div class="form-group">
                <input type="text" class="input-field email" id="email" name="email"  tabindex="1" placeholder="Email:" >
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red invalid-email">Please enter a valid email address</span>
                <span class="error red duplicate">Email address is associated with another account</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
            
              </div>
               <div class="form-group">
                <input type="text" class="input-field stage_name" id="stage_name" name="stage_name"  tabindex="1" placeholder="Stage Name:">
             	<span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter a Stage Name</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
               <div class="form-group">
                <input type="text" class="input-field password" id="password" name="password"  tabindex="1" placeholder="Password:">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter a password</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
              <div class="form-group">
                <input type="text" class="input-field confirm_password" id="confirm_password" name="confirm_password"  tabindex="1" placeholder="Confirm:">
              	<span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red mismatch">Passwords do not match.</span>
              </div>

              <div class="form-group">
                <input type="text" class="input-field city" id="city" name="city"  tabindex="1" placeholder="City:">
                <span class="red" style="display: inline-block">&lowast;</span>
                <span class="error red empty">Please enter the city you live in</span>
                <span class="error red too-long">Please enter less than 255 characters.</span>
              </div>
         </div>
              <div class="col-md-6">

              <div class="form-group">
            		<select id="state_list" name="state" class="form-control">
						<?php
                   		 	$states = Model_State::getStates();
                    		for ($i = 1; $i <= sizeof($states); $i++) {
                       			 echo '<option value="' . $states[$i] . '">' . $states[$i] . "</option>";
                   			 }
                    	?>
   				
					</select>

			 </div>
              </div>
                
              

              <div class="form-group">
              	<input   type="submit"  value="GET STARTED"/>
              <!-- <a href="#" class="btn" role="button"><strong><font color="white">GET STARTED</font></strong></a>-->
              
              </div>
              
         </form>
              
                  
	</div>
			</div>
		</div>
		</div>
		</div>
		<div class="container">
		<div class="row3">
		<h4><font color="red">Join</font> the Movement, <font color="red">HipHopRaw</font>.com...The <font color="red">New</font> Place For <font color="red">Hip Hop</font> </h4>
		</div>
		</div>
		<div class="container">
	<div class="row4">
	
		<div class="container" style="padding-left:6%; padding-right:6%;">
			
		<div class="upload-section">
				<div class="row">
				<div class="upload" style="padding-left:20%; padding-top:18%;"><h2><font color="grey">Featured</font><strong> Profile Features:</strong></h2></div>
			   <div class="cloud-row">
					
				<div class="cloud-like" style="padding-left:20%;"><?php echo Asset::img("artist_landing/cloud-like.jpg", array('width'=>'100', 'height' => '70')); ?></div>
			      
			<div class="upload-text" >
			<h3>Upload Free Videos</h3>
			<h5><small>Upload your videos and showcase your beauty around the world.
			Get votes to have a chance to win the monthly video contest.</small></h5>
			</div>
			
					</div>

					</div>
					<div class="row">
					<div class="HR hr "style="padding-left:28%;">
					<hr>
					</div>
					</div>
					<div class="bottom-text" style="padding-left:28%;">
					<h3>Gain Followers, Get Exposure</h3>
					<h5><small>Become friends, gain followers,sed a message or livechat with existing HHR users, Share your videos with users and friends in one simple step & gain exposure</small></h5>
					</div>
		</div>
		<div class="pc-section"  style="padding-left:6%;">
					<div class="image"><?php echo Asset::img("artist_landing/desktop.jpg", array('width'=>'319', 'height' => '400')); ?></div>
	     </div>

	     </div></div>
									<br><br><br></div>
									<div class="container">
<div class="row5">
	<div class="container">
		<div class="row" >
	
					
			<div class="win-container">
				<div class="row">
				<div class="win-upload" style="padding-left:12%; padding-right:42%;">
				<h2><font color="grey">Upload & Win</font></h2>
				<h1>$1,000 in Cash</h1>
				</div>
					<div class="row">
					<div class="video-icons" style="padding-left:18%;">
				<div class="cloud-like"><?php echo Asset::img("artist_landing/video-icon.jpg", array('width'=>'100', 'height' => '70')); ?></div>
			</div>
			<div class="right-text" style="padding-right:26%;">
			
			<h5><small>Always on the go? our feature will be available soon. We we'll notify you when our mobile app releases in around one month.</small></h5>
					
			</div>
			
					</div></div>
					<div class="row">
					<div class="upload-video" style=" padding-top:4%;  padding-left:20%;"> <a href="#" class="col-md-12 btn btn-danger btn-md" style=" padding-right:5%;"><strong>Upload a Video</strong></a>

					</div>
					
					
					</div>			
				</div>
	</div>
								
									<br><br><br>
		</div>
	</div>
		</div>

	<div class="container">
		<div class="row6">
		
		<div class="mobile-section" style="padding-left:12%;">
			<div class="mob-pic" style="padding-left:12%;">
			<?php echo Asset::img("artist_landing/mob.jpg", array('width'=>'319', 'height' => '460')); ?></div>
			
			
		</div>
		
		<div class="connected-section" style="padding-right:12%;">
			<div class="row">
				<div class="row6-text-right" style="padding-left:28%; padding-top:8%;">
					<h1>DON’T <font color="red">MISS</font> OUT</h1>
					<h3><font color="grey">Accessible</font> <strong>Anytime, AnyWhere:</strong></h3>
				</div>
			<div class="row">
				<div class="globe">
					<div class="cloud-like" ><?php echo Asset::img("artist_landing/global.jpg", array('width'=>'90', 'height' => '90')); ?></div>
			    </div>
				<div class="connected" style="padding-right:15%; padding-top:3%;">
					<h4><strong>Stay Connected</strong></h4>
					<h5><small>Don’t miss out on any thing. See how viral your video is going 24/7.</small></h5>
				</div>
			</div>
					<div class="bottom-text" style="padding-left:28%;">
					<h4>Keep Me Posted</h4>
					<h5><small>Always on the go? our feature will be available soon. We we'll notify you when our mobile app releases in around one month.</small></h5>
					</div>
			
					
				<div class='email_notification' style="padding-left:27%; padding-top:2%;">
        		<form class="form-inline">
        			<div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email Address">
              		
             
              		<button type="submit" class="btn btn-default btn-lg"><font color="red">Notify Me</font></button>
            	</div></form>
        		</div>
        
				</div>
		</div>
			
		</div>
	</div>


	
	
	<div class="container">
 	<footer>
	<div class="footer">
	<div class="footer-logo-image" style=" padding-left:14%;"><?php echo Asset::img("artist_landing/footer-logo.jpg", array('width'=>'60', 'height' => '20')); ?></div>
			<div class="footer-text" style=" padding-left:45%;"><font color="white">Copyright 2015 Raw Entertainment Group LLC.</font> <font color="red">All rights reserved HipHipRaw.com</font></div>
			
			</div>
	
	</footer>
	</div>
</body>
</html>