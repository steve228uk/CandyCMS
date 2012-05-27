$(function(){

	$('#addcat').click(function() {
		
			var cat = jQuery('#newcat').val();
		
			jQuery.post("../core/ajax.php", { action: "Blog", catname: cat},
				
				function(data) {
					
					jQuery('<li>' + cat + '<input type="checkbox" name="categories[]" value="' + data + '" checked="checked" />').appendTo('#blog-cats ul');
					
					jQuery('#newcat').val('');
					
				}
				
			);
		
		
		return false;
		
	});

});