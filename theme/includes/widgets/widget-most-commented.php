<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_most_commented_widget_init');

// Register widget
function exultic_most_commented_widget_init() {
	register_widget('exultic_most_commented_widget');
}

// Widget class
class exultic_most_commented_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/
	
	function exultic_most_commented_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_most_commented_widget','description' => __('The most commented posts on your blog','exultic') );
		
		$control_ops = array('id_base' => 'exultic_most_commented_widget');

		// Create the widget
		$this->WP_Widget('exultic_most_commented_widget', __('Most Commented Posts','exultic'), $widget_ops, $control_ops);
	}

	/******************** DISPLAY WIDGET ********************/

	function widget($args, $instance) {
		extract($args);

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$postcount = $instance['postcount'];

		echo $before_widget;

		// Display the widget title if one was input
		if ($title)
			echo $before_title . $title . $after_title;
		
		// Query
		$popular = new WP_Query();
		$popular->query('ignore_sticky_posts=1&posts_per_page='.$postcount.'&orderby=comment_count');
		echo '<ul>';
		while ($popular->have_posts()) : $popular->the_post();	
		?><li><a href="<?php the_permalink() ?>" rel="bookmark" class="widget-post-title"><?php the_title(); ?></a>
		  <a class="comments-count" href="<?php the_permalink(); ?>#comments" title="<?php _e('View comments', 'exultic'); ?>"><?php comments_number('0', '1', '%'); ?></a><div class="clearfix"></div>
		  </li>
		<?php endwhile;
		wp_reset_query();
		echo '</ul>';
		
		echo $after_widget;
	}

	/******************** UPDATE WIDGET ********************/
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags
		$instance['title'] = strip_tags($new_instance['title'] );
		$instance['postcount'] = strip_tags($new_instance['postcount'] );

		return $instance;
	}
	
	/******************** WIDGET SETTINGS ********************/
	 
	function form($instance) {

		// Set up some default widget settings
		$defaults = array(
		'title' => __('Most Commented Posts','exultic'),
		'postcount' =>'5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'exultic'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('postcount'); ?>"><?php _e('Number of Posts to Show:', 'exultic'); ?></label> 
			<input id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" type="text" value="<?php echo $instance['postcount']; ?>" size="3"/>
		</p>
		
	<?php
	}
}

?>