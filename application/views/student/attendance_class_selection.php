<div style="margin-bottom: 20px"></div>

<div class="container">

	<!-- <h1 align="center">Subject Selection</h1>
	<h2 align="center"><?= $academicYear ?></h2> -->
	<?php $this->Main_model->banner('Subject selection', "$academicYear"); ?>
	<br>

	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Subject Name</th>
					<th>Teacher</th>
					<th>Class Schedule</th>
					<th>Section</th>
					<th>Grade Level</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				//main loop
				foreach ($class_table->result_array() as $row) {
					$class_id = $row['class_id'];
					$subject_id = $row['subject_id'];
					$faculty_id = $row['faculty_id'];
					$class_sched = $row['class_sched'];
					$section_id = $row['section_id'];
					$school_grade_id = $row['school_grade_id'];?>
				
				<tr>
					<td>
						<?php 
						$this->load->model('Main_model');
						$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
						foreach ($subject_table->result_array() as $row) {
							$subject_name = $row['subject_name'];
						}
						echo ucfirst($subject_name);
						 ?>
					</td>
					<td>
						<?php 
						$this->load->model('Main_model');
						$teacher_table = $this->Main_model->get_where('faculty','account_id', $faculty_id);
						foreach ($teacher_table->result_array() as $row) {
							$firstname = $row['firstname'];
							$middlename = $row['middlename'];
							$lastname = $row['lastname'];
						}
						$teacher_fullname = "$firstname $middlename $lastname";
						echo ucfirst($teacher_fullname);
						 ?>
					</td>
					<td>
						<?= $class_sched ?>
					</td>
					<td>
						<?php 
						$this->load->model('Main_model');
						$section_table = $this->Main_model->get_where('section','section_id', $section_id);
						foreach ($section_table->result_array() as $row) {
							$section_name = $row['section_name'];
						}
						echo ucfirst($section_name);
						 ?>
					</td>
					<td>
						<?php 
						$this->load->model('Main_model');
						$section_table = $this->Main_model->get_where('school_grade','school_grade_id', $school_grade_id);
						foreach ($section_table->result_array() as $row) {
							$grade_level_name = $row['name'];
						}
						echo ucfirst($grade_level_name);
						 ?>
					</td>
					<td>
					
					
						
						<?php
						$array['subject_id'] = $subject_id;
						$array['student_id'] = $studentId;
						$parentAttendanceTable = $this->Main_model->multiple_where('parent_attendance', $array);
							$notifCounter = 0;
							foreach ($parentAttendanceTable->result_array() as $row) {
								$notifSubjectId = $row['subject_id'];
								$notifCounter++;
							}
							?>
<?php $button = base_url() . 'parent_student/student_view_attendance/' . $class_id . "?subjectId=" . $subject_id ?>
									<a href="<?= $button ?>">
							<?php 
								if ($notifCounter > 0 ) { ?>
										
									<?php if ($subject_id == $notifSubjectId) {?>	
										<button class="btn btn-info col-md-12"><i class="fas fa-eye"></i>&nbsp;View<span class="badge badge-danger" style="margin-left:10px;"><?= $notifCounter ?></span></button>
									<?php }else{?>
										<button class="btn btn-info col-md-12"><i class="fas fa-eye"></i>&nbsp;View</button>
									<?php } ?>
								 <?php }else{ ?>
									<button class="btn btn-info col-md-12"><i class="fas fa-eye"></i>&nbsp;View</button>
								<?php } ?>
							

							
						
						
						
								
						</a>
					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>
	<div style="margin-bottom: 40px"></div>
	<?php $back = base_url() . 'parent_student/student_page' ?>
	<a href="<?= $back ?>">
		<button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
	</a>
</div>

