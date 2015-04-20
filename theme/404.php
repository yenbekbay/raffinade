<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset=<?php bloginfo('charset'); ?>" />

<title><?php _e('Page Not Found' , 'exultic');  echo " | "; bloginfo('name');?></title>
<?php exultic_favicon(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/error404.css" type="text/css" media="screen" />
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
</head>

<body class="error404">
 <div id="content">
 
 <?php exultic_logo(); ?>
 
 <div id="info">
 
 <h1 class="entry-title"><?php _e('Page Not Found' , 'exultic'); ?></h1>
 
 <div class="entry-content">
  <p><a href="<?php echo home_url(); ?>">&larr; <?php _e( 'Return to ' , 'exultic' ); bloginfo('name'); ?></a></p>
 </div>
 
 </div>
 <div class="clear"></div>
 </div>
</body>

</html>
