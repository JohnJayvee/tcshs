

<div style="margin-bottom: 20px"></div>
<div class="container">
	
	<center class="bg-warning p-3">
		<h1>Manage teacher load</h1>
		<hr width="40%" style="margin: 5px 5px">
		<h2>View other teacher loads</h2>
	</center>
	<div style="margin-bottom:10px"></div>
	<?php $personalLoad = base_url() . "classes/personalLoad?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId" ?>
	<a href="<?= $personalLoad ?>">
		<button class="btn btn-primary col-md-12"><i class="fas fa-user"></i>&nbsp; Personal Teacher Load</button>
	</a><br>&nbsp;

	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Teacher Name</th>
					<th>Subject</th>
					<th>Schedule</th>
					<th>Year Level</th>
					<th>Section</th>
				
				</tr>
			</thead>
			<tbody>
				<?php 
				$this->load->model('Main_model');
				foreach ($teacher_load_table->result_array() as $row) {
					$teacher_load_id = $row['teacher_load_id'];
					$faculty_account_id = $row['faculty_account_id'];
					$subject_id = $row['subject_id'];
					$section_id = $row['section_id'];
					$schedule = $row['schedule'];
					$grade_level = $row['grade_level'];?>
 
				<tr>
					<td>
						<?php 
							$teacher_table = $this->Main_model->get_where('faculty','account_id', $faculty_account_id);
							foreach ($teacher_table->result_array() as $row) {
								$firstname = $row['firstname'];
								$middlename = $row['middlename'];
								$lastname = $row['lastname'];
							}
							$fullname = "$firstname $middlename $lastname";
							echo ucfirst($fullname);
						 ?>
					</td>
					<td>
						<?php 
							$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
							foreach ($subject_table->result_array() as $row) {
								$subject_name = $row['subject_name'];

							}
							
							echo ucfirst($subject_name);
						 ?>
					</td>
					<td>
						<?php 
							echo ucfirst($schedule);
						 ?>
					</td>
					<td>
						<?php 
							$teacher_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level);
							foreach ($teacher_table->result_array() as $row) {
								$name = $row['name'];
							}
							
							echo ucfirst($name);
						 ?>
					</td>
					<td>
						<?php 
							$section_table = $this->Main_model->get_where('section','section_id', $section_id);
							foreach ($section_table->result_array() as $row) {
								$section_name = $row['section_name'];
							}
							
							echo ucfirst($section_name);
						 ?>
					</td>
				</tr>

				<?php } ?>
			</tbody>

		</table>

	</div>

	<div style="margin-bottom: 40px"></div>
	<?php $add_teacher_load = base_url() . "classes/teacher_load?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId"; ?>
	<a href="<?= $add_teacher_load ?>" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</a>
</div>
