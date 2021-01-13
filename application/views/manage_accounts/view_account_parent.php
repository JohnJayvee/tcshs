
<div style="margin-bottom:10ox"></div>

<div class="container">
	
		<center class="bg-warning p-3">
			<h1>View Junior highschool Accounts</h1>
			<hr width="60%" style="margin:5px 5px">
			<h2>Parents accounts</h2>
		</center>
		<div style="margin-bottom:10px"></div>	
	
	<?php 
	$student_url = base_url() . 'manage_user/view_student_account?yearLevelId=' . $yearLevelId . '&sectionId=' . $sectionId;

	 ?>

	<a href="<?= $student_url ?>">
		<button class="btn btn-success col-md-12">
			View Student's Account
		</button>
	</a><br>
	<?php 
		if (isset($_SESSION['parentUpdate'])) {
			echo "<p class='alert alert-success p-3 m-3'>Parent updated successfuly</p>";
			unset($_SESSION['parentUpdate']);
		}
	 ?>
	 <?php 
		if (isset($_SESSION['studentLinkUpdated'])) {
			echo "<p class='alert alert-success p-3 m-3'>Parent student link updated successfuly</p>";
			unset($_SESSION['studentLinkUpdated']);
		}
	 ?>

	
<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					
					<th> Name </th>
					<th> Student Name</th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>
	
	<?php 	
	//FAIL SAFE:  table is empty dont display anything. 
	if (!empty($table[0])) {
		
	
				//parent table ito
		$i = 0;
		foreach ($table as $key => $value) {
			$parent_account_id = $value[$i]['account_id'];
			$firstname = $value[$i]['firstname'];
			$middlename = $value[$i]['middlename'];
			$lastname = $value[$i]['lastname'];
			$parent_fullname = ucfirst($firstname) ." ". ucfirst($middlename) ." ". ucfirst($lastname);
			$parent_status = $value[$i]['status'];
			// $i++;
	 	?> 
	

	 	<tr>
	 		
			<td><?= ucfirst($parent_fullname) ?></td>

			<td>
				<?php 
					$student_data = $this->Main_model->get_where('student_profile','parent_id', $parent_account_id);
					foreach ($student_data->result_array() as $row) {
						$student_firstname = ucfirst($row['firstname']);
						$student_middlename = ucfirst($row['middlename']);
						$student_lastname = ucfirst($row['lastname']);
						$student_full_name = "$student_firstname $student_middlename $student_lastname";

						echo $student_full_name . "<br> <br>";
					}

					


				 ?>
			</td>
		
			<td>
	<?php $classify = 2 ?>
				<?php $update_url = base_url() . 'manage_user/parentEdit/' . $parent_account_id .'/' .$classify. "?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
				<a href="<?= $update_url ?>">
					<button class="btn btn-primary col-md-12">
						<i class="fas fa-edit"></i>
						Edit
					</button>
				</a>
			</td>
	</tr>

	 <?php } } ?> 
	


	
</tbody>
</table>

</div>

