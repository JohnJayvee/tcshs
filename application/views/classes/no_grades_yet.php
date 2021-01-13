<div style="margin-bottom: 40px"></div>

<div class="container">
	<div class="bg-warning p-3 m-4" align="center">
		<h1>You have to upload the Student grades first</h1><br>
		<?php $sectionId = $this->input->get('sectionId'); ?>
		<?php $back = base_url() . "classes/view_student_grades?yearLevelId=$yearLevelId&sectionId=$sectionId&back=1"; ?>
	
		<a href="<?= $back ?>" class="btn btn-primary col-md-4">Back</a>
	</div>
</div>