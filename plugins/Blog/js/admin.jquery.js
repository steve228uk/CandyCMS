$(function(){

	$('#addcat').click(function() {
		
		
			jQuery.post("../core/ajax.php", { action: "Blog"},
				
				function(data) {
					console.log(data);
				}
				
			);
		
		
		return false;
		
	});

});