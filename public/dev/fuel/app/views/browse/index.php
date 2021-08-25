<?php echo View::forge('partials/inner_header'); ?>
<?php echo View::forge('partials/blue_navigator', array('menu' => 'Browse', 'is_completed' => $profile->is_completed)); ?>
<div class="container_main">
    <div  class="left-side-container_large"> 
        <form method="post" action="<?php echo BASEURL . '/browse/index' ?>" id="browse_member_form">
            <div id="upper-search-container">
                <div class="title">
                    <p> BROWSE MEMBERS </p>
                    <a href="#"> View All</a>
                </div>
                <div class="separetor-line"></div>

                <div id="browse-form-container"> 

                    <div id="upper-container">
                        <div id="gender-container"> 
                            <p>
                                <label>I am a:</label>
                                <select name="am_a">
                                    <option value="Man" <?php if (isset($search_criteria) && $search_criteria['am_a'] == 'Man')
                                                echo ' selected="selected"'; ?>>Man</option>
                                    <option value="Woman" <?php if (isset($search_criteria) && $search_criteria['am_a'] == 'Woman')
                                                echo ' selected="selected"'; ?>>Woman</option> 
                                </select>
                            </p>
                            <p>
                                <label>Seeking a:</label>
                                <select name="seeking_a">
                                    <option value="Woman" <?php if (isset($search_criteria) && $search_criteria['seeking_a'] == 'Woman')
                                                echo ' selected="selected"'; ?>>Woman</option>
                                    <option value="Man" <?php if (isset($search_criteria) && $search_criteria['seeking_a'] == 'Man')
                                                echo ' selected="selected"'; ?>>Man</option>
                                </select>
                            </p>
                        </div>

                        <div id="veriical-separetor-img"></div>
                        <div id="between-ages"> 
                            <p>
                                <label>Between Ages:</label>
                                <?php $ages = range(18, 100); ?>
                                <select name="age_min">
                                    <option value=""></option>
                                    <?php foreach ($ages as $age) : ?>
                                        <option value="<?php echo $age; ?>" <?php if (isset($search_criteria) && $search_criteria['age_min'] == $age)
                                        echo ' selected="selected"'; ?>><?php echo $age; ?></option>
                                            <?php endforeach; ?>
                                </select>
                                &nbsp; To &nbsp;
                                <select name="age_max">
                                    <option value=""></option>
                                    <?php foreach ($ages as $age) : ?>
                                        <option value="<?php echo $age; ?>" <?php if (isset($search_criteria) && $search_criteria['age_max'] == $age)
                                        echo ' selected="selected"'; ?>><?php echo $age; ?></option>
                                            <?php endforeach; ?>
                                </select>
                            </p>
                        </div>             
                        <div id="veriical-separetor-img"></div>
                        <div id="located"> 
                            <p>
                                <label>Located:</label>
                                <?php echo View::forge('partials/states_list'); ?>
                                <input type="text" name="city" value="<?php if (isset($search_criteria))
                                    echo $search_criteria['city']; ?>" />
                            </p>
                        </div>
                    </div>
                    <div id="upper-container">
                        <div id="photo-online"> 
                            <p id="filters">
                                <label>Photos Only :</label> 
                                <input type="checkbox" name="with_photos" <?php if (isset($search_criteria) && isset($search_criteria['with_photos'])) echo ' checked'; ?>/>
                            </p>

                            <p id="filters">
                                <label>Online Now :</label>
                                <input type="checkbox" name="online_now" <?php if (isset($search_criteria) && isset($search_criteria['online_now'])) echo ' checked'; ?>/>
                            </p>
                        </div>
                        <div id="veriical-separetor-img"></div>
                        <div id="browse-search"> 
                            <p>
                                Keywords:
                            </p>
                            <div id="browse-search-input">
                                <input type="text" name="key_words"/>
                            </div>
                            <div id="browse-submit">
                                <input class="submit_input" type="submit" name="btnBrowseMembers" value="Search" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php if ($members) : ?>
                <div id="browse-members-container">
                    <ul>
                        <?php foreach ($members as $i => $member): ?>
                            <li>
                                <div class="members-photo-container">
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/' . $member['id']), Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
                                    <p><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
                                    <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>

                                    <div class="linkbuttonscontainer">
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('email.png'); ?> </a>
                                        </div> 
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('chat.png'); ?> </a>
                                        </div>
                                        <div class="link-button"> 
                                            <a href=""><?php echo Asset::img('star.png'); ?> </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <?php if ($i == 4 || $i == 9): ?>
                                <div class="bottome-line"></div>
                            <?php endif; ?>


                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="quick-search-message">
                    <p>
                        The Search returns no result. Please try again.
                    </p>
                </div>
            <?php endif; ?>
            <div id="lower-search-container"> 
                <div class="title">
                    <?php echo Asset::img('icons/search-icpn.png'); ?>
                    <p>SEARCH FILTERS</p>

                </div>
                <div class="separetor-line"></div>
                <div id="lower-search-criteria-container">
                    <div id="search-filter-container"> 
                        <p>
                            <label>Body Type</label>
                            <select name="body_type">
                                <option value=""></option>
                                <?php foreach ($body_types as $body_type) : ?>
                                    <option value="<?php echo $body_type; ?>" <?php if (isset($search_criteria) && $search_criteria['body_type'] == $body_type)
                                                echo ' selected="selected"'; ?>><?php echo $body_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <p>
                            <label>Eye Color</label>
                            <select name="eye_color">
                                <option value=""></option>
                                <?php foreach ($eye_colors as $eye_color) : ?>
                                    <option value="<?php echo $eye_color; ?>" <?php if (isset($search_criteria) && $search_criteria['eye_color'] == $eye_color)
                                                echo ' selected="selected"'; ?>><?php echo $eye_color; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <p>
                            <label>Hair Color</label>
                            <select name="hair_color">
                                <option value=""></option>
                                <?php foreach ($hair_colors as $hair_color) : ?>
                                    <option value="<?php echo $hair_color; ?>" <?php if (isset($search_criteria) && $search_criteria['hair_color'] == $hair_color)
                                                echo ' selected="selected"'; ?>><?php echo $hair_color; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        <p>
                            <label>Ethnicity</label>
                            <select name="ethnicity">
                                <option value=""></option>
                                <?php foreach ($ethnicities as $ethnicity) : ?>
                                    <option value="<?php echo $ethnicity; ?>" <?php if (isset($search_criteria) && $search_criteria['ethnicity'] == $ethnicity)
                                                echo ' selected="selected"'; ?>><?php echo $ethnicity; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                        
                        <p id="refine-search-submit">
                            <input class="submit_input" type="submit" name="btnRefineSearch" value="Refine Search" />
                        </p>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <div  class="right-side-container_small"> 
        <div id="seeonline">
            <p>See Who is Online</p> <a href="#">See All</a>
        </div>
        <div class="see-online-members-container">
            <?php if ($online_members): ?>
                <?php // $images = array("browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png", "browse/browseonline.png"); ?>
                <ul>
                    <?php foreach ($online_members as $online_member): ?>
                        <li>
                            <div class="online-member"> 
                                <div class="online-members-image"> 
                                    <?php if (!empty($online_member['avatar'])): ?>
                                        <a href= "<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?>">
                                            <img class="member-thumbnail" width="76" height="59" src="<?php echo UPLOADURL . $online_member['username'] . '/' . $online_member['avatar'] ?>" />
                                        </a>
                                    <?php else: ?>
                                        <a href= "<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?>">
                                            <img class="member-thumbnail" width="76" height="59" src="<?php echo BASEURL . '/default_images/' . ($online_member['gender'] == 'Female' ? 'woman.jpg' : 'man.jpg') ?>" />
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="online-members-info">
                                    <div class="membername"><p><?php echo Model_Profile::get_username($online_member['user_id'],14); ?>  </p></div>
                                    <div class="memberaddress"><p><?php echo $online_member['city'] != '' ? ($online_member['city'] . ', ' . $online_member['state']) : $online_member['state']; ?></p></div>
                                    <div class="dotted-line"> </div>
                                    <div class="linkbuttonscontainer">
                                        <div class="view-profile"> 
                                            <a href="<?php echo BASEURL . '/profile/public_profile/' . $online_member['id'] ?> ">View Profile</a>
                                        </div> 
                                        <div class="say-hello"> 
                                            <a href="#">Say Hellow</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="empty-message">
                    <p>
                        No online members
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div id="upgrade-container"> 
            <div id="upgrade">
                <?php echo Asset::img('icons/wright.png'); ?>
                <h1> Upgrade Now!</h1>
            </div>
            <div id="upgrade_paragraph">
                <p>Get instant access to all of our features once you upgrade your account</p>
            </div>
            <div id="upgrade-button">
                <input class="submit_input" type="submit" value=" Upgrade Account" />
            </div>
        </div>
    </div>

    <div class="clear">&nbsp;</div>
</div>

<?php echo View::forge('partials/footer'); ?>
