$(function(){

	// Add category
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
	
	// Tabs
	$('.box-link').click(function tabbedbox() {
		
		var box = $(this).attr('href');
		var activetab = $('#links').children();
			
		$(activetab).removeClass('active-tab');
		$(this).addClass('active-tab');
		$('.active').removeClass('active');
		$(box).addClass('active');
		
		return false
		
	});
	
	// Delete Categories
	
	$('.delcat').live('click', function(e) {
	
		var question = 'Are you sure you wish to delete this category?';
	
		var hashed = $(this).attr('href');
		var id = hashed.replace('#', ' ');
		
		var row = $(this);
		
		if (confirm(question)) {
			
			jQuery.post("../core/ajax.php", { action: "Blog", id: id},
				
				function(data) {
					
					$(row).parent().parent().fadeOut();
					
				}
			);
		}

		e.preventDefault();
	
	});
	
	// Add category
	
	$('#addcategory').click(function(e) {
		
		var category = jQuery('#newcat').val();
		
		if (jQuery('#newcat').val() == '') {
			jQuery('#newcat').addClass('error');
		} else if(isNaN(jQuery('#newcat').val())) {
		
			jQuery('#newcat').removeClass('error');
		
			jQuery.post("../core/ajax.php", { action: "Blog", catname: category},
				
				function(data) {
					
					$('#catstable tbody').append('<tr><td>' + data + '</td><td>' + category + '</td><td></td><td><a href="#' + data + '" title="' + category + '" class="delcat"><i class="fa fa-trash-o"></i></a></td></tr>');

					jQuery('#newcat').val('');
					
				}
			);
			
		} else {
			jQuery('#newcat').addClass('error');
		}
		
		e.preventDefault();
		
	});
});