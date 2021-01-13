<?php
$view = base_url() . 'manage_user_accounts/content_view/';
 ?>



<div class="container col-md-12">
	
<div class="card-body">
	
	<br>&nbsp;

	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

		$this->load->model('Main_model');
		$faculty_name = $this->Main_model->get_where('faculty','account_id', $faculty_id);

		

		foreach ($faculty_name->result_array() as $row) {
			$account_id = $row['account_id'];
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];	 
		}

		$this->load->model('Main_model');
		$result = $this->Main_model->get_where('post','post_id', $post_id);

		

		foreach ($result->result_array() as $row) {
			$result_id = $row['post_id'];
			$post_title = $row['post_title'];
			$post_status = $row['post_status'];
			$post_tags = $row['post_tags'];
			$post_image = $row['post_image'];
			$post_content = $row['post_content'];
			$faculty_id = $row['faculty_id'];
			$post_date = $row['post_date'];
		}

		

	?>



	<tr>
			<td><?= $post_title ?></td>

			<td><?= $firstname . ' ' . $middlename .  ' ' . $lastname ?></td>
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
			$view = base_url() . 'manage_user_accounts/content_view';

			 ?>
			<td>
				<a href="<?= $view .'/'. $result_id ?>">
					<button class="btn btn-primary">
						<i class="fas fa-edit"></i>
						View
					</button>
				</a>
				&nbsp;
				<?php $activate = base_url() . 'manage_user_accounts/post_activate/' . $result_id; ?>
				<a href="<?= $activate ?>">
					<button class="btn btn-success">
						<i class="fas fa-check"></i>
						Approve
					</button>
				</a>&nbsp;
				<?php $deactivate = base_url() . 'manage_user_accounts/post_deactivate/' . $result_id; ?>
				<a href="<?= $deactivate ?>">
					<button class="btn btn-danger">
						<i class="fas fa-times"></i>
						Disapprove
					</button>
				</a>
			</td>
	</tr>
	<?php } ?>
				</tbody>
			</table><br>

			<?php 
			$approved_content = base_url() . 'manage_user_accounts/approved_content';
			$disapproved_content = base_url() . 'manage_user_accounts/disapproved_content';
			$back = base_url() . 'manage_user_accounts/approve_content';
			 ?>
			<a href="<?= $approved_content ?>">
				<button class="btn btn-primary col-md-12">Approved Content </button>
			</a><div style="margin-bottom: -10px;"></div>&nbsp;
			<a href="<?= $disapproved_content ?>">
				<button class="btn btn-secondary col-md-12">Disapproved Content</button>
			</a><div style="margin-bottom: -10px;"></div>&nbsp;
			<a href="<?= $back ?>">
				<button class="btn btn-info col-md-12">Back</button>
			</a>

		</div>
	</div>
</div>


