$(function() {
	
	$('.ckeditor').redactor({ focus: false, convertDivs: false, removeClasses: false, imageUpload: 'uploader.php' });
	
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
		
		$('#modal-cont').load(adminpath + 'modals/' + file);
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
		
		$.post(adminpath + 'ajax/getcustomfields.php', { key: key, name: name }, function(data) {
		
		  $('#cf-area').append("<li><h3>" + title + "</h3><p>" + desc + "</p>" + data + "<input type='hidden' name='cfield[" + name + "]' value='" + key + "' /><input type='hidden' name='cf-title["+name+"]' value='" + title + "' /><input type='hidden' name='cf-desc["+name+"]' value='" + desc + "' /></li>");
		  closeModal();
		  
		  $('.ckeditor').redactor({ focus: false, convertDivs: false, removeClasses: false, imageUpload: 'uploader.php' });
		  
		});
	
		e.preventDefault();
	
	});
	
	$('#template').change(function() {
	
		var template = $(this).val();
		$.post(adminpath + 'ajax/templatecf.php', { template: template }, function(data) {
			
			var count = data.length;
			
			$('#cf-area').empty();
			
			for (var i = 0; i < count; i++) {
				
				var title = data[i].title;
				var desc = data[i].desc;
				
				if (title != null) {
				
					$.post(adminpath + 'ajax/templatecf.php', {key: data[i].type, name: data[i].name, title: title, desc: desc}, function(field) {
					
						
						$('#cf-area').append(field);
						
						$('.ckeditor').redactor({ focus: false, convertDivs: false, removeClasses: false, imageUpload: 'uploader.php' });		
						
					
					});
					
				}
				
				
					
			}
			
		}, 'json');
		
	});	
	
		
});