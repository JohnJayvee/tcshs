<?php 


foreach ($class_table->result_array() as $row) {
	$class_id = $row['class_id'];
	$student_profile_id = $row['student_profile_id'];
	$subject_id = $row['subject_id'];
	$faculty_id = $row['faculty_id'];	
}





$query = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);

foreach ($query->result_array() as $row) {
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
}
$student_full_name = "$firstname $middlename $lastname";

$query = $this->Main_model->get_where('subject','subject_id', $subject_id);
foreach ($query->result_array() as $row) {
	$subject_name = $row['subject_name'];
}

$query = $this->Main_model->get_where('faculty','account_id', $faculty_id);
foreach ($query->result_array() as $row) {
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
}
$faculty_full_name = "$firstname $middlename $lastname";


$delete_record = base_url() . 'classes/delete_class/' . $class_id . '/' . 1;
$cancel = base_url() . 'classes/manage_classes/';

 ?>

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>Remove Student</strong><br><br>
 		<p>Are You Sure you want to remove <strong><?= ucfirst($student_full_name) . ' ' ?></strong>From the <strong><?= ucfirst($subject_name) ?></strong> class of <strong><?= ucfirst($faculty_full_name) ?>?</strong></p>
 		<br><br>
 		<a href="<?= $delete_record ?>" class="btn btn-danger">DELETE</a>
 		&nbsp;
 		<a href="<?= $cancel?>" class="btn btn-secondary">CANCEL</a>
 	</div>

 </div> 
