<div style="margin-bottom: 20px"></div>

<div class="container">
	<!-- <div align="center">
		<h1 align="center">Student Attendance Record</h1>
		<hr width="60%">
		<span style="font-size:30px">Year level: <strong><?= $yearLevelName ?></strong>&nbsp;Section: <strong><?= $sectionName ?></strong>&nbsp;Subject: <strong><?= $subjectName ?></strong></span>
	</div> -->
	<?php  
        $lowerText = "<strong>$yearLevelName</strong> | <strong>$sectionName</strong> | <strong>$subjectName</strong>";
        $this->Main_model->banner('View Attendance record', $lowerText);
    ?>
	<div style="margin-bottom: 20px"></div>
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					<th> Teacher</th>
					<th> Student</th>
					<th> Options</th>
				</tr>
			</thead>

	

<tbody>

	
<?php 
$this->load->model('Main_model');
foreach ($class_table->result_array() as $row) {
	$class_id = $row['class_id'];
	$subject_id = $row['subject_id'];
	$faculty_id = $row['faculty_id'];
	$class_sched = $row['class_sched'];
	$student_profile_id = $row['student_profile_id'];
	$section_id = $row['section_id']; 
	$school_grade_id = $row['school_grade_id'];
	?>	



	 	<tr>


			<td>
				<?php 

					$query = $this->Main_model->get_where('faculty','account_id', $faculty_id);
					foreach ($query->result_array() as $row) {
						$firstname = $row['firstname'];
						$middlename = $row['middlename'];
						$lastname = $row['lastname'];

						$full_name = ucfirst($firstname) . ' ' . ucfirst($middlename) . ' ' . ucfirst($lastname);

					}

					echo ucfirst($full_name);

				 ?>
			</td>

			<td>
				<?php 

					$query = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);
					foreach ($query->result_array() as $row) {
						$firstname = $row['firstname'];
						$middlename = $row['middlename'];
						$lastname = $row['lastname'];

						$full_name = ucfirst($firstname) . ' ' . ucfirst($middlename) . ' ' . ucfirst($lastname);

					}

					echo ucfirst($full_name);

				 ?>
			</td>

			<td> <!-- options -->

				<?php $view = base_url() . 'attendance_monitoring/student_view_attendance/' . $class_id . "?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId" ?>
				<a href="<?= $view ?>">
					<button class="btn btn-primary ">
						<i class="fas fa-eye"></i>
						View
					</button>
				</a>
			</td>
	</tr>
<?php } ?>	
</tbody>
</table>
</div>
<br>
<?php $back = base_url() . "attendance_monitoring/subjectSelectionAttendanceRecord?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div> <!-- container -->