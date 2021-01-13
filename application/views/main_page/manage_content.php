<div class="container">
	<div style="margin-bottom:20px"></div>
	
	<?php $this->Main_model->banner("Content management system", "Manage own content | $facultyName"); ?>

<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>	
					<th> Title </th>
					<th> Date </th>
					<th> Status</th>
					<th> OPTIONS </th>
				</tr>
			</thead>

	

<tbody>

<?php 

	foreach ($my_post->result_array() as $row) {
		$post_id = $row['post_id'];
		$post_title = $row['post_title'];
		$post_date = $row['post_date'];
		$post_status = $row['post_status'];
		$post_image = $row['post_image']?>

		<tr>
			<td>
				<?= $post_title ?>
			</td>

			<td>
				<?= $post_date ?>
			</td>
			<td>
				

				<?php $check = base_url() . 'assets/images/cross.jpg';
						$cross = base_url() . 'assets/images/check.jpg';
					if ($post_status == 0) {?>
						<img src="<?= $check ?>" alt="Active" width='50' height='50'>
					<?php }elseif($post_status == 1){?>
						<img src="<?= $cross ?>" alt="Inactive" width='50' height='50'>
					<?php } ?> 
				
			</td>

			<td align="center">
				<?php $view = base_url() . 'main_controller/content_view/' . $post_id ?>
				<a href="<?= $view ?>">
					<button class="btn btn-primary col-md-3 col-sm-4">
					<i class="fas fa-eye"></i>&nbsp;
						View
					</button>
				</a>
				<?php $edit = base_url() . "main_controller/jhsEditContent/" . $post_id ?>
				<a href="<?= $edit ?>">
					<button class="btn btn-secondary col-md-3 col-sm-4">
					<i class="fas fa-edit"></i>&nbsp;
						Edit
					</button>
				</a>
				<?php $post_delete = base_url() .  'main_controller/delete_post/' . $post_id . '/0' ?>
				<a href="<?= $post_delete ?>">
					<button class="btn btn-danger col-md-3 col-sm-4">
					<i class="fas fa-trash"></i>&nbsp;
						Delete
					</button>
				</a>
			</td>
		</tr>

		


	<?php } ?>
	
	

	



 
	


	
</tbody>
</table>
</div>
