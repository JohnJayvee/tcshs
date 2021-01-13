<?php 
$registerNewSecretary = base_url() . 'manage_user_accounts/updateSecretaryAccount';
$assignNewSec = base_url() . 'manage_user_accounts/assignNewSecretary';
$back = base_url() . "manage_user_accounts/manage_account";

foreach ($credentials->result_array() as $row) {
	$credentials_id = $row['credentials_id'];
	$account_id = $row['account_id'];
}

 ?>
<div class="container">

	<?php $this->Main_model->banner("Mange user accounts", "Assign new secretary"); ?>
	<div style="margin-top:-10px"></div>
	<a href="<?= $registerNewSecretary ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Register new secretary</button></a>


<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th> First Name </th>
					<th> Middle Name </th>
					<th> Last Name </th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>

	<?php

 foreach ($faculty_table->result_array() as $row) {
	 	$id = $row['account_id'];
	 	$firstname = $row['firstname'];
	 	$middlename = $row['middlename'];
	 	$lastname = $row['lastname'];
	 	$status = $row['status'];

	 	if ($account_id == $id) {	
	 		continue;
	 	}
		 
		 //remove the current secretary
		if ($secretaryId == $id) {
			continue;
		}
	 	?>

	 	<tr>
			<td><?= $firstname ?></td>
			<td><?= $middlename ?></td>
			<td><?= $lastname ?></td>
			<td>
		 		<a href="<?= $assignNewSec . '/' . $id ?>"><button class="btn btn-success col-md-12"> <i class="fas fa-check"></i>&nbsp; Assign</button></a>
			</td>
	</tr>

	 <?php } ?>
	


	
</tbody>
</table>

</div>
</div>
<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div> <!-- container -->
</div> <!-- just dont delete this -->