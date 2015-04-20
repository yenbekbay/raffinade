<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_flickr_widget_init');

// Register widget
function exultic_flickr_widget_init() {
	register_widget('exultic_flickr_widget');
}

// Widget class
class exultic_flickr_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/
	
	function exultic_flickr_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_flickr_widget','description' => __('Display your Flickr photos','exultic'));
		
		// Widget control settings
		$control_ops = array('id_base' => 'exultic_flickr_widget');

		// Create the widget
		$this->WP_Widget('exultic_flickr_widget', __('Flickr Photos','exultic'), $widget_ops, $control_ops);
	}

	/******************** DISPLAY WIDGET ********************/
	
	function widget($args, $instance){
		extract($args);

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$flickrID = $instance['flickrID'];
		$postcount = $instance['postcount'];
		$type = $instance['type'];
		$display = $instance['display'];

		echo $before_widget;

		// Display the widget title if one was input
		if ($title)
			echo $before_title . $title . $after_title;

		// Display Latest flickrs
?>
  <div id="flickr_badge_wrapper" class="clearfix">
   <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
  </div>
  <?php

		echo $after_widget;
	}

	/******************** UPDATE WIDGET ********************/
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = $new_instance['postcount'];
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];

		return $instance;
	}
	
	/******************** WIDGET SETTINGS ********************/
	 
	function form($instance){

		// Set up some default widget settings
		$defaults = array(
		'title' => __('My Photostream','exultic'),
		'flickrID' => 'XXXXXXXXXXXX',
		'postcount' => '9',
		'type' => 'user',
		'display' => 'latest',
		);
		$instance = wp_parse_args((array)$instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('flickrID'); ?>">Flickr ID: (<a href="http://idgettr.com/">idGettr</a>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickrID'); ?>" name="<?php echo $this->get_field_name('flickrID'); ?>" value="<?php echo $instance['flickrID']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'exultic') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>">
				<option <?php if ('3' == $instance['postcount']) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ('6' == $instance['postcount']) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ('9' == $instance['postcount']) echo 'selected="selected"'; ?>>9</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'exultic') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option <?php if ('user' == $instance['type'] ) echo 'selected="selected"'; ?>><?php _e('user', 'exultic'); ?></option>
				<option <?php if ('group' == $instance['type'] ) echo 'selected="selected"'; ?>><?php _e('group', 'exultic'); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Display (random or latest):', 'exultic') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
				<option <?php if ('random' == $instance['display']) echo 'selected="selected"'; ?>><?php _e('random', 'exultic'); ?></option>
				<option <?php if ('latest' == $instance['display']) echo 'selected="selected"'; ?>><?php _e('latest', 'exultic'); ?></option>
			</select>
		</p>
		
	<?php
	}
}

?>