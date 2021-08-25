<div class="wrapper">

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'header-bgcolor')); ?>
    <div class="container" >

        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><?php echo Asset::img('pages/home2/logo.png'); ?></a>
        </div>
        <div class="hidden-md-block hidden-lg-block header-clr"></div>
        <div class="col-md-7 header-link">
            <p>Join <span class="light-blue">Where</span><span class="pink">We</span><span class="light-grn">All</span><span class="yellow">Meet</span>.com & Find Your Vacation Package Today!</p>
        </div>
    </div> <!-- end container -->
    <!-- phone header
    <div class="container-fluid hidden-md hidden-lg phone-header">
        <img src="img/logo-large.jpg" />
      <div class="clearfix"></div>

      <p>Join <span class="light-blue">Where</span><span class="pink">We</span><span class="light-grn">All</span><span class="yellow">Meet</span>.com & Find Your Vacation Package Today!</p>
    </div>-->

</div> <!-- end navbar -->

<div class="container-fluid row row1">
    <?php echo Asset::img('pages/home2/vacation-bg.jpg', array('class' => 'row-bg visible-md-block visible-lg-block')); ?>
    <div class="container">
        <div class="signup-form">
            <h4 class="signup-title"><span class="light-blue">CREATE</span> <span class="pink">YOUR</span> <span class="light-grn">ACCOUNT</span><span class="yellow"> NOW</span></h4>
            <hr/>
            <?php echo Form::open(array("action" => "users/sign_up", "class" => "form-inline", "role" => "form")) ?>
            <div class="signup-label pull-left"><span>Gender:</span></div>
            <select class="signup-input gender form-control pull-left" name="gender_id">
                <option value="1">male</option>
                <option value="2">female</option>
            </select>
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>Birth Date:</span></div>
            <select class="signup-margin days form-control pull-left" name="month">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <select class="signup-margin days form-control pull-left" name="day">
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <select class="form-control year pull-left" name="year">
                <?php for ($i = date('Y') - 18; $i >= 1915; $i--): ?>
                    <option><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>State:</span></div>
            <select class="form-control gender pull-left" name="state">
                <option value="">Please Select</option>
                <?php foreach ($state as $item) : ?>
                    <option value="<?php echo $item->name; ?>"><?php echo $item->name; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Perfered Ages:</span></div>
            <select class="signup-margin ages form-control pull-left" name="ages_from">
                <?php for ($i = 18; $i <= 99; $i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                <?php $i = 18; ?>
            </select>
            <span class="pull-left signup-margin">to</span>
            <select class="form-control ages pull-left" name="ages_to">
                <?php for ($i = 18; $i <= 99; $i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                <?php $i = 18; ?>
            </select>
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*First Name:</span></div>
            <input type="text" name="first_name" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Last Name:</span></div>
            <input type="text" name="last_name" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Email:</span></div>
            <input type="text" name="email" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Username:</span></div>
            <input type="text" name="username" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Password:</span></div>
            <input type="password" name="password" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <div class="signup-label pull-left"><span>*Confirm:</span></div>
            <input type="password" name="confirm_password" class="form-control sinput pull-left" />
            <div class="clearfix spacer"></div>
            <hr style="margin:2px 0;"/>
					    <span class="signup-text"><b><span class="black">By signing up you agree to the </span><span class="pink">Terms of Use </span>
                                <span class="black">and the </span><span class="pink">Privacy Policy</span></b></span>
            <p><input class="promo" name="promo-code" placeholder="Promo Code" />
                <button name"submit" type="submit" class="btn btn-primary">Get Started Now</button>
            </p>
            <?php echo Form::close();?>
        </div><!-- end of signup form -->
    </div>
</div> <!--end row1 -->

<div class="container-fluid main">
    <div class="container">
        <h3 class="header-text" align="center">Our Group Travel packages includes: All inclusive Accomodations</h3>
        <?php echo Asset::img('pages/home2/color.jpg', array('style' => 'width:100%;height:1px;')); ?>
        <div class="col-md-4">
            <h3 class="light-blue" align="center">WE PLAN...YOU RELAX</h3>
            <?php echo Asset::img('pages/home2/vacation01.jpg'); ?>
        </div>
        <div class="col-md-4">
            <h3 class="pink" align="center">CUSTOM GROUP TRIPS</h3>
            <?php echo Asset::img('pages/home2/vacation02.jpg'); ?>
        </div>
        <div class="col-md-4">
            <h3 class="light-grn" align="center">FOR EVERYBODY</h3>
            <?php echo Asset::img('pages/home2/vacation03.jpg'); ?>
        </div>
        <div class="col-md-12">
            <h4 class="sub-text">
                Looking for inspiration on where to visit on your next trip?
                <span class="light-blue">Where</span><span class="pink">We</span><span class="light-grn">All</span><span class="yellow">Meet</span>.com has organized a roster of exciting group Vacation packages geared to offer our members an adventurous place to meet and mingle with other members of <span class="light-blue">Where</span><span class="pink">We</span><span class="light-grn">All</span><span class="yellow">Meet</span>.com
            </h4>
        </div>
        <div class="clearfix"></div>
        <div class="signup">
            <p><span class="big-text">Sign Up Now and Take Advantage of these Exciting Travel packages</span>
                <a class="sign-btn" href="#">SIGN UP</a></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div> <!--end main -->



<div class="container footer">
    <div class="footer-link col-md-4 pull-right">
        <p><a href="#">Blog </a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#privacy">Privacy</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="#" data-toggle="modal" data-target="#terms">Terms & Agreement</a> </p>
    </div>
    <div class="visible-xs clearfix"></div>
    <div class="col-md-8"> <p>&copy; 2014 Where We All Meet </p></div>

</div>
<?php echo Asset::img('pages/home2/color.jpg', array('class' => 'footer-color')); ?>
</div>
<!-- end footer -->

<!-- Modal Privacy -->
<div class="modal fade" id="privacy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Privacy Policy</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php include('privacy.php'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal terms and agreement -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <?php echo Asset::img('pages/home2/mini.png', array('align' => 'right')); ?>
                <h3 class="modal-title" id="myModalLabel">WhereWeAllMeet.com Terms of Use</h3>

            </div>
            <div class="modal-body modal-privacy">
                <p><?php include('agreement.php'); ?></p>
            </div>
        </div>
    </div>
</div>