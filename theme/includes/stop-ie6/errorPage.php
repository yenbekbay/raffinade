<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?></title>
<?php exultic_favicon(); ?>
<link rel="stylesheet" media="all" href="<?php echo get_template_directory_uri(); ?>/css/errorIE.css"/>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<?php wp_head(); ?>
</head>

 <body class="ie_error">
 <div id="content">
 
 <?php exultic_logo(); ?>
 
 <div id="info">
 
 <div class="entry-content">
   <div class="intro">
    <?php _e('It looks like you are still using Internet Explorer 7 or earlier, which is not supported by this website. Please update to a cooler browser:', 'exultic'); ?>
   </div>
   <ul id="icons">
    <li><a href="http://www.mozilla.com/firefox/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/firefox.png" alt="Firefox" /></a></li>
    <li><a href="http://www.apple.com/safari/download/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/safari.png" alt="Safari" /></a></li>
    <li><a href="http://www.google.com/chrome/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/chrome.png" alt="Chrome" /></a></li>
    <li><a href="http://www.opera.com/download/"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/opera.png" alt="Opera" /></a></li>
    <li><a href="http://www.microsoft.com/windows/internet-explorer/default.aspx"><img src="<?php echo get_template_directory_uri(); ?>/includes/stop-ie6/images/ie.png" alt="Internet Explorer 8" /></a></li>
   </ul>
 </div>
 
 </div>
 </div>
 </body>
</html>