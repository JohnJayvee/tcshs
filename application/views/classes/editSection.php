


<div style="margin-bottom: 60px"></div>

<div class="container">
	<h1>Enter new name of the section</h1>
	<div style="margin-bottom: 80px"></div>
	<?php $form = base_url() . 'classes/update_section?update=' . $section_id; ?>
	<form action="<?= $form ?>" method="post">
		<div class="form-group">
			<label>Enter section name:</label>
			<input type="text" name="newSectionName" reuired class="form-control" value="<?= $section_name ?>">
		</div><br>
		<button class="btn btn-primary col-md-12" type="submit" name="submit">Edit</button>
	</form>

	<?php $back = base_url() . 'classes/add_section' ?>
	<a href="<?= $back ?>">
		<button class="btn btn-secondary col-md-12">Back</button>
	</a>
</div>