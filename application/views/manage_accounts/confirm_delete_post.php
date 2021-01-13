<?php 






foreach ($post_table->result_array() as $row) {
	$post_id = $row['post_id'];
	$post_title = $row['post_title'];
	$post_status = $row['post_status'];
	$post_tags = $row['post_tags'];
	$post_image = $row['post_image'];
	$post_content = $row['post_content'];
	$faculty_id = $row['faculty_id'];
	$post_date = $row['post_date'];
}
$delete_record = base_url() . 'manage_user_accounts/remove/' . $post_id . '/' . 1 ;
$cancel = base_url() . 'Manage_user_accounts/approve_content';
 ?>

 <div class="container" align="center">
 	
 	<div class="alert alert-warning">
 		<strong>DELETE POST</strong><br><br>
 		Are You Sure you want to delete this post <strong> <?= $post_title ?> ?</strong><br>&nbsp;
 		<div class="col-md-6">
 			<?php $image = base_url() . 'cms_uploads/' . $post_image ?>
 			<img src="<?= $image ?>" alt="post image"  class='img-fluid'>
 		</div>
 		<br><br>
 		<a href="<?= $delete_record ?>" class="btn btn-danger">DELETE</a>
 		&nbsp;
 		<a href="<?= $cancel?>" class="btn btn-secondary">CANCEL</a>
 	</div>

 </div>
