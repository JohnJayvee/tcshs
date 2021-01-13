

<div  style="margin-bottom: 40px;"></div>

<div class="container">
	<h1>Register secretary Account</h1><br>

	<?php $form = base_url() . 'manage_user_accounts/registerSecretary' ?>
	<form action="<?= $form ?>" method='post' autocomplete="off">
		<?= validation_errors("<p class='alert alert-danger'>");  ?>
	
		<div class="form-group">
			<label>Firstname: </label>
			<input type="text" name="firstname" placeholder="Firstname" class="form-control">
		</div>
		<div class="form-group">
			<label>Middlename: </label>
			<input type="text" name="middlename" placeholder="Middlename" class="form-control">
		</div>
		<div class="form-group">
			<label>Lastname: </label>
			<input type="text" name="lastname" placeholder="Lastname" class="form-control">
		</div><br>
		<div class="form-group">
			<label>Mobile Number: </label>
			<input type="number" name="mobileNumber" placeholder="Mobile number" class="form-control">
		</div><br>
		<button type="submit" name="submit" class="btn btn-primary col-md-12">Register</button>
	</form>
	<div style="margin-bottom:1px"></div>
	<?php $back = base_url() . 'manage_user_accounts/manage_account' ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>