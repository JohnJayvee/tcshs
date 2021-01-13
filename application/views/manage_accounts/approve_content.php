<?php
$view = base_url() . 'manage_user_accounts/content_view/';

//notifications
$this->Main_model->alertPromt('Post Approved', 'postActivated');
$this->Main_model->alertPromt('Post Approved', 'postDeactivated');
?>



<div class="container">
	
	<?php $this->Main_model->banner("Content management system", $principalName); ?>

<div style="margin-bottom:-10px"></div>

<?php if (count($disapproveTable->result_array()) != 0) { ?>
	<button class='btn btn-dark col-md-12' id='pendingButton'><span style="font-size:20px">Pending list</span>&nbsp; <span class='badge badge-danger' id="postCount"></span></button>
<?php } ?>


<div style="margin-bottom:5px"></div>
<div class="col-md-12 p-4 bg-dark" id="dropDownList">
	<div class="row">
		<table class="table table-striped">
			<tbody>
			<?php foreach ($disapproveTable->result() as $row) { ?>
				<tr>
					<td>
						<span style="color:white;font-size:30px"><?= ucfirst($row->post_title) ?></span>
					</td>
					<?php
						$approveUrl = base_url() . "manage_user_accounts/post_activate/$row->post_id";
						$view = base_url() . "manage_user_accounts/content_view/$row->post_id";
					?>
					<td>
						<a href="<?= $approveUrl ?>"><button class="btn btn-success"><i class="fas fa-check"></i> Approve</button></a>
						&nbsp;
						<a href="<?= $view ?>"><button class="btn btn-light"><fas class="fas fa-eye"></fas> View</button></a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" >
			<thead>
				<tr>
					<th>Title</th>
					<th>Uploaded by</th>
					<th>Status</th>
					<th>Options</th>
				</tr>
			</thead>
<tbody>

	<?php 

		foreach ($post_table->result_array() as $row) {
			$post_id = $row['post_id'];
			$post_title = $row['post_title'];
			$post_status = $row['post_status'];
			$faculty_id = $row['faculty_id'];
			$post_title = $row['post_title'];
			$post_status = $row['post_status'];
			$post_tags = $row['post_tags'];
			$post_image = $row['post_image'];
			$post_content = $row['post_content'];
			$post_date = $row['post_date'];	 
		

	?>



	<tr>
			<td><?= $post_title ?></td>

			<td><?= $this->Main_model->facultyRepository($faculty_id) ?></td>
			<td>
				<?php 
					if ($post_status == 0) {
						echo "<i class='fas fa-times'></i>";
					}else{
						echo "<i class='fas fa-check'></i>";
					}
				 ?>
			</td>
			
			<?php 
				$view = base_url() . "manage_user_accounts/content_view/$post_id";
				$activate = base_url() . "manage_user_accounts/post_activate/$post_id";
				$deactivate = base_url() . "manage_user_accounts/post_deactivate/$post_id";
			 ?>
			<td>

				<a href="<?= $view ?>">
					<button class="btn btn-primary col-md-12">
						<i class="fas fa-eye"></i>
						View
					</button>
				</a>
				<div style="margin-bottom:10px"></div>
				 
				<?php if ($post_status == 0) { ?>
						<!-- //deactivated -->
						<a href="<?= $activate ?>">
							<button class="btn btn-success col-md-12">
								<i class="fas fa-check"></i>
								Approve
							</button>
						</a>
				<?php }else{ ?>
						<!-- //activated -->
						<a href="<?= $deactivate ?>">
							<button class="btn btn-danger col-md-12">
								<i class="fas fa-times"></i>
								Disapprove
							</button>
						</a>
				<?php } ?>
		</td>
	</tr>
	<?php } ?>
				</tbody>
			</table>
			</div>
	</div>
</div>

<?php $pendingUrl = base_url() . "manage_user_accounts/pendingRequestPosts" ?>
<script>
	$(document).ready(function(){
		$("#dropDownList").hide();
		
		$("#pendingButton").click(function(){
			$("#dropDownList").fadeToggle('slow');
		});
		setInterval(function(){
			$.post("<?= $pendingUrl ?>", {getPendingPost: 1}, function(data){
				$("#postCount").html(data);
			});
		});
	});
</script>


