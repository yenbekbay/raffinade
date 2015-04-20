<?php

/******************** THEME OPTIONS ********************/

// Register options page
function exultic_options_page_init() {

	$options_page = add_theme_page(
		__('Theme Options', 'exultic'),
		__('Theme Options', 'exultic'),
		'administrator',
		'theme_options',
		'exultic_theme_options'
	);

	add_action('admin_print_scripts-'.$options_page.'', 'ajaxupload');
	add_action('admin_print_scripts-'.$options_page.'', 'custom_jquery');
	add_action('admin_print_styles-'.$options_page.'', 'styles');	
}
add_action('admin_menu', 'exultic_options_page_init');

// Enqueue needed scripts and styles
function ajaxupload() {
	wp_enqueue_script('ajaxupload', get_template_directory_uri().'/admin/js/ajaxupload.js');
}
function custom_jquery() {
	wp_enqueue_script('custom_jquery', get_template_directory_uri().'/admin/js/custom.jquery.js');
}
function styles() {
	wp_enqueue_style('theme_options_stylesheet', get_template_directory_uri().'/admin/css/style.css');
}

// Display the options
function exultic_theme_options($active_tab = '' ) {

	echo '<div class="wrap">
		
		<div id="icon-themes" class="icon32"></div>';
		settings_errors();
		
		if( isset($_GET['tab'])) {
			$active_tab = $_GET['tab'];
		} elseif($active_tab == 'post' ) {
			$active_tab = 'post';
		} elseif($active_tab == 'seo' ) {
			$active_tab = 'seo';
		} else {
			$active_tab = 'general';
		}
		
		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=theme_options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'exultic'); ?></a>
			<a href="?page=theme_options&tab=post" class="nav-tab <?php echo $active_tab == 'post' ? 'nav-tab-active' : ''; ?>"><?php _e('Post', 'exultic'); ?></a>
			<a href="?page=theme_options&tab=seo" class="nav-tab <?php echo $active_tab == 'seo' ? 'nav-tab-active' : ''; ?>"><?php _e('SEO', 'exultic'); ?></a>
		</h2>
		<?php
		
		echo '<form method="post" action="options.php">';
			
				if($active_tab == 'general') {
					settings_fields('exultic_general_options');
					do_settings_sections('exultic_general_options');
				} elseif($active_tab == 'post') {
					settings_fields('exultic_post_options');
					do_settings_sections('exultic_post_options');
				} else {
					settings_fields('exultic_seo_options');
					do_settings_sections('exultic_seo_options');
				}
				
				submit_button();
			
		echo '</form>
		
	</div>';
}

/******************** SETTING REGISTRATION ********************/ 

