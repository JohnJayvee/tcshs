
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->
<div style="margin-bottom: 50px;"></div>

<!-- get the get data -->
<?php 
	$yearlevelId = $this->input->get('yearLevelId');
	$sectionId = $this->input->get('sectionId');
?>

<div class="container">
	<h1>Select the parent of the Student</h1>
	<div style="margin-bottom: 60px;"></div>
		
<?php $form = base_url() . "manage_user/facultyLink?yearLevelId=$yearlevelId&sectionId=$sectionId" ?>	
<h1 align="center">Faculty Table</h1>



<!-- implement -->
<?php $facultyLink = base_url() . "manage_user/parent_student_link?yearLevelId=$yearlevelId&sectionId=$sectionId" ?>
<div align="center">
	<a href="<?= $facultyLink ?>">
		<button class="btn btn-secondary">Parent Table</button>
	</a>
</div>
<form action="<?= $form ?>" method="post">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>

						<!-- for testing purposes lang itong id. -->
						<th> Faculty</th>
						<th> Options</th>
					</tr>
				</thead>

		

	<tbody>

		



<?php 
		 		foreach ($faculty_table as $row) {
					$account_id = $row['account_id'];
					$firstname = $row['firstname'];
					$middlename = $row['middlename'];
					$lastname = $row['lastname'];
					$parent_status = $row['status'];
					$parent_fullname = "$firstname $middlename $lastname";
					
					?>
		 	<tr>


					<td>
						<?= $parent_fullname ?>
					</td>

				


				


				
				<td>
					<div class="radio">
					  <input type="radio" name="optradio" value="<?= $account_id?>">
					</div>
				</td>
		</tr>
<?php }?>
		
		


		
	</tbody>
	</table><br>

	<button type="submit" class="btn btn-primary col-md-12" name="link">Link</button>
</form>



</div><!-- container --><br>
		<?php $back = base_url() . 'Manage_user/register_parent' ?>
<a href="<?= $back ?>" class="btn btn-info	col-md-12">Back</a>
	</div>
</div> 