<div class="continer">
	
		<?php $this->Main_model->banner("Manage user account", "Account information"); ?>
		<div style="margin-bottom:-37px"></div>&nbsp;

		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
			<?php
				$this->Main_model->alertDanger('p1notp2', "Confirm password does not match");
				$this->Main_model->alertDanger('oldPasswordNoMatch', "Invalid current password");
			?>
		</div>
		
		
<form action="" method="post">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Previous password: </label>
				<input type="password" name="oldPassword" class="form-control" autocomplete="off"  placeholder="Enter current password">
			</div>

			<div class="form-group">
				<label>New password: </label>
				<input type="password" name="newPassword" class="form-control" autocomplete="off" placeholder="Enter new password">
			</div>

			<div class="form-group">
				<label>Confirm Password: </label>
				<input type="password" name="confirmPassword" class="form-control" autocomplete="off" placeholder="Confirm new password">
			</div>
		</div>

		<!-- Devider -->

		<div class="col-md-6">
			<div class="form-group">
				<label>First Name: </label>
				<input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="<?= $firstname?>" value="<?= $firstname ?>">
			</div>

			<div class="form-group">
				<label>Middle Name: </label>
				<input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="<?= $middlename?>" value="<?= $middlename ?>">
			</div>

			<div class="form-group">
				<label>Last Name: </label>
				<input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="<?= $lastname?>" value="<?= $lastname ?>">
			</div><br>
		</div>
		<br>
	</div><!--  row -->
	<?php 
		$credentialsId = $_SESSION['credentials_id'];
		if ($credentialsId == 4) {
			//principal siya
			$back = base_url() . "manage_user_accounts/dashboard";
		}elseif($credentialsId == 5){
			//teacher siya or secretary siya
			$back = base_url() . "manage_user_accounts/secretaryView";
		}elseif($credentialsId == 1){
			//teacher siya.
			$back = base_url() . "manage_user_accounts/dashboard";
		}
	?>
	<div class="row">
		<div class="col-md-6">
			<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
		</div>
		<div class="col-md-6">
			<button type="submit" class="col-md-12 btn btn-primary"><i class="fas fa-check"></i>&nbsp; Update</button>
		</div>
	</div>
	</form>
	
</div>