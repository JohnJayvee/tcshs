<div style="margin-bottom:10px"></div>

<div class="container">

	<div align="center">

	</div>
		
		<center class="bg-warning p-3">
			<h1>View Junior highschool Accounts</h1>
			<hr width="60%" style="margin:5px 5px">
			<h2>Student accounts</h2>
		</center>
		<div style="margin-bottom:10px"></div>					
	<?php $view_parent = base_url() . 'manage_user/view_parent_account?yearLevelId=' . $yearLevelId . '&sectionId=' . $sectionId; ?>
<a href="<?= $view_parent ?>" class="btn btn-primary col-md-12">View Account Parent</a><div style="margin-bottom:10px"></div>
<?php $this->Main_model->alertDanger('accountDeleted','You have deleted an account'); ?>
<?php $this->Main_model->alertDanger('parentFacultyDeactivated','Parent account of the teacher has been deleted since the teacher does not have any children studying in this school'); ?>
<?php $this->Main_model->alertSuccess('updateSuc','Account update success'); ?>
<?php $this->Main_model->alertDanger('parentDeleted','Parent account also deleted'); ?>
				
				<?php if (isset($_SESSION['call_parent'])) {?>
					<p style="background-color: red;border-radius: 40px;color: white;font-size: 20px;font-weight: bold;padding: 10px">Call parent activated: <?= $_SESSION['call_parent'] ?></p>
				<?php unset($_SESSION['call_parent']);} ?>

				<?php 
				if (isset($_SESSION['uncall_parent'])) {?>
						<p style="background-color: green;border-radius: 40px;color: white;font-size: 20px;font-weight: bold;padding: 10px">Call parent Deactivated: <?= $_SESSION['uncall_parent'] ?></p>
				<?php unset($_SESSION['uncall_parent']);} ?>
				
				
				
<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					
					<th>Name</th>
					
					<th>Section</th>
					<th>Year Grade</th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>

	<?php
	
	//get the get data
	$yearLevelId = $this->input->get('yearLevelId');
	$sectionId = $this->input->get('sectionId');

 foreach ($table->result_array() as $row) {
	 	
	 	$id = $row['account_id'];
	 	$firstname = ucfirst($row['firstname']);
	 	$middlename = ucfirst($row['middlename']);
	 	$lastname = ucfirst($row['lastname']);
	 	$student_status = $row['student_status'];
	 	$parent_id = $row['parent_id'];
	 	$student_fullname = "$firstname $middlename $lastname";
	 	$school_grade_id = $row['school_grade_id'];
	 	$section_id = $row['section_id'];

		 //remove all of the deactivated students. 
		 if ($student_status == 0) {
			 continue;
		 }
	 	
	 	
	 	?> 

	 	<tr>
			<td><?= ucfirst($student_fullname) ?></td>
		
	
			<td> <!-- section -->
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
				$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $school_grade_id);
				foreach ($school_grade_table->result_array() as $row) {
					$school_grade_name = $row['name'];
				}

				echo ucfirst($school_grade_name);

				 ?>
			</td>
				
			

			
			<td>
<?php $classify = 1 ?>
			<?php $update_url = base_url() . "manage_user/student_account_edit/$id?yearlevelId=$yearLevelId&sectionId=$sectionId"; ?>
			<a href="<?= $update_url ?>">
				<button class="btn btn-primary col-md-12">
					<i class="fas fa-edit"></i>
					Edit
				</button>
			</a>
			&nbsp;<!--  perform foreach here to get parent_id -->
			<?php $delete_url = base_url() . 'manage_user/account_delete/' . $id . '/1' . "?yearLevelId=$yearLevelId&sectionId=$sectionId"?>
			<a href="<?= $delete_url ?>">
				<button class="btn btn-danger col-md-12">
					<i class="fas fa-trash-alt"></i>
					Delete
				</button>
			</a>
		</td>

			
	</tr>

	 <?php } ?> 
	


	
</tbody>
</table>
</div>
</div>
