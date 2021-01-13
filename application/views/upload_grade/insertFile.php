
<?php 
	if (isset($_SESSION['gradeExist'])) {
		redirect('excel_import/upload_view');
	}

 ?>


<div style="margin-bottom: 40px"></div>
<div class="container">
	
	<div class="bg-success p-3 m-3">
		<h1 align="center">Upload Excel file here</h1><hr><?php
		$subject_selection = $_SESSION['subject_selection'];
		if ($_SESSION['quarter_selection'] == 1) {
			echo "<h3 align='center'>First Quarter : $subject_name : $section_name</h3>";
		}elseif($_SESSION['quarter_selection'] == 2) {
			echo "<h3 align='center'>Second Quarter : $subject_name : $section_name</h3>";
		}elseif($_SESSION['quarter_selection'] == 3) {
			echo "<h3 align='center'>Third Quarter : $subject_name : $section_name</h3>";
		}elseif($_SESSION['quarter_selection'] == 4) {
			echo "<h3 align='center'>fourth Quarter : $subject_name : $section_name</h3>";
		}elseif($_SESSION['quarter_selection'] == 5) {
			echo "<h3 align='center'>Final Quarter : $subject_name : $section_name</h3>";
		}
		 ?><br><br>
			<?php $form = base_url() . 'excel_import/import' ?>
		<form method="post" id="import_form" enctype="multipart/form-data" action="<?= $form ?>">
			<div class="custom-file">
				<input type="file" name="file" class="custom-file-input" id="customFile" required accept=".xls, .xlsx">
				<label class="custom-file-label" for="customFile">Choose file</label>
			</div><div style="margin-bottom:10px"></div>&nbsp;
			<input type="submit" name="import" value="Import" class="btn btn-info col-md-12" />
		</form>
	</div>
	<?php $back = base_url() . 'excel_import/upload_view' ?>
	<a href="<?= $back ?>">
		<button class="btn btn-secondary col-md-12">Back</button>
	</a>
</div>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>