


<div style="margin-bottom: 40px"></div>
<div class="container">

	<div class="bg-warning p-3 m-3">
		<h1 align="center">Batch Account Registration</h1>
		<hr>
		<h2 align="center"><?= ucfirst($yearLevelName) ?> | <?= ucfirst($sectionName) ?></h2>
		<div style="margin-bottom:20px"></div>



		<?php $form = base_url() . "shs/createAccount" ?>
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

            <input type="hidden" name="strandId" value="<?= $strandId ?>">
            <input type="hidden" name="trackId" value="<?= $trackId ?>">
			<br /><br>
			<input type="submit" name="import" value="Import" class="btn btn-info col-md-12" />
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