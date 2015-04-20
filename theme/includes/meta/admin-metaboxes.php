<?php

/******************** ADD A CUSTOM META BOX ********************/

function exultic_add_meta_box($meta_box) {
    if(!is_array($meta_box)) return false;
    
    // Create a callback function
    $callback = create_function('$post,$meta_box', 'exultic_create_meta_box($post, $meta_box["args"]);');

    add_meta_box($meta_box['id'], $meta_box['title'], $callback, $meta_box['page'], $meta_box['context'], $meta_box['priority'], $meta_box);
}

/******************** CREATE CONTENT FOR A CUSTOM META BOX ********************/

function exultic_create_meta_box($post, $meta_box) {	
    if(!is_array($meta_box)) return false;
    
    if(isset($meta_box['description']) && $meta_box['description'] != '')
    	echo '<p>'. $meta_box['description'] .'</p>';
    
	wp_nonce_field(basename(__FILE__), 'exultic_meta_box_nonce');
	echo '<table class="form-table exultic-metabox-table">';
 
	foreach($meta_box['fields'] as $field) {
	
		// Get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		echo '<tr><th><label for="'. $field['id'] .'"><strong>'. $field['name'] .'</strong>
			  <span>'. $field['desc'] .'</span></label></th>';
		
		switch($field['type']) {	
		
			case 'text':
				echo '<td><input type="text" name="exultic_meta['.$field['id'].']" id="'.$field['id'] .'" value="'.($meta ? $meta : $field['std']).'" style="width: 450px"/></td>';
				break;	
				
			case 'textarea':
				echo '<td><textarea name="exultic_meta['.$field['id'].']" id="'.$field['id'].'" rows="3" style="width: 450px">'.($meta ? $meta : $field['std']).'</textarea></td>';
				break;

			case 'file':
				echo '<td><input type="text" name="exultic_meta['.$field['id'].']" id="'.$field['id'].'" value="'.$meta.'" onclick="jQuery(this).select();" style="width: 430px" class="file"/><input type="button" class="button" id="exultic_file_upload" name="'.$field['id'].'_button" value="'.$field['std'].'"/></td>';	
				break;
				
			case 'files':
				global $post;
				$postid = $post->ID;
				$args = array('orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'attachment', 'post_parent' => $postid, 'post_mime_type' => 'audio', 'post_status' => null, 'numberposts' => -1);
				$tracks = get_posts($args);
				echo '<td><input type="button" class="button" name="'.$field['id'].'_button" id="exultic_files_upload" value="'.$field['std'].'"/>';	
				if ($tracks) {
					echo '<ol>';	
					foreach ( $tracks as $track ) {
						$trackid = $track->ID;
						$tracktitle = $track->post_title;
						echo '<li>'.$tracktitle.'</li>';
					}
					echo '</ol';	
				}	
				echo '</td>';				
				break;
				
			case 'image':
				$url = wp_get_attachment_url($meta);
				echo '<td><input name="exultic_meta['.$field['id'].']" type="hidden" id="id'.$field['id'].'" value="'.$meta.'" class="exultic_image_id"/>
				      <input type="text" id="url'.$field['id'].'" value="'.$url.'" onclick="jQuery(this).select();" style="width: 430px" class="exultic_image_url"/><input type="button" class="button image_upload" name="'.$field['id'].'_button" id="button'.$field['id'].'" value="'.$field['std'].'"/>
					  <div class="exultic_loading_image" id="load'.$field['id'].'"></div><img src="'.$url.'" class="exultic_preview_image" id="preview'.$field['id'].'" alt="" style="margin: 10px 0; width: 300px"/>		
					  <small><a href="#" class="exultic_clear_image_button" id="clear'.$field['id'].'">'.__('Remove Image', 'exultic').'</a></small></td>';	
				break;
			
			case 'images':
				global $post;
				$postid = $post->ID;
				$args = array('orderby' => 'menu_order', 'order' => 'ASC', 'post_type' => 'attachment', 'post_parent' => $postid, 'post_mime_type' => 'image', 'post_status' => null, 'numberposts' => -1);
				$images = get_posts($args);		    
				echo '<td><input type="button" class="button" name="exultic_meta['. $field['id'] .']" id="exultic_images_upload" value="'.$field['std'].'" style="display: block"/>';
				if ($images) {
					foreach ($images as $image) {
						$imagesrc = wp_get_attachment_image_src($image->ID , 'thumbnail');
						echo '<img src="'.$imagesrc[0].'" width="90" height="90" style="margin: 10px 10px 0 0">';
					}
				}				   
			    echo '</td>';
				break;
				
			case 'select':
				echo'<td><select name="exultic_meta['.$field['id'].']" id="'.$field['id'].'">';
				foreach($field['options'] as $option){
					echo'<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'"';
					echo'>'.$option['label'].'</option>';
				}
				echo'</select></td>';
				break;
				
			case 'radio':
				echo '<td>';
				foreach($field['options'] as $option){
					echo '<label class="radio-label"><input type="radio" name="exultic_meta['. $field['id'] .']" value="'. $option .'" class="radio"';
					if($meta){ 
						if($meta == $option) echo ' checked="checked"'; 
					} else {
						if($field['std'] == $option) echo ' checked="checked"';
					}
					echo '/>'.$option.'</label> ';
				}
				echo '</td>';
				break;

			case 'checkbox':
			    echo '<td>';
			    $val = '';
                if($meta) {
                    if($meta == 'on') $val = 'checked="checked"';
                } else {
                    if($field['std'] == 'on') $val = 'checked="checked"';
                }

                echo '<input type="hidden" name="exultic_meta['.$field['id'].']" value="off" />
                      <input type="checkbox" id="'.$field['id'].'" name="exultic_meta['.$field['id'].']" value="on" '. $val .'/>';
			    echo '</td>';
			    break;				
		}	
		echo '</tr>';
	}
	echo '</table>';
}

/******************** SAVE CUSTOM META BOX ********************/

function exultic_save_meta_box($post_id) {

	if (defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return;
	
	if (!isset($_POST['exultic_meta']) || !isset($_POST['exultic_meta_box_nonce']) || !wp_verify_nonce($_POST['exultic_meta_box_nonce'], basename( __FILE__ )))
		return;
	
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) return;
	} else {
		if (!current_user_can('edit_post', $post_id)) return;
	}
 
	foreach($_POST['exultic_meta'] as $key=>$val) {
		update_post_meta($post_id, $key, stripslashes(htmlspecialchars($val)));
	}

}
add_action('save_post', 'exultic_save_meta_box');

/******************** REGISTER RELATED SCRIPTS & STYLES ********************/

function exultic_metabox_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('exultic-upload', get_template_directory_uri().'/includes/meta/js/upload-button.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('exultic-upload');
    wp_register_script('metaboxes', get_template_directory_uri().'/includes/meta/js/metaboxes.jquery.js', 'jquery');
    wp_enqueue_script('metaboxes');
}
function exultic_metabox_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_enqueue_scripts', 'exultic_metabox_scripts');
add_action('admin_print_styles', 'exultic_metabox_styles');

/******************** CUSTOM STYLES ********************/

function exultic_custom_admin_styles() {
    echo '<style type="text/css">
    #editor_box { background: none; border: none; }
    #editor_box h3 { display: none; }
    #editor_box .inside { padding: 0; margin-top: 0; }
    #editor_box .handlediv { display: none; }
    #titlediv { margin-bottom: 33px; }
	.exultic_loading_image { display: none; width: 16px; height: 16px; margin:  10px auto 0; background: url('.home_url().'/wp-admin/images/wpspin_light.gif); }
</style>';
}
add_action('admin_head', 'exultic_custom_admin_styles');

?>