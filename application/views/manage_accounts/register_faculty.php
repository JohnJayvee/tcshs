<?php $form_url = base_url() . 'Manage_user_accounts/register_faculty/' .  $academicGradeId ?>
<?php
if (isset($_SESSION['facultyDouble'])) {
	echo "<script>";
	echo "alert('Faculty Member already exists!')";
	echo "</script>";
	unset($_SESSION['facultyDouble']);
}
?>

<div class="container">
	<div style="margin-bottom:20px"></div>

	<form action="<?= $form_url ?>" method="post" onsubmit="return checkMobileNumber();">
		<center class="bg-warning p-3">
			<h1>Faculty Register</h1>
			<hr width="50%" style="margin-top:5px;margin-bottom:5px;">
			<h3><?= $academic_name ?></h3>
		</center>

		<div class="form-group">
			<div style="margin-top:10px"></div>
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>

		<div class="form-group">
			<?php
			$this->load->model('Main_model');
			$this->Main_model->alertSuccess('facultyCreated', 'Faculty account Created');
			?>
		</div>

		<div class="form-group">
			<label>First Name: </label>
			<input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="Firstname" autofocus="on">
		</div>

		<div class="form-group">
			<label>Middle Name: </label>
			<input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="Middle Name"  autofocus="on">
		</div>

		<div class="form-group">
			<label>Last Name: </label>
			<input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="Last Name"  autofocus="on">
		</div>

		<div class="form-group">
			<label>Mobile Number: </label>
			<span class="bg-warning p-1" id="status"></span>
			<input type="number" id="characterCount" name="mobileNumber" class="form-control" autocomplete="off" placeholder="Mobile Number"  autofocus="on">
		</div><br>
		
		<div class="row">
			<div class="col-md-6">
				<?php 
					//$cancel = base_url() . 'manage_user_accounts/secManageAccount' ito yung with shs
					$cancel = base_url() . 'manage_user_accounts/viewSeniorHighSchoolFaculty';
				?>

				<a href="<?= $cancel ?>">
					<button class="btn btn-secondary col-md-12" type="button">
					<i class="fas fa-arrow-left"></i>
						&nbsp; Back
					</button>
				</a>
			</div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-primary col-md-12">
				<i class="fas fa-check"></i>
					&nbsp; Register
				</button>
			</div>
		</div> <!-- row end -->
	</form>
</div>

<!-- for the mobile number length checker -->
<script>
	$(document).ready(function() {
		var maxLen = 11;
		var textBox = $('#characterCount');
		var status = $('#status');

		status.text(maxLen + " Characters left");

		textBox.keyup(function() {
			var characters = $(this).val().length;

			status.text((maxLen - characters) + " Characters Left");

			if (maxLen < characters) {
				status.css('color', 'red');
			} else {
				status.css('color', 'black');
			}
		});
	});
</script>

<!-- mobile number validation -->
<script>
	function checkMobileNumber() {
		var mobileNumber = $("#characterCount").val().length;
		if (mobileNumber < 11) {
			alert('Mobile number is LESS THAN 11 characters ');
			return false;
		} else if (mobileNumber > 11) {
			alert('Mobile number is GREATER THAN 11 chracters');
			return false;
		} else {
			return true;
		}
	}
</script>