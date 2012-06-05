$(function(){

	$('#addcat').click(function() {
		
			var cat = jQuery('#newcat').val();
			
			if (jQuery('#newcat').val() == '') {
				jQuery('#newcat').addClass('error');
			} else if(isNaN(jQuery('#newcat').val())) {
			
				jQuery('#newcat').removeClass('error');
			
				jQuery.post("../core/ajax.php", { action: "Blog", catname: cat},
					
					function(data) {
						
						jQuery('<li>' + cat + '<input type="checkbox" name="categories[]" value="' + data + '" checked="checked" />').appendTo('#blog-cats ul');
						
						jQuery('#newcat').val('');
						
					}
					
				);
				
			} else {
				jQuery('#newcat').addClass('error');
			}
		
		
		return false;
		
	});
	
	
	$('.box-link').click(function tabbedbox() {
		
		var box = $(this).attr('href');
		var activetab = $('#links').children();
			
		$(activetab).removeClass('active-tab');
		$(this).addClass('active-tab');
		$('.active').removeClass('active');
		$(box).addClass('active');
		
		return false
		
	});

});