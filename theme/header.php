<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="robots" content="index, follow"/>
<meta name="description" content="<?php echo exultic_description(); ?>"/>
<meta name="keywords" content="<?php exultic_keywords(); ?>"/>
<meta name="viewport" content="width=1045"/>
<?php exultic_opengraph_tags(); ?>

<title><?php exultic_title(); ?></title>
<?php exultic_enqueue_styles(); ?>
<?php exultic_favicon(); ?>
<?php exultic_apple_icon(); ?>
<?php exultic_site_image(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
<link rel='alternate' type='application/rss+xml' title='<?php bloginfo('name'); ?> - Feed' href='<?php bloginfo('rss2_url'); ?>'/>
<?php if(is_single()) { ?>
<link rel='alternate' type='application/rss+xml' title='<?php bloginfo('name'); ?> - <?php the_title(); ?> Comments Feed' href='<?php the_permalink(); ?>feed'/>
<?php } ?>
<!--[if lte IE 8]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header> 
 <div id="header-wrapper">
 
 <div id="search-header">
  <?php get_search_form(); ?>
 </div>
 
 <?php exultic_login(); ?>
 
 <?php exultic_logo(); ?>
 
 <nav id="mainnav" class="clearfix">
  <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'menu_class' => 'menu','fallback_cb' => 'default_menu', 'menu_id' => 'primary-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s">'."\n".'  %3$s</ul>'."\n", 'walker' => new Cleaner_Walker_Nav_Menu() )); ?>
 </nav>
 
 </div>
</header>

<?php facebook_js(); ?>
