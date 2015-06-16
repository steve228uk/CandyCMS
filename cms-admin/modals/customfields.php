<?php ini_set('display_errors', 1); ?>

<?php include '../classes/CustomFields.php' ?>

<ul id="cf-types" class="clearfix">
<?php

$fields = CustomFields::listFields();

foreach($fields as $key => $field): ?>
	
	<li id="field-<?php echo $key ?>" class="field-btn clearfix">
		<div class="<?php echo $field['icon']?>"></div>
		<p>
			<?php echo $field['title'] ?>
			<span><?php echo $field['desc'] ?></span>
		</p>
	</li>
	
<?php endforeach; ?>
</ul>

<form id="cf-addinfo" class="hide">
	<h3>Custom Field Details</h3>
	<ul>
		<li>
			<label>Field Label</label><input type="text" name="title" placeholder="Left Column" id="cf-title" autocomplete="off" />
		</li>
		<li>
			<label>Field Name</label><input type="text" name="name" placeholder="left_col" id="cf-name" autocomplete="off" />
		</li>
		<li>
			<label>Field Instructions</label><input type="text" name="desc" placeholder="Text to appear in the left column" id="cf-desc" autocomplete="off" />
		</li>
		<li>
			<input type="submit" class="button" id="cf-add" value="Add Custom Field +" />
		</li>
	</ul>
	<input type="hidden" id="cf-key" />
</form>