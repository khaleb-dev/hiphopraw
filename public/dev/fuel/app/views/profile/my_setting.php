<script type="text/javascript"> 
function confirmDelete() { 
 return confirm("Are you sure you want to delete?");   
} 
</script> 
 
<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array('class' => 'white')); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>
</div>

<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/setting_nav"); ?>
    </aside>
    <div id="middle">

        
        <div class="header-section">
            <p class="header-text">My Account</p>
        </div>

        <div class="form-wrapper">
        
           <form class="form" method="post">
              <div class="inner-wrapper">
                <div class="field">
                    <p class="label">Username</p>
                    <input type="text" name="username" value="" placeholder="Your username..."/>
                </div>
                <div class="field">
                    <p class="label">Email Address</p>
                     <input type="text" name="email" value="" placeholder="youremail@domain.com"/> 
                </div>               
                <div class="field">
                    <p class="label">Mobile Phone Number</p>
                    <input type="text" name="mobile" value="" placeholder="(555) 555 - 5555" />     
                </div>       
                <div class="field">
                    <p class="label">Gender</p>
                    <select name="gender">
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                    </select>    
                </div>     
                <div class="field">
                    <p class="label">Password</p>
                    <input class="pull-left" type="password" name="pass" value="" placeholder="*******"/>   
                    <p class="pull-left link"><a href="#">Change Password</a></p>  
                    <div class="clearfix"></div>
                </div>   
                <div class="field">
                    <p class="label">Confirm Password</p>
                    <input type="password" name="pass2" value="" placeholder="" />   
                </div>   
                <div class="field">
                    <span class="label">Delete My Account</span>
                    <input type="checkbox" name="acc_del" value="" />   
                </div>
                <div class="field">
                    <span class="label">Make my profile visible to my friends only</span>
                    <input type="checkbox" name="acc_del" value="" />   
                </div> 

                </div>

                <div class="submit-btn">
                        <div class="btn-wrap gold-bg">
                        <input type="submit" name="submit" value="SAVE" />
                        </div>
                </div>

            </form>
        </div>

        <div class="border-icon1"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div> 
        <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div> 

    </div> <!-- end of middle -->
</div>
