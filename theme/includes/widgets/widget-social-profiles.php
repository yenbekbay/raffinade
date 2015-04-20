<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_social_widget_init');

// Register widget
function exultic_social_widget_init() {
	register_widget('exultic_social_widget');
}

// Widget class
class exultic_social_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/
	
	function exultic_social_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_social_widget','description' => __('Display your social profiles','exultic'));
		
		// Widget control settings
		$control_ops = array('id_base' => 'exultic_social_widget');

		// Create the widget
		$this->WP_Widget('exultic_social_widget', __('Social Profiles','exultic'), $widget_ops, $control_ops);
	}

	/******************** DISPLAY WIDGET ********************/
	
	function widget($args, $instance){
		extract($args);

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title']);
		$text = apply_filters('widget_text', $instance['text'], $instance);
		$twitter = $instance['twitter'];		
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$linkedin = $instance['linkedin'];
		$vimeo = $instance['vimeo'];
		$dribbble = $instance['dribbble'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];	
		$youtube = $instance['youtube'];
		$behance = $instance['behance'];	
		$deviantart = $instance['deviantart'];	
		$forrst = $instance['forrst'];	
		$mail = $instance['mail'];	
		$rss = $instance['rss'];	
		$options = get_option('exultic_general_options');
		if($options['feedburner_url']) {
			$rss_url = trim($options['feedburner_url']);
		} else { 
			$rss_url = get_bloginfo('rss2_url');
		}
		$admin_email = get_bloginfo('admin_email');
		
		echo $before_widget;

		// Display the widget title if one was input
		if ($title)
			echo $before_title . $title . $after_title;

		// Display icons
		echo '<div class="social-wrapper">';
		if ($text)
			echo "<div>".$instance['filter'] ? wpautop($text) : $text."</div>";	
		if ($twitter != '' && $twitter != ' ')
			echo '<a class="twitter-button social-button" href="'.$twitter.'" target = "_blank" title="Twitter"></a>';
		if ($facebook != '' && $facebook != ' ')
			echo '<a class="facebook-button social-button" href="'.$facebook.'" target = "_blank" title="Facebook"></a>';
		if ($googleplus != '' && $googleplus != ' ')
			echo '<a class="googleplus-button social-button" href="'.$googleplus.'" target = "_blank" title="Google Plus"></a>';
		if ($linkedin != '' && $linkedin != ' ')
			echo '<a class="linkedin-button social-button" href="'.$linkedin.'" target = "_blank" title="LinkedIn"></a>';
		if ($vimeo != '' && $vimeo != ' ')
			echo '<a class="vimeo-button social-button" href="'.$vimeo.'" target = "_blank" title="Vimeo"></a>';
		if ($dribbble != '' && $dribbble != ' ')
			echo '<a class="dribbble-button social-button" href="'.$dribbble.'" target = "_blank" title="Dribbble"></a>';
		if ($flickr != '' && $flickr != ' ')
			echo '<a class="flickr-button social-button" href="'.$flickr.'" target = "_blank" title="Flickr"></a>';
		if ($instagram != '' && $instagram != ' ')
			echo '<a class="instagram-button social-button" href="'.$instagram.'" target = "_blank" title="Instagram"></a>';			
		if ($youtube != '' && $youtube != ' ')
			echo '<a class="youtube-button social-button" href="'.$youtube.'" target = "_blank" title="YouTube"></a>';
		if ($behance != '' && $behance != ' ')
			echo '<a class="behance-button social-button" href="'.$behance.'" target = "_blank" title="Behance"></a>';
		if ($deviantart != '' && $deviantart != ' ')
			echo '<a class="deviantart-button social-button" href="'.$deviantart.'" target = "_blank" title="deviantArt"></a>';
		if ($forrst != '' && $forrst != ' ')
			echo '<a class="forrst-button social-button" href="'.$forrst.'"  target = "_blank" title="Forrst"></a>';
		if ($instance['mail'] ?'1' :'0')
			echo '<a class="mail-button social-button" href="mailto:'.$admin_email.'" target = "_blank" title="Email"></a>';
		if ($instance['rss'] ?'1' :'0')
			echo '<a class="rss-button social-button" href="'.$rss_url.'" target = "_blank" title="RSS Feed"></a>';
		echo '<div class="clear"></div></div>';

		echo $after_widget;
	}

	/******************** UPDATE WIDGET ********************/
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags
		$instance['title'] = strip_tags($new_instance['title']);
		if (current_user_can('unfiltered_html'))
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text'])));
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['googleplus'] = strip_tags($new_instance['googleplus']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['vimeo'] = strip_tags($new_instance['vimeo']);
		$instance['dribbble'] = strip_tags($new_instance['dribbble']);
		$instance['flickr'] = strip_tags($new_instance['flickr']);
		$instance['instagram'] = strip_tags($new_instance['instagram']);		
		$instance['youtube'] = strip_tags($new_instance['youtube']);
		$instance['behance'] = strip_tags($new_instance['behance']);
		$instance['deviantart'] = strip_tags($new_instance['deviantart']);
		$instance['forrst'] = strip_tags($new_instance['forrst']);
		$instance['mail'] = !empty($new_instance['mail']) ? 1 : 0;
		$instance['rss'] = !empty($new_instance['rss']) ? 1 : 0;
		
		return $instance;
	}
	
	/******************** WIDGET SETTINGS ********************/
	 
	function form($instance){

		// Set up some default widget settings
		$defaults = array(
		'title' => __('My Social Profiles','exultic')		,
		);
		$instance = wp_parse_args((array)$instance, $defaults);
		$mail = isset($instance['mail']) ? (bool) $instance['mail'] : false;
		$rss = isset($instance['rss'] ) ? (bool) $instance['rss'] : false; ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'exultic') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="8"><?php echo $instance['text']; ?></textarea>
		</p>
		
		<p>
			<?php _e('Note: Make sure you include FULL URL i.e.', 'exultic'); ?> <code>http://example.com</code>.
		</p>
		
		<p>		
			<?php _e('Fill the url to make an icon visible.', 'exultic'); ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $instance['twitter']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $instance['facebook']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('googleplus'); ?>">Google Plus URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $instance['googleplus']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>">LinkedIn URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $instance['linkedin']; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('vimeo'); ?>">Vimeo URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $instance['vimeo']; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble'); ?>">Dribbble URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $instance['dribbble']; ?>"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>">Flickr URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $instance['flickr']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instance['instagram']; ?>"/>
		</p>		
		
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>">YouTube URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $instance['youtube']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('behance'); ?>">Behance URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo $instance['behance']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('deviantart'); ?>">deviantArt URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo $instance['deviantart']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('forrst'); ?>">Forrst URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('forrst'); ?>" name="<?php echo $this->get_field_name('forrst'); ?>" value="<?php echo $instance['forrst']; ?>"/>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('mail'); ?>" name="<?php echo $this->get_field_name('mail'); ?>"<?php checked($mail); ?>/>
			<label for="<?php echo $this->get_field_id('mail'); ?>"><?php _e('Add email button (your admin email will be used)', 'exultic'); ?></label>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>"<?php checked($rss); ?>/>
			<label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('Add rss feed button', 'exultic'); ?></label>
		</p>
				
	<?php
	}
}

?>