// Initialize options
function exultic_initialize_options() {

	// If the theme options don't exist, create them.
	if(get_option('exultic_general_options') == false) {	
		add_option('exultic_general_options');
	}

	// First, we register a section. This is necessary since all future options must belong to a 
	add_settings_section(
		'general_options_section',
		'',
		'exultic_general_options_callback',
		'exultic_general_options'
	);
	
	// Next, we'll introduce the fields for toggling the visibility of content elements.
	add_settings_field(	
		'plain_text_logo',
		'<label for="plain_text_logo">'.__('Plain Text Logo', 'exultic').'</label><span class="description">'.__('Check this box to use a plain text logo rather than upload an image. Site name will be used.', 'exultic').'</span>',
		'exultic_plain_text_logo',
		'exultic_general_options',
		'general_options_section'
	);
	
	add_settings_field(	
		'custom_logo',						
		__('Custom Logo', 'exultic').'<span class="description">'.__('Upload your custom logo (not more than 300px wide).', 'exultic').'</span>',				
		'exultic_custom_logo',	
		'exultic_general_options',					
		'general_options_section'
	);
	
	add_settings_field(	
		'custom_favicon',						
		__('Custom Favicon', 'exultic').'<span class="description">'.__('Upload your custom favicon.', 'exultic').'</span>',				
		'exultic_custom_favicon',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'custom_apple_icon',						
		__('Custom Apple Touch Icon', 'exultic').'<span class="description">'.__('Upload your custom apple touch icon (144px x 144px).', 'exultic').'</span>',				
		'exultic_custom_apple_icon',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'header_login',						
		'<label for="header_login">'.__('Header Login', 'exultic').'</label><span class="description">'.__('Check this box to show user login block in header.', 'exultic').'</span>',				
		'exultic_header_login',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'layout',						
		'<label for="header_login">'.__('Default Layout', 'exultic').'</label><span class="description">'.__('Choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'exultic').'</span>',				
		'exultic_layout',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'footer_text',						
		'<label for="footer_text">'.__('Footer Text', 'exultic').'</label><span class="description">'.__('Edit your footer text.', 'exultic').'</span>',				
		'exultic_footer_text',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'feedburner_url',						
		'<label for="feedburner_url">FeedBurner URL</label><span class="description">'.__('Enter your Feedburner URL e.g.', 'exultic').' <code>http://feeds.feedburner.com/URL</code>.</span>',				
		'exultic_feedburner_url',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	add_settings_field(	
		'tracking_code',						
		'<label for="tracking_code">'.__('Tracking Code', 'exultic').'</label><span class="description">'.__('Enter your Google Analytics (or any other) tracking code.', 'exultic').'</span>',				
		'exultic_tracking_code',	
		'exultic_general_options',		
		'general_options_section'
	);
	
	// Finally, we register the fields with WordPress
	register_setting(
		'exultic_general_options',
		'exultic_general_options'
	);
	
}
add_action('admin_init', 'exultic_initialize_options');

function exultic_intialize_post_options() {

	if(get_option('exultic_post_options') == false) {	
		add_option('exultic_post_options');
	}
	
	add_settings_section(
		'post_options_section',
		'',
		'exultic_post_options_callback',
		'exultic_post_options'
	);
	
	add_settings_field(	
		'show_tags',						
		'<label for="show_tags">'.__('Show Post Tags', 'exultic').'</label><span class="description">'.__('Check this box to show post tags.', 'exultic').'</span>',				
		'exultic_show_tags',	
		'exultic_post_options',		
		'post_options_section'
	);
	
	add_settings_field(	
		'disable_likes',						
		'<label for="disable_likes">'.__('Disable Post Rating System', 'exultic').'</label><span class="description">'.__('Check this box to disable post rating system.', 'exultic').'</span>',				
		'exultic_disable_likes',	
		'exultic_post_options',		
		'post_options_section'
	);

	add_settings_field(	
		'hide_comments_count',						
		'<label for="hide_comments_count">'.__('Hide Post Comments Count', 'exultic').'</label><span class="description">'.__('Check this box to remove comments count from post meta.', 'exultic').'</span>',				
		'exultic_hide_comments_count',	
		'exultic_post_options',		
		'post_options_section'
	);
	
	add_settings_field(	
		'bitly',						
		__('Bit.ly Shortlinks', 'exultic').'<span class="description">'.__('Set up Bit.ly URL shortening service.', 'exultic').'</span>',				
		'exultic_bitly',	
		'exultic_post_options',		
		'post_options_section'
	);
	
	register_setting(
		'exultic_post_options',
		'exultic_post_options'
	);
	
}
add_action('admin_init', 'exultic_intialize_post_options');

function exultic_intialize_seo_options() {

	if(get_option('exultic_seo_options') == false) {	
		add_option('exultic_seo_options');
	}
	
	add_settings_section(
		'seo_options_section',
		'',
		'exultic_seo_options_callback',
		'exultic_seo_options'
	);
	
	add_settings_field(	
		'home_keywords',						
		'<label for="home_keywords">'.__('Home Keywords (comma separated)', 'exultic').'</label><span class="description">'.__('Enter keywords for your site.', 'exultic').'</span>',				
		'exultic_home_keywords',
		'exultic_seo_options',		
		'seo_options_section'
	);
	
	add_settings_field(	
		'opengraph',						
		'<label for="opengraph">'.__('Facebook Open Graph Tags', 'exultic').'</label><span class="description">'.__('Check this box to add Open Graph meta tags to your site.', 'exultic').'</span>',				
		'exultic_opengraph',
		'exultic_seo_options',		
		'seo_options_section'
	);
	
	add_settings_field(	
		'share_buttons',						
		__('Social Share buttons', 'exultic').'<span class="description">'.__('', 'exultic').'</span>',				
		'exultic_share_buttons',
		'exultic_seo_options',		
		'seo_options_section'
	);
	
	register_setting(
		'exultic_seo_options',
		'exultic_seo_options'
	);
	
}
add_action('admin_init', 'exultic_intialize_seo_options');

/******************** SECTION CALLBACKS ********************/ 

function exultic_general_options_callback() {
	echo '';
} 

function exultic_post_options_callback() {
	echo '';
} 
 
function exultic_seo_options_callback() {
	echo '';
} 

/******************** FIELD CALLBACKS ********************/ 

function exultic_plain_text_logo($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="checkbox" id="plain_text_logo" name="exultic_general_options[plain_text_logo]" value="1" '.checked( 1, isset( $options['plain_text_logo'] ) ? $options['plain_text_logo'] : 0, false ).'/>'; 
}

function exultic_custom_logo($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="hidden" id="custom_logo" value="'.$options['custom_logo'].'" name="exultic_general_options[custom_logo]"/>'; 	
	exultic_upload('logo');
}

function exultic_custom_favicon($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="hidden" id="custom_favicon" value="'.$options['custom_favicon'].'" name="exultic_general_options[custom_favicon]"/>'; 
	exultic_upload('favicon');
}

function exultic_custom_apple_icon($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="hidden" id="custom_apple_icon" value="'.$options['custom_apple_icon'].'" name="exultic_general_options[custom_apple_icon]"/>'; 
	exultic_upload('apple_icon');
}

function exultic_header_login($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="checkbox" id="header_login" name="exultic_general_options[header_login]" value="1" '.checked( 1, isset( $options['header_login'] ) ? $options['header_login'] : 0, false ).'/>'; 
}

function exultic_layout() {
	$options = get_option('exultic_general_options');
	foreach (exultic_layouts() as $layout) {
		echo '<div class="layout-radio">
		<label class="description">
			<input type="radio" name="exultic_general_options[layout]" value="'.esc_attr($layout['value']).'" '.checked($options['layout'], $layout['value'], false).'/>
			<span><img src="'.esc_url($layout['thumbnail']).'" width="136" height="122" alt=""/>'.$layout['label'].'</span>
		</label>
		</div>';
	}
}

function exultic_footer_text($args) {
	$options = get_option('exultic_general_options');
	if($options['footer_text']) {
		$footer_text = exultic_validate_options($options['footer_text']);
	} else {
		$footer_text = '© '.date('Y').', <a href="'.get_home_url().'">'.get_bloginfo('name').'</a>.';
	}
	echo '<textarea type="text" id="footer_text" name="exultic_general_options[footer_text]" rows="3" cols="72">'.$footer_text.'</textarea>'; 
}

function exultic_feedburner_url($args) {
	$options = get_option('exultic_general_options');
	echo '<input type="text" id="feedburner_url" name="exultic_general_options[feedburner_url]" size="70" value="'.exultic_sanitize_options($options['feedburner_url']).'"/>';
}

function exultic_tracking_code($args) {
	$options = get_option('exultic_general_options');
	echo '<textarea type="text" id="tracking_code" name="exultic_general_options[tracking_code]" rows="10" cols="72">'.exultic_validate_options($options['tracking_code']).'</textarea>';
}

function exultic_show_tags($args) {
	$options = get_option('exultic_post_options');
	echo '<input type="checkbox" id="show_tags" name="exultic_post_options[show_tags]" value="1" '.checked( 1, isset( $options['show_tags'] ) ? $options['show_tags'] : 0, false ).'/>'; 
}

function exultic_disable_likes($args) {
	$options = get_option('exultic_post_options');
	echo '<input type="checkbox" id="disable_likes" name="exultic_post_options[disable_likes]" value="1" '.checked( 1, isset( $options['disable_likes'] ) ? $options['disable_likes'] : 0, false ).'/>'; 
}

function exultic_hide_comments_count($args) {
	$options = get_option('exultic_post_options');
	echo '<input type="checkbox" id="hide_comments_count" name="exultic_post_options[hide_comments_count]" value="1" '.checked( 1, isset( $options['hide_comments_count'] ) ? $options['hide_comments_count'] : 0, false ).'/>'; 
}

function exultic_bitly($args) {
	$options = get_option('exultic_post_options');
	echo '<div class="row first"><label for="bitly_id">'.__('bitly Username', 'exultic').'</label><input type="text" id="bitly_id" name="exultic_post_options[bitly_id]" size="41" value="'.exultic_validate_options($options['bitly_id']).'"/></div>';
	echo '<div class="row noborder"><label for="bitly_api">'.__('bitly API Key', 'exultic').'</label><input type="text" id="bitly_api" name="exultic_post_options[bitly_api]" size="41" value="'.exultic_validate_options($options['bitly_api']).'"/></div>';
	echo '<div class="description">'.__('You can get your Username and API Key', 'exultic').' <a href="https://bitly.com/a/your_api_key">'.__('here', 'exultic').'</a></div>';
}

function exultic_home_keywords($args) {
	$options = get_option('exultic_seo_options');
	echo '<textarea type="text" id="home_keywords" name="exultic_seo_options[home_keywords]" rows="3" cols="72">'.exultic_validate_options($options['home_keywords']).'</textarea>';
}

function exultic_opengraph($args) {
	$options = get_option('exultic_seo_options');
	echo '<input type="checkbox" id="opengraph" name="exultic_seo_options[opengraph]" value="1" '.checked( 1, isset( $options['opengraph'] ) ? $options['opengraph'] : 0, false ).'/>'; 
	echo '<div id="fb_id"><label for="fb_appid">'.__('Facebook Platform application ID', 'exultic').'</label><input type="text" id="fb_appid" name="exultic_seo_options[fb_appid]" size="16" value="'.exultic_validate_options($options['fb_appid']).'"/>
	<span class="small">'.__('–OR–', 'exultic').'</span><label for="fb_admins">'.__('Your Facebook ID', 'exultic').'</label><input type="text" id="fb_admins" name="exultic_seo_options[fb_admins]" size="16" value="'.exultic_validate_options($options['fb_admins']).'"/></div>';	
}

function exultic_share_buttons($args) {
	$options = get_option('exultic_seo_options');
	echo '<div class="row-first"><label for="twitter">'.__('Enable tweet buttons', 'exultic').'</label><input type="checkbox" id="twitter" name="exultic_seo_options[twitter]" value="1" '.checked( 1, isset( $options['twitter'] ) ? $options['twitter'] : 0, false ).'/>';
	echo '<div id="twitter-username"><label for="twitter_username">'.__('Your Twitter username', 'exultic').'</label><input type="text" id="twitter_username" name="exultic_seo_options[twitter_username]" size="20" value="'.exultic_validate_options($options['twitter_username']).'"/></div></div>';	
	echo '<div class="row"><label for="facebook">'.__('Enable Facebook like buttons', 'exultic').'</label><input type="checkbox" id="facebook" name="exultic_seo_options[facebook]" value="1" '.checked( 1, isset( $options['facebook'] ) ? $options['facebook'] : 0, false ).'/></div>';	
	echo '<div class="row"><label for="plusone">'.__('Enable Google +1 buttons', 'exultic').'</label><input type="checkbox" id="plusone" name="exultic_seo_options[plusone]" value="1" '.checked( 1, isset( $options['plusone'] ) ? $options['plusone'] : 0, false ).'/></div>';	
}

// Sanitization callback 
function exultic_sanitize_options($input) {
	$output = esc_url_raw( strip_tags( stripslashes($input) ) );
	return apply_filters('exultic_sanitize_options', $output, $input);
}

// Validation callback
function exultic_validate_options($input) {
	$output = stripslashes($input);
	return apply_filters('exultic_validate_options', $output, $input );
}

// Upload
function exultic_upload($id) {
	$options = get_option('exultic_general_options');
    $wp_uploads = wp_upload_dir();
    ?>
	<div id="uploaded_<?php echo $id; ?>" class="ajax-uploaded">
        <?php
			if($options['custom_'.$id.'']) {
				$ext = substr($options['custom_'.$id.''], strrpos($options['custom_'.$id.''], '.') + 1);
				if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'ico' )
					echo '<img class="uploaded" src="'. $options['custom_'.$id.''] .'"/>'; 
                else 
                    echo $options['custom_'.$id.''];			
			} elseif($id == 'logo') {
					echo '<img class="uploaded" src="'.get_template_directory_uri().'/images/logo.png"/>';
			} elseif($id == 'favicon') {
					echo '<img class="uploaded" src="'.get_template_directory_uri().'/favicon.ico"/>';
			} elseif($id == 'apple_icon') {
					echo '<img class="uploaded" src="'.get_template_directory_uri().'/images/apple-touch-icon.png"/>';
			}
        ?>	
	</div>
    <a href="#" id="ajax_upload_<?php echo $id; ?>" class="button-secondary"><?php _e( 'Upload', 'exultic' ); ?></a>
    <a href="#" id="ajax_remove_<?php echo $id; ?>" class="button-secondary"<?php if(!$options['custom_'.$id.'']) { echo 'style="display: none"'; } ?>><?php _e( 'Remove', 'exultic' ); ?></a>
    <script type="text/javascript">
        jQuery(document).ready(function($){ 
            var button = $('#ajax_upload_<?php echo $id; ?>');
            var buttonVal = button.text();
            var interval = '';
            // AJAX upload
            new AjaxUpload(button, {
                action: '<?php echo home_url(); ?>/wp-admin/admin-ajax.php',
				data: { action:'exultic_ajax_upload', data:'<?php echo $id; ?>' },
                onSubmit : function(file, ext){
                    button.text('<?php _e('Uploading', 'exultic'); ?>');
                    this.disable();
                    
                    // Uploading
                    interval = window.setInterval(function() {
                        var text = button.text();
                        if (text.length < 13){
                            button.text(text + '.');
                        } else {
                            button.text('<?php _e('Uploading', 'exultic'); ?>');
                        }
                    }, 200);
                },
                onComplete: function(file, response) {
                    button.text(buttonVal);
                    this.enable();
                    window.clearInterval(interval);
                    
                    // Show image
                    $('#uploaded_<?php echo $id; ?>').html('');
                    var ext = file.substr(file.lastIndexOf(".")+1,file.length);
                    if(ext && /^(jpg|png|jpeg|gif|ico)$/.test(ext)){
                        $('#uploaded_<?php echo $id; ?>').html('<img class="uploaded" src="<?php echo $wp_uploads['url']; ?>/' + file + '"/>');
                    } else {
                        $('#uploaded_<?php echo $id; ?>').text('<?php echo $wp_uploads['url']; ?>/' + file);
                    }
                    $('#ajax_remove_<?php echo $id; ?>').show();
					$('#custom_<?php echo $id; ?>').val('<?php echo $wp_uploads['url']; ?>/' + file + '');
                }
            });
            
			// Remove
            var remove = $('#ajax_remove_<?php echo $id; ?>');
            remove.bind('click', function(){
				remove.text('<?php _e('Removing', 'exultic'); ?>...');
                $.post('<?php echo home_url(); ?>/wp-admin/admin-ajax.php',  
                    function(data){
                        remove.fadeOut(500, function(){
							remove.text('<?php _e('Remove', 'exultic'); ?>');
						});
                        $('#uploaded_<?php echo $id; ?>').html('');
						$('#custom_<?php echo $id; ?>').val('');
                    }
                );
				return false;
            });
        });
    </script>
    <?php
}

// Update uploaded file
function exultic_ajax_upload(){
    $wp_uploads = wp_upload_dir();
    $uploadfile = basename($_FILES['userfile']['name']);

    move_uploaded_file($_FILES['userfile']['tmp_name'], $wp_uploads['path'] .'/'.$uploadfile);
}
add_action('wp_ajax_exultic_ajax_upload', 'exultic_ajax_upload');

// Layouts array
function exultic_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __('Content on left', 'exultic'),
			'thumbnail' => get_template_directory_uri().'/admin/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __('Content on right', 'exultic'),
			'thumbnail' => get_template_directory_uri().'/admin/images/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __('One-column, no sidebar', 'exultic'),
			'thumbnail' => get_template_directory_uri().'/admin/images/content.png',
		),
	);
	return apply_filters('exultic_layouts', $layout_options);
}

?>