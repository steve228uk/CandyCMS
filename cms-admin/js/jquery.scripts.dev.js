$(function() {
	
	$('.ckeditor').redactor({
        tabSpaces: 4,
        focus: true,
        convertDivs: false,
        removeClasses: false,
        imageUpload: 'uploader.php',
//        imageUploadErrorCallback: function(json)
//        {
//            alert(json.error);
//            alert(json.anothermessage);
//        },
        //clipboardUploadUrl: '/your_clipboard_upload_script/',
        autoresize: true,
        toolbarFixed: true,
        convertVideoLinks: true,
        plugins: ['fullscreen']
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
	
	$('#page-title, #post-title input').change(function() {
		
		var text = $(this).val();
		var rewrite = text.replace(/&/g, 'and').replace(/[^a-zA-Z0-9 -]+/g, '').replace(/\s+/g, '-').toLowerCase();
		
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
		  
		  $('.ckeditor').redactor({ focus: true, convertDivs: false, removeClasses: false, imageUpload: 'uploader.php', autoresize: false  });
		  
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
						
						$('.ckeditor').redactor({ focus: true, convertDivs: false, removeClasses: false, imageUpload: 'uploader.php', autoresize: false  });
						
					
					});

				}

			}
			
		}, 'json');
		
	});


    function username_check() {
        var username = $('#username').val();
        if(username == "" || username.length < 4)
        {
            $('.tick').hide();
        }
        else
        {
            jQuery.ajax({
                type: "POST",
                url: adminpath + "ajax/uniqueuser.php",
                data: 'username='+ username,
                cache: false,
                success: function(response){
					
                    console.info(response);
					
                    if(response == '1')
                    {
                        $('#username').css('border', '1px #C33 solid');
                        // $('.user_tick').hide();
						  // $('.user_cross').fadeIn();
                        $("#save").attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#username').css('border', '1px #090 solid');
                        // $('.user_cross').hide();
         			   	  // $('.user_tick').fadeIn();
                        $("#save").removeAttr("disabled");
                    }
                }
            });
        }
    }

    function useremail_check() {
        var username = $('#useremail').val();
        if(username == "" || username.length < 4)
        {
            $('.email_tick').hide();
        }
        else
        {
            jQuery.ajax({
                type: "POST",
                url: adminpath + "ajax/uniqueuser.php",
                data: 'username='+ username,
                cache: false,
                success: function(response){
                    if(response == '1')
                    {
                        $('#useremail').css('border', '1px #C33 solid');
                        // $('.email_tick').hide();
//                         $('.email_cross').fadeIn();
                        $("#save").attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#useremail').css('border', '1px #090 solid');
                        // $('.email_cross').hide();
//                         $('.email_tick').fadeIn();
                        $("#save").removeAttr("disabled");
                    }
                }
            });
        }
    }

    $('#username').keyup(username_check);
    $('#useremail').keyup(useremail_check);
		
});