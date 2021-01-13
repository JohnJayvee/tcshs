<?php 
	if (isset($_SESSION['emptyGrades'])) {
		echo "<script>alert('Student grades are empty');</script>";
		unset($_SESSION['emptyGrades']);
	}
	if (isset($_SESSION['noAttendance'])) {
		echo "<script>alert('Student has no attendance');</script>";
		unset($_SESSION['noAttendance']);
	}
	$this->Main_model->alertPromt('Students that are your children can now be registered into your account', 'registeredAsParent');
	$this->Main_model->alertPromt('Students have been successfully added into your section advisee', 'aquiredStudents');
?>
<div style="margin-bottom: 20px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" style="word-wrap:break-word;" align="center">
		<h1><?= $fullname ?></h1>
 	</div> <!-- yellow top -->
	 
 	<hr>
 	<div class="form-group">
			<?php if (isset($_SESSION['alert_message'])): ?>
				<p class='p-3 mb-2 bg-success text-white' align="center" style="font-size: 25px;">
					<?= $_SESSION['alert_message'] ?>
					<!-- <?php unset($_SESSION['alert_message']) ?> -->
				</p>		
			<?php endif ?>
		</div>
 	<div style="margin-bottom: 20px"></div>
				
	<?php $assignSecretary = base_url() . 'manage_user_accounts/configureSecretaryCreds'  ?>
	<?php if ($this->Main_model->secretaryTeacherChecker() == 2) { ?>
		<!-- secretary teacher siya -->
		<a href="<?= $assignSecretary ?>"><button class="btn btn-info col-md-12"><i class="fas fa-user"></i>&nbsp; Enter as secretary</button></a>
		<div style="margin-bottom:20px"></div>

	<?php } ?>

	<div style="margin-bottom: 20px"></div>
	<div class="row">
		<div class="col-md-6">
			<?php $change_password = base_url() . 'manage_user_accounts/change_password/' . $faculty_id ?>
			<a href="<?= $change_password ?>">
				<button class="btn btn-primary col-md-12"><i class="fas fa-key" style="color: white;"></i>&nbsp; Change Password</button>
			</a><br><br>
			<?php $record_attendance = base_url() . 'attendance_monitoring' ?>
			<a href="<?= $record_attendance ?>">
				<button class="btn btn-info col-md-12"> <i class="fas fa-fingerprint"></i> &nbsp;Record Attendance</button>
			</a><br><br>
			<?php $upload_grade = base_url() . "excel_import"; ?>
			<a href="<?= $upload_grade ?>">
				<button class="btn btn-dark col-md-12"> <i class="fas fa-file-csv"></i> &nbsp;Upload Grade</button>
			</a><br><br>


		</div> <!-- left -->
		<div class="col-md-6">
			<?php $add_content = base_url() . 'main_controller/cms_add' ?>
			<a href="<?= $add_content ?>">
				<button class="btn btn-dark col-md-12"> <i class="fas fas fas fa-camera fa-m"></i> &nbsp;Add Content</button>
			</a><br><br>
			<?php $manage_classes = base_url() . 'classes/selectYearSubjectClasses' ?>
			<a href="<?= $manage_classes ?>">
				<button class="btn btn-info col-md-12"> <i class="	fas fa-apple-alt fa-m"></i> &nbsp;Manage Classes</button>
			</a><br><br>
			<?php $student_grade = base_url() . 'classes/selectYearLevelStudentGrades' ?>
			<a href="<?= $student_grade ?>">
				<button class="btn btn-primary col-md-12"> <i class="fas fa-eye"></i> &nbsp;View Student's Grade</button>
			</a>	
		</div> <!-- right -->		
	</div> 
		&nbsp; <!-- para bumaba siya wag tatanggalin yung nbsp -->
	<!-- register as a parent -->
	<?php $registerAsParent = base_url() . "manage_user_accounts/teacherRegisterAsParent" ?>
	<?php
	if ($this->Main_model->determineIfTeacherIsParent($_SESSION['faculty_account_id']) ==  false) { ?>
		<a href="<?= $registerAsParent ?>"><button class="btn btn-outline-success col-md-12"><i class="fas fa-child"></i>&nbsp; Also register as a parent</button></a>
	<?php } ?>
	<div style="margin-bottom:20px"></div>
	<div class="" align="center">
	<?php $searchStudent = base_url() . "searchStudent/adminSelectStudent" ?>
	<?= validation_errors("<p class='alert alert-danger'>"); ?>
		<form action="<?= $searchStudent ?>" method="post">
				<div class="form-group">
					<input id="search_data" autofocus="on" autocomplete="off" required type="text" name="studentName" placeholder="Search Student" class="form-control">
				</div>
				<button class="btn btn-outline-primary col-md-12" style="color:black"><i class="fas fa-search"></i>&nbsp; Search</button>
		</form>
	</div>
 </div> <!-- container -->