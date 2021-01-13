
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->


<?php echo br(3); ?>

<div class="container col-md-11">
	
	<h1>
		Student's Accounts
	</h1>
	
	<?php 
	
	$parent_url = base_url() . 'manage_user/view_parent_account';

	 ?>

	<a href="<?= $parent_url ?>">
		<button class="btn btn-primary col-md-12">
			View Parent's account
		</button>
	</a>

	
<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					
					<th>Name</th>
					<th> Profile ID </th>
					<th>Status</th>
					<th>Section</th>
					<th>Year Grade</th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>

	<?php
	

	



 foreach ($table->result_array() as $row) {
	 	
	 	$id = $row['account_id'];
	 	$firstname = $row['firstname'];
	 	$middlename = $row['middlename'];
	 	$lastname = $row['lastname'];
	 	$student_status = $row['student_status'];
	 	$parent_id = $row['parent_id'];
	 	$student_fullname = "$firstname $middlename $lastname";
	 	$school_grade_id = $row['school_grade_id'];
	 	$section_id = $row['section_id'];

	 	
	 	$profile_picture = $row['profile_picture'];
	 	?> 

	 	<tr>
			<td><?= $student_fullname ?></td>
		
	<?php $picture = base_url() . 'students/' . $profile_picture ?>
			<td>
				<img src="<?= $picture ?>" class="img-thumbnail img-responsive"   alt="Profile picture" width='150' height='150' align='center'>
			</td>
	<?php
	 $picture_active = base_url() . 'assets/images/account_active.jpg';
	 $picture_inactive = base_url() . 'assets/images/account_inactive.jpg';
	 ?>
			<td> <!-- status -->
				<?php if ($student_status == 1){?>
					<img src="<?= $picture_active ?>" alt="active" class="img-fluid" width="100" height="100">
				<?php }elseif($student_status == 0){?>
					<img src="<?= $picture_inactive ?>" alt="inactive" class="img-fluid" width="100" height="100">
				<?php } ?>  
					
				
			</td>
				
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

			
				&nbsp;
				<?php $delete_url = base_url() . 'manage_user/student_account_edit/' . $id ?>
				<a href="<?= $delete_url ?>">
					<button class="btn btn-primary col-md-12">
						<i class="fas fa-trash-alt"></i>
						Edit
					</button>
				</a>&nbsp;

				<?php $delete_url = base_url() . 'manage_user/account_delete/' . $id . '/' . 1 ?>
				<a href="<?= $delete_url ?>">
					<button class="btn btn-danger col-md-12">
						<i class="fas fa-trash-alt"></i>
						Delete
					</button>
				</a>&nbsp;
			<?php $deactivate = base_url() . 'manage_user/deactivate/' . $id . '/1' ?>
				<?php if ($student_status == 1) {?>
					<a href="<?= $deactivate ?>">
						<button class="btn btn-warning col-md-12">
							
							Deactivate
						</button>
					</a>
			
				<?php }elseif($student_status == 0){
			$activate = base_url() . 'manage_user/activate/' . $id . '/1';?>
					<a href="<?= $activate ?>">
						<button class="btn btn-success col-md-12">
							
							Activate
						</button>
					</a>
				<?php } ?>  
			</td>
	</tr>

	 <?php } ?> 
	


	
</tbody>
</table>
</div>
</div>
