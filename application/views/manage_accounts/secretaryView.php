<?php
if (isset($_SESSION['noGradeAvailable'])) {
	echo "<script>alert('The student has no available grades yet');</script>";
	unset($_SESSION['noGradeAvailable']);
}


if (isset($_SESSION['noAttendanceRecord'])) {
	echo "<script>alert('Student has no attendance record yet');</script>";
	unset($_SESSION['noAttendanceRecord']);
}

$this->Main_model->alertPromt('Principal account updated, username and password will be texted to the new principal', 'changePrincipal');
?>


<div style="margin-bottom: 20px"></div>
<div class="container">

	<div class="alert alert-warning" align="center">



		<h1><?= $fullname ?></h1>

	</div> <!-- yellow top -->

	<hr>
	<div class="form-group">
		<?php if (isset($_SESSION['alert_message'])) : ?>
			<p class='p-3 mb-2 bg-success text-white' align="center" style="font-size: 25px;">
				<?= $_SESSION['alert_message'] ?>
				<!-- <?php unset($_SESSION['alert_message']) ?> -->
			</p>
		<?php endif ?>
	</div>
	
	<?php $assignSecretary = base_url() . 'manage_user_accounts/dashboard'  ?>
	<?php if ($this->Main_model->secretaryTeacherChecker() == 2) { ?>
		<!-- secretary teacher siya -->
		<a href="<?= $assignSecretary ?>"><button class="btn btn-info col-md-12"><i class="fas fa-user"></i>&nbsp; Enter as Teacher</button></a>
		<div style="margin-bottom:20px"></div>

	<?php } ?>


	<div class="row">
		<!-- student search -->
		<div style="margin-bottom:30px"></div>
		<!-- other buttons -->
		<div class="col-md-6">
			<?php $change_password = base_url() . 'manage_user_accounts/change_password/' . $faculty_id ?>
			<a href="<?= $change_password ?>">
				<button class="btn btn-primary col-md-12"><i class="fas fa-key" style="color: white;"></i>&nbsp; Change Password</button>
			</a>
			<div style="margin-bottom:5px"></div>
			<?php //$batch = base_url() . 'Manage_user_accounts/secManageAccount' //heto yung merong shs ?>
			<?php $batch = base_url() . 'manage_user_accounts/viewJuniorHighSchoolFaculty' //heto yung merong shs ?>
			<!-- facultyRegisterBatch -->
			<a href="<?= $batch ?>"><button class="btn btn-success col-md-12 p-3"><i class="fas fa-users"> &nbsp;Faculty register</i></button></a>
		</div>

		<div class="col-md-6" align="center">
			<?php $studentSearch = base_url() . "SearchStudent" ?>
			<form action="<?= $studentSearch ?>" method="post">
				<div class="form-group">
					<input type="text" autofocus="on" autocomplete="off" placeholder="Search student" name="search" class="form-control">
				</div>
				<button class="btn btn-outline-info col-md-12" style="color:black"><i class="fas fa-search" style="color: black;"></i>&nbsp; Search a Student</button>
			</form>
		</div>
	</div>
	<div style="margin-bottom:5px"></div>
	<?php $strandTransfer = base_url() . "shs/strandTransfer" ?>
	<a href="<?= $strandTransfer ?>" class="button btn btn-dark col-md-12">Strand Transfer</a>&nbsp;
	<br>
	<!-- register as a parent -->
	<?php $registerAsParent = base_url() . "manage_user_accounts/teacherRegisterAsParent" ?>
	<?php
	if ($this->Main_model->determineIfTeacherIsParent($_SESSION['faculty_account_id']) ==  false) { ?>
		<a href="<?= $registerAsParent ?>"><button class="btn btn-outline-success col-md-12"><i class="fas fa-child"></i>&nbsp; Also register as a parent</button></a>
	<?php } ?>
</div><!-- container -->

<div style="margin-bottom: 40px"></div>