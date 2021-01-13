<?php
foreach ($user_table->result_array() as $row) {
	$id = $row['account_id'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
}

$form_url = base_url() . 'Manage_user_accounts/update_faculty/' . $id;
?>
<div class="continer col-md-12">
	<form action="<?= $form_url ?>" method="post">
		<?php $this->Main_model->banner('Manage faculty accounts', 'Update account'); ?>

		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>


		<div class="form-group">
			<label>First Name: </label>
			<input type="text" name="firstname" class="form-control" autocomplete="off" value="<?= $firstname ?>">
		</div>

		<div class="form-group">
			<label>Middle Name: </label>
			<input type="text" name="middlename" class="form-control" autocomplete="off" value="<?= $middlename ?>">
		</div>

		<div class="form-group">
			<label>Last Name: </label>
			<input type="text" name="lastname" class="form-control" autocomplete="off" value="<?= $lastname ?>">
		</div><br>


		<div class="row">

			<div class="col-md-4">
				<?php 
				$cancel = base_url() . 'Manage_user_accounts/secManageAccount'; // for tcshs shs
				$cancel = base_url() . 'manage_user_accounts/viewJuniorHighSchoolFaculty';
				?>
				<a href="<?= $cancel ?>">
					<button type="button" class="btn btn-secondary col-md-12">
						<i class="fas fa-arrow-left"></i>
						Cancel
					</button>
				</a>
			</div>

			<div class="col-md-4">
				<button type="submit" class="btn btn-primary col-md-12">
					<i class="fas fa-edit"></i>&nbsp;
					Update
				</button>
			</div>

			<div class="col-md-4">
				<?php $delete = base_url() . "Manage_user_accounts/sureDeletion?id=$id" ?>
				<a href="<?= $delete ?>">
					<button type="button" class="btn btn-danger col-md-12">
						<i class="fas fa-trash"></i>
						Delete
					</button>
				</a>
			</div>
		</div>

	</form>

	<br><br><br>


</div>