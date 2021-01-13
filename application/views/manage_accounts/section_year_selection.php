

<?php $form_url = base_url() . 'manage_user_accounts/update_grade_class' ?>


<!-- Validation Errors here -->
		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>


<form action="<?= $form_url ?>" method="post">
		<!-- header title -->
		<div style="margin-bottom:20px"></div>
		<?php $this->Main_model->banner("Manage student academic year", "Select section"); ?>
		<div style="margin-bottom:20px"></div>
		<!-- notifications -->
		<?php $this->Main_model->alertSuccess('allHavePassed', 'All of the students in the section have passed the school year'); ?>
	<div class="form-group">
		<label>Year level:</label>
		<select name="grade" class="form-control" id="grades" required>
			<option value="">Select Grade level</option>
			<?php 
			foreach ($school_grade_table->result_array() as $row) {
			 	$school_grade_id = $row['school_grade_id'];
				$name = $row['name'];
				if ($row['academic_grade_id'] == 2) {
					continue;
				} 
				 ?>
				<option value="<?= $school_grade_id ?>"><?= $name ?></option>

			<?php } ?>	 

			 
		</select>
	</div>
		

	<div class="form-group">
		<label>Section:</label>
		<select name="section" class="form-control" id="section" required>
			<option>Select Section</option>	
		</select>
	</div>

		<br>

		<button type="submit" class="btn btn-primary col-md-12">
			Proceed
		</button>
		
	</form>
	<div style="margin-bottom: 40px;"></div>


	<?php 
	if (isset($_SESSION['empty'])) {
		echo "<div align='center'>";
		echo $_SESSION['empty'];
		echo "</div>";

		unset($_SESSION['empty']);

	}
	 ?>

<!-- scripts for the dynamic drop down -->
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<!-- getting the values of the grade select -->
<script>
	$(document).ready(function(){
		$("#grades").change(function(){
			var grades = $("#grades").val();
			var url = "http://localhost/tcshs/manage_user_accounts/getGradeAndHaveSection";
			$.post(url, {
				yearLevelId: grades
			}, function(data){
				//yung data yun yung galing sa i eecho mo sa post mo
				$("#section").html(data);
			});
		});

		//notification disapear
		

		setTimeout(function(){
			$("#disappear").fadeOut(3000);
		}, 12000);
	});
</script>