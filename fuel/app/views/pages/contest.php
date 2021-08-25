
<div id="center" class="container">
    <input type="hidden" id="page" value="CONTEST WINNERS" />

<?php if(count($banners) > 0): ?>
        <div class="header-slider" style="background-color:#f1f1f1">
            <div id="left">
                <a href="#" data-direction="left"><?php echo Asset::img('left-slide-arrow.png'); ?> </a>
            </div>
            <div id="visible-top-videos">
                <div id="top-videos-items" class="clearfix" data-left="0">
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('slide-image1.png'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "http://www.whereweallmeet.com">--><?php ////echo Asset::img('wwambanner.jpg'); ?><!-- </a>-->
<!--                        <a href = "#">--><?php ////echo Asset::img('hhr1.jpg'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('top100ad.jpg'); ?><!-- </a>-->
<!--                    </div>-->
                    <?php foreach ($banners as $banner) : ?>
                        <div id="main-image">
                            <a href="<?php echo $banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($banner)) ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="right">
                <a href="#" data-direction="right"><?php echo Asset::img('right-slide-arrow.png'); ?> </a>
            </div>
            <div></div>
        </div>
    <?php endif; ?>
    
<div id="content">
    <div class="title clearfix" >
                <p class="pull-left main-title">HHR <span class="red">CONTEST</span></p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>
    </div>
<div class="clearfix"></div>
<div id ="videos-container">
<div class="inner-wrapper">
<div class="vid-con pull-left">
<?php echo Asset::img("contest/hpr-vids.png"); ?>
<a class="enter-link" href="<?php echo Uri::create('pages/contest_winners') ?>">Enter</a>
</div>
<div class="model-con pull-right">
<?php echo Asset::img("contest/hhr-models.png"); ?>
<a class="enter-link" href="<?php echo Uri::create('pages/contest_winners') ?>">Enter</a>
</div>
<div class="clearfix"></div>
</div>
</div>
<div class="clearfix"></div>
 

</div>
 </div>

    <div class="clearfix"></div>