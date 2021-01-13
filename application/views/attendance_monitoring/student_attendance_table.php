<div style="margin-bottom: 20px;"></div>

<div class="container">
	
	<?php  
        $lowerText = "<strong>" . ucfirst($teacher_fullname) . "</strong> | <strong>" . ucfirst($subject_name) . "</strong>";
        $this->Main_model->banner('View Attendance record', $lowerText);
    ?>
	<div style="margin-bottom: 20px;"></div>
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Student Name</th>
					<th>Date</th>
					<th>Status</th>
					<th>Excuse</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$this->load->model('Main_model');
					foreach ($attendance_table->result_array() as $row) {
						$class_id = $row['class_id'];
						$date = $row['date'];
						$attendance_status = $row['attendance_status'];
						$school_grade_id = $row['school_grade_id'];


						$class_table = $this->Main_model->get_where('class','class_id', $class_id);
						foreach ($class_table->result_array() as $row) {
							$subject_id = $row['subject_id'];
							$faculty_id = $row['faculty_id'];
							$class_sched = $row['class_sched'];
							$student_profile_id = $row['student_profile_id'];
							$section_id = $row['section_id'];
							$school_grade_id = $row['school_grade_id'];
						}

						?>


					
				<tr>
					<td>
						<?php 
						$student_table = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);
						foreach ($student_table->result_array() as $row) {
							$student_firstname = $row['firstname'];
							$student_middlename = $row['middlename'];
							$student_lastname = $row['lastname'];
						}
						$student_fullname = "$student_firstname $student_middlename $student_lastname ";
						echo ucfirst($student_fullname);
						 ?>
					</td>
					<td><?= $date ?></td>
					<td>	
						<?php 
						if ($attendance_status == 0) {
							echo "Absent";
						}else{
							echo "Present";
						}
						 ?>
					</td>
					<td>
						<?php 
						if ($attendance_status == 0) {
							$array['date_of_absent'] = $date;
							$array['class_id']  = $class_id;
							$excuse_table = $this->Main_model->multiple_where('excuse_attendance', $array);
							foreach ($excuse_table->result_array() as $row) {
							$excuse = $row['excuse'];
							}
							if ($excuse == 0) {
							echo "Unexcused";
							}else{
							echo ucfirst($excuse);
							}
						}else{
							$array['date_of_absent'] = $date;
							$array['class_id']  = $class_id;
							$excuse_table = $this->Main_model->multiple_where('excuse_attendance', $array);
							$count = count($excuse_table->result_array());

							if ($count == 0) {
								echo "Present";
							}else{
								foreach ($excuse_table->result_array() as $row) {
									$excuse = $row['excuse'];
								}
									if ($excuse == 0) {
									echo ucfirst($excuse);
									}
							}
						}

						 ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div style="margin-bottom: 40px;"></div>
	<?php $back = base_url() . "attendance_monitoring/view_attendance_record?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId" ?>
	<a href="<?= $back  ?>">
		<button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
	</a>
</div> <!-- container -->