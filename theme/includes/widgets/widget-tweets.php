<?php
// Add function to widgets_init that'll load our widget.
add_action('widgets_init','exultic_tweet_widget_init');

// Register widget
function exultic_tweet_widget_init() {
	register_widget('exultic_tweet_widget');
}

// Widget class
class exultic_tweet_widget extends WP_Widget {

	/******************** WIDGET SETUP ********************/
	
	function exultic_tweet_widget() {
	
		// Widget settings
		$widget_ops = array('classname' => 'exultic_tweet_widget','description' => __('Display your latest tweets','exultic'));
		
		// Widget control settings
		$control_ops = array('id_base' => 'exultic_tweet_widget');

		// Create the widget
		$this->WP_Widget('exultic_tweet_widget', __('Twitter','exultic'), $widget_ops, $control_ops);
	}

	/******************** DISPLAY WIDGET ********************/
	
	function widget($args, $instance){
		extract($args);

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$postcount = $instance['postcount'];
		$tweettext = $instance['tweettext'];

		echo $before_widget;

		// Display the widget title if one was input
		if ($title)
			echo $before_title . $title . $after_title;

		// Display Latest Tweets
?>
  <div id="twitter_div" class="clearfix">
   <div id="twitter-top"><a href="http://twitter.com/<?php echo $username ?>" id="twitter-icon" title="<?php __('Follow Me On Twitter','exultic') ?>"></a></div>
   <ul id="twitter_update_list">
    <li>&nbsp;</li>
   </ul>
   <div id ="twitter-bottom"><span>@<?php echo $username ?></span><a href="http://twitter.com/<?php echo $username ?>" id="twitter-link"><?php echo $tweettext ?></a></div>
  </div>
  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/twitter-blogger.js"></script>
  <script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $username ?>.json?callback=twitterCallback2&amp;count=<?php echo $postcount ?>"></script>		
<?php

		echo $after_widget;
	}

	/******************** UPDATE WIDGET ********************/
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// Strip tags
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['postcount'] = strip_tags( $new_instance['postcount'] );
		$instance['tweettext'] = strip_tags( $new_instance['tweettext'] );

		return $instance;
	}
	
	/******************** WIDGET SETTINGS ********************/
	 
	function form($instance){

		// Set up some default widget settings
		$defaults = array(
		'title' => __('Latest Tweets','exultic'),
		'username' =>'',
		'postcount' =>'5',
		'tweettext' => __('Follow','exultic'),
		);
		$instance = wp_parse_args((array)$instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('postcount'); ?>"><?php _e('Number of tweets (max 20):','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('postcount'); ?>" name="<?php echo $this->get_field_name('postcount'); ?>" value="<?php echo $instance['postcount']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('tweettext'); ?>"><?php _e('Follow Text:','exultic') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('tweettext'); ?>" name="<?php echo $this->get_field_name('tweettext'); ?>" value="<?php echo $instance['tweettext']; ?>"/>
		</p>
		
	<?php
	}
}

?>