<div style="margin-bottom:20px"></div>


	<center class="bg-warning p-3">
		<h1>Content Management System</h1>
		<hr width="50%" style="margin: 5px 5px">
		<h2>Update your content</h2>
	</center>

<div class="container">
	<div class="row">
		<div class="col-md-6">
        <?= validation_errors("<p class='alert alert-danger'>") ?>
			<?php echo form_open_multipart('main_controller/jhsEditContent/' . $postId);?>
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
						<input type="file" value="<?= $postTable[0]['post_image'] ?>" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="userfile">
						<label class="custom-file-label"><?= $postTable[0]['post_image'] ?></label>
				</div>
			</div><div style="margin-bottom:-5px"></div> &nbsp;

			<div class="form-group">
				<label>Title:</label>
				<input type="text" name="post_title" class="form-control" autocomplete="off" value="<?= $postTable[0]['post_title'] ?>" placeholder="Enter Post Title">
			</div>
			<div class="form-group">
				<label>Tags:</label>
				<select name="post_tags" class="form-control">
                <option value="<?= $postTable[0]['post_tags'] ?>"><?= $this->Main_model->maskTags($postTable[0]['post_tags']) ?></option>
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
			<textarea class="form-control z-depth-1" name="post_content" rows="3" placeholder="Enter Content Here"><?= $postTable[0]['post_content'] ?></textarea>
			</div>

			<div class="form-group">
				<label>Date:</label>
				<input type="date" name="post_date" class="form-control" autocomplete="off" placeholder="Enter Date" value="<?= $postTable[0]['post_date'] ?>">
			</div>

			



			<button type="submit" class="btn btn-primary col-md-12" value="upload">
			<i class="fas fa-sync"></i> &nbsp; Update
			</button>
		<?php echo form_close() ?>
		</div> 
		<!-- right end -->
		<div class="col-md-6">
			<div class="p-2 m-4 bg-info">
				<div class="table table-responsive">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th>Image preview</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="show-image" align="center">
                                <?php $src = base_url() . "cms_uploads/" . $postTable[0]['post_image'] ?>
                                    <img src="<?= $src ?>"style="width:100%" height="400" alt="Avatar" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
    <div style="margin-bottom:20px"></div>
    <?php $back = base_url() . "main_controller/manage_content" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
<?php $url = base_url() . "main_controller/fileAsynchronous" ?>
<!-- for the image to show up asynchronous -->
<script>
	$("#inputGroupFile01").change(function(){
		var data = new FormData();
		data.append('file', $('#inputGroupFile01')[0].files[0]);
		$.ajax({
			url: "<?= $url ?>",
			type: 'POST', 
			data: data, 
			processData: false,
			contentType: false, 
			beforeSend: function(){
				$('#show-image').html('Loading...');
			},
			success: function(data){
				//alert(data);
				var src = "<?= base_url() ?>" + "temp_upload/" + data;
				$('#show-image').html('<img src="' + src + '"style="width:100%" height="400" alt="Avatar" />');
			}
		})
	});
</script>

