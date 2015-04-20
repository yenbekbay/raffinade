jQuery(document).ready(function($){

	$('.exultic-metabox-table .button').click(function() {
		var tbURL = $('#content-add_media').attr('href'),
			button = $(this),
			id = button.attr('name').replace('_button', '');

		tb_show('', tbURL);
		
		if($(this).hasClass('image_upload')) {
		    window.send_to_editor = function(html) {		
				var imgurl = $('img', html).attr('src'),
					classes = $('img', html).attr('class');					
				imgid = classes.replace(/(.*?)wp-image-/, '');
				$('#id'+ id).val(imgid);		
				$('#url'+ id).val(imgurl);
				$('#preview'+ id).attr('src', imgurl);
				$('#load'+ id).show();
				setTimeout(function() { $('#load'+ id).hide(); }, 1000);
				setTimeout(function() { $('#preview'+ id).css('display', 'block'); }, 1000);
				setTimeout(function() { $('#clear'+ id).css('display', 'block'); }, 1000);	
    			tb_remove();
    		}		
		} 
		
		if($(this).attr('id') == 'exultic_file_upload' ) {
		    window.send_to_editor = function(html) {		
				var hrefurl = jQuery(html).attr('href');
    			$('#'+ id).val(hrefurl);
    			tb_remove();
    		}		
		} 
		
    	return false;
	});
	
	$('.image_upload').each(function() {
		id = $(this).attr('name').replace('_button', '');
		if( !$('#url'+ id).val() ) {
			$('#preview'+ id).css('display', 'none');
			$('#clear'+ id).css('display', 'none');
		} else {
			$('#preview'+ id).css('display', 'block');
		}
	});
	
    $('.exultic_clear_image_button').click(function() {  
		id = $(this).attr('id').replace('clear', '');
    	$('#url'+ id).val('');
		$('#id'+ id).val('');	
		$('#preview'+ id).hide();
        $(this).hide();

        return false;  
    });  	

});
