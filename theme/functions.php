<?php
	
/******************** SET UP ********************/

// Load translation domain
load_theme_textdomain('exultic', get_template_directory().'/languages');
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
	if( is_readable($locale_file ) )
		require_once($locale_file );

function raffinade() {
	// Add support for post thumbnails
	add_theme_support('post-thumbnails');
	add_image_size('slider-image', 580, 9999);
	// Add support for WP3 custom background
	add_theme_support('custom-background');
	// Register custom navigation menu
	register_nav_menus( array(
		'primary' => __('Primary Navigation', 'exultic'),
	) );	
	// Add support for Post Formats
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'video', 'image', 'quote', 'audio', 'chat'));
	// Set content width
	if(!isset($content_width)) $content_width = 600;
}
add_action('after_setup_theme', 'raffinade');

/******************** REGISTER WIDGETIZED AREA ********************/

// Register sidebars
function exultic_widgets_init() {
	register_sidebar( array (
		'name' => __('Main sidebar', 'exultic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Post sidebar', 'exultic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Page sidebar', 'exultic'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action('init', 'exultic_widgets_init');

/******************** INCLUDES ********************/

$options = get_option('exultic_post_options');
require_once(get_template_directory().'/includes/widgets/widget-flickr.php');
require_once(get_template_directory().'/includes/widgets/widget-most-commented.php');
if(!isset($options['disable_likes'])) require_once(get_template_directory().'/includes/widgets/widget-most-liked.php');
require_once(get_template_directory().'/includes/widgets/widget-post-formats.php');
require_once(get_template_directory().'/includes/widgets/widget-social-profiles.php');
require_once(get_template_directory().'/includes/widgets/widget-tweets.php');
if(!isset($options['disable_likes'])) require_once(get_template_directory().'/includes/likes.php');
require_once(get_template_directory().'/includes/outputs.php');
require_once(get_template_directory().'/includes/shortcodes.php');
if(is_admin()) require_once(get_template_directory().'/admin/theme-options.php');
require_once(get_template_directory().'/includes/stop-ie6/stopie6.php');

/******************** HOME LINK ********************/

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link
function exultic_page_menu_args($args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter('wp_page_menu_args', 'exultic_page_menu_args');

/******************** POST EXCERPT ********************/

// Improved Excerpt
function exultic_improved_trim_excerpt($text) {
	global $post;
	if('' == $text) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<p> <a> ');
		$excerpt_length = 50;
		$words = explode(' ', $text, $excerpt_length + 1);
		if(count($words)> $excerpt_length) {
		array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}
	}
	$content = get_the_content('');
	if(!is_feed) { return $text.'<div class="readmore"><a href="'.get_permalink().'"> '.__( 'Continue reading &rarr;', 'exultic' ).'</a></div> ';
	} else { 
		if($content != '') { return $text.'<div class="readmore"><a href="'.get_permalink().'"> '.__( 'Continue reading &rarr;', 'exultic' ).'</a></div> '; 
		} else { 
		return $text; }
	}
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'exultic_improved_trim_excerpt');

// Remove more jump link
function exultic_remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if($offset) {
		$end = strpos($link, '"',$offset);
	}
	if($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'exultic_remove_more_jump_link');

/******************** TEMPLATE FOR COMMENTS & PINGBACKS ********************/

function exultic_comment($comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ($comment->comment_type ) {
		case'':
	?>
 <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
 <div id="comment-<?php comment_ID(); ?>">
  <div class="comment-gravatar"><?php echo get_avatar($comment, 65 ); ?></div>
		
 <div class="comment-body">
  <div class="comment-meta commentmetadata"> 
  <?php printf( __('%s', 'exultic'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
  
  <span class="comment-date"><?php comment_date('d.m.Y') ?></span><br>
  <span class="comment-time"><?php comment_time() ?></span>
 </div>

 <?php comment_text(); ?>
		
 <?php if($comment->comment_approved =='0') : ?>
 <p class="moderation"><?php _e('Your comment is awaiting moderation.', 'exultic'); ?></p>
 <?php endif; ?>

 <div class="reply">
  <?php comment_reply_link( array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
 
 </div>
 <?php edit_comment_link( __('[edit]', 'exultic'), ''); ?>	
		
 </div>
		
 </div>

 <?php
  break;
   case'pingback' :
   case'trackback':
 ?>
 <li class="post pingback">
  <p><?php _e('Pingback:', 'exultic'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('[edit]', 'exultic'), ''); ?></p>
 <?php
  break;
   }
}

/******************** WP ADMIN ********************/

// Remove WP logo from toolbar
function exultic_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
}
add_action('wp_before_admin_bar_render', 'exultic_remove_admin_bar_links');

// Edit admin footer link and remove version number
function exultic_change_footer_admin () {
	return '<a href="'. get_home_url().'" style="color: #999">© '.get_bloginfo('name').'</a> ';
}
add_filter('admin_footer_text', 'exultic_change_footer_admin', 9999);
function exultic_remove_footer_version() {
	return '';
}
add_filter('update_footer', 'exultic_remove_footer_version', 9999);

// Disable dashboard widgets
function exultic_disable_default_dashboard_widgets() { 
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
	remove_meta_box('dashboard_primary', 'dashboard', 'core');  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');  
}  
add_action('admin_menu', 'exultic_disable_default_dashboard_widgets');  

// Remove widgets
function exultic_unregister_widget() {
    unregister_widget('WP_Widget_Pages'); 
    unregister_widget('WP_Widget_Calendar'); 
    unregister_widget('WP_Widget_Meta');  
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud'); 
    unregister_widget('Akismet_Widget');
}
add_action('widgets_init', 'exultic_unregister_widget');

// Add admin area favicon
function exultic_admin_favicon() {
	$options = get_option('exultic_general_options');
	if($options['custom_favicon']) {
		$favicon_url = $options['custom_favicon'];
	} else {		
		$favicon_url = get_template_directory_uri().'/favicon.ico';
	}
	echo "\n".'<link rel="shortcut icon" href="'.$favicon_url.'"/>';
}
add_action('admin_head', 'exultic_admin_favicon');
add_action('login_head', 'exultic_admin_favicon');

// Highligt posts statuses
function exultic_posts_status_color(){
	echo '<style>
	.status-draft{ background: #FCE3F2!important; }
	.status-pending{ background: #87C5D6!important; }
	.status-future{ background: #C6EBF5!important; }
	.status-private{ background:#F2D46F!important; }
</style>'."\n";
}
add_action('admin_footer','exultic_posts_status_color');

// Add custom avatar
function exultic_custom_avatar($avatar_defaults) {
    $exultic_avatar = get_template_directory_uri().'/images/avatar.png';
    $avatar_defaults[$exultic_avatar] = get_bloginfo('name');
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'exultic_custom_avatar');

// Remove admin color scheme options
function exultic_remove_admin_color_scheme() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'exultic_remove_admin_color_scheme');

// Display post id column
function exultic_posts_columns_id($defaults){
    $defaults['exultic_post_id'] = 'ID';
    return $defaults;
}
function exultic_posts_custom_id_columns($column_name, $id){
    if($column_name === 'exultic_post_id'){
        echo $id;
    }
}
function exultic_posts_columns_attachment_id($defaults){
    $defaults['exultic_attachments_id'] = 'ID';
	return $defaults;
}
function exultic_posts_custom_columns_attachment_id($column_name, $id){
    if($column_name === 'exultic_attachments_id'){
        echo $id;
    }
}
add_filter('manage_posts_columns', 'exultic_posts_columns_id', 5);
add_action('manage_posts_custom_column', 'exultic_posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'exultic_posts_columns_id', 5);
add_action('manage_pages_custom_column', 'exultic_posts_custom_id_columns', 5, 2);
add_filter('manage_media_columns', 'exultic_posts_columns_attachment_id', 1);
add_action('manage_media_custom_column', 'exultic_posts_custom_columns_attachment_id', 1, 2);

// Display post attachment count column
function exultic_posts_columns_attachment_count($defaults) {
    $defaults['exultic_post_attachments'] = __('Attachments', 'exultic');
    return $defaults;
}
function exultic_posts_custom_columns_attachment_count($column_name, $id){
    if($column_name === 'exultic_post_attachments') {
		$attachments = get_children(array('post_parent'=>$id));
		$count = count($attachments);
		if($count !=0){
			echo $count;
		}
    }
}
add_filter('manage_posts_columns', 'exultic_posts_columns_attachment_count', 5);
add_action('manage_posts_custom_column', 'exultic_posts_custom_columns_attachment_count', 5, 2);

// Display media library URL column
function exultic_muc_column( $cols ) {
        $cols["media_url"] = "URL";
        return $cols;
}
function exultic_muc_value( $column_name, $id ) {
        if ( $column_name == "media_url" ) echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="'.wp_get_attachment_url( $id ).'"/>';
}
add_filter( 'manage_media_columns', 'exultic_muc_column' );
add_action( 'manage_media_custom_column', 'exultic_muc_value', 10, 2);

// Add styles for columns
function exultic_columns_styles() {
	echo "\n".'<style type="text/css">
    .column-exultic_post_id, .column-exultic_attachments_id { width: 50px; }
    .column-exultic_post_attachments { width: 100px; }
    .column-author { width: 130px!important; }
</style>'."\n";
}
add_action('admin_head', 'exultic_columns_styles');

/******************** WP LOGIN ********************/

// Add custom login title and link
function exultic_wp_login_url($url) {
    return home_url();
}
function exultic_wp_login_title() {
	return '';
}
add_filter('login_headerurl', 'exultic_wp_login_url');
add_filter('login_headertitle', 'exultic_wp_login_title');

// Add custom styles for login page
function exultic_custom_login() { 
	echo "\n".'<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/css/login.css" type="text/css" media="screen"/>'."\n";
}
add_action('login_head', 'exultic_custom_login');

// Add custom login logo
function exultic_login_logo() {
	$options = get_option('exultic_general_options');
	if($options['custom_logo']) {
		$logo_url = $options['custom_logo'];
	} else {		
		$logo_url = get_template_directory_uri().'/images/logo.png';
	}		
	if(!$options['plain_text_logo']) {
		echo "\n".'<style type="text/css">
    .login h1 a { background-image: url('.$logo_url.')!important; }
</style>'."\n";
	}		
}
add_action('login_head', 'exultic_login_logo');

// Allow login with email address
function exultic_login_with_email_address($username) {
    $user = get_user_by('email',$username);
    if(!empty($user->user_login))
        $username = $user->user_login;
    return $username;
}
add_action('wp_authenticate','exultic_login_with_email_address');
function exultic_username_text($text){
    if(in_array($GLOBALS['pagenow'], array('wp-login.php'))) {
        if ($text == 'Username') { $text = 'Username / Email'; }
		elseif ($text == 'Имя пользователя') { $text = 'Имя пользователя / Email'; }
    }
    return $text;
}
add_filter( 'gettext', 'exultic_username_text' );

// Change register to sign up
function exultic_register_text($text) {
     $text = str_ireplace('Register',  'Sign up',  $text);
     return $text;
}
add_filter('gettext', 'exultic_register_text');
add_filter('ngettext', 'exultic_register_text');

// Redirect after login & logout
function exultic_login_redirect($redirect, $request_redirect ) {
    if($request_redirect ==='')
        $redirect = home_url();
    return $redirect; 
}
add_filter('login_redirect', 'exultic_login_redirect', 10, 2 );

/******************** POST ADMIN ********************/

// Post Formats meta box
function exultic_post_formats($post) {
    remove_meta_box(
        'formatdiv',
        $post->post_type,
        'side'
    );
    add_meta_box(
       'exultic_formatdiv ',
        _x('Format', 'post format'),
       'exultic_format_meta_box',
        $post->post_type,
       'normal',
       'high'
    );
}
function exultic_format_meta_box($post, $box) {
	if( current_theme_supports('post-formats') && post_type_supports($post->post_type, 'post-formats')) {
		$post_formats = get_theme_support('post-formats');

		if( is_array($post_formats[0] ) ) {
			$post_format = get_post_format($post->ID );
			if(!$post_format)
				$post_format ='aside';
			if($post_format && !in_array($post_format, $post_formats[0]) )
				$post_formats[0][] = $post_format;
			echo '<style type="text/css">
	#post-formats-select { margin-top: 70px; }
	input.post-format { display: none;}
	input.post-format + label { display: block; width: 90px; float: left; margin: -60px 5px 0 0; padding-top: 60px; text-align: center; background: url('.get_template_directory_uri().'/images/admin-icons.png) no-repeat; opacity: 0.5; filter: alpha(opacity=50); transition: opacity 0.12s ease-out; -webkit-transition: opacity 0.12s ease-out; -moz-transition: opacity 0.12s ease-out; -o-transition: opacity 0.12s ease-out; }
	#post-formats-select label:hover { opacity: 0.7; filter: alpha(opacity=70); }
	input.post-format:checked + label { opacity: 1; filter: alpha(opacity=100); }
	input#post-format-gallery + label { background-position: -270px 0; }
	input#post-format-link + label { background-position: -450px 0; }
	input#post-format-video + label { background-position: -630px 0; }
	input#post-format-image + label { background-position: -360px 0; }
	input#post-format-quote + label { background-position: -540px 0; }
	input#post-format-audio + label { background-position: -90px 0; }
	input#post-format-chat + label { background-position: -180px 0; }
</style>
<div id="post-formats-select">'."\n";
			foreach ($post_formats[0] as $format) {
				echo '<input type="radio" name="post_format" class="post-format" id="post-format-'.esc_attr($format).'" value="'.esc_attr($format).'" '.checked($post_format, $format, false).'/> <label for="post-format-'.esc_attr($format).'">'.esc_html( get_post_format_string($format) ).'</label>';
			} echo '<br/>
</div>';
		} 
	}
}
add_action('add_meta_boxes_post', 'exultic_post_formats');
function exultic_filter_formats($terms, $post_id, $taxonomy) {
    if('post_format'!= $taxonomy) return $terms;
    if(empty($terms)) {
        $aside = get_term_by('slug', 'post-format-aside', 'post_format');
        if($aside) {
            $terms[] = $aside;
        } else {
            $term = wp_insert_term('post-format-aside', 'post_format');
            $terms[] = get_term($term['term_id'], 'post_format');
        }
    }
    return $terms;
}
add_filter('get_the_terms', 'exultic_filter_formats', 10, 3 );

// Publish post with empty title and empty content
function exultic_mask_empty($value) {
    if(empty($value))
        return ' ';
    return $value;
}
add_filter('wp_insert_post_data', 'exultic_unmask_empty');
function exultic_unmask_empty($data) {
    if ($data['post_title'] == ' ')
        $data['post_title'] = '';
    if ($data['post_content'] == ' ')
        $data['post_content'] = '';
    return $data;
}
add_filter('pre_post_title', 'exultic_mask_empty');
add_filter('pre_post_content', 'exultic_mask_empty');

// Remove Gallery Settings
function exultic_remove_gallery_settings() {
    echo '<style type="text/css">
            #gallery-settings * { display: none; }
        </style>'."\n";
}
add_action('admin_head_media_upload_gallery_form', 'exultic_remove_gallery_settings');

/******************** HEADER ********************/

// Meta Description
function exultic_description() {
	global $wp_query, $post;
	if(is_single() || is_page()) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text);
		$excerpt_length = 50;
		$words = explode(' ', $text, $excerpt_length + 1);
		if(count($words)> $excerpt_length) {
		array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}
		$description = $text;
	} elseif(is_category()) {
		$category = $wp_query->get_queried_object();
		$description = trim(strip_tags($category->category_description));
	} else {
		$description = trim(strip_tags(get_bloginfo('description')));
	}

	if($description) {
		return $description;
	}
}

// Meta Title
function exultic_title() {
	global $page, $paged;
		wp_title('|', true, 'right');
		bloginfo('name');
		if($paged >= 2 || $page >= 2)
			echo ' | '. sprintf(__('Page %s', 'exultic'), max($paged, $page));
}

// Meta Keywords
function exultic_keywords() {
	$posttags = get_the_tags();
	$options = get_option('exultic_seo_options');
	if($options['home_keywords']) {
		$blogtags = $options['home_keywords'];
	} else {
		$blogtags = get_bloginfo('name');
	}
	if(is_home() || is_page() || is_archive()) {
		echo $blogtags;
	} else { 
		if($posttags) {
			foreach($posttags as $tag) {
				echo ($tag->name);
			}
		} else {
			echo $blogtags;
		}			
	}
}
// Facebook OpenGraph Meta Tags
function exultic_opengraph_tags() {
	$seo_options = get_option('exultic_seo_options');
	if($seo_options['opengraph']) {
		$gen_options = get_option('exultic_general_options');
		if($gen_options['custom_logo']) {
			$image = $gen_options['custom_logo'];
		} else {		
			$image = get_template_directory_uri().'/images/logo.png';
		}			
        if($seo_options['fb_appid']) { 
			echo '<meta property="fb:app_id" content="'.$seo_options['fb_appid'].'"/>'."\n"; 
		} elseif($seo_options['fb_admins']) {
			echo '<meta property="fb:admins" content="'.$seo_options['fb_admins'].'"/>'."\n"; 
		} 
        echo '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>'."\n";
		echo '<meta property="og:description" content="'.exultic_description().'"/>'."\n";
        global $post;
        if (is_singular()) {
            echo '<meta property="og:type" content="article"/>'."\n";
			echo '<meta property="og:title" content="'.get_the_title().'"/>'."\n";
            echo '<meta property="og:url" content="'.get_permalink().'"/>'."\n";
			if (has_post_thumbnail($post->ID)) {
				$feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );		
				echo '<meta property="og:image" content="'.esc_attr($feat_image[0]).'"/>'."\n";
			} else {
				echo '<meta property="og:image" content="'.$image.'"/>'."\n";
			}
        }
        if ( is_home() ) {
            echo '<meta property="og:type" content="website"/>'."\n";
            echo '<meta property="og:url" content="'.home_url().'"/>'."\n";
            echo '<meta property="og:image" content="'.$image.'"/>'."\n";
        }
	}
}

// Remove meta from wp_head
remove_action('wp_head', 'feed_links_extra', 3); 
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

// Enqueue stylesheets
function exultic_enqueue_styles() {
	echo '<link rel="stylesheet" media="all" href="'.get_bloginfo('stylesheet_url').'"/>'."\n";
	echo '<link rel="stylesheet" media="all" href="'.get_template_directory_uri().'/css/prettyPhoto.css"/>'."\n";
	echo '<link rel="stylesheet" media="all" href="'.get_template_directory_uri().'/css/mediaelementplayer.css"/>'."\n";
}
	
// Enqueue scripts
function exultic_enqueue_scripts() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js');
	wp_register_script('jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', 'jquery', '2.1');
	wp_register_script('jplayer_playlist', get_template_directory_uri() . '/js/jplayer.playlist.min.js', 'jquery', '2.1');
	wp_register_script('slides', get_template_directory_uri() . '/js/slides.min.jquery.js', 'jquery', '1.1.9');
	wp_register_script('prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', 'jquery', '3.1.3');
	wp_register_script('mediaelement', get_template_directory_uri() . '/js/mediaelement-and-player.min.js', 'jquery', '2.9.1');
	wp_register_script('superfish', get_template_directory_uri() . '/js/jquery.superfish.js', 'jquery', '1.4.8');
	wp_register_script('respond', get_template_directory_uri() . '/js/respond.min.js', '', '1.1', TRUE);
	wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', '');
		
	wp_enqueue_script('jquery');
	wp_enqueue_script('custom');
	wp_enqueue_script('superfish');
	wp_enqueue_script('prettyphoto');
	if(is_page_template('audio.php') || !is_page()) {
		wp_enqueue_script('jplayer');
		wp_enqueue_script('jplayer_playlist');
	}
	if(!is_page()) wp_enqueue_script('slides');
	wp_enqueue_script('mediaelement');
	wp_enqueue_script('respond');
	if(is_singular()) wp_enqueue_script( 'comment-reply' );
	$options = get_option('exultic_seo_options');
	if($options['twitter']) {
		echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>'."\n";
	} if($options['plusone']) {	
		echo '<script src="https://apis.google.com/js/plusone.js"> {lang: "en"} </script>'."\n";
	}	
}
add_action('wp_enqueue_scripts', 'exultic_enqueue_scripts');

// Favicon
function exultic_favicon() {
	$options = get_option('exultic_general_options');
	if($options['custom_favicon']) {
		$favicon_url = $options['custom_favicon'];
	} else {		
		$favicon_url = get_template_directory_uri().'/favicon.ico';
	}
	echo '<link rel="shortcut icon" href="'.$favicon_url.'"/>'."\n";
}

// Apple touch icon
function exultic_apple_icon() {
	$options = get_option('exultic_general_options');
	if($options['custom_apple_icon']) {
		$apple_icon_url = $options['custom_apple_icon'];
	} else {		
		$apple_icon_url = get_template_directory_uri().'/images/apple-touch-icon.png';
	}
	echo '<link rel="apple-touch-icon-precomposed" href="'.$apple_icon_url.'"/>'."\n";
}

// Site image
function exultic_site_image() {
	$options = get_option('exultic_general_options');
	if($options['custom_logo']) {
		$image_url = $options['custom_logo'];
	} else {		
		$image_url = get_template_directory_uri().'/images/logo.png';
	}
	echo '<link rel="image_src" href="'.$image_url.'"/>'."\n";
}

// Body class
function exultic_body_classes($classes) {
	if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) $classes[] = 'ie'.$browser_version[1];
	return $classes;
}
add_filter('body_class','exultic_body_classes');

// Logo
function exultic_logo() {
	$options = get_option('exultic_general_options');
	if(isset($options['plain_text_logo'])) {
		echo '<a id="logo" href="'.get_home_url().'"><h1>'.get_bloginfo('name').'</h1></a>';
	} else {
		if($options['custom_logo']) {
			$logo_url = $options['custom_logo'];
		} else {		
			$logo_url = get_template_directory_uri().'/images/logo.png';
		}
		echo '<a id="logo" href="'.get_home_url().'">
  <img src="'.$logo_url.'" alt="'.get_bloginfo('name').'"/>
 </a>'."\n";
	}
}

// Header login block
function exultic_login() {
	$options = get_option('exultic_general_options');
	global $current_user;
	if($options['header_login']) {
		echo '<div id="header-login">'."\n";
		if (is_user_logged_in()) {
		echo '  <a href="'.home_url().'/wp-admin/"><strong>';
		if ( isset($current_user) ) {
			echo $current_user->user_login;
		}
		echo '</strong></a>
  <span>/</span>
  <a href="'.wp_logout_url(home_url()).'">'.__('Log out', 'exultic').'</a>'."\n";
		} else {
		echo '  <a href="'.wp_login_url(home_url()).'"><strong>'.__('Log in', 'exultic').'</strong></a>
  <span>'.__('or', 'exultic').'</span>
  <a href="/wp-login.php?action=register">'.__('Sign up', 'exultic').'</a>'."\n";
		}
		echo ' </div>'."\n";
	}
}

// Facebook JS
function facebook_js() {
	$options = get_option('exultic_seo_options');
	if($options['facebook']) {
	echo '<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs); }(document, "script", "facebook-jssdk"));
</script>'."\n";
	}
}

/******************** POST ********************/

// Post title
function exultic_post_title($postid) {
	$post_title = get_post_meta($postid, '_exultic_post_title', true); 
	if((get_the_title($postid) != '') && ($post_title == 'on')) {
		echo '<h2 class="entry-title">';
		if(!is_single()) { 
			echo '<a href="'.get_permalink($postid).'" rel="bookmark">'.get_the_title($postid).'</a></h2>';
		} else { 
			echo get_the_title($postid).'</h2>';
		} 
	}
} 

// Page title
function exultic_page_title($pageid) {
	$page_title = get_post_meta($pageid, '_exultic_page_title', true); 
	if((get_the_title($pageid) != '') && ($page_title == 'off')) {
		echo '<h2 class="entry-title">';
		echo get_the_title($pageid).'</h2>';
	}
} 

// Page hr
function exultic_page_hr($pageid) {
	$page_title = get_post_meta($pageid, '_exultic_page_title', true); 
	if($page_title == 'off') {
		echo '<hr>';
	}
} 

// Post inner div fix
function exultic_entry_style($postid) {
	$post_title = get_post_meta($postid, '_exultic_post_title', true); 
	if((get_the_title($postid) != '') && ($post_title == 'on')) { 
		echo 'style="margin: 0"';
	}
}

// Post entry content
function exultic_entry_content($postid) {
	$post_content = get_post_meta(get_the_ID(), '_exultic_post_content', true);
	if(is_single()) {
		the_content();
	} else {
		if($post_content == 'excerpt') {
			the_excerpt();
		} else {
			the_content(__('Continue Reading &rarr;', 'exultic')); 
		}
	}
}

// Post Tags
function exultic_tags($postid) {
	$options = get_option('exultic_post_options');
	if(isset($options['show_tags'])) {
		$tags = get_the_tags($postid);
		if ($tags) {
			echo "\n".'  <div class="post-tags">Tagged: ';
			$i = 1;
			$count = count($tags);
			foreach ($tags as $tag){
				$tag_link = get_tag_link($tag->term_id);
				echo "\n".'   <a href="'.$tag_link.'">';
				echo $tag->name.'</a>';
				if(($count > 1) && ($i != $count)) echo ',';
				$i++;
			}
			echo "\n".'  </div>';
		}
	}
} 

// Post comments count
function exultic_comments_count($postid) {
	$options = get_option('exultic_post_options');
	if(!isset($options['hide_comments_count'])) {
		if (comments_open($postid)) {
			echo '<a class="comments-count" href="'.get_permalink($postid).'#comments" title="'.__('View comments', 'exultic').'">'.get_comments_number($postid).'</a>';
		}
	}
} 

// Post likes count
function exultic_likes($postid) {
	$options = get_option('exultic_post_options');

	if(!isset($options['disable_likes'])) {
		$likes = exultic_like($postid);
		if(isset($_COOKIE["like_" . $postid])) {
			echo '<div class="likes-count active">'.$likes.'</div>';
			return;
		}
		echo '<a class="likes-count" href="#" id="like-'.$postid.'" title="'.__('I like it!', 'exultic').'">'.$likes.'</a>';
	}
}

// Social share buttons
function exultic_share($postid) {
	$options = get_option('exultic_seo_options');
	$twitter = $options['twitter'];
	$facebook = $options['facebook'];
	$plusone = $options['plusone'];	
	if($options['twitter_username']) {
		$twitter_username = 'date-via="'.$options['twitter_username'].'"';
	}
	if($twitter || $facebook || $plusone || ($bitlyid & $bitlyapi)) {
		echo "\n".'  <div class="share-bubble">
   <a class="action-icon"></a>
   <div class="popover">'."\n";
		if($twitter) {
		echo '    <div class="bt_twitter">
     <a href="https://twitter.com/share" class="twitter-share-button" data-text="'.get_the_title($postid).'" data-url="'.get_permalink($postid).'" '.$twitter_username.' data-lang="en">Tweet</a>
    </div>'."\n";
	}
		if($facebook) {
		echo '    <div class="bt_facebook">
     <div class="fb-like" data-href="'.get_permalink($postid).'" data-layout="button_count" data-send="false" data-width="82" data-show-faces="false"></div>
    </div>'."\n";
	}
		if($plusone) {
		echo '    <div class="bt_plusone">
     <div class="g-plusone" data-size="medium" data-href="'.get_permalink($postid).'"></div>
    </div>'."\n";
	}
		echo shortlink($postid).'   
   </div>
  </div>'."\n";
	}
}
function exultic_page_share($pageid) {
	$page_sharing = get_post_meta($pageid, '_exultic_page_sharing', TRUE);
	if($page_sharing != 'on')
		exultic_share($pageid);
}

// Bit.ly shortlinks
function shortlink($postid) {
	$options = get_option('exultic_post_options');
	$bitlyid = $options['bitly_id'];
	$bitlyapi = $options['bitly_api'];
	$url = get_permalink($postid);
	if($bitlyid && $bitlyapi) {
		$content = file_get_contents("http://api.bit.ly/v3/shorten?login=".$bitlyid."&apiKey=".$bitlyapi."&longUrl=".$url."&format=xml");
		$element = new SimpleXmlElement($content);
		$bitly = $element->data->url;
		$bitly = preg_replace('#^https?://#', '', $bitly);
		echo '    <input class="shortlink" type="text" onclick="jQuery(this).select();" value="'.$bitly.'"/>';
	}
}
	
/******************** FOOTER ********************/

// Footer text
function footer_text() {
	$options = get_option('exultic_general_options');
	if($options['footer_text']) {
		$footer_text = $options['footer_text'];
	} else {		
		$footer_text = '© '.date('Y').', <a href="'.get_home_url().'">'.get_bloginfo('name').'</a>.';
	}
	echo '<p>'.$footer_text.'</p>'."\n";
}

// Output the tracking code
function exultic_tracking_code_output(){
    $options = get_option('exultic_general_options');
    if($options['tracking_code'])
        echo $options['tracking_code'];
}
add_action('wp_footer', 'exultic_tracking_code_output');

/******************** CSS ********************/

// Special styles
function exultic_special_styles() {
	$seo_options = get_option('exultic_seo_options');
	$post_options = get_option('exultic_post_options');
	$twitter = $seo_options['twitter'];
	$facebook = $seo_options['facebook'];
	$plusone = $seo_options['plusone'];
	$bitlyid = $post_options['bitly_id'];
	$bitlyapi = $post_options['bitly_api'];	
	$comments = isset($post_options['hide_comments_count']);
	$likes = isset($post_options['disable_likes']);
	if(($twitter & $facebook & $plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .popover { top: -95px; }
	#entries .share-bubble:hover .popover { top: -110px; }
</style>'."\n";	
	if(($twitter || $facebook || $plusone) && !($twitter & $facebook) && !($facebook & $plusone) && !($twitter & $plusone) && !($twitter & $facebook & $plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .popover { top: -45px; }
	#entries .share-bubble:hover .popover { top: -55px; }
	#entries .share-bubble .popover .bt_plusone { padding-top: 1px; }
	#entries .share-bubble .popover .bt_twitter { margin-bottom: -12px; }
</style>'."\n";
	if(($twitter || $facebook || $plusone) && !($twitter & $facebook) && !($facebook & $plusone) && !($twitter & $plusone) && !($twitter & $facebook & $plusone) && ($bitlyid & $bitlyapi))
	 echo '<style type="text/css">
	#entries .popover { top: -65px; }
	#entries .share-bubble:hover .popover { top: -80px; }
	#entries .share-bubble .popover .bt_plusone { padding-top: 1px; }
	#entries .share-bubble .popover .bt_twitter { margin-bottom: -12px; }
</style>'."\n";
	if((($twitter & $facebook) || ($facebook & $plusone) || ($twitter & $plusone)) & !($twitter & $facebook & $plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .popover { top: -65px; }
	#entries .share-bubble:hover .popover { top: -80px; }
</style>'."\n";
	if((($twitter & $facebook) || ($facebook & $plusone) || ($twitter & $plusone)) & !($twitter & $facebook & $plusone) && ($bitlyid & $bitlyapi))
	 echo '<style type="text/css">
	#entries .popover { top: -95px; }
	#entries .share-bubble:hover .popover { top: -110px; }
</style>'."\n";
	if($twitter & $plusone & !$facebook)
	 echo '<style type="text/css">
	#entries .share-bubble .popover .bt_plusone { padding-top: 0; }
</style>'."\n";
	if($comments && !$likes && ($twitter & $facebook & $plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .likes-count { right: 120px; }
</style>'."\n";
	if($comments && !$likes && (!$twitter & !$facebook & !$plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .likes-count { right: 110px; }
</style>'."\n";
	if(!$comments && $likes && (!$twitter & !$facebook & !$plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .comments-count { right: 110px; }
</style>'."\n";
	if(!$comments && !$likes && (!$twitter & !$facebook & !$plusone) && !$bitlyid && !$bitlyapi)
	 echo '<style type="text/css">
	#entries .comments-count { right: 110px; }
	#entries .likes-count { right: 120px; }
</style>'."\n";
}
add_action('wp_head', 'exultic_special_styles');

function exultic_layout_classes($existing_classes) {
	$options = get_option('exultic_general_options');
	$current_layout = $options['layout'];
	
	if ('content' == $current_layout)
		$classes[] = 'one-column';

	if ('sidebar-content' == $current_layout)
		$classes[] = 'left-sidebar';
	else
		$classes[] = '';

	$classes = apply_filters('exultic_layout_classes', $classes, $current_layout);
	return array_merge($existing_classes, $classes);
}
add_filter('body_class', 'exultic_layout_classes');

/******************** RSS ********************/

// Add post data
function exultic_postrss($content) {
	global $wp_query;
	$postid = $wp_query->post->ID;
		if(is_feed()) {
			$gallery = exultic_get_images($postid);
			$link = exultic_link($postid);
			$quote = exultic_quote($postid);
			$video = exultic_video($postid);	
			$embed = exultic_embed_video($postid);
			$content = $content.'<br/><br/><div> '.$gallery; $link; $quote; $video; $embed.'</div>\n';
		}
	return $content;
}
add_filter('the_content', 'exultic_postrss');

// Get images for galley
function exultic_get_images($postid) {
    $images =& get_children('post_type=attachment&post_mime_type=image&post_parent='.$postid.'');
    if($images) {
        $keys = array_keys($images);	
        foreach($images as $image) {
            $new_images[] = $image;
        }
        for($i = 0; $i < sizeof($new_images) - 1; $i++) {
            for($j = 0; $j < sizeof($new_images) - 1; $j++) {
                if((int)$new_images[$j]->menu_order > (int)$new_images[$j + 1]->menu_order) {
                    $temp = $new_images[$j];
                    $new_images[$j] = $new_images[$j + 1];
                    $new_images[$j + 1] = $temp;
                }
            }
        }
        $keys = array();
        foreach($new_images as $new_image) {
            $keys[] = $new_image->ID;
        }
        foreach ($keys as $key) {
			$image_url = wp_get_attachment_url($key);
	 
			$image_string ='<img src="'. $image_url .'"/> ';
			if(('gallery' == get_post_format($postid)) || ('image' == get_post_format($postid))) {
				echo $image_string;
			}
		}
    }
}

// Hide post formats from WordPress generated RSS feeds:
function exclude_post_formats_from_feeds( &$wp_query ) {
	if($wp_query->is_feed()) {
		// Exclude Audio Post Format
		$post_formats_to_exclude = array(
			'post-format-audio'
		);
		$extra_tax_query = array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => $post_formats_to_exclude,
			'operator' => 'NOT IN'
		);
		$tax_query = $wp_query->get('tax_query');
		if( is_array($tax_query ) ) {
			$tax_query = $tax_query + $extra_tax_query;
		} else {
			$tax_query = array($extra_tax_query );
		}
		$wp_query->set('tax_query', $tax_query );
	}
}
add_action('pre_get_posts', 'exclude_post_formats_from_feeds');

/* Redirect the RSS feed
 * Credit: Feedburner Feedsmith Plugin */
function exultic_feed_redirect() {
	global $wp, $feed, $withcomments;
    
	$options = get_option('exultic_general_options');
    if($options['feedburner_url']) {
        if( is_feed() && $feed != 'comments-rss2' && !is_single() && $wp->query_vars['category_name'] == '' && ($withcomments != 1) ){
            if( function_exists('status_header') ) status_header( 302 );
            header("Location:" . trim($options['feedburner_url']));
            header("HTTP/1.1 302 Temporary Redirect");
            exit();
        }
    }
}
function exultic_check_url() {
	$options = get_option('exultic_general_options');
    if($options['feedburner_url']) {
        switch( basename($_SERVER['PHP_SELF']) ){
            case 'wp-rss.php':
            case 'wp-rss2.php':
            case 'wp-atom.php':
            case 'wp-rdf.php':
                if( function_exists('status_header') ) status_header( 302 );
                header("Location:" . trim($options['feedburner_url']));
                header("HTTP/1.1 302 Temporary Redirect");
                exit();
                break;
        }
    }
}
if(!preg_match("/feedburner|feedvalidator/i", $_SERVER['HTTP_USER_AGENT']) ){
	add_action('template_redirect', 'exultic_feed_redirect');
	add_action('init', 'exultic_check_url');
}


/******************** DISABLE ATTACHMENT PAGES ********************/

// Disable attachment posts
function exultic_attachment_fields_edit($form_fields,$post){ 
    $form_fields['url']['html'] = preg_replace('/<button(.*)<\/button>/', '', $form_fields['url']['html']);
    $form_fields['url']['helps'] ='';
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'exultic_attachment_fields_edit', 10, 2);

// Redirect attachment pages
function sar_attachment_redirect() {  
	global $post;
	if( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent != 0) ) {
		wp_redirect(get_permalink($post->post_parent), 301); // permanent redirect to post/page where image or document was uploaded
		exit;
	} elseif( is_attachment() && isset($post->post_parent) && is_numeric($post->post_parent) && ($post->post_parent < 1) ) {   // for some reason it doesnt work checking for 0, so checking lower than 1 instead...
		wp_redirect(get_bloginfo('wpurl'), 302); // temp redirect to home for image or document not associated to any post/page
		exit;       
    }
}
add_action('template_redirect', 'sar_attachment_redirect',1);

/******************** REPLACE ********************/

// Apply class to paragraphs with image and add prettyphoto anchor
function image_replace($content) {
	$pattern = '/<p><img(.*?)src="(.*?).(bmp|gif|jpeg|jpg|png)" alt="(.*?)"(.*?)>/i';
  	$replacement = '<p class="image"><a href="$2.$3" class="prettyphoto-anchor" rel="prettyPhoto" alt="$4"></a><img$1src="$2.$3"  alt="$4"$5>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'image_replace');

// Remove link around images and add prettyphoto anchor
function exultic_remove_img_anchors($content) {
	$pattern = '/<a href="(.*?).(bmp|gif|jpeg|jpg|png)"><img(.*?)alt="(.*?)"(.*?)align(left|center|right)(.*?)><\/a>/i';
  	$replacement = '<p class="entry-image $6"><a href="$1.$2" rel="prettyPhoto" alt="$4"><img$3alt="$4"$5align$6$7></a></p>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;	
}
add_filter('the_content', 'exultic_remove_img_anchors');

// Apply class to paragraphs with video
function video_replace($content) {
	$pattern = '/<p><iframe(.*?)feature=oembed(.*?)/i';
  	$replacement = '<p class="video"><iframe$1feature=oembed&wmode=opaque$2';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'video_replace');

// Apply class to paragraphs with mejs audio
function audio_replace($content) {
	$pattern = '/<p><audio/i';
  	$replacement = '<p class="audio-mejs"><audio';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
add_filter('the_content', 'audio_replace');

// Remove captions from images
function exultic_remove_img_titles($text) {
    $result = array();
    preg_match_all('|title="[^"]*"|U', $text, $result);
    foreach($result[0] as $img_tag) {
        $text = str_replace($img_tag, '', $text);
    }
    return $text;
}
add_filter('the_content', 'exultic_remove_img_titles');

// Set image links
function exultic_imagelink() {
    $image_set = get_option('image_default_link_type');
    if ($image_set != 'file') {
        update_option('image_default_link_type', 'file');
    }
}
add_action('admin_init', 'exultic_imagelink');

/******************** MISC. ********************/

// Clean nav menu
class Cleaner_Walker_Nav_Menu extends Walker {
    var $tree_type = array('post_type', 'taxonomy', 'custom');
    var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent      <ul class=\"sub-menu\">\n";
    }
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent    </ul>\n";
    }
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ($depth) ? str_repeat( "\t", $depth ) :'';
        $class_names = $value ='';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes = in_array('current-menu-item', $classes ) ? array('current-menu-item') : array();
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes ), $item, $args ) );
        $class_names = strlen(trim($class_names ) ) > 0 ?' class="'. esc_attr($class_names ).'"':'';
        $id = apply_filters('nav_menu_item_id', '', $item, $args );
        $id = strlen($id ) ?' id="'.esc_attr($id ).'"':'';
        $output .= $indent . '<li'. $id . $value . $class_names .'>';
        $attributes  = ! empty($item->attr_title ) ?'title="' . esc_attr($item->attr_title ).'"':'';
        $attributes .= ! empty($item->target )     ?'target="'. esc_attr($item->target     ).'"':'';
        $attributes .= ! empty($item->xfn )        ?'rel="'   . esc_attr($item->xfn        ).'"':'';
        $attributes .= ! empty($item->url )        ?'href="'  . esc_attr($item->url        ).'"':'';
        $item_output = $args->before;
        $item_output .='<a '.$attributes.'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .='</a>';
        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		$output = preg_replace('/<\/a>(.*?)<\/li>/i', '</a></li>', $output);
    }
    function end_el(&$output, $item, $depth) {
        $output .= "  </li>\n  ";
	}
}

/* Convert cyrillic, european and georgian characters in post, term slugs and media file names to latin characters
 * Credit: Cyr to Lat enhanced Plugin */
function ctl_sanitize_title($title) {
	global $wpdb;

	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
		'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
		'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
		'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K`',
		'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N`',
		'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
		'У' => 'U', 'Ў' => 'U`', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
		'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '``',
		'Ы' => 'Y`', 'Ь' => '`', 'Э' => 'E`', 'Ю' => 'YU', 'Я' => 'YA',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
		'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
		'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k`',
		'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n`',
		'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ў' => 'u`', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
		'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '``',
		'ы' => 'y`', 'ь' => '`', 'э' => 'e`', 'ю' => 'yu', 'я' => 'ya'
	);
	$geo2lat = array(
		'ა' => 'a', 'ბ' => 'b', 'გ' => 'g', 'დ' => 'd', 'ე' => 'e', 'ვ' => 'v',
		'ზ' => 'z', 'თ' => 'th', 'ი' => 'i', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm',
		'ნ' => 'n', 'ო' => 'o', 'პ' => 'p','ჟ' => 'zh','რ' => 'r','ს' => 's',
		'ტ' => 't','უ' => 'u','ფ' => 'ph','ქ' => 'q','ღ' => 'gh','ყ' => 'qh',
		'შ' => 'sh','ჩ' => 'ch','ც' => 'ts','ძ' => 'dz','წ' => 'ts','ჭ' => 'tch',
		'ხ' => 'kh','ჯ' => 'j','ჰ' => 'h'
	);
	$iso9_table = array_merge($iso9_table, $geo2lat);

	$locale = get_locale();
	switch ( $locale ) {
		case 'bg_BG':
			$iso9_table['Щ'] = 'SHT';
			$iso9_table['щ'] = 'sht'; 
			$iso9_table['Ъ'] = 'A`';
			$iso9_table['ъ'] = 'a`';
			break;
		case 'uk':
			$iso9_table['И'] = 'Y`';
			$iso9_table['и'] = 'y`';
			break;
	}

	$is_term = false;
	$backtrace = debug_backtrace();
	foreach ( $backtrace as $backtrace_entry ) {
		if ( $backtrace_entry['function'] == 'wp_insert_term' ) {
			$is_term = true;
			break;
		}
	}

	$term = $is_term ? $wpdb->get_var("SELECT slug FROM {$wpdb->terms} WHERE name = '$title'") : '';
	if ( empty($term) ) {
		$title = strtr($title, apply_filters('ctl_table', $iso9_table));
		if(function_exists('iconv')){
			$title = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title);
		}
		$title = preg_replace("/[^A-Za-z0-9'_\-\.]/", '-', $title);
		$title = preg_replace('/\-+/', '-', $title);
		$title = preg_replace('/^-+/', '', $title);
		$title = preg_replace('/-+$/', '', $title);
	} else {
		$title = $term;
	}

	return $title;
}
add_filter('sanitize_title', 'ctl_sanitize_title', 9);
add_filter('sanitize_file_name', 'ctl_sanitize_title');

function ctl_convert_existing_slugs() {
	global $wpdb;

	$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^A-Za-z0-9\-]+') AND post_status = 'publish'");
	foreach ( (array) $posts as $post ) {
		$sanitized_name = ctl_sanitize_title(urldecode($post->post_name));
		if ( $post->post_name != $sanitized_name ) {
			add_post_meta($post->ID, '_wp_old_slug', $post->post_name);
			$wpdb->update($wpdb->posts, array( 'post_name' => $sanitized_name ), array( 'ID' => $post->ID ));
		}
	}

	$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^A-Za-z0-9\-]+') ");
	foreach ((array) $terms as $term) {
		$sanitized_slug = ctl_sanitize_title(urldecode($term->slug));
		if ($term->slug != $sanitized_slug) {
			$wpdb->update($wpdb->terms, array('slug' => $sanitized_slug), array('term_id' => $term->term_id));
		}
	}
}

function ctl_schedule_conversion() {
	add_action('shutdown', 'ctl_convert_existing_slugs');
}
register_activation_hook(__FILE__, 'ctl_schedule_conversion');

// Allow upload of webm
function exultic_mime_types($mime_types){
    $mime_types['webm'] = 'video/webm';
    return $mime_types;
}
add_filter('upload_mimes', 'exultic_mime_types', 1, 1);

?>