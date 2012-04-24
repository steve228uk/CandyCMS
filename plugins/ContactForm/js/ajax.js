$(document).ready(function() {

	$('#cf-send').click(function() {
		
		var string = $('#contactform').serialize();
		
		$.ajax({
			url: cfurl,
			type: 'post',
			data: string,
			success: function() {
				alert('sent!');
			}
		});
		
		return false;
		
	});

});