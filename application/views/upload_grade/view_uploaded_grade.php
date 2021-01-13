<div style="margin-bottom: 20px"></div>


<div class="container">
	<center class="bg-warning p-3">
		<h1>Here are your <strong>First Quarter</strong> Subjects</h1>
		<p>for: <strong><?= ucfirst($subject_name) ?></strong> on the section of <strong><?= ucfirst($section_name) ?></strong>, <strong><?= ucfirst($grade_level_name) ?></strong><br>During the <strong><?= ucfirst($quarter_stats) ?></strong><br><strong><?= $_SESSION['school_year_selection'] ?></strong></p>
	</center>
	<div style="margin-bottom: 40px"></div>
	<?php 
	if (isset($_SESSION['update_grade'])) {
		echo "<p class='alert alert-success col-md-12'>";
		echo $_SESSION['update_grade'];
		echo "</p>";
		 unset($_SESSION['update_grade']);
	}?>

	 
		<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Student's Name</th>
							<th>Grade</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($grades_table->result_array() as $row) {

							$student_grades_id = $row['student_grades_id'];
							$student_name = $row['student_name'];
							$quarter1 = $row['quarter1'];
							$quarter2 = $row['quarter2'];
							$quarter3 = $row['quarter3'];
							$quarter4 = $row['quarter3'];
							$final_grade = $row['final_grade'];?>
						
						 
						<tr>
							<td>
								<?= ucfirst($student_name) ?>
							</td>
							<td>
								<?php
								if ($quarter_level == 1) {
									if ($quarter1 <= 0) {
										echo "No Grade";
									}else{
										echo $quarter1;
									}
								}elseif($quarter_level == 2) {
									if ($quarter2 <= 0) {
										echo "No Grade";
									}else{
										echo $quarter2;
									}
								}elseif($quarter_level == 3) {
									if ($quarter3 <= 0) {
										echo "No Grade";
									}else{
										echo $quarter3;
									}
								}
								elseif($quarter_level == 4) {
									if ($quarter4 <= 0) {
										echo "No Grade";
									}else{
										echo $quarter4;
									}
								}elseif($quarter_level == 5) {
									if ($final_grade <= 0) {
										echo "No Grade";
									}else{
										echo $final_grade;
									}
								}

								 ?>
							</td>
							<td>
								<?php $edit = base_url() . 'excel_import/edit_grade/' . $student_grades_id . '/' . $quarter_level . '?subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
								<a href="<?= $edit ?>" class="btn btn-info col-md-12"><i class="fas fa-eye"></i> Edit</a>
							</td>
						</tr>

						<?php } ?>
					</tbody>
				</table>
		</div>
		<div style="margin-bottom: 40px"></div>

		<?php $pull_out_early = base_url() . 'excel_import/pull_out_early?subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&school_year_grade=' .  $grade_level_id . '&quarter_level=' . $quarter_level;?>

		
		<?php if (isset($quarter1)): ?>
			
		
		<div class="row">
			<div class="col-md-6">
			<?php $back = base_url() . 'excel_import/upload_view' ?>
				<a href="<?= $back ?>" class="btn btn-secondary col-md-12" style="font-weight: bold;"><i class="fas fa-arrow-left"></i> Back</a>
			</div>
		<?php if ($quarter_level == 1) {
			if ($quarter1 > 0) {?>
				<div class="col-md-6">
					<a href="<?= $pull_out_early ?>" class="btn btn-danger col-md-12" style="font-weight: bold;">PULL OUT QUARTERLY GRADE</a>
				</div>
			<?php } ?>
		<?php }elseif($quarter_level == 2) {
			if ($quarter2 > 0) {?>
			<div class="col-md-6">
				<a href="<?= $pull_out_early ?>" class="btn btn-danger col-md-12" style="font-weight: bold;">PULL OUT QUARTERLY GRADE</a>
			</div>
			<?php } ?>
		<?php }elseif($quarter_level == 3) {
			if ($quarter3 > 0) {?>
			<div class="col-md-6">
				<a href="<?= $pull_out_early ?>" class="btn btn-danger col-md-12" style="font-weight: bold;">PULL OUT QUARTERLY GRADE</a>
			</div>
			<?php } ?>
		<?php } elseif($quarter_level == 4) {
			if ($quarter4 > 0) {?>
			<div class="col-md-6">
				<a href="<?= $pull_out_early ?>" class="btn btn-danger col-md-12" style="font-weight: bold;">PULL OUT QUARTERLY GRADE</a>
			</div>
			<?php } ?>
		<?php }elseif($quarter_level == 5) {
			if ($final_grade > 0) {?>
			<div class="col-md-6">
				<a href="<?= $pull_out_early ?>" class="btn btn-danger col-md-12" style="font-weight: bold;">PULL OUT QUARTERLY GRADE</a>
			</div>
		<?php } }?>
		 <?php endif ?>
	</div><!-- row end -->
	<!-- kapag hindi pa nakakapag upload ng quarter 1 dapat meron paring back -->
	<?php if (empty($quarter1)) { ?>
	<?php $back = base_url() . "excel_import/upload_view" ?>
		<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i> &nbsp;Back</button></a>
	<?php }?>
</div>