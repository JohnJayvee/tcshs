
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->


<div style="margin-bottom:20px"></div>

<div class="container">
		 
		<?php
			$this->load->model('Main_model');
			//get the section and year level name
			$yearLevelName = $this->Main_model->getSchoolNameWithId($yearLevelId);
			$sectionName = $this->Main_model->getSectionNameWithId($sectionId);
		?>

	<?php
		$lowerText = "<strong>$yearLevelName</strong> | <strong>$sectionName</strong>"; 
		$this->Main_model->banner('View student grades', $lowerText);
	?>
		
<div style="margin-bottom:20px"></div>

<!-- notification alert -->
		<?php 
				if (isset($_SESSION['call_parent'])) {?>
					<p class="alert alert-danger t-30">Call parent activated:<b> <?= ucfirst($_SESSION['call_parent']) ?></b></p>
				<?php unset($_SESSION['call_parent']);} ?>

				<?php 
				if (isset($_SESSION['uncall_parent'])) {?>
						<p class="alert alert-success t-30">Call parent Deactivated:<b> <?= ucfirst($_SESSION['uncall_parent']) ?></b></p>
				<?php unset($_SESSION['uncall_parent']);} ?>
	
	

<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					
					<th>Name</th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>

	<?php
	

	


// table = just_get_everything sa s"student_profile table"
 foreach ($table->result_array() as $row) {
	 	
	 	$id = $row['account_id'];//student_id
	 	$firstname = ucfirst($row['firstname']);
	 	$middlename = ucfirst($row['middlename']);
	 	$lastname = ucfirst($row['lastname']);
	 	$student_status = $row['student_status'];
	 	$parent_id = $row['parent_id'];
	 	$student_fullname = "$firstname $middlename $lastname";
	 	$school_grade_id = $row['school_grade_id'];
	 	$section_id = $row['section_id'];?> 

	 	<tr>
			<td><?= $student_fullname ?></td>
		
				
			<td align="center">

			
				
				<?php $viewGrades = base_url() . "classes/student_grades/$id?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
				<a href="<?= $viewGrades ?>">
					<button class="btn btn-primary col-md-5" style="margin-right:5px">
						<i class="fas fa-edit"></i>
						View Grades
					</button>
				</a>

				<?php 
				$this->load->model('Main_model');
				$deactivate = base_url() . 'classes/deactivate_call_parent/' . $id . "/$sectionId";
				$activateCallParent = base_url() . 'classes/confirmCallparent/' . $id . "/$sectionId";
				$where['faculty_id'] = $_SESSION['faculty_account_id'];
				$where['student_profile_id'] = $id;

				$callParentTable = $this->Main_model->multiple_where('call_parent', $where);
				?> <!-- dito ka mag lagay------------ -->
				

				<?php 
				foreach ($callParentTable->result_array() as $row) {
					$callParentId = $row['call_parent_id'];
					$putangInangStatusTo = $row['status'];
					$student_profile_id = $row['student_profile_id'];
				}
				
				$cp_count = count($callParentTable->result_array());
				
					
					if ($cp_count > 0) {?>

						<?php 
						
						if ($putangInangStatusTo == 1) {?>
							<a href="<?= $deactivate ?>">
								<button class="btn btn-success col-md-5">
									<i class="fas fa-phone"></i>							
									Deactivate Call Parent
								</button>
							</a>
						<?php }else{?>
							<a href="<?= $activateCallParent ?>">
								<button class="btn btn-danger col-md-5">
									<i class="fas fa-phone"></i>
									Activate Call Parent
								</button>
							</a>&nbsp;
						<?php }?>

						 

				<?php }else{ ?>
					
				 	<a href="<?= $activateCallParent ?>">
						<button class="btn btn-danger col-md-5">
							<i class="fas fa-phone"></i>
							Activate Call Parent
						</button>
					</a>
				<?php }  ?>
				 

				
			</td>
	</tr>

	 <?php } ?> 
	


	
</tbody>
</table>
</div><br>
<?php $back = base_url() . "classes/selectStudentSection?YearLevelId=$yearLevelId" ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary  col-md-12"><i class="fas fa-arrow-left"></i> &nbsp;Back</button></a>
</div>
