jQuery(document).ready(function($) {

/******************** DISPLAY POST FORMAT META BOXES ********************/

    // Grab our vars
	var postOptions = $('#exultic_post_options'),
		quoteOptions = $('#exultic-metabox-post-quote'),
		quoteTrigger = $('#post-format-quote'),
		linkOptions = $('#exultic-metabox-post-link'),
		linkTrigger = $('#post-format-link'),
		audioOptions = $('#exultic-metabox-post-audio'),
		soundcloudOptions = $('#exultic-metabox-post-soundcloud'),
		audioTrigger = $('#post-format-audio'),
		videoOptions = $('#exultic-metabox-post-video'),
		embedOptions = $('#exultic-metabox-post-video-embed'),
		videoTrigger = $('#post-format-video'),
		imageOptions = $('#exultic-metabox-post-image'),		
		imageTrigger = $('#post-format-image'),		
		galleryOptions = $('#exultic-metabox-post-gallery'),
		galleryTrigger = $('#post-format-gallery'),
		asideTrigger = $('#post-format-aside'),
		chatTrigger = $('#post-format-chat'),
		editor = $('#editor_box'),
		group = $('#post-formats-select input'),
		audioTemp = $('select#page_template'),
		audioTempTrigger = $('#page_template option[value="audio.php"]'),
		audioTempOptions = $('#exultic-metabox-page-audio');

    // Hide and show sections as needed
    exulticHideAll(null);	
	
	group.change(function() {
		exulticHideAll(null);		
		
		if($(this).val() == 'quote') {
			quoteOptions.css('display', 'block');	
		} else if($(this).val() == 'link') {
			linkOptions.css('display', 'block');
		} else if($(this).val() == 'audio') {
			audioOptions.css('display', 'block');
			soundcloudOptions.css('display', 'block');
			editor.css('display', 'block');
			postOptions.css('display', 'block');	
		} else if($(this).val() == 'video') {
			videoOptions.css('display', 'block');
			embedOptions.css('display', 'block');
			editor.css('display', 'block');
			postOptions.css('display', 'block');	
		} else if($(this).val() == 'image') {
		    imageOptions.css('display', 'block');		
			editor.css('display', 'block');
			postOptions.css('display', 'block');
		} else if($(this).val() == 'gallery') {
		    galleryOptions.css('display', 'block');
			editor.css('display', 'block');
			postOptions.css('display', 'block');	
		} else if($(this).val() == 'aside') {
			editor.css('display', 'block');
			postOptions.css('display', 'block');
		} else if($(this).val() == 'image') {
			editor.css('display', 'block');
			postOptions.css('display', 'block');
		} else if($(this).val() == 'chat') {
			editor.css('display', 'block');
			postOptions.css('display', 'block');
		}
	});
	
	audioTemp.change(function() {
		audioTempOptions.css('display', 'none');
		if(audioTempTrigger.attr('selected') == 'selected')
			audioTempOptions.css('display', 'block');
	});
	
	if(audioTempTrigger.attr('selected') == 'selected')
		audioTempOptions.css('display', 'block');
	
	if(quoteTrigger.is(':checked'))
		quoteOptions.css('display', 'block');
		
	if(linkTrigger.is(':checked'))
		linkOptions.css('display', 'block');
	
	if(audioTrigger.is(':checked'))	
		audioOptions.css('display', 'block');	

	if(audioTrigger.is(':checked'))	
		soundcloudOptions.css('display', 'block');
		
	if(audioTrigger.is(':checked'))	
		editor.css('display', 'block');
	
	if(audioTrigger.is(':checked'))		
		postOptions.css('display', 'block');
		
	if(videoTrigger.is(':checked'))
		videoOptions.css('display', 'block');
		
	if(videoTrigger.is(':checked'))
		embedOptions.css('display', 'block');
		
	if(videoTrigger.is(':checked'))
		editor.css('display', 'block');

	if(videoTrigger.is(':checked'))		
		postOptions.css('display', 'block');
		
	if(imageTrigger.is(':checked'))
		imageOptions.css('display', 'block');
		
	if(imageTrigger.is(':checked'))
		editor.css('display', 'block');
		
	if(imageTrigger.is(':checked'))
		postOptions.css('display', 'block');
		
	if(galleryTrigger.is(':checked'))
		galleryOptions.css('display', 'block');
		
	if(galleryTrigger.is(':checked'))
		editor.css('display', 'block');

	if(galleryTrigger.is(':checked'))		
		postOptions.css('display', 'block');
		
	if(asideTrigger.is(':checked'))
		editor.css('display', 'block');

	if(asideTrigger.is(':checked'))		
		postOptions.css('display', 'block');

	if(imageTrigger.is(':checked'))		
		postOptions.css('display', 'block');
		
	if(chatTrigger.is(':checked'))
		editor.css('display', 'block');

	if(chatTrigger.is(':checked'))		
		postOptions.css('display', 'block');
		
    function exulticHideAll(notThisOne) {
		videoOptions.css('display', 'none');
		embedOptions.css('display', 'none');
		quoteOptions.css('display', 'none');
		linkOptions.css('display', 'none');
		audioOptions.css('display', 'none');
		soundcloudOptions.css('display', 'none');
		imageOptions.css('display', 'none');
		galleryOptions.css('display', 'none');
		editor.css('display', 'none');
		postOptions.css('display', 'none');
		audioTempOptions.css('display', 'none');
    }
	
});