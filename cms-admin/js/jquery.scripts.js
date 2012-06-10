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
	
	function modal(title, file) {
	
		$('body').append('<div id="overlay"></div><div id="modal"><div id="modal-title">' + title + '<button class="icon-remove close-btn"></button></div><div id="modal-cont"></div></div>');
		
		$('#modal-cont').load('/cms-admin/modals/' + file);
	}
	
	function closeModal() {
	
		$('#modal').remove();
		$('#overlay').remove();
	
	}
	
	$('#cfbtn').click(function() {
		modal('Custom Fields', 'customfields.php');
	});
	
	$('#overlay, .close-btn').live('click', function() {
		closeModal();
	});
	
	$('.field-btn').live('click', function() {
	
		var id = $(this).attr('id');
		
		var key = id.replace('field-', '');

		$('#cf-types').fadeOut('fast', function() {
		
			$('#cf-addinfo').fadeIn('fast');
			
			$('#cf-key').val(key);
		});
		
	});
	
	$('#cf-title').live('keyup', function() {
		
		var text = $(this).val();
		var name = text.replace(/\s+/g, '_').toLowerCase();
		
		$('#cf-name').val(name);
		
	});
	
	$('#cf-addinfo').live('submit', function(e) {
	
		var key = $('#cf-key').val();
		var title = $('#cf-title').val();
		var name = $('#cf-name').val();
		var desc = $('#cf-desc').val();
		
		$.post('/cms-admin/ajax/getcustomfields.php', { key: key, name: name }, function(data) {
		
		  $('#cf-area').append("<li><h3>" + title + "</h3><p>" + desc + "</p>" + data + "<input type='hidden' name='cfield[" + name + "]' value='" + key + "' /><input type='hidden' name='cf-title["+name+"]' value='" + title + "' /><input type='hidden' name='cf-desc["+name+"]' value='" + desc + "' /></li>");
		  closeModal();
		  
		  $('.ckeditor').redactor();
		  
		});
	
		e.preventDefault();
	
	});
		
});