<div style="margin-bottom: 40px;"></div>

<div class="container">
	<center class="col-md-12 p-3 bg-warning">
		<h1>Parent respond</h1>
	</center>

	<?php
	if (isset($_SESSION['parentResponded'])) {
		echo "<p class='alert alert-success' align='center'>Thank you for responding</p>";
		unset($_SESSION['parentResponded']);
	}
	?>


	<div style="margin-bottom: 40px;"></div>
	<?php $form = base_url() . 'manage_user/parentEdit/' ?>

	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Teacher name</th>
					<th>Mobile number</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$this->load->model('Main_model');
				foreach ($callParentTable as $row) {
					$callParentId = $row['call_parent_id'];
					$facultyId = $row['faculty_id'];
					$studentProfileId = $row['student_profile_id'];
					$schoolYear = $row['school_year'];
					$respondStatus  = $row['respond_status'];
					$teacherNumber = $this->Main_model->facultyMobileNumberRepositoryManager($facultyId); ?>

					<tr>
						<td>
							<?php echo $this->Main_model->facultyRepository($facultyId); ?>
						</td>
						<td>
							<input type="text" value="<?= $teacherNumber ?>" readonly="readonly" id="myInput" class="form-control">
						</td>
						<td>
							<?php $respond = base_url() . 'parent_student/callParentRespond?callParentId=' . $callParentId; ?>

							<button class="btn btn-primary col-md-12" onclick="myFunction()"><i class="fas fa-clipboard-list"></i> &nbsp; Copy number</button>

						</td>
					</tr>

				<?php } ?>
			</tbody>
		</table>
	</div><br>
	<?php $back = base_url() . "parent_student/student_page" ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i> &nbsp; Back</button></a>
</div> <!-- container -->

<script>
	function myFunction() {
		/* Get the text field */
		var copyText = document.getElementById("myInput");

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy");

		/* Alert the copied text */
		alert("Copied the text: " + copyText.value + " you may now paste it into your phone contacts");
	}
</script>