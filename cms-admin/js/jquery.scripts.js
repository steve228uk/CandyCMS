$(function() {
	
	$('.ckeditor').redactor();
		
	$('#sortable').sortable({
		opacity: 0.6,
		cursor: 'move',
		update: function() {
			var order = $('#sortable').sortable('serialize');
			$.post("dashboard.php?page=nav&savenavigation", order);
		}
	});	

	
	$(".colorpicker").miniColors({
		letterCase: 'uppercase',
		change: function(hex) {
			var data = $('#colorform').serialize();
			$.post("dashboard.php?page=theme&savecolors", data);
		}
	});
	
	$(".delete").click(function() {
		
		var url = $(this).attr('href');
		var page = $(this).attr('title');
		var message = confirm('Are you sure you want to delete the following: "'+ page +'"? This cannot be undone.');
		
		if (message) {
			window.location = url;
		}
		
		return false;
		
	});
	
	$('.user-btn').toggle(function() {
		$('#usernav').show();
	}, function() {
		$('#usernav').hide();
	});
	
	$('#page-title').keyup(function() {
		
		var text = $('#page-title').val();
		var rewrite = text.replace(/\s+/g, '-').toLowerCase();
		
		$('#rewrite').val(rewrite);
		
	});
	
});