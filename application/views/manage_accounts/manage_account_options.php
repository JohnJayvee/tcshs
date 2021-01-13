
<?php 
$register_account = base_url() . 'manage_user_accounts/register_faculty';
$change_principal = base_url() . 'manage_user_accounts/change_principal';


foreach ($credentials->result_array() as $row) {
	$credentials_id = $row['credentials_id'];
	$account_id = $row['account_id'];
}

// notifications
$this->Main_model->alertPromt('Secretary registered successfully', 'newSecretaryUpdated');
$this->Main_model->alertPromt('Secretary registered Successfully', 'newSecReg');
$this->Main_model->alertPromt('The new secretary teacher will be a Junior high school teacher. The secretary may transfer his/her account in his account', 'secretaryTeacherReg');
$this->Main_model->alertPromt('Secretary update successfully', 'secretaryAccountUpdated');
?>
<div class="container">

	<?php $this->Main_model->banner('Manage faculty accounts', "Activate or deactivate"); ?>

	<?php 
	$this->load->model('Main_model');
	$this->Main_model->alertSuccess('secretaryCreated','Secretary account Created');
	$this->Main_model->alertDanger('secretaryAvailable','Secretary account already exist!');
	 ?>
	<div class="bg-info">
		<?php $assignSecretary = base_url() . 'manage_user_accounts/assignSecretary/';
			$registerSecretary = base_url() . 'manage_user_accounts/registerSecretary';
		 ?>
		<div class=" p-3">
			<div style="font-weight: bold;font-size: 25px;"> Assigned Secretary: 
				<?php
					if (isset($secretaryName)) {
						echo $secretaryName;
					} else{
						echo "Register Secretary's account";
					}
				?>
			</div><br>
			<div style="margin-left: 0%;">
			<div class="row">
			<?php
					if (isset($secretaryName)) {?>
						<!-- meaning lang neto meron ng secretary na naka assign -->
						<!-- check mo na kung secretary teacher siya -->
						<?php $secretaryControl = base_url() . "manage_user_accounts/controlSecretaryRole" ?>
						<?php if ($_SESSION['secretaryTeacher'] == 1) { ?>
							<!-- Secretary teacher siya -->
							<div class="col-md-6">
								<a href="<?= $secretaryControl ?>"><button class="btn btn-dark col-md-12">Assign secretary teacher as only as a secretary</button></a>
							</div>
						<?php }else{ ?>
							<!-- Secretary lang siya siya -->
							<div class="col-md-6">
								<a href="<?= $secretaryControl ?>"><button class="btn btn-dark col-md-12">Assign secretary also as a teacher</button></a>
							</div>
						<?php } ?>
						<div class="col-md-6">
							<a href="<?= $assignSecretary ?>"><button class="btn btn-success col-md-12">Assign new secretary</button></a>
						</div>
					</div><!-- row div end -->
					<?php } else{?>
						<a href="<?= $registerSecretary ?>"><button class="btn btn-dark col-md-12">Register Secretary</button></a>
					<?php }?>
			</div>
		</div>
	</div>
	<div style="margin-bottom: 40px;"></div>
		

	

<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					<th> First Name </th>
					<th> Middle Name </th>
					<th> Last Name </th>
					<th> Status </th>
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
	 	

	 	?>

	 	<tr>
		
			<td><?= $firstname ?></td>
			<td><?= $middlename ?></td>
			<td><?= $lastname ?></td>
			<td>

				<?php
				$check = base_url() . 'assets/images/check.jpg';
				$cross = base_url() . 'assets/images/cross.jpg'; 
					if ($status == 0) {?>
						<img src="<?= $cross ?>" alt="active" width='50' height='50'>
					<?php }else{?>
						<img src="<?= $check ?>" alt="inactive" width='50' height='50'>
						
					<?php }?>
				 
			</td>
			<td>
			<?php $activate_account = base_url() . 'manage_user_accounts/activate_faculty/' . $id ?>
			<?php $delete_url = base_url() . 'manage_user_accounts/delete_faculty?id=' . $id ?>
				 <?php
					if ($status == 0) {?>
						<a href="<?= $activate_account ?>" >
							<button class="btn btn-success">
								activate
							</button>
						</a>
					<?php }else{?>
						<a href="<?= $delete_url ?>">
							<button class="btn btn-danger">
								Deactivate
							</button>
						</a>
					<?php }?>
				
				
				
				
				
				
			</td>
	</tr>

	 <?php } ?>
	


	
</tbody>
</table>

</div>
</div>
</div>
</div> <!-- just dont delete this -->