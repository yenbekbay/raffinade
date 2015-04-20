<?php 

/******************** INCLUDES ********************/

require_once('meta/post-metaboxes.php');
require_once('meta/admin-metaboxes.php');

/******************** OUTPUT QUOTE ********************/

function exultic_quote($postid) { 
	$quote = get_post_meta($postid, '_exultic_quote_quote', TRUE);
	$author = get_post_meta($postid, '_exultic_quote_author', TRUE);
	if($quote != '') {
		echo '<blockquote>'.$quote.'</blockquote>';
		if($author != '')
			echo '<cite>- '.$author.'</cite>';
	}
}

/******************** OUTPUT LINK ********************/

function exultic_link($postid) { 
	$title= get_post_meta($postid, '_exultic_link_title', TRUE);
	$url = get_post_meta($postid, '_exultic_link_url', TRUE);
	$description = get_post_meta($postid, '_exultic_link_description', TRUE);
	if($title == '') {
		if(get_the_title($postid) != '')
			$title = get_the_title($postid);
		else $title = $url;
	}
	if($url != '') {
		echo "\n".'   <div class="link-url"><a href="'.$url.'">'.$title.'<span>&rarr;</span></a></div>'."\n";  
	if($description != '')
		echo '   <div class="link-description">'.$description.'</div>'."\n";
	}
}

/******************** OUTPUT IMAGE ********************/

function exultic_image($postid) { 
	$imageid = get_post_meta($postid, '_exultic_image_upload', TRUE);
	$imageurl = wp_get_attachment_url($imageid);
	$alt = get_post_meta($imageid, '_wp_attachment_image_alt', true);
	if($imageid != '') {
		echo '<p class="image">
    <a href="'.$imageurl.'" class="prettyphoto-anchor" rel="prettyPhoto" '.$alt.'></a>
    <img src="'.$imageurl.'" alt="'.$alt.'"/>
   </p>'."\n";
	}
}

/******************** OUTPUT AUDIO ********************/

function exultic_gettracks($postid, $number, $pageid) {
	$args = array(
		'numberposts' => $number,
		'order'=> 'ASC',
		'post_mime_type' => 'audio',
		'post_parent' => $postid,
		'post_status' => 'any',
		'post_type' => 'attachment'
	);
	$argsall = array(
		'post_mime_type' => 'audio',
		'post_parent' => $postid,
	);
	if($postid) {
		$id = $postid;
	} else {
		$id = $pageid;
	}
	$count = count(get_children($argsall));	
	$tracks = get_children($args);
	$cut = $number - 1;
	if($count > 1) {
		foreach(array_slice($tracks, $cut) as $track) {
			$trackid = $track->ID;
			$tracktitle = $track->post_title;
			$trackurl = wp_get_attachment_url($trackid);
			$free = get_post_meta($id, '_exultic_audio_free', true);  
			echo '{'."\n";
			echo '		  title: "'.$tracktitle.'",	
                  mp3: "'.$trackurl.'"'; if($free == 'on') { echo ','; } echo "\n";
            if($free == 'on') { echo '		  free: true'."\n"; }				
            echo '	      }'; if($number != $count) { echo ','; } 
		}
	} else { 
		foreach($tracks as $track) {
			$trackid = $track->ID;
			$tracktitle = $track->post_title;
			$trackurl = wp_get_attachment_url($trackid);
            echo '      title: "'.$tracktitle.'",
	              mp3: "'.$trackurl.'"';
		}
	}
}
function exultic_tracks($postid, $pageid) {
	$argsall = array(
		'post_mime_type' => 'audio',
		'post_parent' => $postid,
	);
	$tracks = get_children($argsall);
	$i = 1;	
    foreach($tracks as $track) {
		exultic_gettracks($postid, $i, $pageid);
        $i++;
    }	
}

