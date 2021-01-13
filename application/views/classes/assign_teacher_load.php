<div style="margin-bottom: 20px"></div>


<div class="container">
	<!-- <h1 align="center">Assign your teacher Load</h1><hr style="width:50%;">
	<div align="center" style="font-size: 25px"></div> -->

	<center class="bg-warning p-3">
		<h1>Assign your teacher load</h1>
		<hr width="40%" style="margin:5px 5px">
		<h2><?= ucfirst($teacher_fullname) ?></h2>
	</center>
	 
	<div style="margin-bottom: 20px"></div>
	<?php $form = base_url() . "classes/teacher_load?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId";  ?>
	<form action="<?= $form ?>" method="post">

		<input type="hidden" name="teacher" value="<?= $faculty_account_id?>" >

		<div class="form-row">
			<div class="col bg-success p-3" style="font-size:30px">
				<span>Year Level: <strong> <?= $yearLevelName ?></strong></span><br>	
				<span>Section: <strong><?= $sectionName ?></strong></span><br>
				<span>Subject: <strong><?= $subjectName ?></strong></span><br>
			</div>

			<div class="col bg-warning p-3">
				<label style="font-size:30px;font-weight:bold;">Enter Schedule: </label>
				<input type="text" autofocus="on" name="schedule" placeholder="Enter Schedule here (MTH 7:30 - 10:30)" class="form-control" autocomplete="off" required>
			</div>
		</div>
		<div style="margin-bottom:30px"></div>
		<button type="submit" name="submit" class="btn btn-primary col-md-12">Submit</button>
		<div style="margin-bottom:10px"></div>
		<?php $view_teacher_load = base_url() ."classes/view_teacher_load?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId"; ?>
	
	</form>
		<?php $back = base_url() . "classes/subjectSelectionTeacherLoad?yearLevelId=$yearLevelId&sectionId=$sectionId";?>
	<!-- <div class="d-flex justify-content-between" style="margin-top:-10px;">
		
		
	</div> -->

	<div class="row">
		<div class="col-md-6">
			<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12">Back</button></a>
		</div>
		<div class="col-md-6">
			<a href="<?= $view_teacher_load ?>"><button type="button" class="btn btn-info col-md-12">View Teacher's Load</button></a>
		</div>
	</div>
	
</div>



