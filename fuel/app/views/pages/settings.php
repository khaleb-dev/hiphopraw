<div id="center" class="clearfix">

	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends"=>$friends, "followers"=>$followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>


	</div>
	
							
	 <div id="content" class="with-sidebar-left profile">
		<div id="settings" class="content-box">
			<div class="white-back">
		  <div class="title" style="padding-top:10px;">
	 <p class="pull-left middle-title-setting">ACCOUNT SETTINGS
                </p>
				 <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>
				<br>
				<p> <hr style="height:1px;border:none;background-color:#000; margin-top:5px;width:772px;"/></p>
				
					</div>
				
            <?php echo Form::open(array("action" => "users/update", "enctype" => "multipart/form-data", "id"=>"settings-form")); ?>
                <?= Form::hidden('redirect', "users/show/$current_user->id")?>


                <div id="profile-pic" class="section clearfix">
                    <h3 style="border-button:3px;margin-left:5px;">Profile Picture</h3>
                    <hr style="height:1px;border:none;background-color:rgb(52,52,52); margin-top:2px;"/>
                    <?php echo Html::img(Model_User::get_picture($current_user, 'profile'), array("id" => "profile-pic", "width" => "63")); ?>
                    <div id="profile-pic-upload">
                        <?php echo Form::file('profile_picture'); ?>
                        <!-- <p>or <strong>take a photo</strong> from your <strong>webcam</strong></p>-->
                    </div>
                </div>

                <h3 style="color:red; border-button:1px;margin-left:5px;">User Information</h3>

                <div id="user-info1" class="section">
                    <hr style="height:1px;border:none;background-color:rgb(52,52,52); margin-top:2px;margin-left:1%;margin-right:1%;"/>

                    <p style="padding-top:25px;">
                        <?= Form::label('Email &nbsp;', 'email'); ?>
                        <?php echo Form::input('email', $current_user->email, array("class" => "text-field long", "id" => "email")); ?>
                        <b style="color:red;">&lowast;</b><br>
                        <span class="error red invalid-email">Please enter a valid email address</span>
                        <span class="error red too-long">Please enter less than 255 characters.</span>
                        <?= Form::label('Stage Name &nbsp;', 'Stage Name'); ?>
                        <?php echo Form::input('stage_name', $current_user->stage_name, array("class" => "text-field long")); ?>

                    </p>
                </div>
                <div id="password-settings" class="section">
                    <h3 style="margin-left:5px;">Password Settings</h3>
                    <hr style="height:1px;border:none;background-color:rgb(52,52,52); margin-top:2px;margin-left:1%;margin-right:1%;"/>
                    <p style="padding-top:25px;">
                        <?= Form::label('Password &nbsp;', 'old_password'); ?>
                        <?php if ($current_password_not_correct) { ?>
                            <?php echo Form::password('old_password', '********', array("class" => "text-field long", "autocomplete" => 'off', "id" => "old_password")); ?>
                            <span class="error red incorrect-password" style="display: block;">
                                The current password you entered is not correct.

                            </span>
                        <?php }else{ ?>
                            <?php echo Form::password('old_password', '', array("class" => "text-field long", "autocomplete" => 'off', "id" => "old_password")); ?>
                        <?php }?>
                    </p>

                    <p>
                        <?= Form::label('New Password &nbsp;', 'new_password'); ?>
                        <?php echo Form::password('new_password', '', array("class" => "text-field long", "autocomplete" => 'off', "id" => "new_password")); ?>
                        <b class="required-ast" style="color:red; display: none;">&lowast;</b>
                        <span class="error red empty">Please enter the new password</span>
                        <span class="error red too-long">Please enter less than 255 characters.</span>
                    </p>

                    <p>
                        <?= Form::label('Confirm &nbsp;', 'confirm_password'); ?>
                        <?php echo Form::password('confirm_password', '', array("class" => "text-field long", "id" => "confirm_password")); ?>
                        <b class="required-ast" style="color:red; display: none;">&lowast;</b>
                        <span class="error red mismatch">Passwords do not match.</span>
                    </p>
                </div>
                <div id="location-settings" class="section">
                    <h3 style="margin-left:5px;">Location Settings</h3>
                    <hr style="height:1px;border:none;background-color:rgb(52,52,52);  margin-top:2px;margin-left:1%;margin-right:1%;"/>
                    <p>
                        <?= Form::label('City &nbsp;', 'city'); ?>
                        <?php echo Form::input('city', $current_user->city, array("id" => "city")); ?>
                        <b style="color:red;">&lowast;</b>
                        <span class="error red empty">Please enter the city you live in</span>
                        <span class="error red too-long">Please enter less than 255 characters.</span>
                    </p>
                    <p>
                        <?= Form::label('State &nbsp;', 'state'); ?>

                        <div id="select1">
                            <select name="state">
                                <?php
                                $states = Model_State::getStates();
                                for ($i = 1; $i <= sizeof($states); $i++) {
                                    if ($current_user->state === $states[$i]) {
                                        echo '<option value="' . $states[$i] . '" selected>' . $states[$i] . "</option>";
                                    } else {
                                        echo '<option value="' . $states[$i] . '">' . $states[$i] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <button class="select-red-btn" type="button"></button>
                        </div>
                    </p>
                    <hr style="height:1px;border:none;background-color:rgb(51,51,51); margin-top:15px;"/>
                </div>
                <div id="submit">
                    <p>
                        <?php echo Form::submit('', 'Save Settings', array('class' => 'button rounded-corners')); ?>
                    </p>
                </div>

                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>

</div>
