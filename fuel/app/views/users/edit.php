<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_" . (in_array('build_profile', $route) ? '' : 'alt_') . "control", array("user" => $current_user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>

    <div id="content" class="with-sidebar-left profile">

        <div id="settings" class="content-box">
            <div class="white-back">
                <div class="title" style="padding-top: 10px;">
                    <p class="pull-left middle-title-setting">EDIT PROFILE
                    </p>

                    <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span
                            class="red">Hip Hop</span>
                    </p>
                    <br>

                <p> <hr style="height:1px;border:none;background-color:#000; margin-top:5px;width:772px;"/></p>

                </div>
                <?php echo Form::open(array("action" => "users/update", "enctype" => "multipart/form-data", "id"=>"settings-form")); ?>
                <p>
                    <label>Profile Picture</label>
                    <?php echo Form::file('profile_picture'); ?>
                </p>

                <p>
                    <label for="first_name">First Name</label>
                    <?php echo Form::input('first_name', isset($current_user->first_name)?$current_user->first_name:"", array( "id" => "first_name", "placeholder"=>"Enter your name")); ?>
                    <span class="red" style="display: inline-block">&lowast;</span>
                    <span class="error red empty">Please enter your first name</span>
                    <span class="error red too-long">Please enter less than 255 characters.</span>
                </p>

                <p>
                    <label for="last_name">Last Name</label>
                    <?php echo Form::input('last_name', isset($current_user->last_name)?$current_user->last_name:"", array( "id" => "last_name", "placeholder"=>"Enter your name")); ?>
                    <span class="red" style="display: inline-block">&lowast;</span>
                    <span class="error red empty">Please enter your last name</span>
                    <span class="error red too-long">Please enter less than 255 characters.</span>
                </p>

                <p>
                    <label for="city">City</label>
                    <?php echo Form::input('city', isset($current_user->city)?$current_user->city:"", array( "id" => "city", "placeholder"=>"City")); ?>
                    <span class="red" style="display: inline-block">&lowast;</span>
                    <span class="error red empty">Please enter the city you live in</span>
                    <span class="error red too-long">Please enter less than 255 characters.</span>
                </p>

                <div id="location-settings" class="section">
                    <p>
                        <label for="state">State</label>

                    <div id="select1"><select name="state">
                            <?php
                            $states = Model_State::getStates();
                            for ($i = 1; $i <= sizeof($states); $i++) {
                                if (isset($current_user->state) && $current_user->state === $states[$i]) {
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
                </div>
                <p>
                    <label for="about_you">About Me</label>
                    <?php echo Form::textarea('about_you', isset($current_user->about_you)?$current_user->about_you:""); ?>
                </p>

                <div id="location-settings1" class="section">
                    <p>
                        <label for="state">BirthDay</label>

                    <div id="select2"><select name="birthday_month">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                if (isset($this->current_user->birthday_month) && $this->current_user->birthday_month == $i) {
                                    echo '<option value="' . $i . '>' . '" selected>' . date("F", mktime(0, 0, 0, $i, 10)) . '</option>';
                                } else {
                                    echo '<option value="' . $i . '>' . '">' . date("F", mktime(0, 0, 0, $i, 10)) . '</option>';
                                }
                            }
                            ?>

                        </select>
                        <button class="select-red-btn" type="button"></button>
                    </div>
                    <div id="select3">
                        <select name="birthday_day">
                            <?php
                            for ($i = 1; $i <= 31; $i++) {
                                if (isset($this->current_user->birthday_day) && $this->current_user->birthday_day == $i) {
                                    echo '<option value="' . $i . '>' . '" selected>' . $i . '</option>';
                                } else {
                                    echo '<option value="' . $i . '>' . '">' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <button class="select-red-btn" type="button"></button>
                    </div
                    </p>
                </div>
                <div id="location-settings2" class="section">
                    <p style="float:left;">

                        <label for="state">Gender</label>

                    <div id="select5" style="margin-right:10px;margin-top:20px;"><select name="gender_id">
                            <option
                                value="0" <?php if (isset($this->current_user->gender_id) && $this->current_user->gender_id === "0") echo 'selected'; ?> >
                                Male
                            </option>
                            <option
                                value="1" <?php if (isset($this->current_user->gender_id) && $this->current_user->gender_id === "1") echo 'selected'; ?> >
                                Female
                            </option>

                        </select>
                        <button class="select-red-btn" type="button"></button>
                    </div>
                    </p>

                </div>
                <div id="location-settings3" class="section">
                    <p style="float:left;">
                        <label for="mobile">Mobile #</label>
                        <?php echo Form::input('mobile', isset($this->current_user->mobile)?$this->current_user->mobile:""); ?>
                    </p>
                </div>
                <?php if($current_user->facebook_link != '1'|| empty($user->facebook_link)): ?>
                <div id="location-settings4" class="section">
                    <p style="float:left;">
                        <label for="state">Category</label>

                        <div id="select6" style="margin-top:78px;"><select name="category">
                            <?php
                            for ($i = 1; $i <= sizeof($categories); $i++) {
                                if (isset($this->current_user->category) && ( $this->current_user->category+"" == $i+"") ) {
                                    echo '<option value="' . $i . '" selected >' . $categories[$i] . '</option>';
                                } else {
                                    echo '<option value="' . $i . '" >' . $categories[$i] . '</option>';
                                }
                            }
                            ?>
                            </select>
                            <button class="select-red-btn" type="button"></button>
                        </div>
                    </p>
                </div>
                <?php endif; ?>
                <hr style="height:1px;border:none;background-color:rgb(51,51,51); margin-top:30px;clear:both;"/>
                <div id="location-settings5" class="section">
                    <p>
                         <?php if($current_user->facebook_link != '1'|| empty($user->facebook_link)): ?>
<!--                        <input name="redirect" value="videos/new" type="hidden"/>-->
                        <?php echo Form::submit('redirect', 'Save', array("class" => "button rounded-corners")); ?>
                        <?php echo Form::submit('redirect', 'Upload Your Video', array("class" => "button rounded-corners")); ?>
                        <?php echo Html::anchor(Router::get("invite"), "No thanks, I'll do that later", array("class" => "skip grey-txt")); ?>
                         <?php endif; ?>
                         <?php if($current_user->facebook_link === '1'): ?>
                          <?php echo Form::submit('redirect', 'Save', array("class" => "button rounded-corners")); ?>
                         <?php echo Html::anchor(Router::get("invite"), "Next Invite Your Friends", array("class" => "button rounded-corners")); ?>
                          <?php endif; ?>
                    </p>
                </div>
                <?php echo Form::close(); ?>
            </div>

            <?php if (!in_array('build_profile', $route)): ?>
                <p class="back"
                   style="float:left;"><?php echo Html::anchor("users/home_login/$current_user->id", "&lt;  Back"); ?></p>
            <?php endif; ?>

        </div>
    </div>

</div>
