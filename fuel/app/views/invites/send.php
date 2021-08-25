<div id="center" class="clearfix">
    <div id="sidebar-left">
         <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends"=>$friends, "followers"=>$followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>		
    </div>
    <div id="content" class="with-sidebar-left profile">
      
        <div id="settings" class="content-box">
            <div class="white-back">
    			<div class="title" style="padding-top:10px;">
                   <p class="pull-left middle-title-setting">INVITE YOUR FRIENDS 
                        </p>
    				
                        <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span
                                class="red">Hip Hop</span>
                        </p>
    			</div>
                <?php echo Form::open(array("action" => "invites/send", "class" => "settings-form")); ?>
                <p>
                    <label for="email">Email Addresses:</label>
                    <?php echo Form::input('emails', Validation::instance()->validated('emails')); ?>
                    <span class="with-margin" style="font-size:10px;font-style:italic;">Please separate emails with a <span class="red" style="display: inline;">comma</span>, e.g. john@example.com, mary@site.org</span>
                    <span class="error with-margin"><?php echo Validation::instance()->error('emails'); ?></span>
                </p>
                <p>
                    <label for="email">Message:</label>
                    <?php echo Form::textarea('message', Validation::instance()->validated('message')); ?>
                    <span class="error with-margin"><?php echo Validation::instance()->error('message'); ?></span>
                </p>
              <p class="back"><?php echo Html::anchor(Uri::create('users/edit'), "&laquo;  Back"); ?></p>   
                <hr style="height:1px;border:none;background-color:rgb(52,52,52); margin-top:5px;width:7"/>
                <p class="submit" id="submit">
                    <?php echo Form::submit('', 'Send Invite', array("class" => "button rounded-corners")); ?>
                </p>
                <?php echo Form::close(); ?>
					
            </div>	
        </div>
    </div>
    
</div>
