<?php 



foreach ($section_table->result_array() as $row) {
	$section_id = $row['section_id'];
	$section_name = $row['section_name'];	
}

$putangInaMo = base_url() . 'classes/delete_section/' . $section_id . '/1?yearLevel=' . $_GET['yearLevel'];
$cancel = base_url() . 'classes/add_section/' . $_GET['yearLevel'];


 ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>DELETE SECTION</strong><br><br>
 		Are You Sure you want to delete The Section <strong> <?= $section_name ?> ?</strong>
 		<br><br>
 		<a href="<?= $cancel?>" class="btn btn-secondary">CANCEL</a>
 		&nbsp;
 		<a href="<?= $putangInaMo ?>" class="btn btn-danger">DELETE</a>
 	</div>

 </div>
