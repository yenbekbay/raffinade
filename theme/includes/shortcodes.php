<?php

// Enable shortcodes in widget areas
add_filter('widget_text', 'do_shortcode');

/******************** COLUMNS ********************/

// Two Columns
function exultic_shortcode_one_half($atts, $content = null) {
	return '<div class="one-half">'.$content.'</div>';
}
add_shortcode('one_half', 'exultic_shortcode_one_half');

function exultic_shortcode_one_half_last($atts, $content = null) {
	return '<div class="one-half last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'exultic_shortcode_one_half_last');

// Three Columns
function exultic_shortcode_one_third($atts, $content = null) {
	return '<div class="one-third">'.$content.'</div>';
}
add_shortcode('one_third', 'exultic_shortcode_one_third');

function exultic_shortcode_one_third_last($atts, $content = null) {
	return '<div class="one-third last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'exultic_shortcode_one_third_last');

function exultic_shortcode_two_third($atts, $content = null) {
	return '<div class="two-third">'.$content.'</div>';
}
add_shortcode('two_third', 'exultic_shortcode_two_third');

function exultic_shortcode_two_third_last($atts, $content = null) {
	return '<div class="two-third last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('two_third_last', 'exultic_shortcode_two_third_last');

// Four Columns
function exultic_shortcode_one_fourth($atts, $content = null) {
   return '<div class="one-fourth">'.$content.'</div>';
}
add_shortcode('one_fourth', 'exultic_shortcode_one_fourth');

function exultic_shortcode_one_fourth_last($atts, $content = null) {
   return '<div class="one-fourth last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'exultic_shortcode_one_fourth_last');

function exultic_shortcode_two_fourth($atts, $content = null) {
   return '<div class="two-fourth">'.$content.'</div>';
}
add_shortcode('two_fourth', 'exultic_shortcode_two_fourth');

function exultic_shortcode_two_fourth_last($atts, $content = null) {
   return '<div class="two-fourth last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('two_fourth_last', 'exultic_shortcode_two_fourth_last');

function exultic_shortcode_three_fourth($atts, $content = null) {
   return '<div class="three_fourth">'.$content.'</div>';
}
add_shortcode('three_fourth', 'exultic_shortcode_three_fourth');

function exultic_shortcode_three_fourth_last($atts, $content = null) {
   return '<div class="three-fourth last">'.$content.'</div><div class="clear"></div>';
}
add_shortcode('three_fourth_last', 'exultic_shortcode_three_fourth_last');


/******************** DIVIDE TEXT ********************/

function exultic_shortcode_divider($atts, $content = null) {
   return '<hr>';
}
add_shortcode('divider', 'exultic_shortcode_divider');


/******************** TEXT HIGHLIGHT & INFO BOXES ********************/

function exultic_shortcode_highlight($atts, $content = null) {
   return '<span class="highlight">'.$content.'</span>';
}
add_shortcode('highlight', 'exultic_shortcode_highlight');

function exultic_shortcode_yellow_box($atts, $content = null) {
   return '<div class="exultic-box yellow">'.$content.'</div>';
}
add_shortcode('yellow_box', 'exultic_shortcode_yellow_box');

function exultic_shortcode_red_box($atts, $content = null) {
   return '<div class="exultic-box red">'.$content.'</div>';
}
add_shortcode('red_box', 'exultic_shortcode_red_box');

function exultic_shortcode_green_box($atts, $content = null) {
   return '<div class="exultic-box green">'.$content.'</div>';
}
add_shortcode('green_box', 'exultic_shortcode_green_box');

/******************** QUOTE ********************/

function exultic_shortcode_quote($atts, $content=null) {  
    extract(shortcode_atts( array(  
        'author' => ''
    ), $atts));  
    return '<blockquote><p>'.$content.'<cite>- '.$author.'</cite></p></blockquote>';  
}  
add_shortcode('quote', 'exultic_shortcode_quote');  

/******************** YOUTUBE ********************/

function exultic_shortcode_youtube_video($atts, $content=null) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '650',  
        'height' => '366'  
    ), $atts));  
    return '<p><iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe></p>';  
}  
add_shortcode('youtube', 'exultic_shortcode_youtube_video');  

/******************** VIMEO ********************/

function exultic_shortcode_vimeo_video($atts, $content=null) {  
    extract(shortcode_atts( array(  
        'id' => '',  
        'width' => '650',  
        'height' => '366'
    ), $atts));  
    return '<p><iframe src="http://player.vimeo.com/video/'.$id.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe></p>';  
}  
add_shortcode('vimeo', 'exultic_shortcode_vimeo_video');  

?>