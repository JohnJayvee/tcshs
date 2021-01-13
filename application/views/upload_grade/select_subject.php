


<div style="margin-bottom: 20px"></div>

<div class="container">
		

		<!-- <h1>Hello <?= $teacher_fullname ?> </h1> -->
		<?php $this->Main_model->banner('Upload student grade', "$teacher_fullname"); ?>
		<!-- section subject quarter grade level -->
		<div style="margin-bottom: 40px"></div>
		<?php 
			if (isset($_SESSION['noYearGrade'])) {
				echo "<p class='alert alert-warning'>Please select a school year</p>";
				unset($_SESSION['noYearGrade']);
			}
		?>
		
		
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Subject</th>
							<th>Section</th>
							<th>Grade Level</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						
					
					<?php 
					$this->load->model('Main_model');
					foreach ($teacher_load_table->result_array() as $row) {
						$teacher_load_id = $row['teacher_load_id'];
						$faculty_account_id = $row['faculty_account_id'];
						$subject_id = $row['subject_id'];
						$grade_level = $row['grade_level'];
						$section_id = $row['section_id'];?>
					
						<tr>
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
									$section_table = $this->Main_model->get_where('section','section_id', $section_id);
									foreach ($section_table->result_array() as $row) {
										$section_name = $row['section_name'];
									}
									echo ucfirst($section_name);
								?>
							</td>
							<td>
								<?php 
									$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level);
									foreach ($school_grade_table->result_array() as $row) {
										$school_year_grade = $row['name'];
									}
									echo ucfirst($school_year_grade);
								?>
							</td>
							
							<td>
								<?php
								 $link = base_url() . 'excel_import?subject=' . $subject_id . '&section=' . $section_id . '&grade_level=' . $grade_level  . '&submit=' . $teacher_load_id; 
								 ?>
								 <form action="<?= $link ?>" method='post'>
								 	<div class="container text-center">
									 
										 <input class="date-own form-control" style="width: 100%;" type
										 ="text" name="school_year" placeholder="CLick to insert school year" autocomplete="off" >


								  <script type="text/javascript">
								      $('.date-own').datepicker({
								         minViewMode: 2,
								         format: 'yyyy'
								       });
								  </script>
								  <div style="margin-bottom: 5px;"></div>
								  <button type="submit" class="col-md-12 btn btn-primary" name="submit">Enter</button>
								</div>


								 </form>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div><br>

			
		
</div>
