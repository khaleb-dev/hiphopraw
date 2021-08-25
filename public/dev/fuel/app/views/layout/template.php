<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<?php if(!isset($home_page)): ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="<?php echo Uri::create(Asset::find_file('favicon.ico', 'img')); ?>" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta name="keywords" content="DATING SITE, SOCIAL PLATFORM, DATING VIP VACATIONS, EVENTS, WOMEN, MEN, INTERNET DATING, SEARCH ENGINE, DATING CONCIERGE AGENT">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <?php echo Asset::css('normalize.css'); ?>
        <?php echo Asset::css('font-awesome.min.css'); ?>
        <?php echo Asset::css('flowplayer/minimalist.css'); ?>
        <?php echo Asset::css('style.css'); ?>
        <?php echo Asset::css('chat.css'); ?>
        <?php echo Asset::css('slimbox2.css'); ?>
        <?php echo Asset::css('jquery-ui.css'); ?>
        <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>

        <?php echo Asset::js('modernizr-2.6.2.min.js'); ?>
        <?php echo Asset::js('jquery-1.10.2.min.js'); ?>
        <?php echo Asset::js('jquery-ui.min.js'); ?>
        <script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="/chat_server/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js" type="text/javascript"></script>
        <script src="/chat_server/node_modules/node-uuid/uuid.js" type="text/javascript"></script>
        <?php echo Asset::js('facescroll.js'); ?>

        <?php echo Asset::js('jtmyw.js'); ?>
        <?php echo Asset::js('flowplayer/flowplayer.js'); ?>
        <?php echo Asset::js('slimbox2.js'); ?>
        <?php echo Asset::js('chat.js'); ?>
        <?php echo Asset::js('member_interaction.js'); ?>
        <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="wrapper">
            <?php echo isset($home_page) ? "" : View::forge("layout/partials/header"); ?>
            <?php echo isset($home_page) ? "" : View::forge("layout/partials/navigation"); ?>
            <?php echo View::forge("layout/partials/flash"); ?>
            <?php echo $content; ?>
            <?php echo View::forge("layout/partials/footer"); ?>
        </div>       

    </body>
<?php else: ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="<?php echo Uri::create(Asset::find_file('favicon.ico', 'img')); ?>" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <meta name="keywords" content="DATING SITE, SOCIAL PLATFORM, DATING VIP VACATIONS, EVENTS, WOMEN, MEN, INTERNET DATING, SEARCH ENGINE, DATING CONCIERGE AGENT">

        <?php echo Asset::css('pages/bootstrap.min.css'); ?>
        <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>

        <?php echo Asset::js('jquery-1.10.2.min.js'); ?>
        <?php //echo Asset::js('pages/bootstrap.min.js'); ?>
        <?php echo Asset::js('pages/home.js'); ?>
        <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>

    </head>
    <body>
        <?php echo $content; ?>
    </body>
<?php endif; ?>
</html>
