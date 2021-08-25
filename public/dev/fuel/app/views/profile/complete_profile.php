<?php echo View::forge('partials/inner_header'); ?>
<?php echo View::forge('partials/blue_navigator', array('menu' => 'Complete Profile', 'is_completed' => $profile->is_completed)); ?>

<div class="container_main">
    <div  class="left-side-container_small"> 
        <div> 
            <div class="account-upgrade">
                <div id="upgrade-account-logo"><?php echo Asset::img('profile/account-upgrade-logo.png'); ?></div>
                <h1>UPGRADING YOUR ACCOUNT</h1>
                <div class="separetor-line"></div>
                <h2> Upgrade now to take advantage of benefits
                    such as sending messages without a photo
                    and enhanced profile visibility!
                </h2>
                <div class="upgrade-account-button">
                    <a href="<?php echo BASEURL . '/membership/upgrade' ?>">UPGRADE NOW</a>
                </div></br>
                <h2>Subscriptions include:
                </h2>
                <u>
                    <li> <a href="#">Listed at Top of Search Results</a></li>
                    <li> <a href="#">Premium Member Badge for your Profile</a></li>
                    <li> <a href="#">Appear Highlighted in Search Results</a></li>
                    <li> <a href="#">24 Hour Exclusive Access to new members</a></li>
                    <li> <a href="#">Recommended to new members</a></li>
                </u>
            </div>
        </div>
    </div>
    <div  class="right-side-container_large"> 
        <div class="full-form-title">
            <p> Complete Profile </p>
        </div>
        <div class="full-separator-line"></div>
        <p class ="form-text">
            As a guest member you are required to have at least one public profile photo to complete most actions. Take some time to fill
            out some additional information or <a href="<?php echo BASEURL . '/profile/personal_profile' ?>">skip this step and view your profile.</a>
        </p>
        <div id="profile-form-container">
            <?php if ($success): ?>
                <div id="message" class="success">
                    <p>Profile information updated successfully.</p>
                </div>
            <?php endif; ?>
            <?php if (isset($errors)): ?>
                <div id="message" class="error">
                    <p> The following errors have occurred:</p>
                    <ul class="error-message">
                        <?php foreach ($errors as $key => $value): ?>
                            <li><?php echo $value; ?></li>
                        <?php endforeach; ?>
                    </ul>                        
                </div>
            <?php endif; ?>

            <div id="form-section">
                <div id="basic-information" class="<?php echo $submitted_form == 'interest' || $submitted_form == 'looking-for' ? 'hide-block' : '' ?>">
                    <form method="post" action="#" id="complete-profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="submitted-form" value="profile-detail" />
                        <div id="main-picture-container">
                            <label class="darker-text">Main Profile Pic:</label>
                            <div id="profile-picture-container">
                                <div class="left">
                                    <img class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($profile->gender == 'Female' ? 'signup-woman.png' : 'signup-man.png') ?>" />
                                </div>
                                <div class="right">
                                    <p class="profile-picture-header darker-text">GET NOTICED!</p>
                                    <p class="profile-picture-content">Upload a photo to create a good profile. Click the button below to upload your profile photo.</p>
                                    <p id="profile-photo-select" class="profile-picture-footer">
                                        <input hidden="true" type="file" name="avatar" size="1"/>
                                        <a id="profile-upload-button" class="upload-button">Select Photo</a>
                                    </p>
                                </div>                        
                            </div>                    
                        </div>
                        <div id ="additional-profile-link" class="active-form profile-form-separator <?php echo $submitted_form == 'profile-detail' ? 'hide-block' : '' ?>">
                            <a>Fill out additional profile details</a>
                        </div>

                        <div id ="upgrade-now-container" class="<?php echo $submitted_form == 'profile-detail' ? 'hide-block' : '' ?>">
                            <p>If you don't want to upload a photo but still want to send a message. Upgrade now and become a Premium Member</p>
                            <div class="upgrade-account-button">
                                <a href="<?php echo BASEURL . '/membership/upgrade' ?>">UPGRADE NOW</a>
                            </div>
                        </div>

                        <div id="basic-information-inner" class="form-field-container <?php echo $submitted_form == 'profile-detail' ? 'active-form' : '' ?>">
                            <div class="inner-form-separator"></div>
                            <p>
                                <label>Looking for:</label>
                                <select name="looking_for" class="small">
                                    <?php foreach ($genders as $gender) : ?>
                                        <?php
                                        $selected = '';
                                        if ($gender == $profile->looking_for)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $gender; ?>" <?php echo $selected; ?>><?php echo $gender; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Preferred ages:</label>
                                <?php $ages = range(18, 100); ?>
                                <select name="preferred_ages_from">
                                    <?php foreach ($ages as $age) : ?>
                                        <?php
                                        $selected = '';
                                        if ($age == $profile->preferred_ages_from)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $age; ?>" <?php echo $selected; ?>><?php echo $age; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                &nbsp; To &nbsp;
                                <select name="preferred_ages_to">
                                    <?php foreach ($ages as $age) : ?>
                                        <?php
                                        $selected = '';
                                        if ($age == $profile->preferred_ages_to)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $age; ?>" <?php echo $selected; ?>><?php echo $age; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Occupation:</label>
                                <select name="occupation" class="long">
                                    <option value="Administrative / Secretarial" <?php if ($profile->occupation == 'Administrative / Secretarial')
                                        echo ' selected="selected"'; ?>>Administrative / Secretarial</option>
                                    <option value="Artistic / Creative / Performance" <?php if ($profile->occupation == 'Artistic / Creative / Performance')
                                                echo ' selected="selected"'; ?>>Artistic / Creative / Performance</option>
                                    <option value="Executive / Management" <?php if ($profile->occupation == 'Executive / Management')
                                                echo ' selected="selected"'; ?>>Executive / Management</option>
                                    <option value="Financial services" <?php if ($profile->occupation == 'Financial services')
                                                echo ' selected="selected"'; ?>>Financial services</option>
                                    <option value="Labor / Construction" <?php if ($profile->occupation == 'Labor / Construction')
                                                echo ' selected="selected"'; ?>>Labor / Construction</option>
                                    <option value="Legal" <?php if ($profile->occupation == 'Legal')
                                                echo ' selected="selected"'; ?>>Legal</option>
                                    <option value="Medical / Dental / Veterinary" <?php if ($profile->occupation == 'Medical / Dental / Veterinary')
                                                echo ' selected="selected"'; ?>>Medical / Dental / Veterinary</option>
                                    <option value="Sales / Marketing" <?php if ($profile->occupation == 'Sales / Marketing')
                                                echo ' selected="selected"'; ?>>Sales / Marketing</option>
                                    <option value="Technical / Computers / Engineering" <?php if ($profile->occupation == 'Technical / Computers / Engineering')
                                                echo ' selected="selected"'; ?>>Technical / Computers / Engineering</option>
                                    <option value="Travel / Hospitality / Transportation" <?php if ($profile->occupation == 'Travel / Hospitality / Transportation')
                                                echo ' selected="selected"'; ?>>Travel / Hospitality / Transportation</option>
                                    <option value="Political / Govt / Civil Service / Military" <?php if ($profile->occupation == 'Political / Govt / Civil Service / Military')
                                                echo ' selected="selected"'; ?>>Political / Govt / Civil Service / Military</option>
                                    <option value="Retail / Food services" <?php if ($profile->occupation == 'Retail / Food services')
                                                echo ' selected="selected"'; ?>>Retail / Food services</option>
                                    <option value="Teacher / Professor" <?php if ($profile->occupation == 'Teacher / Professor')
                                                echo ' selected="selected"'; ?>>Teacher / Professor</option>
                                    <option value="Student" <?php if ($profile->occupation == 'Student')
                                                echo ' selected="selected"'; ?>>Student</option>
                                    <option value="Retired" <?php if ($profile->occupation == 'Retired')
                                                echo ' selected="selected"'; ?>>Retired</option>
                                    <option value="Other profession" <?php if ($profile->occupation == 'Other profession')
                                                echo ' selected="selected"'; ?>>Other profession</option>
                                </select>
                            </p>
                            <p>
                                <label>Relationship:</label>
                                <select name="relationship" class="long">
                                    <option value="Single" <?php if ($profile->relationship == 'Single')
                                                echo ' selected="selected"'; ?>>Single</option>
                                    <option value="Married" <?php if ($profile->relationship == 'Married')
                                                echo ' selected="selected"'; ?>>Married</option>
                                    <option value="Divorced" <?php if ($profile->relationship == 'Divorced')
                                                echo ' selected="selected"'; ?>>Divorced</option>
                                    <option value="Separated" <?php if ($profile->relationship == 'Separated')
                                                echo ' selected="selected"'; ?>>Separated</option>
                                    <option value="Attached" <?php if ($profile->relationship == 'Attached')
                                                echo ' selected="selected"'; ?>>Attached</option>
                                    <option value="Widowed" <?php if ($profile->relationship == 'Widowed')
                                                echo ' selected="selected"'; ?>>Widowed</option>
                                </select>
                            </p>
                            <p>
                                <label>Have Kids?:</label>
                                <select name="have_kids" class="small">
                                    <option value="No" <?php if ($profile->have_kids == 'No')
                                                echo ' selected="selected"'; ?>>No</option>
                                    <option value="Yes" <?php if ($profile->have_kids == 'Yes')
                                                echo ' selected="selected"'; ?>>Yes</option>
                                </select>
                            </p>
                            <p>
                                <label>Want Kids?:</label>
                                <select name="want_kids" class="small">
                                    <option value="No" <?php if ($profile->want_kids == 'No')
                                                echo ' selected="selected"'; ?>>No</option>
                                    <option value="Yes" <?php if ($profile->want_kids == 'Yes')
                                                echo ' selected="selected"'; ?>>Yes</option>
                                </select>
                            </p>
                            <p>
                                <label>Gender:</label>
                                <select name="gender" class="small">
                                    <?php foreach ($genders as $gender) : ?>
                                        <?php
                                        $selected = '';
                                        if ($gender == $profile->gender)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $gender; ?>" <?php echo $selected; ?>><?php echo $gender; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </p>
                            <p>
                                <label>Ethnicity:</label>
                                <select name="ethnicity" class="long">
                                    <?php foreach ($ethnicities as $ethnicity) : ?>
                                        <?php
                                        $selected = '';
                                        if ($ethnicity == $profile->ethnicity)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $ethnicity; ?>" <?php echo $selected; ?>><?php echo $ethnicity; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Body Type:</label>
                                <select name="body_type" class="long">
                                    <?php foreach ($body_types as $body_type) : ?>
                                        <?php
                                        $selected = '';
                                        if ($body_type == $profile->body_type)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $body_type; ?>" <?php echo $selected; ?>><?php echo $body_type; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Height:</label>
                                <select name="height" class="long">
                                    <option value="<152 cm" <?php if ($profile->height == '<152 cm')
                                        echo ' selected="selected"'; ?>><152 cm</option>
                                    <option value="152-154 cm" <?php if ($profile->height == '152-154 cm')
                                                echo ' selected="selected"'; ?>>152-154 cm</option>
                                    <option value="154-157 cm" <?php if ($profile->height == '154-157 cm')
                                                echo ' selected="selected"'; ?>>154-157 cm</option>
                                    <option value="157-160 cm" <?php if ($profile->height == '157-160 cm')
                                                echo ' selected="selected"'; ?>>157-160 cm</option>
                                    <option value="160-162 cm" <?php if ($profile->height == '160-162 cm')
                                                echo ' selected="selected"'; ?>>160-162 cm</option>
                                    <option value="162-165 cm" <?php if ($profile->height == '162-165 cm')
                                                echo ' selected="selected"'; ?>>162-165 cm</option>
                                    <option value="165-167 cm" <?php if ($profile->height == '165-167 cm')
                                                echo ' selected="selected"'; ?>>165-167 cm</option>
                                    <option value="167-170 cm" <?php if ($profile->height == '167-170 cm')
                                                echo ' selected="selected"'; ?>>167-170 cm</option>
                                    <option value="170-172 cm" <?php if ($profile->height == '170-172 cm')
                                                echo ' selected="selected"'; ?>>170-172 cm</option>
                                    <option value="172-175 cm" <?php if ($profile->height == '172-175 cm')
                                                echo ' selected="selected"'; ?>>172-175 cm</option>
                                    <option value="175-177 cm" <?php if ($profile->height == '175-177 cm')
                                                echo ' selected="selected"'; ?>>175-177 cm</option>
                                    <option value="177-180 cm" <?php if ($profile->height == '177-180 cm')
                                                echo ' selected="selected"'; ?>>177-180 cm</option>
                                    <option value="180-182 cm" <?php if ($profile->height == '180-182 cm')
                                                echo ' selected="selected"'; ?>>180-182 cm</option>
                                    <option value="182-185 cm" <?php if ($profile->height == '182-185 cm')
                                                echo ' selected="selected"'; ?>>182-185 cm</option>
                                    <option value="185-187 cm" <?php if ($profile->height == '185-187 cm')
                                                echo ' selected="selected"'; ?>>185-187 cm</option>
                                    <option value="187-190 cm" <?php if ($profile->height == '187-190 cm')
                                                echo ' selected="selected"'; ?>>187-190 cm</option>
                                    <option value="190-193 cm" <?php if ($profile->height == '190-193 cm')
                                                echo ' selected="selected"'; ?>>190-193 cm</option>
                                    <option value="193-195 cm" <?php if ($profile->height == '193-195 cm')
                                                echo ' selected="selected"'; ?>>193-195 cm</option>
                                    <option value=">193 cm" <?php if ($profile->height == '>193 cm')
                                                echo ' selected="selected"'; ?>>>193 cm</option>
                                </select>
                            </p>
                            <p>
                                <label>Eyes:</label>
                                <select name="eye_color" class="medium">
                                    <?php foreach ($eye_colors as $eye_color) : ?>
                                        <?php
                                        $selected = '';
                                        if ($eye_color == $profile->eye_color)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $eye_color; ?>" <?php echo $selected; ?>><?php echo $eye_color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Hair:</label>
                                <select name="hair_color" class="medium">
                                    <?php foreach ($hair_colors as $hair_color) : ?>
                                        <?php
                                        $selected = '';
                                        if ($hair_color == $profile->hair_color)
                                            $selected = 'selected';
                                        ?>
                                        <option value="<?php echo $hair_color; ?>" <?php echo $selected ?>><?php echo $hair_color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </p>
                            <p>
                                <label>Religion:</label>
                                <select name="religion" class="long">
                                    <option value="Agnostic" <?php if ($profile->religion == 'Agnostic')
                                        echo ' selected="selected"'; ?>>Agnostic</option>
                                    <option value="Atheist" <?php if ($profile->religion == 'Atheist')
                                                echo ' selected="selected"'; ?>>Atheist</option>
                                    <option value="Buddhist / Taoist" <?php if ($profile->religion == 'Buddhist / Taoist')
                                                echo ' selected="selected"'; ?>>Buddhist / Taoist</option>
                                    <option value="Christian / Catholic" <?php if ($profile->religion == 'Christian / Catholic')
                                                echo ' selected="selected"'; ?>>Christian / Catholic</option>
                                    <option value="Christian / LDS" <?php if ($profile->religion == 'Christian / LDS')
                                                echo ' selected="selected"'; ?>>Christian / LDS</option>
                                    <option value="Christian / Protestant" <?php if ($profile->religion == 'Christian / Protestant')
                                                echo ' selected="selected"'; ?>>Christian / Protestant</option>
                                    <option value="Christian / Other" <?php if ($profile->religion == 'Christian / Other')
                                                echo ' selected="selected"'; ?>>Christian / Other</option>
                                    <option value="Jewish" <?php if ($profile->religion == 'Jewish')
                                                echo ' selected="selected"'; ?>>Jewish</option>
                                    <option value="Hindu" <?php if ($profile->religion == 'Hindu')
                                                echo ' selected="selected"'; ?>>Hindu</option>
                                    <option value="Muslim / Islam" <?php if ($profile->religion == 'Muslim / Islam')
                                                echo ' selected="selected"'; ?>>Muslim / Islam</option>
                                    <option value="Spiritual but not religious" <?php if ($profile->religion == 'Spiritual but not religious')
                                                echo ' selected="selected"'; ?>>Spiritual but not religious</option>
                                    <option value="Other" <?php if ($profile->religion == 'Other')
                                                echo ' selected="selected"'; ?>>Other</option>
                                </select>
                            </p>
                            <p>
                                <label>Income:</label>
                                <select name="income" class="long">
                                    <option value="<10000" <?php if ($profile->income == '<10000')
                                                echo ' selected="selected"'; ?>><10000</option>
                                    <option value="10000-20000" <?php if ($profile->income == '10000-20000')
                                                echo ' selected="selected"'; ?>>10000-20000</option>
                                </select>
                            </p>
                            <p>
                                <label>Smoke:</label>
                                <select name="smoke">
                                    <option value="Non-smoker" <?php if ($profile->smoke == 'Non-smoker')
                                                echo ' selected="selected"'; ?>>Non-smoker</option>
                                    <option value="Light/Social smoker" <?php if ($profile->smoke == 'Light/Social smoker')
                                                echo ' selected="selected"'; ?>>Light/Social smoker</option>
                                    <option value="Heavy smoker" <?php if ($profile->smoke == 'Heavy smoker')
                                                echo ' selected="selected"'; ?>>Heavy smoker</option>
                                    <option value="Cigar/Pipe smoker" <?php if ($profile->smoke == 'Cigar/Pipe smoker')
                                                echo ' selected="selected"'; ?>>Cigar/Pipe smoker</option>
                                    <option value="Other" <?php if ($profile->smoke == 'Other')
                                                echo ' selected="selected"'; ?>>Other</option>
                                </select>
                            </p>
                            <p>
                                <label>Drink:</label>
                                <select name="drink">
                                    <option value="Non-drinker" <?php if ($profile->drink == 'Non-drinker')
                                                echo ' selected="selected"'; ?>>Non-drinker</option>
                                    <option value="Light/Social drinker" <?php if ($profile->drink == 'Light/Social drinker')
                                                echo ' selected="selected"'; ?>>Light/Social drinker</option>
                                    <option value="Heavy drinker" <?php if ($profile->drink == 'Heavy drinker')
                                                echo ' selected="selected"'; ?>>Heavy drinker</option>
                                    <option value="Other" <?php if ($profile->drink == 'Other')
                                                echo ' selected="selected"'; ?>>Other</option>
                                </select>
                            </p>

                            <div id="profile-submit-container">
                                <input class="submit_input" type="submit" src="" name="btnUpdateProfile" value="Save" />
                            </div>
                            <div id ="complete-interest-link" class="profile-form-separator <?php echo $submitted_form == 'profile-detail' ? 'active-form' : '' ?>">
                                <a>Complete Your Interests</a>
                            </div>
                        </div>

                    </form>
                </div>


                <div id="profile-interest-container" class="form-field-container <?php echo $submitted_form == 'interest' ? 'active-form' : '' ?>">
                    <form method="post" action="#" id="complete-profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="submitted-form" value="interest" />
                        <div id="main-picture-container">
                            <label class="darker-text">Main Profile Pic:</label>
                            <div id="profile-picture-container">
                                <div class="left">
                                    <img class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($profile->gender == 'Female' ? 'signup-woman.png' : 'signup-man.png') ?>" />
                                </div>
                                <div class="right">
                                    <p class="profile-picture-header darker-text">GET NOTICED!</p>
                                    <p class="profile-picture-content">Upload a photo to create a good profile. Click the button below to upload your profile photo.</p>
                                    <p id="profile-photo-select1" class="profile-picture-footer">
                                        <input hidden="true" type="file" name="avatar" size="1"/>
                                        <a id="profile-upload-button" class="upload-button">Select Photo</a>
                                    </p>
                                </div>                        
                            </div>                    
                        </div>
                        <div class="inner-form-separator"></div>

                        <p>
                            <label>About Me:</label>
                            <textarea rows="5" name="about_me" id="about-me"><?php echo $profile->about_me; ?></textarea>
                        </p>
                        <p>
                            <label>The most important thing that I'm looking for in a person:</label>
                            <textarea rows="3" name="important_thing_looking_for" id="important_thing_looking_for"><?php echo $profile->important_thing_looking_for; ?></textarea>
                        </p>
                        <p>
                            <label>The first thing people notice about me is:</label>
                            <textarea rows="3" name="first_thing_noticable" id="first_thing_noticable"><?php echo $profile->first_thing_noticable; ?></textarea>
                        </p>
                        <p>
                            <label>Interest:</label>
                            <textarea rows="3" name="interest" id="interest"><?php echo $profile->interest; ?></textarea>
                        </p>
                        <p>
                            <label>My friends described me as:</label>
                            <textarea rows="3" name="friends_describe_me" id="friends_describe_me"><?php echo $profile->friends_describe_me; ?></textarea>
                        </p>
                        <p>
                            <label>For fun I like to:</label>
                            <textarea rows="3" name="for_fun" id="for_fun"><?php echo $profile->for_fun; ?></textarea>
                        </p>
                        <p>
                            <label>Favorite things:</label>
                            <textarea rows="3" name="favorite_things" id="favorite_things"><?php echo $profile->favorite_things; ?></textarea>
                        </p>
                        <p>
                            <label>Last book I read was:</label>
                            <textarea rows="3" name="last_book_read" id="last_book_read"><?php echo $profile->last_book_read; ?></textarea>
                        </p>


                        <div id="profile-submit-container">
                            <input class="submit_input" type="submit" src="" name="btnUpdateProfile" value="Save" />
                        </div>
                        <div id ="looking-for-link" class="active-form profile-form-separator">
                            <a>Tell us what you're looking for</a>
                        </div>

                    </form>
                </div>

                <div id="profile-looking-for-container" class="form-field-container <?php echo $submitted_form == 'looking-for' ? 'active-form' : '' ?>">
                    <form method="post" action="#" id="complete-profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="submitted-form" value="looking-for" />
                        <div id="main-picture-container">
                            <label class="darker-text">Main Profile Pic:</label>
                            <div id="profile-picture-container">
                                <div class="left">
                                    <img class="member-thumbnail" src="<?php echo BASEURL . '/default_images/' . ($profile->gender == 'Female' ? 'signup-woman.png' : 'signup-man.png') ?>" />
                                </div>
                                <div class="right">
                                    <p class="profile-picture-header darker-text">GET NOTICED!</p>
                                    <p class="profile-picture-content">Upload a photo to create a good profile. Click the button below to upload your profile photo.</p>
                                    <p id="profile-photo-select2" class="profile-picture-footer">
                                        <input hidden="true" type="file" name="avatar" size="1"/>
                                        <a id="profile-upload-button" class="upload-button">Select Photo</a>
                                    </p>
                                </div>                        
                            </div>                    
                        </div>
                        <div class="inner-form-separator"></div>
                        <p id="priority-label-container">
                            Priority:
                        </p>
                        <p>
                            <label>Height:</label>
                            <select name="seeking_height" class="medium">
                                <option value="<152 cm" <?php if ($profile->seeking_height == '<152 cm')
                                                echo ' selected="selected"'; ?>><152 cm</option>
                                <option value="152-154 cm" <?php if ($profile->seeking_height == '152-154 cm')
                                            echo ' selected="selected"'; ?>>152-154 cm</option>
                                <option value="154-157 cm" <?php if ($profile->seeking_height == '154-157 cm')
                                            echo ' selected="selected"'; ?>>154-157 cm</option>
                                <option value="157-160 cm" <?php if ($profile->seeking_height == '157-160 cm')
                                            echo ' selected="selected"'; ?>>157-160 cm</option>
                                <option value="160-162 cm" <?php if ($profile->seeking_height == '160-162 cm')
                                            echo ' selected="selected"'; ?>>160-162 cm</option>
                                <option value="162-165 cm" <?php if ($profile->seeking_height == '162-165 cm')
                                            echo ' selected="selected"'; ?>>162-165 cm</option>
                                <option value="165-167 cm" <?php if ($profile->seeking_height == '165-167 cm')
                                            echo ' selected="selected"'; ?>>165-167 cm</option>
                                <option value="167-170 cm" <?php if ($profile->seeking_height == '167-170 cm')
                                            echo ' selected="selected"'; ?>>167-170 cm</option>
                                <option value="170-172 cm" <?php if ($profile->seeking_height == '170-172 cm')
                                            echo ' selected="selected"'; ?>>170-172 cm</option>
                                <option value="172-175 cm" <?php if ($profile->seeking_height == '172-175 cm')
                                            echo ' selected="selected"'; ?>>172-175 cm</option>
                                <option value="175-177 cm" <?php if ($profile->seeking_height == '175-177 cm')
                                            echo ' selected="selected"'; ?>>175-177 cm</option>
                                <option value="177-180 cm" <?php if ($profile->seeking_height == '177-180 cm')
                                            echo ' selected="selected"'; ?>>177-180 cm</option>
                                <option value="180-182 cm" <?php if ($profile->seeking_height == '180-182 cm')
                                            echo ' selected="selected"'; ?>>180-182 cm</option>
                                <option value="182-185 cm" <?php if ($profile->seeking_height == '182-185 cm')
                                            echo ' selected="selected"'; ?>>182-185 cm</option>
                                <option value="185-187 cm" <?php if ($profile->seeking_height == '185-187 cm')
                                            echo ' selected="selected"'; ?>>185-187 cm</option>
                                <option value="187-190 cm" <?php if ($profile->seeking_height == '187-190 cm')
                                            echo ' selected="selected"'; ?>>187-190 cm</option>
                                <option value="190-193 cm" <?php if ($profile->seeking_height == '190-193 cm')
                                            echo ' selected="selected"'; ?>>190-193 cm</option>
                                <option value="193-195 cm" <?php if ($profile->seeking_height == '193-195 cm')
                                            echo ' selected="selected"'; ?>>193-195 cm</option>
                                <option value=">193 cm" <?php if ($profile->seeking_height == '>193 cm')
                                            echo ' selected="selected"'; ?>>>193 cm</option>
                            </select> 
                            <select class="input-position" name="height_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Body Type:</label>
                            <select name="seeking_body_type" class="medium">
                                <?php foreach ($body_types as $body_type) : ?>
                                    <?php
                                    $selected = '';
                                    if ($body_type == $profile->seeking_body_type)
                                        $selected = 'selected';
                                    ?>
                                    <option value="<?php echo $body_type; ?>" <?php echo $selected; ?>><?php echo $body_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="input-position" name="body_type_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>

                        <p>
                            <label>Eyes:</label>
                            <select name="seeking_eyes" class="medium">
                                <?php foreach ($eye_colors as $eye_color) : ?>
                                    <?php
                                    $selected = '';
                                    if ($eye_color == $profile->seeking_eyes)
                                        $selected = 'selected';
                                    ?>
                                    <option value="<?php echo $eye_color; ?>" <?php echo $selected; ?>><?php echo $eye_color; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="input-position" name="eyes_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Hair:</label>
                            <select name="seeking_hair" class="medium">
                                <?php foreach ($hair_colors as $hair_color) : ?>
                                    <?php
                                    $selected = '';
                                    if ($hair_color == $profile->seeking_hair)
                                        $selected = 'selected';
                                    ?>
                                    <option value="<?php echo $hair_color; ?>" <?php echo $selected ?>><?php echo $hair_color; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="input-position" name="hair_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Smoke:</label>
                            <select name="seeking_smoke">
                                <option value="Non-smoker" <?php if ($profile->seeking_smoke == 'Non-smoker')
                                    echo ' selected="selected"'; ?>>Non-smoker</option>
                                <option value="Light/Social smoker" <?php if ($profile->seeking_smoke == 'Light/Social smoker')
                                            echo ' selected="selected"'; ?>>Light/Social smoker</option>
                                <option value="Heavy smoker" <?php if ($profile->seeking_smoke == 'Heavy smoker')
                                            echo ' selected="selected"'; ?>>Heavy smoker</option>
                                <option value="Cigar/Pipe smoker" <?php if ($profile->seeking_smoke == 'Cigar/Pipe smoker')
                                            echo ' selected="selected"'; ?>>Cigar/Pipe smoker</option>
                                <option value="Other" <?php if ($profile->seeking_smoke == 'Other')
                                            echo ' selected="selected"'; ?>>Other</option>
                            </select>
                            <select class="input-position" name="smoke_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Drink:</label>
                            <select name="seeking_drink">
                                <option value="Non-drinker" <?php if ($profile->seeking_drink == 'Non-drinker')
                                            echo ' selected="selected"'; ?>>Non-drinker</option>
                                <option value="Light/Social drinker" <?php if ($profile->seeking_drink == 'Light/Social drinker')
                                            echo ' selected="selected"'; ?>>Light/Social drinker</option>
                                <option value="Heavy drinker" <?php if ($profile->seeking_drink == 'Heavy drinker')
                                            echo ' selected="selected"'; ?>>Heavy drinker</option>
                                <option value="Other" <?php if ($profile->seeking_drink == 'Other')
                                            echo ' selected="selected"'; ?>>Other</option>
                            </select>
                            <select class="input-position" name="drink_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Occupation:</label>
                            <select name="seeking_occupation" class="long">
                                <option value="Administrative / Secretarial" <?php if ($profile->seeking_occupation == 'Administrative / Secretarial')
                                            echo ' selected="selected"'; ?>>Administrative / Secretarial</option>
                                <option value="Artistic / Creative / Performance" <?php if ($profile->seeking_occupation == 'Artistic / Creative / Performance')
                                            echo ' selected="selected"'; ?>>Artistic / Creative / Performance</option>
                                <option value="Executive / Management" <?php if ($profile->seeking_occupation == 'Executive / Management')
                                            echo ' selected="selected"'; ?>>Executive / Management</option>
                                <option value="Financial services" <?php if ($profile->seeking_occupation == 'Financial services')
                                            echo ' selected="selected"'; ?>>Financial services</option>
                                <option value="Labor / Construction" <?php if ($profile->seeking_occupation == 'Labor / Construction')
                                            echo ' selected="selected"'; ?>>Labor / Construction</option>
                                <option value="Legal" <?php if ($profile->seeking_occupation == 'Legal')
                                            echo ' selected="selected"'; ?>>Legal</option>
                                <option value="Medical / Dental / Veterinary" <?php if ($profile->seeking_occupation == 'Medical / Dental / Veterinary')
                                            echo ' selected="selected"'; ?>>Medical / Dental / Veterinary</option>
                                <option value="Sales / Marketing" <?php if ($profile->seeking_occupation == 'Sales / Marketing')
                                            echo ' selected="selected"'; ?>>Sales / Marketing</option>
                                <option value="Technical / Computers / Engineering" <?php if ($profile->seeking_occupation == 'Technical / Computers / Engineering')
                                            echo ' selected="selected"'; ?>>Technical / Computers / Engineering</option>
                                <option value="Travel / Hospitality / Transportation" <?php if ($profile->seeking_occupation == 'Travel / Hospitality / Transportation')
                                            echo ' selected="selected"'; ?>>Travel / Hospitality / Transportation</option>
                                <option value="Political / Govt / Civil Service / Military" <?php if ($profile->seeking_occupation == 'Political / Govt / Civil Service / Military')
                                            echo ' selected="selected"'; ?>>Political / Govt / Civil Service / Military</option>
                                <option value="Retail / Food services" <?php if ($profile->seeking_occupation == 'Retail / Food services')
                                            echo ' selected="selected"'; ?>>Retail / Food services</option>
                                <option value="Teacher / Professor" <?php if ($profile->seeking_occupation == 'Teacher / Professor')
                                            echo ' selected="selected"'; ?>>Teacher / Professor</option>
                                <option value="Student" <?php if ($profile->seeking_occupation == 'Student')
                                            echo ' selected="selected"'; ?>>Student</option>
                                <option value="Retired" <?php if ($profile->seeking_occupation == 'Retired')
                                            echo ' selected="selected"'; ?>>Retired</option>
                                <option value="Other profession" <?php if ($profile->seeking_occupation == 'Other profession')
                                            echo ' selected="selected"'; ?>>Other profession</option>
                            </select>
                            <select class="input-position" name="occupation_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Income:</label>
                            <select name="seeking_income" class="long">
                                <option value="<10000" <?php if ($profile->seeking_income == '<10000')
                                            echo ' selected="selected"'; ?>><10000</option>
                                <option value="10000-20000" <?php if ($profile->seeking_income == '10000-20000')
                                            echo ' selected="selected"'; ?>>10000-20000</option>
                            </select>
                            <select class="input-position" name="income_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Relationship:</label>
                            <select name="seeking_relationship" class="long">
                                <option value="Single" <?php if ($profile->seeking_relationship == 'Single')
                                            echo ' selected="selected"'; ?>>Single</option>
                                <option value="Married" <?php if ($profile->seeking_relationship == 'Married')
                                            echo ' selected="selected"'; ?>>Married</option>
                                <option value="Divorced" <?php if ($profile->seeking_relationship == 'Divorced')
                                            echo ' selected="selected"'; ?>>Divorced</option>
                                <option value="Separated" <?php if ($profile->seeking_relationship == 'Separated')
                                            echo ' selected="selected"'; ?>>Separated</option>
                                <option value="Attached" <?php if ($profile->seeking_relationship == 'Attached')
                                            echo ' selected="selected"'; ?>>Attached</option>
                                <option value="Widowed" <?php if ($profile->seeking_relationship == 'Widowed')
                                            echo ' selected="selected"'; ?>>Widowed</option>
                            </select>
                            <select class="input-position" name="relationship_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Have Kids?:</label>
                            <select name="seeking_have_kids" class="small">
                                <option value="No" <?php if ($profile->seeking_have_kids == 'No')
                                            echo ' selected="selected"'; ?>>No</option>
                                <option value="Yes" <?php if ($profile->seeking_have_kids == 'Yes')
                                            echo ' selected="selected"'; ?>>Yes</option>
                            </select>
                            <select class="input-position" name="have_kids_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Want Kids?:</label>
                            <select name="seeking_want_kids" class="small">
                                <option value="No" <?php if ($profile->seeking_want_kids == 'No')
                                            echo ' selected="selected"'; ?>>No</option>
                                <option value="Yes" <?php if ($profile->seeking_want_kids == 'Yes')
                                            echo ' selected="selected"'; ?>>Yes</option>
                            </select>
                            <select class="input-position" name="want_kids_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Ethnicity:</label>
                            <select name="seeking_ethnicity" class="long">
                                <?php foreach ($ethnicities as $ethnicity) : ?>
                                    <?php
                                    $selected = '';
                                    if ($ethnicity == $profile->seeking_ethnicity)
                                        $selected = 'selected';
                                    ?>
                                    <option value="<?php echo $ethnicity; ?>" <?php echo $selected; ?>><?php echo $ethnicity; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="input-position" name="ethnicity_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>
                        <p>
                            <label>Faith:</label>
                            <select name="seeking_faith" class="long">
                                <option value="Agnostic" <?php if ($profile->seeking_faith == 'Agnostic')
                                    echo ' selected="selected"'; ?>>Agnostic</option>
                                <option value="Atheist" <?php if ($profile->seeking_faith == 'Atheist')
                                            echo ' selected="selected"'; ?>>Atheist</option>
                                <option value="Buddhist / Taoist" <?php if ($profile->seeking_faith == 'Buddhist / Taoist')
                                            echo ' selected="selected"'; ?>>Buddhist / Taoist</option>
                                <option value="Christian / Catholic" <?php if ($profile->seeking_faith == 'Christian / Catholic')
                                            echo ' selected="selected"'; ?>>Christian / Catholic</option>
                                <option value="Christian / LDS" <?php if ($profile->seeking_faith == 'Christian / LDS')
                                            echo ' selected="selected"'; ?>>Christian / LDS</option>
                                <option value="Christian / Protestant" <?php if ($profile->seeking_faith == 'Christian / Protestant')
                                            echo ' selected="selected"'; ?>>Christian / Protestant</option>
                                <option value="Christian / Other" <?php if ($profile->seeking_faith == 'Christian / Other')
                                            echo ' selected="selected"'; ?>>Christian / Other</option>
                                <option value="Jewish" <?php if ($profile->seeking_faith == 'Jewish')
                                            echo ' selected="selected"'; ?>>Jewish</option>
                                <option value="Hindu" <?php if ($profile->seeking_faith == 'Hindu')
                                            echo ' selected="selected"'; ?>>Hindu</option>
                                <option value="Muslim / Islam" <?php if ($profile->seeking_faith == 'Muslim / Islam')
                                            echo ' selected="selected"'; ?>>Muslim / Islam</option>
                                <option value="Spiritual but not religious" <?php if ($profile->seeking_faith == 'Spiritual but not religious')
                                            echo ' selected="selected"'; ?>>Spiritual but not religious</option>
                                <option value="Other" <?php if ($profile->seeking_faith == 'Other')
                                            echo ' selected="selected"'; ?>>Other</option>
                            </select>
                            <select class="input-position" name="faith_priority">
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                            </select>
                        </p>

                        <div id="profile-submit-container">
                            <input class="submit_input" type="submit" src="" name="btnUpdateProfile" value="Save" />
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
    <div class="clear">&nbsp;</div>
</div>

<?php echo View::forge('partials/footer'); ?>
