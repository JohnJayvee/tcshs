

<?php 
foreach ($teacher_load_table->result_array() as $row) {
	$pick_teacher_load_id = $row['teacher_load_id'];
	$faculty_account_id = $row['faculty_account_id'];
	$pick_section_id = $row['section_id'];
	$pick_subject_id = $row['subject_id'];
	$pick_schedule = $row['schedule'];
	$pick_grade_level = $row['grade_level'];
}

 ?>
<class class="container">
	<center class="bg-warning p-3">
		<h1>Edit your teacher load</h1>
		<hr width="40%" style="margin: 5px 5px">
		<h2><?= $teacher_fullname ?></h2>
	</center>

	<div style="margin-bottom: 40px"></div>
	<?php $form = base_url() . 'classes/teacher_load?edit=' . $teacher_load_id;  ?>
	<form action="<?= $form ?>" method="post">
		
		<!-- insert select grade level -->
		<div class="form-group">
			<label>Select Grade Level:</label>
			<select name="school_year_grade" class="form-control" id="gradeLevel">
				<?php 
					$this->load->model("Main_model");
					$pick_school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $pick_grade_level);
					foreach ($pick_school_grade_table->result_array() as $row) {
						$pick_school_grade_id = $row['school_grade_id'];
						$pick_name = $row['name'];?>

						<option value="<?= $pick_school_grade_id ?>"><?= $pick_name ?></option>

					<?php } ?>
				 <!-- edit above code -->

				<?php 
				foreach ($school_grade_table as $row) {
					$school_grade_id = $row['school_grade_id'];
					//remove all of the school grade that doesn't have any students
					if ($this->Main_model->checkIfSchoolGradeHasStudents($school_grade_id) ==  false) {
						//mag true true siya kapag merong siyang nahanap, kaya dapat naka false siya
						//para pag walang students saka niya i sskip
						continue;
					}
					$name = $row['name'];?>
				
				<option value="<?= $school_grade_id ?>"><?= $name ?></option>
				<?php } ?>
			</select>
		</div>
		
		<!-- select section -->
		<div class="form-group">
			<label>Select Section:</label> 
			<select name="section" id="section" class="form-control">
				<?php 
					$this->load->model("Main_model");
					$pick_section_table = $this->Main_model->get_where('section','section_id', $pick_section_id);
					foreach ($pick_section_table->result_array() as $row) {
						$pick_section_id = $row['section_id'];
						$pick_section_name = $row['section_name'];?>
						<option value="<?= $pick_section_id ?>"><?= $pick_section_name ?></option>
					<?php } ?>
					<!-- get all data -->
					<?php
						$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $pick_grade_level);
						foreach ($sectionTable->result() as $row) {?>
							<option value="<?= $row->section_id ?>"><?= $row->section_name ?></option>
						<?php } ?>
					
			</select>
		</div>

		<!-- select subject -->
		<div class="form-group">
			<label>Select Subject:</label> 
			<select name="subject" id="subject" class="form-control">
				<?php 
					$this->load->model("Main_model");
					$pick_subjct_table = $this->Main_model->get_where('subject','subject_id', $pick_subject_id);
					foreach ($pick_subjct_table->result_array() as $row) {
						$pick_subjct_id = $row['subjct_id'];
						$pick_subject_name = $row['subject_name'];?>
						<option value="<?= $pick_subject_id ?>"><?= $pick_subject_name ?></option>
					<?php } ?>

					<!-- get all data -->
					<?php
						foreach ($subject_table as $row) {
							//hindi na dapat mag pakita yung mga nakuha ng mga subjects
							// $this->Main_model->removeAlreadyAquiredSubjects($row->subject_id);
							?>
							<option value="<?= $row['subject_id'] ?>"><?= $row['subject_name'] ?></option>
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
	<?php $back = base_url() . "classes/viewPersonalTeacherLoad" ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</class>
<!-- scripts for the dynamic drop down -->


<!-- perform dynamic dropdown menu script -->
<script>
	$(document).ready(function(){
		$('#gradeLevel').change(function(){
			var gradeLevel = $("#gradeLevel").val();
			$.post(
				"http://localhost/tcshs/classes/selectSection",
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
				"http://localhost/tcshs/classes/selectSubject", //url
				{gradeLevelId: yearLevelId}, //post data
				function(data){
					//call back
					$("#subject").html(data);
				}
			);
		});//ending script for the first dynamic dropdown.
	});
</script>

