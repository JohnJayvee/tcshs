<?php 






if ($classify == 1) {
	$name = 'Student Record';

	foreach ($account_name->result_array() as $row) {
	$account_id = $row['account_id'];
	$firstname =$row['firstname'];
	$middlename =$row['middlename'];
	$lastname =$row['lastname'];
}
}elseif ($classify == 2) {
	$name = 'Parent Record';

	foreach ($account_name->result_array() as $row) {
	$account_id = $row['account_id'];
	$firstname =$row['firstname'];
	$middlename =$row['middlename'];
	$lastname =$row['lastname'];
	
}
}

 ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>DELETE RECORD</strong><br><br>
 		Are You Sure you want to delete <strong><?= $name ?></strong>  <strong> <?= strtoupper($firstname) .' '. strtoupper($middlename) .' '. strtoupper($lastname) ?> ?</strong>
 		<br><br>

 		<?php 
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');
 			
 			if ($classify == 1) {
 				$back = base_url() . "manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId";
 				$delete = base_url() . 'manage_user/delete/' . $classify . '/' . $account_id . "?yearLevelId=$yearLevelId&sectionId=$sectionId";
 			}elseif ($classify == 2) {
				 $back = base_url() . "manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId";
 				$delete = base_url() . 'manage_user/delete/' . $classify . '/' . $account_id . "?yearLevelId=$yearLevelId&sectionId=$sectionId";
 			}


 		 ?>
 		
 	
 		<a href="<?= $back ?>" class="btn btn-secondary">CANCEL</a>	&nbsp;
		 <a href="<?= $delete ?>" class="btn btn-danger">DELETE</a>
 	</div>

 </div>
