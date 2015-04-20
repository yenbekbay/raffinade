<?php

/******************** CREATE THE POST FORMAT META BOXES ********************/
 
function exultic_post_metaboxes() {
	global $_wp_post_type_features;
	if (isset($_wp_post_type_features['post']['editor']) && $_wp_post_type_features['post']['editor']) {
		unset($_wp_post_type_features['post']['editor']);
    }
	
	// Create a post options metabox
	$meta_box = array(
		'id' => 'exultic_post_options',
		'title' => __('Post Options', 'exultic'),
		'page' => 'post',
		'context' => 'side',
		'priority' => 'default',
		'fields' => array(
    		array(
    				'name' =>  __('Show Post Title?', 'exultic'),
    				'id' => '_exultic_post_title',
    				'type' => 'checkbox',
    				'std' => 'on'
    			),
			array(
			        'name'=> __('Post Content', 'exultic'),  
					'id'	=> '_exultic_post_content',
					'type'	=> 'select',
					'options' => array (
						'full' => array (
							'label' => __('Full', 'exultic'),
							'value'	=> 'full'
						),
						'excerpt' => array (
							'label' => __('Excerpt', 'exultic'),
							'value'	=> 'excerpt'
						)
					)
				)
		)					
	);
    exultic_add_meta_box($meta_box);

	// Create a page options metabox
	$meta_box = array(
		'id' => 'exultic_page_options',
		'title' => __('Page Options', 'exultic'),
		'page' => 'page',
		'context' => 'side',
		'priority' => 'default',
		'fields' => array(
    		array(
    				'name' => __('Hide Page Title?', 'exultic'),
    				'id' => '_exultic_page_title',
    				'type' => 'checkbox'
    			),
    		array(
    				'name' => __('Disable Sharing?', 'exultic'),
    				'id' => '_exultic_page_sharing',
    				'type' => 'checkbox'
    			)
		)					
	);
    exultic_add_meta_box($meta_box);
	
    // Create an image metabox
	$meta_box = array(
		'id' => 'exultic-metabox-post-image',
		'title' => __('Image', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
    		array(
    				'name' => __('Image File', 'exultic'),
    				'id' => '_exultic_image_upload',
    				'type' => 'image',
					'std' => __('Upload', 'exultic')
    			)
		)
	);
    exultic_add_meta_box($meta_box);
	
    // Create a gallery metabox
	$meta_box = array(
		'id' => 'exultic-metabox-post-gallery',
		'title' => __('Gallery', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
    		array(
    				'name' => __('Upload Images', 'exultic'),
    				'id' => '_exultic_gallery_upload',
    				'type' => 'images',
    				'std' => __('Upload', 'exultic')
    			),
    		array(
    				'name' => __('Enable Autoplay?', 'exultic'),
    				'id' => '_exultic_gallery_play',
    				'type' => 'checkbox',
    			)
		)
	);
    exultic_add_meta_box($meta_box);
    
    // Create a quote metabox
    $meta_box = array(
		'id' => 'exultic-metabox-post-quote',
		'title' => __('Quote', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
					'name' => __('Quote', 'exultic'),
					'id' => '_exultic_quote_quote',
					'type' => 'textarea',
				),
			array(
					'name' => __('Author', 'exultic'),
					'desc' => __('(optional)', 'exultic'),
					'id' => '_exultic_quote_author',
					'type' => 'text',
				)
		)
	);
    exultic_add_meta_box($meta_box);
	
	// Create a link metabox
	$meta_box = array(
		'id' => 'exultic-metabox-post-link',
		'title' => __('Link', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
					'name' => __('Title', 'exultic'),
					'id' => '_exultic_link_title',
					'type' => 'text',
					'std' => ''
				),
			array(
					'name' => 'URL',
					'desc' => __('(with http://)', 'exultic'),
					'id' => '_exultic_link_url',
					'type' => 'text',
					'std' => ''
				),
			array(
					'name' => __('Description', 'exultic'),
					'desc' => __('(optional)', 'exultic'),
					'id' => '_exultic_link_description',
					'type' => 'textarea',
					'std' => ''
				)
		)
	);
    exultic_add_meta_box($meta_box);
    
    // Create a video metabox
    $meta_box = array(
		'id' => 'exultic-metabox-post-video',
		'title' => __('Video Settings', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array( 
					'name' => __('MP4 File URL', 'exultic'),
					'id' => '_exultic_video_mp4',
					'type' => 'file',
    				'std' => __('Upload', 'exultic')
				),
			array( 
					'name' => __('WEBM File URL', 'exultic'),
					'desc' => __('(for Firefox 4 and Opera)', 'exultic'),
					'id' => '_exultic_video_webm',
					'type' => 'file',
    				'std' => __('Upload', 'exultic')
				),
			array( 
					'name' => __('OGG File URL', 'exultic'),
					'desc' => __('(for Firefox 3)', 'exultic'),
					'id' => '_exultic_video_ogv',
					'type' => 'file',
    				'std' => __('Upload', 'exultic')
				),
			array( 
					'name' => __('Poster Image', 'exultic'),
					'desc' => __('The preview image should be 540px wide.', 'exultic'),
					'id' => '_exultic_video_poster_url',
					'type' => 'image',
    				'std' => __('Upload', 'exultic')
				)
		)
	);
	exultic_add_meta_box($meta_box);
	
    // Create a video embed metabox
    $meta_box = array(
		'id' => 'exultic-metabox-post-video-embed',
		'title' => __('Embed External', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
					'name' => __('Video URL or Embed Code', 'exultic'),
					'id' => '_exultic_video_embed',
					'type' => 'textarea'
				)
		)
	);
	exultic_add_meta_box($meta_box);
	
	// Create an audio metabox
	$meta_box = array(
		'id' => 'exultic-metabox-post-audio',
		'title' => __('Audio Settings', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
    		array(
    				'name' => __('Upload Files', 'exultic'),
    				'id' => '_exultic_audio_upload',
    				'type' => 'files',
    				'std' => __('Upload', 'exultic')
    			),
    		array(
    				'name' => __('Allow Downloads?', 'exultic'),
    				'id' => '_exultic_audio_free',
    				'type' => 'checkbox',
    				'std' => 'on'
    			)
		)
	);
	exultic_add_meta_box($meta_box);	
	
	// Create a Soundcloud metabox
	$meta_box = array(
		'id' => 'exultic-metabox-post-soundcloud',
		'title' => __('Embed Soundcloud Player', 'exultic'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array( 
					'name' => __('Embed URL', 'exultic'),
					'id' => '_exultic_soundcloud_url',
					'type' => 'text',
					'std' => ''
				)
		)
	);
	exultic_add_meta_box($meta_box);
	
	// Create an audio metabox
	$meta_box = array(
		'id' => 'exultic-metabox-page-audio',
		'title' => __('Audio Settings', 'exultic'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
    		array(
    				'name' => __('Allow Downloads?', 'exultic'),
    				'id' => '_exultic_audio_free',
    				'type' => 'checkbox',
    				'std' => 'on'
    			)
		)
	);
	exultic_add_meta_box($meta_box);	
	
	// Create an editor box
	add_meta_box(
		'editor_box',
		__('Description'),
		'editor_box',
		'post', 'normal', 'low'
	);
}
add_action('add_meta_boxes', 'exultic_post_metaboxes');
	
function editor_box($post) {
	wp_editor($post->post_content, 'content', $settings = array('dfw' => true));
}

?>