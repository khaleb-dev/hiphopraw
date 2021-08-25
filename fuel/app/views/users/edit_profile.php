<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user, "friends" => $friends, "followers" => $followers)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $count)); ?>
        <?php } ?>
    </div>

    <div class="videokes-center content-box clearfix">
        <div class="vids">
            <div class="title">
              
       <p class="pull-left middle-title-setting">BUILD YOUR PROFILE
                </p>

                <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

               

                <div class="clearfix">
				</div>
                <hr class="divider"/>
				
				 <div class="profile_pic">
				
				<form>
				<div id="image">
				 <label style="padding-left:26px;">Profile Picture: </label><a style="width:90px"><input type="button" value="Choose File" /></a>
				<a style="margin-top:5px; width:100px;">No File Selected</a>
			</div>
			<div class="profile_pic1">
			 <label style="padding-left:8px;">First Name: </label> <input type="text" name="fname" /><br>
			 <label style="padding-left:8px;">Last Name: </label> <input type="text" name="lname" /><br>
			 <label style="padding-left:50px;">City: </label> <input type="text" name="city" /><br>
			  <label style="padding-left:40px;">State: </label><div id="select1"><select name="state"  >
                                  <option>States </option>
                                      
                                     </select>  </div> <br>
				  <label style="padding-left:10px;">About Me: </label>	  <textarea rows="4" cols="40" name="aboutme"></textarea>
					
				</div>
				</div>
			     
            </div>


			<div class="clearfix"></div>
		</div>


	</div>

	<div class="clearfix separator"></div>


</div>
