<div id="content" class="clearfix">
<aside id="sidebar">
    <div id="profile-summary">
        <h3>Upload Your <em>Profile Image!</em></h3>

        <div class="content">
            <?php $picture_uploaded = $current_profile->picture=="" ? 0 : 1; ?>
            <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile")), array("id" => "profile-picture-container", "data-picture-uploaded" => $picture_uploaded)); ?>
            <h4>Get Noticed Faster!</h4>

            <p>
                Upload a photo to create a good profile. Click the button below to upload your profile photo.
            </p>
            <?php echo Html::anchor("#", "Upload Photo", array("id" => "upload-photo", "data-dialog" => "upload-photo-dialog")); ?>
        </div>
    </div>
    <div id="dating-concierge">
        <h3>Sign Up & Get Your Own Dating Concierge</h3>

        <div class="content">
            <?php echo Asset::img("concierge/sidebar_pic.jpg"); ?>
            <p>
                Join Now and Consult Live with your own online concierge.
            </p>
        </div>
    </div>
    <div id="refer-a-friend">
        <h3>Refer a friend and get 1 month free</h3>

        <div class="content">
            <?php echo Asset::img("refer_a_friend.jpg"); ?>
            <?php echo Html::anchor("#", "Get Details Now!", array("id" => "get-details-now")); ?>
        </div>
    </div>
</aside>

<div id="main-content">
<p id="join-now-text-ad">
    <em>Join now</em> and see more of your <em>top matches!</em>
</p>

