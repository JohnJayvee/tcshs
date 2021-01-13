<?php
if (isset($_SESSION['gradeExist'])) {
	redirect('excel_import/upload_view');
}

?>


<div style="margin-bottom: 20px"></div>
<div class="container">

	
	<?php $this->Main_model->banner("Batch account registration", ucfirst($yearLevelName) . " | " . ucfirst($sectionName)) ?>
	


	<div class="col-md-12 p-4 bg-info">
		<?php $form = base_url() . "RegisterBatch/createAccount" ?>
		<form action="<?= $form ?>" method="post" id="import_form" enctype="multipart/form-data">
			<label style="font-size:30px;font-weight:bold;">Enter Excel File</label><br>

			<?php
			$this->load->model('Main_model');
			$this->Main_model->alertDanger('duplicateDataBatch', "The Data in the excel file has duplicates at the system's database");
			?>
			<div class="custom-file">
				<input type="file" class="custom-file-input" id="customFile" name="file" required accept=".xls, .xlsx">
				<label class="custom-file-label" for="customFile">Choose file</label>
			</div>
			<input type="hidden" name="yearLevelId" value="<?= $yearLevelId ?>">
			<input type="hidden" name="sectionId" value="<?= $sectionId ?>">
			<br /><br>
			<input type="submit" name="import" value="Import" class="btn btn-dark col-md-12" />
		</form>
	</div>
</div>
<script>
	// Add the following code if you want the name of the file appear on select
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>