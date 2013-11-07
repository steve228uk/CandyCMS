<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Manage and create navigation for your site
*/

?>

<? if (isset($_GET['savenavigation'])) :?>
	<? Pages::saveNav($_POST['nav']) ?>
<? else : ?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1>Navigation</h1>
	
	</div>

</div>

<div id="container" class="clearfix">
	
	<p class="message success hide">Navigation Saved!</p>
	
	<div id="sidebar">
		
		<h4>Add Links</h4>
		
		<div class="module">
			<div class="module-head">
				Pages
			</div>
			<div class="module-cont">
				<? Pages::listAddPages() ?>
			</div>
		</div>
		
		<button class="button right" id="add-links">Add Links</button>
		
	</div>	
	
	<div id="right-col">
		
		<div class="dd" id="nestable">
		    
		    <? Pages::sortPages() ?>
		    
		</div>
		
		<input type="hidden" id="nestable-output" />
	
		<button class="button right" id="save-nav">Save Navigation</button>
			
	</div>

</div>

<? endif; ?>

<script type="text/javascript">
	
	$(function() {
			var list = $('#nestable');
			var output = $('#nestable-output');
			
			var updateList = function() {
			    var data = list.nestable('serialize');
			    if (window.JSON) {
			        output.val(window.JSON.stringify(data));
			    } else {
			        output.val('JSON browser support required for this demo.');
			    }
			};
			
			$('.rm-nav').live('click', function() {
				var answer = 'Are you sure you wish to delete the nav item? This will remove ALL sub-items';
				if (confirm(answer)) {
				
					$(this).parent().parent().fadeOut(function() {
						$(this).remove();
						
						setTimeout(updateList, 100);
						
					});
				}
			});
			
			list.nestable({
			    listNodeName    : 'ol',
			    itemIdAttribute : 'data-id'
			}).on('change', updateList);
		
			$('#add-links').click(function() {
				
				var links = new Array();
				
				var i = 0;
				
				$('.add-pages-ul input:checkbox').each(function() {
				
					if ($(this).is(':checked')) {
						
						var linkid = $(this).val();
						
						var name = $(this).prev('label').text();
						
						links[i] = {"id":linkid,"name":name};
						
						i = i+1;
						
					}
					
				});
				
				var count = links.length;
				
				for (var i = 0; i < count; i++) {
					var linkid = links[i].id;
					var linkname = links[i].name;
					
					$('#nestable > ol').append('<li class="dd-item" data-id="'+linkid+'"><div class="dd-handle">'+linkname+'<button class="icon-remove rm-nav right" value="'+linkid+'"></button></div></li>');
				}
				
				$(".add-pages-ul input:checkbox").attr('checked', false);
				
				updateList();
				
			});
		
			$('#save-nav').click(function() {
				var order = output.val();
				$.post("dashboard.php?page=nav&savenavigation", {nav: order},function() {
					
					$('.message.success.hide').fadeIn('fast').delay(1500).fadeOut('fast');
				
				});
			});
			
			updateList();
	});
	
</script>
