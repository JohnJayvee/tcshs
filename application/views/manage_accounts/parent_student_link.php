<div class="container">
	
<div style="margin-bottom: 20px;"></div>

	<center class="bg-warning p-3">
		<h1>Junior highschool registration</h1>
		<hr style="margin: 5px 5px" width="40%">
		<h2><?= $studentFullName ?></h2>
	</center>

<?php
	$yearLevelId = $this->input->get('yearLevelId');
	$sectionId = $this->input->get('sectionId');
?>
<?php $form = base_url() . "manage_user/parent_student_link?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>	


<!-- get the get data -->
<?php 
	$yearlevelId = $this->input->get('yearLevelId');
	$sectionId = $this->input->get('sectionId');
?>

<!-- implement -->
<?php $facultyLink = base_url() . "manage_user/facultyLink?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
<form action="<?= $form  ?>" method="post">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>

						<!-- for testing purposes lang itong id. -->
						<th> Parent Name</th>
						<th> Options</th>
					</tr>
				</thead>

		

	<tbody>

		



<?php 
		 		foreach ($parent_table as $row) {
					$account_id = $row['account_id'];
					$firstname = $row['firstname'];
					$middlename = $row['middlename'];
					$lastname = $row['lastname'];
					$parent_status = $row['status'];
					$parent_fullname = "$firstname $middlename $lastname";?>
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



</div><!-- container --> <div style="margin-bottom:10px"></div>
<?php 
	$yearlevelId = $this->input->get('yearlevelId');
	$sectionId = $this->input->get('sectionId');
?>
		<?php $back = base_url() . "Manage_user/register_parent?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
<a href="<?= $back ?>" class="btn btn-secondary	col-md-12">Back</a>
	</div>
</div> 
</div>