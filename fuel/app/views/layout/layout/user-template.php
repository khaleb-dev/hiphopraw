<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <?php echo Asset::css('template/user-template.css'); ?>
    <?php echo Asset::css('bootstrap.min.css'); ?>
    <?php echo Asset::css('users/sign_up.css'); ?>
    <?php echo Asset::css('tools/datepicker.css'); ?>
    <?php echo Asset::css('tools/bootstrap-datetimepicker.min.css'); ?>
    <?php echo Asset::css('font-awesome.min.css'); ?>
    <?php echo Asset::css('font-awesome-ie7.min.css'); ?>
    <?php echo Asset::css('flowplayer/minimalist.css'); ?>
   
    <?php echo Asset::css('smoothness/jquery-ui-1.10.3.custom.min.css'); ?>
    <?php echo Asset::css('jquery-ui.css'); ?>
    <?php echo Asset::css('slimbox2.css'); ?>
    <?php echo Asset::css('style.css'); ?>
    <?php echo Asset::css('chat.css'); ?>
    <?php echo Asset::css('videokes/index.css'); ?>
    <?php echo isset($template_css) ? Asset::css($template_css) : ""; ?>
    <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>

    
    <?php echo Asset::js('modernizr-2.6.2.min.js'); ?>
    <?php echo Asset::js('jquery-1.11.1.min.js'); ?>   
    <?php echo Asset::js('jquery-ui.min.js'); ?>
    <?php// echo Asset::js('jquery-ui-1.10.3.custom.min.js'); ?>
   
    <?php echo Asset::js('jquery.form.min.js'); ?>
    <?php echo Asset::js('bootstrap.min.js'); ?>
    <?php echo Asset::js('user_template.js'); ?>
    
    <?php echo Asset::js('facescroll.js'); ?>
    <?php echo Asset::js('tools/bootstrap-datepicker.js'); ?>
    <?php echo Asset::js('tools/bootstrap-datetimepicker.min.js'); ?>

    <script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="/chat_server/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js" type="text/javascript"></script>
    <script src="/chat_server/node_modules/node-uuid/uuid.js" type="text/javascript"></script>
    
    <!--    -->
    <?php echo Asset::js('jsmvk.js'); ?>
    <?php echo Asset::js('chat.js'); ?>

    <!--    -->
    <?php echo Asset::js('flowplayer/flowplayer.js'); ?>
    <!--    -->
    <?php echo Asset::js('slimbox2.js'); ?>
    <?php echo Asset::js('featured_videos.js'); ?>
    

    <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>

    <script type="text/javascript">
      window.heap=window.heap||[],heap.load=function(t,e){window.heap.appid=t,window.heap.config=e;
        var a=document.createElement("script");
        a.type="text/javascript",a.async=!0,a.src=("https:"===document.location.protocol?"https:":"http:")+"//cdn.heapanalytics.com/js/heap.js";
        var n=document.getElementsByTagName("script")[0];
        n.parentNode.insertBefore(a,n);
    for(var o=function(t){return function(){heap.push([t].concat(Array.prototype.slice.call(arguments,0)))}},p=["clearEventProperties","identify","setEventProperties","track","unsetEventProperty"],c=0;
        c<p.length;
        c++)heap[p[c]]=o(p[c])};
      heap.load("777704730");
</script> 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66787021-1', 'auto');
  ga('send', 'pageview');

</script>

    
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
    improve your experience.</p>
<![endif]-->

<div id="notification-container">
    <div class="detail">
        <h3></h3>

        <p></p>
        <i class="icon-remove-circle"></i>
    </div>
</div>
<div id="container">
    <?php echo View::forge("layout/partials/user-header"); ?>
     <?php echo View::forge("layout/partials/flash"); ?>
    <?php echo $content; ?>
    <?php echo View::forge("layout/partials/user-footer"); ?>
</div>
</body>


</html>
