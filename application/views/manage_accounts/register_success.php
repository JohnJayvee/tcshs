<?php  ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>Account Registered Successfuly</strong><br><br>
 		<p>You have successfuly registered both of the accounts</p>
 		<br>
	<!-- get the get data -->	
	<?php
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');
		$additionalLink = "?yearLevelId=$yearLevelId&sectionId=$sectionId";
	?>

	<?php $back = base_url() . 'manage_user/register?yearLevelId=' . $_GET['yearLevelId'] . '&sectionId=' . $_GET['sectionId'] ?>
	
 		<a href="<?= $back ?>">
 			<button class="btn btn-success col-md-4">
 				Back
 			</button>
 		</a>

 		
 	</div>

 </div>
