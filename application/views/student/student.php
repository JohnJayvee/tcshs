<?php
	if (isset($_SESSION['wrongCode'])) {
		echo "<script>alert('Wrong Code please try again');</script>";
		unset($_SESSION['wrongCode']);
	}

	

	if (isset($_SESSION['sameNumber'])) {
		echo "<script>alert('Trying to update the same number');</script>";
		unset($_SESSION['sameNumber']);
	}
?>

<div style="margin-bottom: 20px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">
 		

 		
	<?php 
		if (isset($parentName)) {
			echo "<h1>" . ucfirst($parentName) . "</h1><hr width='60%'><h3>$student_fullname</h3>";
		}else{
			echo "<h1>$student_fullname</h1>";
		}

	 ?>

	
<div style="margin-bottom: 30px"></div>
	<?php 
	if (isset($_SESSION['parent_account_id'])) {?>
			
			<!-- notification for call parent -->
			<span id="callParent"></span>

	<?php } ?>  
	
	

 	</div> <!-- yellow top -->

 	<hr>
	<?php $this->Main_model->alertSuccess('numberUpdated','Mobile Number Updated') ?>
 	<div class="form-group">
			<?php if (isset($_SESSION['alert_message'])): ?>
				<p class='p-3 mb-2 bg-success text-white' align="center" style="font-size: 25px;">
					<?= $_SESSION['alert_message'] ?>
					<?php unset($_SESSION['alert_message']) ?> 
				</p>		
			<?php endif ?>
		</div>
 	<div style="margin-bottom: 20px"></div>

	

	<div class="row" align="center">
		<div class="col-md-12">
			
			<?php $view_grades = base_url() . 'parent_student/view_grades?academicYear' ?>
			<a href="<?= $view_grades ?>">
				<button class="btn btn-info col-md-12"> <i class="fas fa-graduation-cap" style="color:white;"></i> &nbsp;View Grades</button>
			</a><div style="margin-bottom:5px"></div>
			<?php $view_attendance = base_url() . 'parent_student/view_attendance' ?>
			<a href="<?= $view_attendance ?>">
				<button class="btn btn-dark col-md-12" id="badge"> <i class="fas fa-fingerprint" style="color: white;"></i> &nbsp;View Attendance <i class="badge badge-danger"></i></button>
			</a>
		
<?php
			if (isset($_SESSION['parent_account_id'])) {
			$this->load->model('Main_model');
			//table para sa mga students na anak ng ng naka loged in na user
			$student_table = $this->Main_model->get_where('student_profile','parent_id', $_SESSION['parent_account_id']);
			$studentCount = count($student_table->result_array());
			$childCount = $this->Main_model->checkIfParentHasMoreThanOneChild();
			
			if ($childCount > 1) {
				$student_select = base_url() . 'parent_student/selectStudent';?>
				
					<div style="margin-top:-20px"></div> &nbsp;
					<a href="<?= $student_select ?>">
						<button class="btn btn-primary col-md-12"><i class="fas fa-users"></i> &nbsp; Select Student</button>
					</a><br>
				
			<?php } } ?>
			<div style="margin-bottom:5px"></div>
			<!-- drop down for change parent information -->
			<?php 
				if (isset($_SESSION['parent_account_id'])) {
					$change_password = base_url() . 'parent_student/parentChangePassword';
					$updateMobileNumber = base_url() . "parent_student/parentUpdateMobileNumber";
				}else{
					$change_password = base_url() . 'parent_student/change_password/' . $account_id;
					$updateMobileNumber = base_url() . "parent_student/studentChangeNumber";
				}
			?>

			<?php if (isset($_SESSION['parent_account_id'])) { ?>
				<?php if ($this->Main_model->checkIfFacultyParent() == false) { ?>
					<!-- saka lang siya mag papakita kapag parent lang siya -->
					<div class="dropdown">
						<button class="btn btn-warning dropdown-toggle col-md-12"  type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user"></i>&nbsp; Update Information
						</button>
						<div class="dropdown-menu col-md-12" aria-labelledby="dropdownMenu2">
						<center>
							<a href="<?= $change_password ?>"><button class="dropdown-item" type="button" style="color:green"><i class="fas fa-key"></i>&nbsp; Password</button></a>
							<a href="<?= $updateMobileNumber ?>"><button class="dropdown-item" type="button" style="color:blue"><i class="fas fa-mobile-alt"></i> &nbsp;Mobile Number</button></a>
						</center>
						</div>
					</div>
				<?php } ?>
			<?php }else{ ?>
				<!-- student naman yung naka log in -->
					<div class="dropdown">
						<button class="btn btn-warning dropdown-toggle col-md-12"  type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user"></i>&nbsp; Update Information
						</button>
						<div class="dropdown-menu col-md-12" aria-labelledby="dropdownMenu2">
						<center>
							<a href="<?= $change_password ?>"><button class="dropdown-item" type="button" style="color:green"><i class="fas fa-key"></i>&nbsp; Password</button></a>
							<a href="<?= $updateMobileNumber ?>"><button class="dropdown-item" type="button" style="color:blue"><i class="fas fa-mobile-alt"></i> &nbsp;Mobile Number</button></a>
						</center>
						</div>
					</div>
			<?php } ?>
			<br>
				


		</div> <!-- left -->
	</div> 	
 </div>

 <!-- php badge notificaiton script -->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

 <script>

		function loadDoc() {
			setInterval(function(){

		  var xhttp = new XMLHttpRequest();
		   
		  xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    document.getElementById("badge").innerHTML = this.responseText;
		    }
		  };
		  xhttp.open("GET", "http://localhost/tcshs/parent_student/parentAttendanceNotification", true);
		  xhttp.send();

		  },1000);
		}
		loadDoc();

		var badgeValue = $('#badge').text();
			
			
			

	</script>

	<!-- para naman sa call parent -->
	<script>

	$(document).ready(function(){
		setInterval(function(){
			var badgeValue = $("#callParent").load("http://localhost/tcshs/parent_student/callParentNotification");
		}, 1000);
	});

	</script>