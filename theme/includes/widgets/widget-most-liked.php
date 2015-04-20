<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_most_liked_widget_init');

// Register widget
function exultic_most_liked_widget_init() {
	register_widget('exultic_most_liked_widget');
}

// Widget class
class exultic_most_liked_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/
	
	function exultic_most_liked_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_most_liked_widget','description' => __('The most liked posts on your blog','exultic') );
		
		$control_ops = array('id_base' => 'exultic_most_liked_widget');

		// Create the widget
		$this->WP_Widget('exultic_most_liked_widget', __('Most Liked Posts','exultic'), $widget_ops, $control_ops);
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
		
		// Get Data
		global $wpdb;
		 $querystr = "
			SELECT $wpdb->posts.*, (meta_value+0) AS likes
			FROM $wpdb->posts, $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
			AND $wpdb->postmeta.meta_key = '_likes' 
			AND $wpdb->posts.post_status = 'publish' 
			AND $wpdb->posts.post_type = 'post'
			ORDER BY likes DESC
			LIMIT " . $postcount;
			
		// Display The Most Liked Posts
		 $pageposts = $wpdb->get_results($querystr, OBJECT);
		  if ($pageposts):
		  global $post;
		  echo '<ul>';
		  foreach ($pageposts as $post):
		  setup_postdata($post);		
		  ?><li><a href="<?php the_permalink() ?>" rel="bookmark" class="widget-post-title"><?php the_title(); ?></a>
		    <span class="likes-count"><?php echo get_post_meta(get_the_id(),"_likes",1); ?></span><div class="clearfix"></div>
		    </li>
		  <?php endforeach;
		  echo '</ul>';
		  endif; 

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
		'title' => __('Most Liked Posts','exultic'),
		'postcount' =>'5',
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

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