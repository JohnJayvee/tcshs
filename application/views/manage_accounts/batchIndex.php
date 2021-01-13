<div class="container">
<div style="margin-bottom: 40px;"></div>

<h1>Upload an the excel file</h1>
<div style="margin-bottom: 40px;"></div>

<?php $form = base_url() . 'registerBatch' ?>
    <?= validation_errors("<p class='alert alert-warning'>")  ?>
		<form method="post" id="import_form" enctype="multipart/form-data" action="<?= $form ?>">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="excel" required>
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div> <br>&nbsp;
        <input type="submit" name="import" value="Import" class="btn btn-info col-md-12" />
		</form>

</div>
<form>


<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>