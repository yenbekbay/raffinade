<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_post_formats_widget_init');

// Register widget
function exultic_post_formats_widget_init() {
	register_widget('exultic_post_formats_widget');
}

// Widget class
class exultic_post_formats_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/

	function exultic_post_formats_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_post_formats_widget','description' => __('A list or dropdown of post formats','exultic'));
		
		$control_ops = array('id_base' => 'exultic_post_formats_widget');		
		
		// Create the widget
		$this->WP_Widget('exultic_post_formats_widget', __('Post Formats', 'exultic'), $widget_ops, $control_ops);
	}

	/******************** DISPLAY WIDGET ********************/
	
	function widget($args, $instance) {
		extract($args);

		// Our variables from the widget settings
		$title = apply_filters('widget_title', empty($instance['title'] ) ? __('Post Formats','exultic') : $instance['title'], $instance, $this->id_base);
		$c = $instance['count'] ?'1' :'0';
		$d = $instance['dropdown'] ?'1' :'0';
		$f = $instance['format_id'] ?'1' :'0';

		echo $before_widget;

		// Display the widget title if one was input
		if ($title)
			echo $before_title . $title . $after_title;

		// If selected Display as dropdown
		if ($d ) { ?>

		<select id="post-format-dropdown" class="postform" name="post-format-dropdown">
		<option value="null"><?php _e('Select Post Format','exultic');?></option>
<?php			
		foreach (get_post_format_strings() as $slug => $string ) {
			if (get_post_format_link($slug)) {
				$post_format = get_term_by('slug','post-format-'.$slug,'post_format' );
				if ($post_format->count > 0 ) {
					$count = $c ?' ('.$post_format->count.')' :'';
					$format_id = $f ?' (ID:'.$post_format->term_id.')' :'';
					echo'<option class="level-0" value="'.$slug.'">'.$string . $count . $format_id.'</option>';
				}
			}
		} ?>
		</select>

<script type='text/javascript'>
/* <![CDATA[ */
	var pfDropdown = document.getElementById("post-format-dropdown");
	function onFormatChange() {
		if ( pfDropdown.options[pfDropdown.selectedIndex].value !='null' ) {
			location.href = "<?php echo home_url(); ?>/?post_format="+pfDropdown.options[pfDropdown.selectedIndex].value;
		}
	}
	pfDropdown.onchange = onFormatChange;
/* ]]> */
</script>

<?php
		// Else
		} else {
?>
		<ul>
<?php
		$tooltip = __('View all %format posts', 'exultic');
		foreach (get_post_format_strings() as $slug => $string) {
			if (get_post_format_link($slug)) {
				$post_format = get_term_by('slug','post-format-'.$slug,'post_format');
				if ($post_format->count > 0 ) {
					$count = $c ?' ('.$post_format->count.')' :'';
					$format_id = $f ?' (ID:'.$post_format->term_id.')' :'';
					echo'<li class="post-format-item"><a title="'.str_replace('%format', $string, $tooltip).'" href="'.get_post_format_link($slug).'">'.$string.''.$count.'</a></li>';
				}
			}
		}
?>
		</ul>
<?php
		}

		echo $after_widget;
	}

	/******************** UPDATE WIDGET ********************/
		
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		// Strip tags		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['format_id'] = !empty($new_instance['format_id']) ? 1 : 0;

		return $instance;
	}
	
	/******************** WIDGET SETTINGS ********************/

	function form($instance) {
	
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array('title' =>''));
		$title = !empty($instance['title']) ? esc_attr($instance['title'] ) : __('Post Formats', 'exultic');
		$count = isset($instance['count']) ? (bool) $instance['count'] : false;
		$dropdown = isset($instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		$format_id = isset($instance['format_id'] ) ? (bool) $instance['format_id'] : false; ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'exultic'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked($dropdown ); ?>/>
			<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown', 'exultic'); ?></label>
		<br/>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked($count); ?>/>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts', 'exultic'); ?></label>
		</p>

	<?php
	}
}

?>