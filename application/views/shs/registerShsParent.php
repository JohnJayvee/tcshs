<div class="container">
	<div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Register Shs Parent</h1>
        <h2><?= $studentFullName ?></h2>
    </center>

        <div class="col-md-12">
           <form action="" onsubmit="return checkMobileNumber();" method="post">

						<!-- notifications -->
		<?php 
			$this->Main_model->alertPromt('Record already exist!', 'same');
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
		<div class="row">
			<div class="col-md-6">
				<?php $back = base_url(). 'shs/registerShsStudent'  ?>
				<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
			</div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-primary col-md-12" value="upload" name="student">PROCEED</button>
			</div>
		</div>
</form>
	<div style="marigin-bottm:40px"></div>&nbsp;
	<?php $parentStudentLink = base_url() . "shs/parentStudentLink"; ?>
	<center><a href="<?= $parentStudentLink ?>">Link the student into existing parent</a></center>
</div>

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


