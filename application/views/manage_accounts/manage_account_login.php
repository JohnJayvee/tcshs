<?php $form_url = base_url() . 'Manage_user_accounts/login' ?>

<div class="continer col-md-12" >
	<form action="<?= $form_url ?>" method="post">
		<div class="form-group" align="center">
			<h1>Login</h1>
		</div>

		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>

		<div class="form-group">
			<label>Username:</label>
			<input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username">
		</div><br>

		<div class="form-group">
			<label>Password:</label>
			<input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password">
		</div>

		<button type="submit" class="btn btn-primary">
			Login
		</button>

	</form><br><br><br>

	<h6 align="center">Only the Principal can access this area</h6>
</div>