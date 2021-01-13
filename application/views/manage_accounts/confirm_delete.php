<?php 



foreach ($faculty_table->result_array() as $row) {
	$account_id = $row['account_id'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];	
}

$deactivate = base_url() . 'Manage_user_accounts/deactivateFaculty/?id=' . $account_id;
$cancel = base_url() . 'Manage_user_accounts/manage_account/';


 ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>DEACTIVATE ACCOUNT</strong><br><br>
 		Are You Sure you want to Deactivate Faculty record <strong> <?= "$firstname $middlename $lastname" ?> ?</strong>
 		<br><br>
 		<a href="<?= $deactivate ?>" class="btn btn-danger">DEACTIVATE</a>
 		&nbsp;
 		<a href="<?= $cancel?>" class="btn btn-secondary">CANCEL</a>
 	</div>

 </div>
