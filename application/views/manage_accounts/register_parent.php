

<div class="container">
        <!-- start code on the left side of the page -->
		<center class="bg-warning p-3">
			<h1>Register Junior highschool</h1>
			<hr width="40%" style="margin: 5px 5px">
			<?php 
				//get the student that is currently being registered
				$currentStudent = $_SESSION['studentInfo'];

				
				//get the full name of the student being registered
				$firstname = ucfirst($currentStudent['firstname']);
				$middlename = ucfirst($currentStudent['middlename']);
				$lastname = ucfirst($currentStudent['lastname']);

				$studentFullname = "$firstname $middlename $lastname";
			?>
			<h2><?= $studentFullname ?></h2>
		</center>
        <div class="col-md-12">
		<?php 
			if (isset($_SESSION['jhsParentDuplicate'])) {
				echo "<script>". "alert('Parent account already existing');" ."</script>";
				unset($_SESSION['jhsParentDuplicate']);
			}
		?>
		<?php $form = base_url() . "manage_user/registerParent?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
    	<form action="<?= $form ?>" method="post" onsubmit="return checkMobileNumber();">
				
		<!-- Validation Errors here -->
		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
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
			<span class="bg-warning p-1" id='status'></span>
			<input id="characterCount" type="number" name="mobileNumber" class="form-control" autocomplete="off" placeholder="Mobile Number">
		</div>
    </div>
        <!-- left code ends here -->

<div class="row">
<?php $back = base_url() . "manage_user/register?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
	<div class="col-md-6"><a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a></div>
	<div class="col-md-6"><button type="submit" class="btn btn-primary col-md-12">Register <i class="fas fa-arrow-right"></i></button>
</div>
	</div>
</form>
<div style="margin-bottom:20px"></div>
 <div align="center">
	<?php $parent_student_link = base_url() . "manage_user/parent_student_link/?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
	<a href="<?= $parent_student_link ?>">
		link the student into existing parent account 
	</a>
</div>

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
	function checkMobileNumber()
	{
		var mobileNumber = $("#characterCount").val().length;
		if (mobileNumber > 11) {
			alert('Mobile number GREATER THAN 11 characters');
			return false;
		}else if(mobileNumber < 11){
			alert('Mobile Number LESS THAN 11 characters');
			return false;
		}else{
			return true;
		}
	}
</script> 

