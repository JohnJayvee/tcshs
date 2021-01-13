<div class="container" >
	
		<?php $this->Main_model->banner('Change password', $parentFullName); ?>

		<div class="form-group">
			<?= validation_errors("<p class='alert alert-danger'>"); ?>
		</div>
		
		<?php 
			$this->Main_model->alertDanger('diffPassword','Password and Confirm password does not match');
			$this->Main_model->alertDanger('oldPassFalse','Previous password does not match');
		?>
	<form action="" method="post">

		
		<div class="form-group">
			<label>Old Password: </label>
			<input type="password" name="oldPassword" class="form-control" autocomplete="off" placeholder="Enter old password">
		</div>

		<div class="form-group">
			<label>Password: </label>
			<input type="password" name="newPassword" class="form-control" autocomplete="off" placeholder="Enter new password">
		</div>
		
		<div class="form-group">
			<label>Confirm Password: </label>
			<input type="password" name="confirmPassword" class="form-control" autocomplete="off" placeholder="Confirm new password">
		</div><br>
		
		<div class="row">
			<div class="col-md-6">
			<?php $back = base_url() . 'parent_student/student_page' ?>
				<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i> Back</button></a>
			</div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-primary col-md-12"><i class="fas fa-edit"></i> Update</button>
			</div>
		</div>
	</form>


	

	<br><br><br>

	
</div>