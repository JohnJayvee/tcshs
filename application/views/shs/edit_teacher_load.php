

<?php 
foreach ($teacher_load_table->result_array() as $row) {
	$pick_teacher_load_id = $row['id'];
	$faculty_account_id = $row['faculty_account_id'];
	$pick_section_id = $row['sh_section_id'];
	$pick_subject_id = $row['sh_subject_id'];
	$pick_schedule = $row['schedule'];
	$pick_grade_level = $row['year_level'];
}

 ?>
<class class="container">
	<center class="bg-warning p-3">
		<h1>Edit your teacher load</h1>
		<hr width="40%" style="margin: 5px 5px">
		<h2><?= $teacher_fullname ?></h2>
	</center>

	<div style="margin-bottom: 40px"></div>
	<?php $form = base_url() . 'shs/teacher_load?edit=' . $teacher_load_id;  ?>
	<form action="<?= $form ?>" method="post">
		
		<!-- insert select grade level -->
		<div class="form-group">
			<label>Select year Level:</label>
			<select name="school_year_grade" class="form-control" id="gradeLevel">
				<option value="<?= $pick_grade_level ?>"><?= $this->Main_model->getYearLevelNameFromId($pick_grade_level); ?></option>
				 <!-- edit above code -->

				<?php 
				foreach ($school_grade_table->result_array() as $row) {
					$year_level_id = $row['school_grade_id'];
                    $name = $row['name'];
                    $academicGradeId = $row['academic_grade_id'];
                    $status = $row['status'];

                    //remove academic jhs students
                    if (($academicGradeId == 1) || ($status == 0)) {
                        continue;
                    }
                    ?>
				
				<option value="<?= $year_level_id ?>"><?= $name ?></option>
				<?php } ?>
			</select>
		</div>
		
		<!-- select section -->
		<div class="form-group">
			<label>Select Section:</label> 
			<select name="section" id="section" class="form-control">

                <option value="<?= $pick_section_id ?>"><?= $this->Main_model->getShSectionName($pick_section_id); ?></option>
                                    
                <!-- get all data -->
                <?php foreach ($section_table->result() as $row) { ?>
                    <option value="<?= $row->section_id ?>"><?= $this->Main_model->getShSectionName($row->section_id) ?></option>
                <?php } ?>
					
			</select>
		</div>

		<!-- select subject -->
		<div class="form-group">
			<label>Select Subject:</label> 
			<select name="subject" id="subject" class="form-control">
				
					<option value="<?= $pick_subject_id ?>"><?= $this->Main_model->getShSubjectNameFromId($pick_subject_id); ?></option>

					<!-- get all data -->
					<?php foreach ($subject_table->result() as $row) {
						$teacherLoadId = $this->Main_model->getTeacherLoadIdFromSubject($row->subject_id);
            
						if ($teacherLoadId == true) {
							//merong laman merong nahanap
							echo "merong laman merong nahanap <br>";
							// unset($subjectTable[0]);
							continue;
						}
						?>
                        <option value="<?= $row->subject_id ?>"><?= $this->Main_model->getShSubjectNameFromId($row->subject_id) ?></option>
                    <?php } ?>
			</select>
		</div>
		
		<div class="form-group">
			<label>Enter Schedule</label>
			<input type="text" name="schedule" placeholder="Schedule" class="form-control" value="<?= $pick_schedule ?>">
		</div><br>
		<button type="submit" name="submit" class="btn btn-primary col-md-12">Submit</button>
	</form> <div style="margin-top:-10px"></div>
	<div style="margin-bottom:20px"></div>
	<?php $back = base_url() . "shs/viewPersonalTeacherLoad" ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</class>
<!-- scripts for the dynamic drop down -->


<!-- perform dynamic dropdown menu script -->
<script>
	$(document).ready(function(){
		$('#gradeLevel').change(function(){
			var gradeLevel = $("#gradeLevel").val();
            
			$.post(
				"http://localhost/tcshs/shs/selectSection",
				{gradeLevel: gradeLevel}, //post data
				function(data){
					//call back.
					$("#section").html(data);
				}
			);

			//pangalawang request para sa subject naman ito
			var yearLevelId = $("#gradeLevel").val();
			// alert(yearLevelId + "is the yearLevelId");
			$.post(
				"http://localhost/tcshs/shs/selectSubject", //url
				{gradeLevelId: yearLevelId}, //post data
				function(data){
					//call back
					$("#subject").html(data);
				}
			);
		});//ending script for the first dynamic dropdown.
	});
</script>

