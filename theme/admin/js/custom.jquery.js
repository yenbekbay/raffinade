jQuery(document).ready(function($){

	if($('input#opengraph').attr('checked')) {
		$('#fb_id').show();
	}
	
	$('input#opengraph').click(function() {
		if(!$(this).attr('checked')) {	
			$('#fb_id').slideUp('fast');
		} else {
			$('#fb_id').slideDown('fast');
		}
	});
	
	if($('input#twitter').attr('checked')) {
		$('#twitter-username').show();
	}
	
	$('input#twitter').click(function() {
		if(!$(this).attr('checked')) {	
			$('#twitter-username').slideUp('fast');
		} else {
			$('#twitter-username').slideDown('fast');
		}
	});
	
	$('.layout-radio').parent().css('width', '510px');
	
});