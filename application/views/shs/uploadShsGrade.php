<div class="container">
    <?php $this->Main_model->banner("Upload grades", "$sectionName | $subjectName | $semesterName") ?>
    <div style="margin-bottom:-10px"></div>
    <div class="bg-success p-3">
		<h1 align="center">Upload Excel file here</h1><hr><br><br>
			<?php $form = base_url() . "shs/importStudentGrades/$semester" ?>
		<form method="post" id="import_form" enctype="multipart/form-data" action="<?= $form ?>">
			<div class="custom-file">
				<input type="file" name="file" class="custom-file-input" id="customFile" required accept=".xls, .xlsx">
				<label class="custom-file-label" for="customFile">Choose file</label>
			</div><div style="margin-bottom:10px"></div>&nbsp;
			<input type="submit" name="import" value="Import" class="btn btn-info col-md-12" />
		</form>
	</div> <!-- green box -->
    <div style="margin-bottom:20px"></div>
    <?php $back = base_url() . "shs/selectQuarter?sectionId=$sectionId&subjectId=$subjectId&semester=$semester" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>