function exultic_audio($postid, $pageid = null) {
		$argsall = array(
			'post_mime_type' => 'audio',
			'post_parent' => $postid,
		);
		$tracks = get_children($argsall);
		$count = count($tracks);
		if($postid) {
			$id = $postid;
		} else {
			$id = $pageid;
		}
		$free = get_post_meta($id, '_exultic_audio_free', true);
		foreach($tracks as $track) {
			$trackid = $track->ID;
			$tracktitle = $track->post_title;
			$trackurl = wp_get_attachment_url($trackid);
		}
		
		if($tracks) {
		if($count > 1) {
 ?> 
   <script type="text/javascript">
      //<![CDATA[
      $(document).ready(function(){
          new jPlayerPlaylist({
              jPlayer: "#jquery_jplayer_<?php echo $postid; ?>",
              cssSelectorAncestor: "#jp_container_<?php echo $postid; ?>"
          }, [		
              <?php exultic_tracks($postid, $pageid); ?>
        
          ], {
              swfPath: "<?php echo get_template_directory_uri(); ?>/js",
              supplied: "mp3",
              wmode: "window",
              solution: "flash, html"
          });
      });
      //]]>
    </script>
		
    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer"></div>

    <div id="jp_container_<?php echo $postid; ?>" class="jp-audio-container playlist-player">
       <div class="jp-audio">
          <div class="jp-type-playlist">
              <div id="jp-interface_<?php echo $postid; ?>" class="jp-interface">
                  <ul class="jp-controls">
                      <li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
                      <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                      <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                      <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
                      <li><a href="javascript:;" class="jp-mute" tabindex="1">mute</a></li>
                      <li><a href="javascript:;" class="jp-unmute" tabindex="1">unmute</a></li>
                      <li><a href="javascript:;" class="jp-volume-max" tabindex="1">max volume</a></li>
                  </ul>
                  <ul class="jp-toggles">
                      <li><a href="javascript:;" class="jp-shuffle" tabindex="1">shuffle</a></li>
                      <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1">shuffle off</a></li>
                      <li><a href="javascript:;" class="jp-repeat" tabindex="1">repeat</a></li>
                      <li><a href="javascript:;" class="jp-repeat-off" tabindex="1">repeat off</a></li>
                  </ul>
                  <div class="jp-volume-bar">
                      <div class="jp-volume-bar-value"><span></span></div>
                  </div>
                  <div class="jp-progress">
                      <div class="jp-seek-bar">
                          <div class="jp-play-bar"><span class="handle"></span></div>
                      </div>
                  </div>
                  <div class="jp-current-time"></div>
                  <div class="jp-duration"></div>
              </div>
              <div class="jp-playlist">
              <ul>
                  <li></li>
              </ul>
              </div>
              <div class="jp-no-solution">
                  <span>Update Required</span>
                  To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
              </div>	
          </div>
       </div>
    </div>	
  <?php 
 } else {
 ?>
    <script type="text/javascript">
      //<![CDATA[
      $(document).ready(function(){
          $("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
              ready: function (event) {
                  $(this).jPlayer("setMedia", {
                  <?php exultic_gettracks($postid, 1, $pageid); ?>

                  });
              },
              play: function() {
                  jQuery(this).jPlayer("pauseOthers");
              },
              swfPath: "<?php echo get_template_directory_uri(); ?>/js",
              supplied: "mp3",
              cssSelectorAncestor: "#jp_container_<?php echo $postid; ?>",
              wmode: "window",
              solution: "flash, html"
          });
      });
      //]]>
    </script>
		
    <div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer"></div>

    <div id="jp_container_<?php echo $postid; ?>" class="jp-audio-container single-player">
       <div class="jp-audio">
          <div class="jp-type-single">
              <div id="jp-interface_<?php echo $postid; ?>" class="jp-interface">
                  <ul class="jp-controls">
                      <li><div class="seperator-first"></div></li>
                      <li><div class="seperator-second"></div></li>
                      <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                      <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                      <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                      <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                      <li><a href="#" class="jp-volume-max" tabindex="1">max volume</a></li>
                  </ul>
                  <ul class="jp-toggles">
                      <li><a href="javascript:;" class="jp-repeat" tabindex="1">repeat</a></li>
                      <li><a href="javascript:;" class="jp-repeat-off" tabindex="1">repeat off</a></li>
                  </ul>
                  <div class="jp-volume-bar-container">
                      <div class="jp-volume-bar">
                          <div class="jp-volume-bar-value"><span></span></div>
                      </div>
                  </div>
                  <div class="jp-progress-container">
                      <div class="jp-progress">
                          <div class="jp-seek-bar">
                              <div class="jp-play-bar"><span></span></div>
                          </div>
                      </div>
                  </div>
                  <div class="jp-current-time"></div>
                  <div class="jp-duration"></div>
                  <div class="jp-title">
                      <ul>
                      <li class="title-normal" id="title-normal_<?php echo $postid; ?>"><?php echo $tracktitle; ?></li>
                      <li class="title-marquee" id="title-marquee_<?php echo $postid; ?>"><marquee behavior="scroll" scrollamount="1"><?php echo $tracktitle; ?></marquee></li>
                      <script type="text/javascript">
                      $(document).ready(function(){
                          if( $("#title-normal_<?php echo $postid; ?>").width() > '200') {
                          $('#title-normal_<?php echo $postid; ?>').hide();
                          } else {
                          $('#title-marquee_<?php echo $postid; ?>').hide();
						  $('#title-normal_<?php echo $postid; ?>').css('width', '200px');
                          }
                      });
                      </script>
                      </ul>
                  </div>
                  <?php if($free == 'on') { ?><a class="download-link" tabindex="1" href="<?php echo $trackurl; ?>" onclick="ShowDownloading();"></a><?php } ?>			
              </div>
          </div>
          <div class="jp-no-solution">
              <span>Update Required</span>
              To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
          </div>		
       </div>
    </div>	
  <?php
}
}
}

/******************** OUTPUT SOUNDCLOUD ********************/

