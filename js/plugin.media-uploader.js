(function($){
	
	//version tracking
	var ver = "1.0.0";
		
	$.fn.wp_media_uploader = function(opts){
		
		var defaults = {
				'preview' : '.preview-upload',
	            'text'    : '.commentbar_thumbnail',
	            'button'  : '.button-upload'
		};
		
		var options = $.extend(defaults, opts);
		
		// When the Button is clicked...
		$(options.button).click(function(){
			//get the text element
			var text = $(this).siblings(options.text);
			
			// Show WP Media Uploader popup
            tb_show('Upload a logo', 'media-upload.php?referer=comment_bar&type=image&TB_iframe=true&post_id=0', false);
            
            // Re-define the global function 'send_to_editor'
    		// Define where the new value will be sent to
            window.send_to_editor = function(html) {
            	// Get the URL of new image
                var src = $('img', html).attr('src');
                // Send this value to the Text field.
                text.attr('value', src).trigger('change'); 
                tb_remove(); // Then close the popup window
            };
            
            return false;
		});
		
		$(options.text).bind('change', function() {
        	// Get the value of current object
            var url = this.value;
            // Determine the Preview field
            var preview = $(this).siblings(options.preview);
            // Bind the value to Preview field
            $(preview).attr('src', url);
        });
	};	
	
}(jQuery));


//attach it anywhere in the page
jQuery(document).ready(function($){
		
	var victoria = {
		'preview' : '#victoria_preview',
        'text'    : '#victoria_text',
        'button'  : '#victoria_button'	
	};
	$('.victoria_shop').wp_media_uploader(victoria);
	
	var sixpm = {
		'preview' : '#sixpm_preview',
        'text'    : '#sixpm_text',
        'button'  : '#sixpm_button'	
	};
	$('.sixpm_shop').wp_media_uploader(sixpm);	
	
});
