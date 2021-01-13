<div style="margin-bottom: 40px"></div>

<div class="container">
	<h1>Enter Registry Password</h1><br>

	<form action="" method="post">
		<div class="form-group">
			<label>Enter Registry Password</label>
			<input type="password" name="pas1" class="form-control" required>
		</div>

		<div class="form-group">
			<label>Confirm Registry Password</label>
			<input type="password" name="pas2" class="form-control" required>
		</div>
		<button type="submit" class="btn btn-primary col-md-12">Submit</button>
	</form>
	<?php $back = base_url() . 'manage_user_accounts/manage_account' ?>
	<a href="<?= $back ?>">
		<button class="btn btn-secondary col-md-12">Back</button>
	</a>
</div>