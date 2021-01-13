



<div style="border-bottom: 1000px"></div><br><br><br>
<div class="container" style="align-content: center">
	
	<h1 align="center">Select A Student</h1>
	<br><br>
	<div class="row" align="center">	
<?php 
	foreach ($student_table->result_array() as $row) {
		$student_id = $row['account_id'];
		$firstname = $row['firstname'];
		$middlename = $row['middlename'];
		$lastname = $row['lastname'];
	
		$student_status = $row['student_status'];
		$school_grade_id = $row['school_grade_id'];
		$section_id = $row['section_id'];
		$student_fullname = "$firstname $middlename $lastname";

		if ($student_status == 0) {
			continue;
		}
		?>
	
		<div class="card" style="width: 18rem;">

		  <div class="card-body">
		    <h5 class="card-title"><?= $student_fullname ?></h5>
		    <p class="card-text"><?php 
		    	$this->load->model('Main_model');
		    	$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $school_grade_id);
		    	foreach ($school_grade_table->result_array() as $row) {
		    		$school_grade_name = $row['name'];
		    	}
		    	echo ucfirst($school_grade_name);
		     ?></p>
		     <?php $select_student = base_url() . 'parent_student/student_page?parent_access=' . $student_id; ?>
		    <a href="<?= $select_student ?>" class="btn btn-primary col-md-12">Select</a>
		  </div>
		</div>
		<div style="margin-left: 40px"></div>
	

<?php } ?>
	
</div>


</div> <!-- container -->