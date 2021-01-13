
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->


<div style="margin-bottom:20px"></div>



<div class="container">

	<?= $this->Main_model->banner("Classroom attendance", "Excuse a student"); ?>
	<div style="margin-bottom:20px"></div>
	



	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>

						<!-- for testing purposes lang itong id. -->
						
						<th> Student Name</th>
						<th>Date of Absent</th>
						<th> Excuse</th>
					</tr>
				</thead>
<!-- 
		foreach ($excused_table as $row) {
						$class_id = $row; -->

		<tbody>
			
					<?php 
					$this->load->model('Main_model');

					
					foreach ($excuse_attendance_table->result_array() as $row) {
						$excuse_attendance_id = $row['excuse_attendance_id'];
						$date_of_absent = $row['date_of_absent'];
						$all_class_id = $row['class_id'];
						$excuse = $row['excuse'];
						$status = $row['status'];?>
					
					

						<tr>
							<td>
								<?php 
								$class_table = $this->Main_model->get_where('class','class_id', $all_class_id);
								foreach ($class_table->result_array() as $row) {
									$student_profile_id = $row['student_profile_id'];
								}

								$student_table = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);
								foreach ($student_table->result_array() as $row) {
									$account_id = $row['account_id'];
									$firstname = $row['firstname'];
									$middlename = $row['middlename'];
									$lastname = $row['lastname'];
									$student_status = $row['student_status'];
								}
								$student_fullname = "$firstname $middlename $lastname";
								echo ucfirst($student_fullname);
								 ?>
							</td>
							<td>
								<?= $date_of_absent ?>
							</td>
								
							<td>
								<?php $excuse = base_url() . 'attendance_monitoring/excuse_student/' . $class_id. '/' . $date_of_absent ?>
								<a href="<?= $excuse ?>">
									<button class="btn btn-success col-md-12">Enter Reason</button>
								</a>
								
							</td>
						</tr>
						
				

					 

						

						<?php } ?>
						<!-- add content here -->
						
					


				
				
		</tbody>
	</table><br>
	<?php
	$grade = $_SESSION['grade'];
	$section = $_SESSION['section'];
	$subject = $_SESSION['subject'];
	 $back = base_url() . "attendance_monitoring/class_selection?record=1&grade=$grade&section=$section&subject=$subject";
	 $all_present = base_url() . "attendance_monitoring/class_selection?all_present=1";
	 $excuse = base_url() . 'main_controller/sandbox';
	 ?>
	 

	</div> <!-- card body -->
	
	 	
			

	






	<a href="<?= $back ?>">
		<button class="btn btn-secondary col-md-12" type="button">
			Back
		</button>
	</a><br>&nbsp;
</div>
</div>



