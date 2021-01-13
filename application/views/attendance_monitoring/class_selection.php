


<div style="margin-bottom: 20px;"></div>


<div class="container">

	<?php 
		$lowerText = "<strong>$grade | $section | $subject</strong>";
		$this->Main_model->banner("Class room attendance", $lowerText);
	 ?>


<?php $form = base_url() . 'attendance_monitoring/mark_absent' ?>
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
						
						
						
						$where['account_id'] = $student_profile_id;
						$where['student_status'] = 1;
						$query = $this->Main_model->multiple_where('student_profile', $where);
						if (count($query->result_array()) == 0) {
							$this->session->set_userdata('noStudents',1);
							redirect("attendance_monitoring");
						}


						foreach ($query->result_array() as $row) {
							$student_id = $row['account_id'];
							$firstname = ucfirst($row['firstname']);
							$middlename = ucfirst($row['middlename']);
							$lastname = ucfirst($row['lastname']);
							$fullname = "$firstname $middlename $lastname";

							//find how many excuse
							$find['class_id'] =  $class_id;
							$find['status'] = 0;
							$excuse_attendance_table = $this->Main_model->multiple_where('excuse_attendance', $find);

							
			

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
									
									if (count($excuse_attendance_table->result_array())  == 0) {
										echo "No absences";
									}else{
										echo count($excuse_attendance_table->result_array()) ;
									}
								 ?>
							</td>
								
							<td>
								
								<input type="checkbox" name="absent_students[]" value="<?= $class_id ?>">
								
							</td>

							

							<!-- excuse button -->
								<?php 
								if ($no_absent > 0) {
									
									//kapag meron siya unexcused saka lang siya ma eexcuse
									if (count($excuse_attendance_table->result_array()) > 0) { ?> 
										<td>
											<?php $excuse = base_url() . 'Attendance_monitoring/perform_excuse/' . $class_id ?>
											<a href="<?= $excuse ?>">
												<button class="btn btn-danger" type="button">Excuse</button>
											</a>
										</td>
									<?php } } ?>
						</tr>
						<!-- add content here -->
						
					<?php }	?>


				
				
		</tbody>
	</table><br>
	<?php
	$subjectId = $this->input->get('subject');
	$yearLevelId = $this->input->get('grade');
	$sectionId = $this->input->get('section');
	 $back = base_url() . 'attendance_monitoring';
	 $all_present = base_url() . "attendance_monitoring/class_selection?all_present=1&subjectId=$subjectId&yearLevelId=$yearLevelId&sectionId=$sectionId";
	 ?>
	 

	</div> <!-- card body -->
	<div style="margin-bottom:20px"></div>
			<div class="row">
				<div class="col-md-4">
					<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
				</div>
				<div class="col-md-4">
					<a href="<?= $all_present ?>"><button type="button" class="btn btn-success col-md-12"><i class="fas fa-users"></i>&nbsp; All present</button></a>
				</div>
				<div class="col-md-4">
					<button type="submit" name="submit" class="btn btn-danger col-md-12"><i class="fas fa-check"></i>&nbsp; Mark as absent</button>
				</div>
			</div>
	</form>
	</div>
</div>