wp_oembed_add_provider('http://soundcloud.com/*', 'http://soundcloud.com/oembed/');

function exultic_soundcloud($postid) {
    $soundcloud_url = get_post_meta($postid, '_exultic_soundcloud_url', true);
	if($soundcloud_url != '') {
		$soundcloud = wp_oembed_get($soundcloud_url)."\n";
		$soundcloud = preg_replace('/<iframe width="(.*?)"(.*?)maxheight=(.*?)"(.*?)iframe>/i', '<p class="soundcloud"><iframe width="100%"$2maxheight=450&color=ff3300"$4iframe>', $soundcloud);	
		echo $soundcloud;		
	}
}

/******************** OUTPUT VIDEO ********************/

function exultic_embed_video($postid) {
    $embed = get_post_meta($postid, '_exultic_video_embed', true);	
	if($embed != '') {
		if((strpos($embed, 'http') === 0) || (strpos($embed, 'https') === 0)) {
			$embed_code = wp_oembed_get($embed);
		} else {
			$embed_code = htmlspecialchars_decode($embed);
		}
		echo '<p class="video">'.$embed_code.'</p>'."\n";
	}
}

function exultic_video($postid) {
    $mp4 = get_post_meta($postid, '_exultic_video_mp4', true);
	$webm = get_post_meta($postid, '_exultic_video_webm', true);
    $ogv = get_post_meta($postid, '_exultic_video_ogv', true);
    $poster = get_post_meta($postid, '_exultic_video_poster_url', true);
	$poster = wp_get_attachment_url($poster);
	$flash = get_template_directory_uri().'/js/flashmediaelement.swf';
	if($mp4 != '') {			
	echo '<p class="video">
    <video width="540" height="365" id="mejs_player_'.$postid.'" poster="'.$poster.'" controls="controls" preload="none">
     <source type="video/mp4" src="'.$mp4.'" />'."\n";
    if($webm != '') echo '     <source type="video/webm" src="'.$webm.'"/>'."\n";
    if($ogv != '') echo '     <source type="video/ogg" src="'.$ogv.'"/>'."\n";

     echo '     <object width="540" height="365" type="application/x-shockwave-flash" data="'.$flash.'"> 		
      <param name="movie" value="'.$flash.'" /> 
      <param name="flashvars" value="controls=true&amp;poster='.$poster.'&amp;file='.$mp4.'" /> 		
      <img src="'.$poster.'" width="540" height="365" title="No video playback capabilities"/>
     </object> 	
    </video>
   </p>'."\n";
    }
}

/******************** OUTPUT GALLERY ********************/

function exultic_gallery($postid) { 
    $play = get_post_meta($postid, '_exultic_gallery_play', true);	
 ?>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#slider-<?php echo $postid; ?>").slides({
            preload: true,
            preloadImage: $("#slider-<?php echo $postid; ?>").attr('data-loader'), 
            next: 'slides_next',
            prev: 'slides_prev',
            effect: 'slide',
            crossfade: true,
            autoHeight: true,
            bigTarget: true,
            <?php if($play == 'on') { ?>
            play: 5000,
            pause: 2500,<?php } 
			?>generatePagination: true,
            animationComplete: function(current) {
                var myImgs = $("#slider-<?php echo $postid; ?>").find('img'),
                    myTitle = myImgs[current-1].title;
                $("#slider-<?php echo $postid; ?>").next('.entry-title').html(myTitle);
            }
        });
    });
   </script>
  <?php 
    $loader = 'ajax-loader.gif';
    $thumbid = 0;
    
    // get the featured image for the post
    if(has_post_thumbnail($postid))
        $thumbid = get_post_thumbnail_id($postid);
    echo "\n".'   <div id="slider-'.$postid.'" class="slider" data-loader="'.get_template_directory_uri().'/images/'.$loader.'">';
        
    $posttitle = the_title_attribute(array('echo' => 0));
        
    // get all of the attachments for the post
    $args = array(
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_type' => 'attachment',
        'post_parent' => $postid,
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => -1
    );
    $attachments = get_posts($args);
    if( !empty($attachments) ) {
        echo "\n".'    <div class="slides_container">';
        $i = 0;
        foreach($attachments as $attachment) {
            if($attachment->ID == $thumbid) continue;
            $src = wp_get_attachment_image_src($attachment->ID, 'slider-image');
			$srcfull = wp_get_attachment_image_src($attachment->ID, 'large');
            $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            $alt = ($alt) ? $alt : $posttitle;
            echo "\n".'     <div><a class="prettyphoto-anchor" href="'.$srcfull[0].'" rel="prettyPhoto['.get_the_ID().']" alt="'.$alt.'"></a><img height="'.$src[2].'" width="'.$src[1].'" src="'.$src[0].'" alt="'.$alt.'" title=""></div>';
            $i++;
        }
        echo "\n".'    </div>';
    }
    echo "\n   </div>\n";
}

?>