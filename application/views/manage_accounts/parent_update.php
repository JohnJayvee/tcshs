<div style="margin-bottom: 20px;"></div>

<div class="container">
	<?php $this->Main_model->banner("Update parent's account", $parentFullName);  ?>
	<?php $parent_link = base_url() . 'manage_user/editStudentLink/' . $parent_id . "?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
	<a href="<?= $parent_link ?>">
		<button class="btn btn-info col-md-12"><i class="fas fa-edit"></i>&nbsp; Manage parent's children</button>
	</a>
	<div style="margin-bottom: 40px;"></div>
	<?php $form = base_url() . 'manage_user/parentEdit/' . $parent_id . "?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
		<form action="<?= $form ?>" method="post">
			<?= validation_errors("<p class='alert alert-danger p-3 m-4'>"); ?>
			<div class="form-group">
				<label>First Name:</label>
				<input type="text" name="firstname" value="<?= $firstname ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Middle Name:</label>
				<input type="text" name="middlename" value="<?= $middlename ?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Last Name:</label>
				<input type="text" name="lastname" value="<?= $lastname ?>" class="form-control">
			</div>
			<?php $back = base_url() . "manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
			<div class="row">
				<div class="col-md-6">
					<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
				</div>
				<div class="col-md-6">
					<button type="submit" name="update" class="btn btn-primary col-md-12">Update</button>
				</div>
			</div>
			<div style="margin-bottom: 30px;"></div>
		</form> 		
</div> <!-- container -->