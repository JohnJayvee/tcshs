<?php
	//notif noStudents
	$this->load->model('Main_model');
	$this->Main_model->alertWarning('noStudents', 'There are no students in this class');
?>



<div class="container">
<div style="margin-bottom:20px"></div>
<?php $this->Main_model->banner("Record class room attendance", "Class room selection"); ?>
	<div style="margin-bottom: 40px"></div>
		<h1 >To record current day</h1>
		<div style="margin-bottom:20px"></div>
	<div class="row">
		<?php 
		foreach ($teacher_load_table->result_array() as $row) {
			$subject_id = $row['subject_id'];
			$grade_level = $row['grade_level'];
			$section_id = $row['section_id'];?>
		
		<div class="card" style="width: 18rem;">
		  <div class="card-body" align="center">
		    <p class="card-text">Subject: <strong>
		    	<?= $this->Main_model->getSubjectNameFromId($subject_id) ?>
		    </strong><br>Section:<strong>
		    	<?php 
		    	$this->load->model('Main_model');
		    	$section_table = $this->Main_model->get_where('section','section_id', $section_id);
		    	foreach ($section_table->result_array() as $row) {
		    		$section_name = $row['section_name'];
		    		$section_id = $row['section_id'];
		    	}
		    	echo ucfirst($section_name);
		    	 ?>
		    </strong><br>Grade: <strong>
		    	<?php 
		    	$this->load->model('Main_model');
		    	$grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level);
		    	foreach ($grade_table->result_array() as $row) {
		    		$school_grade_id = $row['school_grade_id'];
		    		$grade_level_name = $row['name'];
		    	}
		    	echo ucfirst($grade_level_name);
		    	 ?>
		    </strong></p>
		    <?php $selection = base_url() . 'attendance_monitoring/class_selection?record=1&grade=' . $school_grade_id . '&section=' . $section_id . '&subject=' . $subject_id ?>
		    <a href="<?= $selection ?>" class="btn btn-primary">Enter Class</a>
		  </div>
		</div>
		<div style="margin: 10px"></div>

		<?php } ?>

		</div><hr>
		<div style="margin-bottom: 40px"></div>
		
			<h1>Select Date:</h1>
			<span style="font-size: 20px">To record Missed days</span><br><br>
			<?php $form = base_url() . 'attendance_monitoring/selectDate' ?>
			<form action="<?= $form ?>" method="post">
				<div class="form-group">
					<label>Select Date:</label>
					<input type="date" name="date" class="form-control col-md-12" required>
				</div>

				<div class="form-group">
					<label>Select Load:</label>
					<select class="form-control" name="teacher_load_id" required="">
						<?php 
						foreach ($teacher_load_table->result_array() as $row) {
							$teacher_load_id = $row['teacher_load_id'];
							$subject_id = $row['subject_id'];
							$section_id = $row['section_id'];
							$grade_level_id = $row['grade_level'];?>
						
						 
						<option value="<?= $teacher_load_id ?>">
							<?php 
							$this->load->model('Main_model');
							$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
							foreach ($subject_table->result_array() as $row) {
								$subject_name = $row['subject_name'];
							}

							$section_table = $this->Main_model->get_where('section','section_id', $section_id);
							foreach ($section_table->result_array() as $row) {
								$section_name = $row['section_name'];
							}

							$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level_id);
							foreach ($school_grade_table->result_array() as $row) {
								$grade_level_name = $row['name'];
							}
							 ?>
							<?= ucfirst($subject_name) ?> - <?= ucfirst($section_name) ?> - <?= ucfirst($grade_level_name) ?>
								
							</option>

						<?php } ?>
					</select><br>
				</div>
				<button type="submit" class="btn btn-primary col-md-12">Record</button>
			</form>
		
</div> <!-- container -->