<div id="potential-matches">
    <p>
        <?php echo Asset::img("tmyw_icon.png"); ?>
        <em>Meet these</em> Potential Matches <em>once you create your</em> Free Membership
    </p>

    <div id="matches" class="clearfix">
        <?php if ($preferred_members): ?>
            <?php foreach ($preferred_members as $member): ?>
                <div class="match">
                    <?php echo Html::anchor('#', Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list"))); ?>
                    <p><?php echo Model_Profile::get_username($member['user_id']) ?></p>

                    <p class="location"><?php echo $member['state'] ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No members for your criteria</p>
        <?php endif; ?>
    </div>
</div>
<div id="profile-edit">
    <div class="heading clearfix">
        <h3 id="section-title">Tell Us About Yourself</h3>
        <span>Fill out the steps below in order to begin browsing the matches you have been waiting for.</span>
    </div>
    <?php echo Form::open(array("action" => "profile/update", "id" => "edit-profile-form", "class" => "clearfix")) ?>
        <section id="about-yourself" class="active clearfix" data-heading-text="Tell Us About Yourself"
                 data-nav-button-text="Keep Going <i class='fa fa-arrow-right'></i>" data-nav-button-action="nav">
            <p id="username-field">
                <label>Username:</label>
                <input type="text" name="username" disabled value="<?php echo Model_Profile::get_username($profile->user_id); ?>"/>
            </p>
            <p>
                <label>When's your birthday?</label>
                <select name="month">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <?php $selected = ($i == date('m', $profile->birth_date) ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="day">
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <?php $selected = ($i == date('d', $profile->birth_date) ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <select name="year">
                    <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                        <?php $selected = ($i == date('Y', $profile->birth_date) ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </p>
            <p>
                <label>Gender:</label>
                <select name="gender_id">
                    <?php foreach ($gender as $item) : ?>
                        <?php $selected = ($item->id == $profile->gender_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What's your state?</label>
                <select name="state">
                    <option value="">Please Select</option>
                    <?php foreach ($state as $item) : ?>
                        <?php $selected = ($item->name == $profile->state ? 'selected' : ''); ?>
                        <option value="<?php echo $item->name; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What's your city?</label>
                <input type="text" name="city" value="<?php echo $profile->city; ?>"/>
            </p>
            <p>
                <label>What's your zip code?</label>
                <input type="text" name="zip" value="<?php echo $profile->zip; ?>"/>
            </p>
            <p>
                <label>What's your occupation?</label>
                <select name="occupation_id">
                    <option value="">Please Select</option>
                    <?php foreach ($occupation as $item) : ?>
                        <?php $selected = ($item->id == $profile->occupation_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What's your Relationship Status?</label>
                <select name="relationship_status_id">
                    <option value="">Please Select</option>
                    <?php foreach ($relationship_status as $item) : ?>
                        <?php $selected = ($item->id == $profile->relationship_status_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Do you have kids?</label>
                <select name="have_kids">
                    <option value="">Please Select</option>
                    <option value="Yes" <?php if ($profile->have_kids == 'Yes')  echo "selected"; ?>>Yes</option>
                    <option value="No" <?php if ($profile->have_kids == 'No')
                        echo "selected"; ?>>No</option>
                </select>
            </p>
            <p>
                <label>Do you want kids?</label>
                <select name="want_kids">
                    <option value="">Please Select</option>
                    <option value="Yes" <?php if ($profile->want_kids == 'Yes')
                        echo "selected"; ?>>Yes</option>
                    <option value="No" <?php if ($profile->want_kids == 'No')
                        echo "selected"; ?>>No</option>
                </select>
            </p>
            <p>
                <label>What's your body type?</label>
                <select name="body_type_id">
                    <option value="">Please Select</option>
                    <?php foreach ($body_type as $item) : ?>
                        <?php $selected = ($item->id == $profile->body_type_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What's your ethnicity?</label>
                <select name="ethnicity_id">
                    <option value="">Please Select</option>
                    <?php foreach ($ethnicity as $item) : ?>
                        <?php $selected = ($item->id == $profile->ethnicity_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>How tall are you?</label>
                <select name="height_foot">
                    <option value="">Please Select</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <?php $selected = ($i == substr($profile->height, 0, strpos($profile->height, "'")) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>'</strong>
                <select name="height_inches">
                    <option value="">Please Select</option>
                    <?php for ($i = 0; $i <= 99; $i++): ?>
                        <?php $selected = ($i == substr($profile->height, strpos($profile->height, "'") + 1, -2) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>"</strong>
            </p>
            <p>
                <label>What color are your eyes?</label>
                <select name="eye_color_id">
                    <option value="">Please Select</option>
                    <?php foreach ($eye_color as $item) : ?>
                        <?php $selected = ($item->id == $profile->eye_color_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What color is your hair?</label>
                <select name="hair_color_id">
                    <option value="">Please Select</option>
                    <?php foreach ($hair_color as $item) : ?>
                        <?php $selected = ($item->id == $profile->hair_color_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>What's your religion?</label>
                <select name="religion_id">
                    <option value="">Please Select</option>
                    <?php foreach ($religion as $item) : ?>
                        <?php $selected = ($item->id == $profile->religion_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Do you smoke?</label>
                <select name="smoke_id">
                    <option value="">Please Select</option>
                    <?php foreach ($smoke as $item) : ?>
                        <?php $selected = ($item->id == $profile->smoke_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Do you drink?</label>
                <select name="drink_id">
                    <option value="">Please Select</option>
                    <?php foreach ($drink as $item) : ?>
                        <?php $selected = ($item->id == $profile->drink_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p class="continue-text">
                Keep Going we want to know more about you!
            </p>
        </section>
        <section id="additional-details" class="clearfix" data-heading-text="Additional Details"
                 data-nav-button-text="Keep Going <i class='fa fa-arrow-right'></i>" data-nav-button-action="nav">
            <p>
                <label>About Me:</label>
                <textarea name="about_me"><?php echo $profile->about_me; ?></textarea>
            </p>

            <p>
                <label>The most important thing I look for in a person:</label>
                <textarea name="things_looking_for"><?php echo $profile->things_looking_for; ?></textarea>
            </p>

            <p>
                <label>The first thing people notice about me is:</label>
                <textarea name="first_thing_noticable"><?php echo $profile->first_thing_noticable; ?></textarea>
            </p>

            <p>
                <label>Interest:</label>
                <textarea name="interest"><?php echo $profile->interest; ?></textarea>
            </p>

            <p>
                <label>My Friends describe me as:</label>
                <textarea name="friends_describe_me"><?php echo $profile->friends_describe_me; ?></textarea>
            </p>

            <p>
                <label>For fun I like to:</label>
                <textarea name="for_fun"><?php echo $profile->for_fun; ?></textarea>
            </p>

            <p>
                <label>Favorite things:</label>
                <textarea name="favorite_things"><?php echo $profile->favorite_things; ?></textarea>
            </p>

            <p>
                <label>Last book I read was:</label>
                <textarea name="last_book_read"><?php echo $profile->last_book_read; ?></textarea>
            </p>

            <p class="continue-text">
                Keep Going we want to know more your match!
            </p>
        </section>
        <section id="your-match" class="clearfix" data-heading-text="More About Your Match" data-nav-button-text="Finish!"
                 data-nav-button-action="finish">
            <p>
                <label>Preferred ages:</label>
                <select name="ages_from">
                    <?php for ($i = 18; $i <= 99; $i++): ?>
                        <?php $selected = ($i == $profile->ages_from ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
                <label class="inline">to</label>
                <select name="ages_to">
                    <?php for ($i = 18; $i <= 99; $i++): ?>
                        <?php $selected = ($i == $profile->ages_to ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </p>
            <p>
                <label>Gender:</label>
                <select name="seeking_gender_id">
                    <option value="">Please Select</option>
                    <?php foreach ($gender as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_gender_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Location:</label>
                <select name="seeking_location">
                    <option value="">Please Select</option>
                    <?php foreach ($state as $item) : ?>
                        <?php $selected = ($item->name == $profile->seeking_location ? 'selected' : ''); ?>
                        <option value="<?php echo $item->name; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p>
                <label>Occupation:</label>
                <select name="seeking_occupation_id">
                    <option value="">Please Select</option>
                    <?php foreach ($occupation as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_occupation_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Relationship Status:</label>
                <select name="seeking_relationship_status_id">
                    <option value="">Please Select</option>
                    <?php foreach ($relationship_status as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_relationship_status_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Have kids?</label>
                <select name="seeking_have_kids">
                    <option value="">Please Select</option>
                    <option value="Yes" <?php if ($profile->seeking_have_kids == 'Yes')
                        echo "selected"; ?>>Yes</option>
                    <option value="No" <?php if ($profile->seeking_have_kids == 'No')
                        echo "selected"; ?>>No</option>
                </select>
            </p>
            <p>
                <label>Want kids:</label>
                <select name="seeking_want_kids">
                    <option value="">Please Select</option>
                    <option value="Yes" <?php if ($profile->seeking_want_kids == 'Yes')
                        echo "selected"; ?>>Yes</option>
                    <option value="No" <?php if ($profile->seeking_want_kids == 'No')
                        echo "selected"; ?>>No</option>
                </select>
            </p>
            <p>
                <label>Body type:</label>
                <select name="seeking_body_type_id">
                    <option value="">Please Select</option>
                    <?php foreach ($body_type as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_body_type_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Height From:</label>
                <select name="seeking_height_foot">
                    <option value="">Please Select</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <?php $selected = ($i == substr($profile->seeking_height, 0, strpos($profile->seeking_height, "'")) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>'</strong>
                <select name="seeking_height_inches">
                    <option value="">Please Select</option>
                    <?php for ($i = 0; $i <= 99; $i++): ?>
                        <?php $selected = ($i == substr($profile->seeking_height, strpos($profile->seeking_height, "'") + 1, -2) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>"</strong>
            </p>
            <p>
                <label>Height To:</label>
                <select name="seeking_height_to_foot">
                    <option value="">Please Select</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <?php $selected = ($i == substr($profile->seeking_height_to, 0, strpos($profile->seeking_height_to, "'")) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>'</strong>
                <select name="seeking_height_to_inches">
                    <option value="">Please Select</option>
                    <?php for ($i = 0; $i <= 99; $i++): ?>
                        <?php $selected = ($i == substr($profile->seeking_height_to, strpos($profile->seeking_height_to, "'") + 1, -2) ? 'selected' : ''); ?>
                        <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select> <strong>"</strong>
            </p>
            <p>
                <label>Ethnicity:</label>
                <select name="seeking_ethnicity_id">
                    <option value="">Please Select</option>
                    <?php foreach ($ethnicity as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_ethnicity_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Eye color:</label>
                <select name="seeking_eye_color_id">
                    <option value="">Please Select</option>
                    <?php foreach ($eye_color as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_eye_color_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Hair Color:</label>
                <select name="seeking_hair_color_id">
                    <option value="">Please Select</option>
                    <?php foreach ($hair_color as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_hair_color_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Religion:</label>
                <select name="seeking_religion_id">
                    <option value="">Please Select</option>
                    <?php foreach ($religion as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_religion_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Smoke:</label>
                <select name="seeking_smoke_id">
                    <option value="">Please Select</option>
                    <?php foreach ($smoke as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_smoke_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label>Drink:</label>
                <select name="seeking_drink_id">
                    <option value="">Please Select</option>
                    <?php foreach ($drink as $item) : ?>
                        <?php $selected = ($item->id == $profile->seeking_drink_id ? 'selected' : ''); ?>
                        <option value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <div id="priorities" class="clearfix">
                <div class="heading clearfix">
                    <h3>Your Top 5 Priorities in A Match</h3>
                    <span>Please select the top 5 priorities you are seeing in a match.</span>
                </div>
                <div id="priority-selection" class="clearfix">
                    <p>
                        <label>1</label>
                        <select name="priority_1">
                            <option value="">Please Select</option>
                            <?php foreach ($priority_field as $item) : ?>
                                <?php $selected = ($item->id == $profile->priority_1 ? 'selected' : ''); ?>
                                <option
                                    value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label>2</label>
                        <select name="priority_2">
                            <option value="">Please Select</option>
                            <?php foreach ($priority_field as $item) : ?>
                                <?php $selected = ($item->id == $profile->priority_2 ? 'selected' : ''); ?>
                                <option
                                    value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label>3</label>
                        <select name="priority_3">
                            <option value="">Please Select</option>
                            <?php foreach ($priority_field as $item) : ?>
                                <?php $selected = ($item->id == $profile->priority_3 ? 'selected' : ''); ?>
                                <option
                                    value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label>4</label>
                        <select name="priority_4">
                            <option value="">Please Select</option>
                            <?php foreach ($priority_field as $item) : ?>
                                <?php $selected = ($item->id == $profile->priority_4 ? 'selected' : ''); ?>
                                <option
                                    value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label>5</label>
                        <select name="priority_5">
                            <option value="">Please Select</option>
                            <?php foreach ($priority_field as $item) : ?>
                                <?php $selected = ($item->id == $profile->priority_5 ? 'selected' : ''); ?>
                                <option
                                    value="<?php echo $item->id; ?>" <?php echo $selected; ?>><?php echo $item->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                </div>
            </div>
        </section>
        <div id="form-navigation" class="clearfix">
                <span id="prev">
                    <?php echo Html::anchor("#", "<i class='fa fa-arrow-circle-left'></i>"); ?>
                </span>
                <span id="next">
                  <?php echo Html::anchor("#", "Keep Going <i class='fa fa-arrow-right'></i>", array("id" => "nav-button", "data-action" => "next")); ?>
                  <?php echo Html::anchor("profile/dashboard", "or skip this step", array("id" => "skip-link")); ?>
                </span>
        </div>
    <?php echo Form::close(); ?>
</div>
</div>

</div>

<div id="upload-photo-dialog" class="dialog">
    <?php echo Form::open(array("action" => "profile/upload_profile_picture", "enctype" => "multipart/form-data", "class" => "clearfix")) ?>
    <i class="close-dialog fa fa-times-circle-o"></i>

    <div class="dialog-header clearfix">
        <p class="left">
            <?php echo Asset::img("logo_man_24.png"); ?>
            <span>COMPLETE YOUR PROFILE</span>
        </p>

        <p class="right">
            Step 1. UPLOAD PHOTO
        </p>
    </div>
    <div class="dialog-content">
        <p>
            As a guest member you are required to have at least one public profile photo to complete most actions. Take
            some time to fill
            out some additional information or <a href="#">skip this step and view your profile.</a>
        </p>

        <div id="center-content" class="clearfix">
            <div class="center-left">
                <div class="left">
                    <?php echo Asset::img("defaults/profile_pic_2.jpg"); ?>
                </div>
                <div class="right">
                    <h3>Get Noticed!</h3>

                    <p id="instruction">Upload a photo to create a good profile. Click the button below to upload your
                        profile photo.</p>

                    <p id="profile-photo-select">
                        <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                        <a id="profile-upload-button" class="upload-button">Choose File</a>
                        <span>No file selected</span>
                    </p>
                </div>
            </div>
            <div class="center-middle">
                <p>or</p>
            </div>
            <div class="center-right">
                <h3>Want to stay Anonymouse?</h3>

                <p>If you don’t want to upload a photo but still want to
                    send messages. Upgrade now and become a
                    Premium Member. </p>

                <p class="upgrade-button">
                    <?php echo Html::anchor('membership/upgrade', "Upgrade Now!"); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="dialog-footer clearfix">
        <span>Continue to additional profile details</span>
        <input type="submit" name="btnLogin" value="Upload"/>
        or
        <a id="skip-button" href="#">Skip</a>
    </div>

    <?php echo Form::close(); ?>
</div>