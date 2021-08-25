<div id="content">
    <div id="build-profile-container">
        <div id="advertizment">
            <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
            <p><b>Upgrade</b> to never see ads again. <b>Remove</b></p>
        </div>
        <div id="profile-picture-section" class="clearfix active">
            <div class="left">
                <?php echo Asset::img('line_end.png', array('class' => 'line-end')); ?>
                <?php echo Asset::img('profile_circle.png', array('class' => 'profile-circle')); ?>
            </div>
            <div class="right">
                <?php echo Asset::img('pages/home2/rachel_profile_pic.jpg', array('class' => '')); ?>
                <p>Rachel Vanhook</p>
            </div>
        </div>
        <div id="bottom-section" class="active">
            <div id="get-started-content" class="active">
                <div id="welcome-message">
                    <h3>Hello! & Welcome to WhereWeAllMeet.com</h3>
                    <p>
                        My name is Rachel, and I'm your support on whereWeAllMeet.com! I'll be working with you to help
                        you around the site and to organize any events, getaways or dating packages you find interesting
                        on whereWeAllMeet.com. You can send me a message any time and I'll try to assist you with any
                        questions you may have.

                        For 1 on 1 attention you can upgrade to one of our dating agents! They will work directly with you
                        in assisting you in your quest for the perfect match, getaway or night out on the town with your
                        friends, colleagues or significant other.
                    </p>
                </div>
                <div id="get-started-today">
                    <a>GET STARTED TODAY - IT ONLY TAKES 1 MINUTE </a>
                </div>
                <div id="additional-info">
                    <p class="signup">Signup is free.</p>
                    <p>You can invite your friends with their email address to chat, message and organize
                        events vacations and dating options all for free.</p>
                </div>
                <?php echo Asset::img('line_end.png', array('class' => 'line-end')); ?>
            </div>
            <div id="complete-profile-content" class="inactive">
                <div id="complete-profile-container">
                    <h3>Hello! & Welcome to WhereWeAllMeet.com</h3>
                    <?php echo Form::open(array("action" => "profile/update", "enctype" => "multipart/form-data", "class" => "")) ?>
                    <div id="form-inner-container">
                        <div>
                            <p>Where are you located?</p>
                            <p>
                                <input type="text" name="city" placeholder="City..." />
                                <select class="state-field" name="state">
                                    <option value="" class="empty-text" selected>State...</option>
                                    <?php foreach ($state as $item) : ?>
                                        <option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="zip" placeholder="Zip/Postal"/>
                            </p>
                        </div>
                        <div>
                            <p>When's your birthday?</p>
                            <select class="month-field" name="month">
                                <option value="" class="empty-text" selected>Month...</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select class="day-field" name="day">
                                <option value="" class="empty-text" selected>Day...</option>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select class="year-field" name="year">
                                <option value="" class="empty-text" selected>Year...</option>
                                <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <p>Tell me about your occupation and hobbies? Be impressive!</p>
                            <textarea name="about_me"></textarea>
                            <p class="gray-text">The more you write, the easier it is for others to get to know you're interests. Minimum 80 Characters</p>
                        </div>
                        <div id="upload-button-container" class="clearfix">
                            <div class="left">
                                <p class="field-header">Upload a Profile Pic <span>(optional)</span></p>
                                <input hidden="true" type="file" id="profile-picture" name="picture" size="1"/>
                                <span class="file-name">No file selected</span>
                                <a id="profile-upload-button" class="upload-button">Upload</a>
                            </div>
                            <div class="right">
                                <span>(We strongly suggest that you upload a picture that captures your personality. People are visual, they like to see others.)</span>
                            </div>
                        </div>
                    </div>
                    <div id="finish-button-container">
                        <a>I'M FINISHED</a>
                    </div>
                    <?php echo Form::close();?>
                </div>
                <?php echo Asset::img('line_end.png', array('class' => 'line-end')); ?>
            </div>

            <?php echo Asset::img('hi_circle.png', array('class' => 'hi-circle')); ?>
        </div>
        <div id="finish-container" class="inactive">
            <div id="finish-content">
                <p class="top">Thank You For Joining <i class="blue">Where</i><i class="pink">We</i><i class="green">All</i><i class="yellow">Meet</i>.com!!</p>
                <p class="bottom">You can complete more detailed information about yourself in your profile settings</p>
            </div>
            <?php echo Asset::img('line_end.png', array('class' => 'line-end')); ?>
            <?php echo Asset::img('thumbs_up_circle.png', array('class' => 'thumbs-up-circle')); ?>
        </div>
    </div>
</div>