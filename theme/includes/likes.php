<?php

/******************** POST LIKES ********************/

function exultic_like($postid,$action = 'get') {

	if(!is_numeric($postid)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	}

	switch($action) {	
		case 'get':
			$data = get_post_meta($postid, '_likes');
			if(!is_numeric($data[0])) {
				$data[0] = 0;
				add_post_meta($postid, '_likes', '0', true);
			}
			return $data[0];
		break;
		
		case 'update':
			if(isset($_COOKIE["like_" . $postid])) {
				return;
			}
			$currentValue = get_post_meta($postid, '_likes');
			if(!is_numeric($currentValue[0])) {
				$currentValue[0] = 0;
				add_post_meta($postid, '_likes', '1', true);
			}
			$currentValue[0]++;
			update_post_meta($postid, '_likes', $currentValue[0]);			
			setcookie("like_" . $postid, $postid,time()+(60*60*24*365));
		break;
	}
}

function exultic_setup_likes($postid) {
	if(!is_numeric($postid)) {
		error_log("Error: Value submitted for post_id was not numeric");
		return;
	}
	add_post_meta($postid, '_likes', '0', true);
}

function exultic_check_headers() {
	if(isset($_POST["likepost"])) {
		exultic_like($_POST["likepost"],'update');
	}
}
add_action ('publish_post', 'exultic_setup_likes');
add_action ('init', 'exultic_check_headers');

?>