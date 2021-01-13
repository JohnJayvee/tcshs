<div style="margin-bottom: 20px"></div>

<div class="container">
	<center class="bg-warning p-3">
		<h1>Edit Student Grade</h1>
		<h3><?= ucfirst($student_name) ?></h3>
	</center>
	<div style="margin-bottom: 40px"></div>
	<?php $form = base_url() . 'excel_import/edit_grade?subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
	<form action="<?= $form ?>" method="post">
		<div class="form-group">
			<label>Update Current Grade:</label>
			<input type="text" name="new_grade" class="form-control" value="<?= $current_quarter_grade ?>" required>
		</div><br>
		<input type="hidden" name="quarter_level" value="<?= $quarter_level ?>">
		<input type="hidden" name="student_grades_id" value="<?= $student_grades_id ?>">
		<div class="row">
			<div class="col-md-6">
				<?php $back = base_url() . 'excel_import/view_uploaded_grades?quarter='.$_SESSION['quarter_selection'].'&subject_id='.$subject_id.'&section_id='.$section_id.'&faculty_id='.$_SESSION['faculty_account_id'].'&grade_level='. $grade_level_id ?>
				<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
			</div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-success col-md-12" name="submit"><i class="fas fa-edit"></i>&nbsp; Update</button>
			</div>
		</div>
	</form>
</div>