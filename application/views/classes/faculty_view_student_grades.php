
<div style="margin-bottom: 20px"></div>
<div class="container">
<?php $this->Main_model->banner("View student grades", "$studentFullName"); ?>
<button class="btn btn-info col-md-12" id="filterBtn">Filter Students</button>
<div style="margin-bottom:5px"></div>
<div class="bg-info p-3" id="filterDd">
	<h5>Filter student's grade by school year</h5>
	<select name="school_year" id="syDd" class="form-control">
		<option value="">Select school year</option>
		<?php 
			foreach ($schoolYear as $row) {
				echo "<option value=" . $row .">". $row . "</option>";

			}
		?>
	</select>
</div>
<div style="margin-bottom:20px"></div>

		<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Subject</th>
							<th>Teacher</th>
							<th>Q 1</th>
							<th>Q 2</th>
							<th>Q 3</th>
							<th>Q 4</th>
							<th>Final Grade</th>
							<th>Grade Level</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php 
						foreach ($student_grades_table->result_array() as $row) {
							$subject_id = $row['subject_id'];
							$faculty_id = $row['faculty_id'];
							$quarter1 = $row['quarter1'];
							$quarter2 = $row['quarter2'];
							$quarter3 = $row['quarter3'];
							$quarter4 = $row['quarter4'];
							$final_grade = $row['final_grade'];
							$student_name = $row['student_name'];
							$school_year_grade = $row['school_year_grade'];
							// remove not curent year. 
							if ($this->Main_model->getAcademicYear() != $row['school_year']) {
								continue; 
							}
							?>
						

						 
						<tr>
							<td><?= $this->Main_model->getSubjectNameFromId($subject_id); ?></td>
							
							<td><?= $this->Main_model->facultyRepository($faculty_id) ?></td>
							
							<td><?= $this->Main_model->uploadedUnUploaded($quarter1) ?></td>

							<td><?= $this->Main_model->uploadedUnUploaded($quarter2) ?></td>

							<td><?= $this->Main_model->uploadedUnUploaded($quarter3) ?></td>

							<td><?= $this->Main_model->uploadedUnUploaded($quarter4) ?></td>

							<td><?= $this->Main_model->uploadedUnUploaded($final_grade) ?></td>

							<td><?= $this->Main_model->getYearLevelNameFromId($school_year_grade); ?></td>

							 
							
								<td><?= $this->Main_model->gradeStatus($final_grade) ?></td>
							
						</tr>
						<?php } ?>
					</tbody>
				</table>
		</div>
		
		<div style="margin-bottom: 40px;"></div>
			<?php 
				$subjectId = $this->input->get('back');
				$studentId = $this->uri->segment(3);
				$back  = base_url() . 'classes/view_student_grades/' . $sectionId . '?back=' . $subjectId. "&yearLevelId=$yearLevelId&sectionId=$sectionId";  
			?>
		<a href="<?= $back ?>">
			<button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
		</a>

</div> <!-- container -->

<script>
	$(document).ready(function(){
		$("#filterDd").hide();
		$("#filterBtn").click(function(){
			$("#filterDd").fadeToggle();
		});
	});
</script>
<?php $syUrl = base_url() . "classes/filterBySchoolYear" ?>
<!-- para naman sa drop down sorting -->
<script>
	$(document).ready(function(){
		$("#syDd").change(function(){
			var sy = $("#syDd").val();
			$.post("<?= $syUrl ?>", {
				schoolYear: sy,
				studentId: <?= $studentId ?>
			}, function(data){
				//papalitan na ng content ng tbody
				$("#tbody").html(data);
			});
		});
	});
</script>

	