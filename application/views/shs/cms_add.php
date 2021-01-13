<div style="margin-bottom:20px"></div>

	<center class="bg-warning p-3">
		<h1>Content Management System</h1>
		<hr width="50%" style="margin: 5px 5px">
		<h2>Upload content to your website</h2>
	</center>

<div class="container">
	<?php echo form_open_multipart('shs/do_upload');?>
		<!-- header title -->

		<!-- Validation Errors here -->
		<div class="form-group">
			<?php echo validation_errors("<p class='alert alert-danger'>"); ?>
		</div>
		
		<label>Upload Image:</label>
		<div class="form-group">
			<?php echo $error;?>
		</div>
		<div class="custom-file">
			<div class="custom-file">
					<input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="userfile">
					<label class="custom-file-label"></label>
			</div>
		</div>&nbsp;

		<div class="form-group">
			<label>Title:</label>
			<input type="text" name="post_title" class="form-control" autocomplete="off" placeholder="Enter Post Title">
		</div>
		<div class="form-group">
			<label>Tags:</label>
			<select name="post_tags" class="form-control">
		<?php 

            foreach ($tags->result_array() as $row) {
            	$tag_name = $row['tag_name'];
            	$id = $row['id'];?>

					<option value="<?= $id ?>"><?= $tag_name ?></option>

            <?php } ?>
            	</select>
            </div>

		<div class="form-group shadow-textarea">
		  <label>Content</label>
		  <textarea class="form-control z-depth-1" name="post_content" rows="3" placeholder="Enter Content Here"></textarea>
		</div>

		<div class="form-group">
			<label>Date:</label>
			<input type="date" name="post_date" class="form-control" autocomplete="off" placeholder="Enter Date">
		</div>

		



		<button type="submit" class="btn btn-primary col-md-12" value="upload">
		<i class="fas fa-upload"></i> &nbsp; Upload
		</button>
	<?php echo form_close() ?>
</div>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

