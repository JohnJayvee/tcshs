<?php
	if (isset($_SESSION['accountCreated'])) {
		echo "<script>alert('You have successfully registered both of the accounts');</script>";
		unset($_SESSION['accountCreated']);
	}
	if (isset($_SESSION['studentDuplicate'])) {
		echo "<script>alert('Student already exists');</script>";
		unset($_SESSION['studentDuplicate']);
	}
?>

<div class="container">
	<div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Register Shs Student</h1>
        <hr width="40" style="margin: 5px 5px">
        <h2><?= $yearLevelName ?> | <?= $strandName ?> | <?= $sectionName ?></h2>
    </center>

        <div class="col-md-12">
           <form action="" onsubmit="return checkMobileNumber();" method="post">
		<!-- notifications -->
		<?php 
			if (isset($_SESSION['same'])) {
				echo "<script>alert('Record already exist!')</script>";
				unset($_SESSION['same']);		
			}

			if (isset($_SESSION['numberInvalid'])) {
				$text = $_SESSION['numberInvalid'];
				echo "<p class='alert alert-warning'>$text</p>";
				unset($_SESSION['numberInvalid']);		
			}
		?>
		
        <div style="margin-bottom:10px"></div>
		<!-- Validation Errors here -->
		<div class="form-group">
			<?= validation_errors("<p class='alert alert-danger'>"); ?>
		</div>
		
		<div class="form-group">
			<label>First Name</label>
			<input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="First name">
		</div>

		<div class="form-group">
			<label>Middle Name</label>
			<input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="Middle Name">
		</div>

		<div class="form-group">
			<label>Last Name</label>
			<input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="Last Name">
		</div>

		<div class="form-group">
			<label>Mobile Number</label> &nbsp;
			<span id="status" class="bg-warning p-1">11</span> 
			<input id="characterCount" type="number" maxlegnth="11" name="mobileNumber" class="form-control" autocomplete="off" placeholder="Mobile Number">
		</div>
      </div>


    
<button type="submit" class="btn btn-primary col-md-12" value="upload" name="student">
	PROCEED
</button>&nbsp;<br>
</form>
</div>
</div> <!-- container ---> 

<script>
    $(document).ready(function(){
        var maxLen = 11;
        var textBox = $('#characterCount');
        var status = $('#status');

        status.text(maxLen + " Characters left");
        
        textBox.keyup(function() {
            var characters = $(this).val().length;

            status.text((maxLen - characters) + " Characters Left");

            if (maxLen < characters) {
                status.css('color', 'red');
            }else{
                status.css('color', 'black');
            }
        });
	});
</script>

<script>
	function checkMobileNumber() {
		var mobileNumber =  $("#characterCount").val().length;
		if (mobileNumber < 11) {
			alert('Mobile number is LESS THAN 11 characters ');
			return false;
		}else if(mobileNumber > 11){
			alert('Mobile number is GREATER THAN 11 chracters');
			return false;
		}else{
			return true;
		}
	}
</script>


