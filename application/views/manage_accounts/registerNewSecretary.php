
<div class="container">

    <?php $this->Main_model->banner('Manage user accounts', 'Register new secretary'); ?>

	<form action="" method="post" onsubmit="return checkMobileNumber();">
		<div class="form-group">
				<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
			</div>

			<div class="form-group">
				<label>First Name: </label>
				<input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="Enter first name">
			</div>

			<div class="form-group">
				<label>Middle Name: </label>
				<input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="Enter middle name">
			</div>

			<div class="form-group">
				<label>Last Name: </label>
				<input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="Enter last name">
			</div>
			
			<div class="form-group">
				<label>Mobile Number: </label>
				<span class="bg-warning p-1" id="status"></span>
				<input type="number" id="characterCount" name="mobileNumber" class="form-control" autocomplete="off" placeholder="Mobile Number"  autofocus="on">
			</div>
			<!-- will not show if previous secretary is not a teacher -->
			<?php 
			if (isset($_SESSION['secretaryTeacher'])) {
				//secretary teacher
				$previeousSecText = "will still be a teacher";
			}else{
				//secretary
				$previeousSecText = "will be a teacher";
			}?>
			
				
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<input type="checkbox" name="teacherConfirm" id="" class="m-1">
						<label style="margin-left:10px;font-size:20px"><b>Previous secretary</b> <?= $previeousSecText ?></label>
					</div>
					<div class="col-md-6">
						<input type="checkbox" name="newSecConfirm" id="" class="m-1">
						<label style="margin-left:10px;font-size:20px"><b>New secretary</b> will be a teacher</label>
					</div>
				</div>
			</div>

			<br>

            <?php $back = base_url() . "manage_user_accounts/assignSecretary" ?>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary col-md-12">
                        <i class="fas fa-edit"></i>&nbsp;
                        Update
                    </button>
                </div>
            </div>
			
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