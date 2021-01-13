
<?php

foreach ($principal_id->result_array() as $row) {
	$id = $row['account_id'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$mobileNumber = $row['mobile_number'];
}
 ?>

<?php $this->Main_model->banner('Manage user accounts', 'Change principal'); ?>

<div class="container">
	<form action="" method="post" onsubmit="return checkMobileNumber();">
		<div class="form-group">
				<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
			</div>

			<div class="form-group">
				<label>First Name: </label>
				<input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="First name">
			</div>

			<div class="form-group">
				<label>Middle Name: </label>
				<input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="Middle name">
			</div>

			<div class="form-group">
				<label>Last Name: </label>
				<input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="Last name">
			</div>
			
			<div class="form-group">
				<label>Mobile Number: </label>
				<span class="bg-warning p-1" id="status"></span>
				<input type="number" id="characterCount" name="mobileNumber" class="form-control" autocomplete="off" placeholder="Mobile Number"  autofocus="on">
			</div><br>

			<button type="submit" class="btn btn-primary col-md-12">
				<i class="fas fa-edit"></i>&nbsp;
				Update
			</button>
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