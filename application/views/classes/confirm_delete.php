<?php 



foreach ($subject_table->result_array() as $row) {
	$subject_id = $row['subject_id'];
	$subject_name = $row['subject_name'];	
}

$yearLevelId = $this->input->get('yearLevelId');
$delete_record = base_url() . 'classes/delete_subject/' . $subject_id . "/1?yearLevelId=$yearLevelId";
$cancel = base_url() . 'classes/add_subject/' . $yearLevelId;


 ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>DELETE SUBJECT</strong><br><br>
 		Are You Sure you want to delete Subject <strong> <?= $subject_name ?> ?</strong>
 		<br><br>
 		<a href="<?= $cancel?>" class="btn btn-secondary">CANCEL</a>
 		&nbsp;
 		<a href="<?= $delete_record ?>" class="btn btn-danger">DELETE</a>
 	</div>

 </div>
