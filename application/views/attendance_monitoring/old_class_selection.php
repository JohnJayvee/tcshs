
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->

<div style="margin-bottom: 40px;"></div>


<div class="container col-md-11">

	<h1>Classroom Attendance</h1>
	<span style="font-size: 20px;margin-right: 20px">Section:<strong> <?= $section ?></strong></span>
	<span style="font-size: 20px;margin-right: 20px">Subject: <strong><?= $subject ?></strong></span>
	<span style="font-size: 20px;margin-right: 20px">Grade:<strong> <?= $grade ?></strong></span>
	


<?php $form = base_url() . 'attendance_monitoring/mark_absent_2' ?>
<form action="<?= $form ?>" method="post">	
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>

						<!-- for testing purposes lang itong id. -->
						
						<th> Student Name</th>
						<th>No. of Absences</th>
						<th style="font-size: 80%;" width="15%"> Select Absent Student</th>
						<?php 
						if (isset($excuse_th)) {
							echo "<th> Excuse</th>";
						}
						 ?>
					</tr>
				</thead>

		

		<tbody>
			
					<?php 
					// $student_table = array();
					foreach ($class->result_array() as $row) {
						$class_id = $row['class_id'];
						$subject_id = $row['subject_id'];
						$faculty_id = $row['faculty_id'];
						$class_sched = $row['class_sched'];
						$student_profile_id = $row['student_profile_id'];
						$section_id = $row['section_id'];
						$school_grade_id = $row['school_grade_id'];

						$query = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);

						foreach ($query->result_array() as $row) {
							$student_id = $row['account_id'];
							$firstname = $row['firstname'];
							$middlename = $row['middlename'];
							$lastname = $row['lastname'];
							$fullname = "$firstname $middlename $lastname";

							
							// array_push($student_table, $fullname);

						}?>
						<tr>
							
							<td>
								<?= $fullname ?>
							</td>
							<td>
								<?php 
									$this->load->model('Main_model');
									$array['attendance_status'] = 0;
									$array['class_id'] = $class_id; 
									$absent = $this->Main_model->multiple_where('attendance', $array);
									$no_absent = $absent->num_rows();
									echo $no_absent;
								 ?>
							</td>
								
							<td>
								
								<input type="checkbox" name="absent_students[]" value="<?= $class_id ?>">
								
							</td>

							
								<?php 
								if ($no_absent > 0) {?>
									<td>
										<?php $excuse = base_url() . 'Attendance_monitoring/perform_excuse/' . $class_id ?>
										<a href="<?= $excuse ?>">
											<button class="btn btn-danger" type="button">Excuse</button>
										</a>
									</td>
								<?php } ?>
								 
							
						</tr>
						<!-- add content here -->
						
					<?php }	?>


				
				
		</tbody>
	</table><br>
	<?php
	 $back = base_url() . 'attendance_monitoring';
	 $all_present = base_url() . "attendance_monitoring/selectDate?all_present=1";
	 $excuse = base_url() . 'main_controller/sandbox';
	 ?>
	 

	</div> <!-- card body -->
	
	 	
			<button class="btn btn-danger col-md-12" type="submit" name="absent">
				Mark as Absent
			</button>
		<br>&nbsp;

	
	</form>




 	<a href="<?= $all_present ?>">
		<button class="btn btn-success col-md-12" type="button">
			All Present
		</button>
	</a><br>&nbsp;

	
	<a href="<?= $back ?>">
		<button class="btn btn-primary col-md-12" type="button">
			Back
		</button>
	</a><br>&nbsp;

</div>
</div>



