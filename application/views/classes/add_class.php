<?php 

	foreach ($the_principal->result_array() as $row) {
		$principal_id = $row['account_id'];
	}
 ?>



<?php $form_url = base_url() . 'classes/create_class'; ?>
<div class="container">
	<form action="<?= $form_url ?>" method='post'>
		<!-- header title -->
		<div class="form-group">
			<h1>Add Class</h1>
		</div><br>


		<!-- Validation Errors here -->
		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>
		
		<?php 
		if (isset($_SESSION['createClassSuccess'])) {?>
			<div class="form-group">
				<?php echo "<p class='alert alert-success'> Add Class Successful </p>";
				unset($_SESSION['createClassSuccess']);
				 ?>
			</div> 
		<?php } ?>
	<div class="bg-info p-3">
		<div align="center"><label style="font-weight: bold;">Select Teacher's Load:</label></div>
		 <div style="margin-bottom: 10px"></div><br>
		<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Teacher Name</th>
							<th>Subject</th>
							<th>Schedule</th>
							<th>Grade Level</th>
							<th>Select</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($teacher_load_table->result_array() as $row) {
							$teacher_load_id = $row['teacher_load_id'];
							$faculty_account_id = $row['faculty_account_id'];
							$subject_id = $row['subject_id'];
							$schedule = $row['schedule'];
							$grade_level = $row['grade_level'];?>
						
						 
						<tr>
							<td>
								<?php
								$this->load->model('Main_model');
								$faculty_table = $this->Main_model->get_where('faculty','account_id', $faculty_account_id);
								foreach ($faculty_table->result_array() as $row) {
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
								<?= $schedule ?>
							</td>
							<td>
								<?php 
								$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level);
								foreach ($school_grade_table->result_array() as $row) {
									$name = $row['name'];
								}
								echo ucfirst($name);
								 ?>
							</td>
							<td>
								<input type="checkbox" name="teacher_load[]" value="<?= $teacher_load_id?>">
							</td>
						</tr>

						<?php } ?>
					</tbody>
				</table>
		</div><br>
		
	</div><br>
		<div class="form-group">
			<label>Student:</label>
			<select name="student" class="form-control">
	<?php 
		foreach ($student_table->result_array() as $row) {
			$account_id = $row['account_id'];
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
			$student_full_name = "$firstname $middlename $lastname";
			?>	
			
				<option value="<?= $account_id ?>"><?= ucfirst($student_full_name) ?></option>

	<?php } ?>
				</select>
		</div>
  

		<div class="form-group">
			<label>Section:</label>
			<select name="section" class="form-control">
	<?php 
		foreach ($section_table->result_array() as $row) {
			$section_id = $row['section_id'];
			$section_name = $row['section_name'];
			?>	
			
				<option value="<?= $section_id ?>"><?= ucfirst($section_name) ?></option>

	<?php } ?>
				</select>
		</div>
<br>
	
	

	

		



		<button type="submit" class="btn btn-primary col-md-12">
			Submit
		</button>
		
	<?php echo form_close() ?>

	<?php $view_classes = base_url() . 'classes/manage_classes' ?>
	<a href="<?= $view_classes ?>" class="btn btn-info col-md-12">View Classes</a>

<br>
