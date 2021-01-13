<?php 
	if (isset($_SESSION['gradeExist'])) {
		echo "<script>alert('Grade Already Exists')</script>";
		unset($_SESSION['gradeExist']);
	}

	if (isset($_SESSION['studentNotExist'])) {
		echo "<script>alert('Student: " . $_SESSION['studentNotExist'] ." Does not exist in the system')</script>";
		unset($_SESSION['studentNotExist']);
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>How to Import Excel Data into Mysql in Codeigniter</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/bootstrap.min.css" />
	<script src="<?php echo base_url(); ?>asset/jquery.min.js"></script>
</head>

<body>

	<div class="container">
		<div style="margin-bottom:20px"></div>
		<?php
			$lowerText = "<strong>" .ucfirst($section_name). " | " . ucfirst($grade_level_name) ." | ". ucfirst($subject_name) . " | " . ucfirst($_SESSION['school_year_selection']). "</strong>";
			$this->Main_model->banner("Upload student grades", $lowerText);
		?>

			<div class="table-responsive">
				<table class="table table-bordered"  width="50%" cellspacing="0">
					<thead>
						<tr>
							<th>Quarter</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>First Quarter</td>
							<td>
								<?php $first = base_url() . 'excel_import/view_uploaded_grades?quarter=1&subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
								<a href="<?= $first ?>" class="btn btn-secondary"><i class="fas fa-eye"></i>&nbsp;View</a>
							
								<?php $upload_grade = base_url() . 'excel_import/uploadGrade/1' ?>
								<a href="<?= $upload_grade ?>">
									<button class="btn btn-info">Upload Grade</button>
								</a>
							</td>
							
						</tr>
						<tr>
							<td>Second Quarter</td>
							<td>
								<?php $second = base_url() . 'excel_import/view_uploaded_grades?quarter=2&subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
								<a href="<?= $second ?>" class="btn btn-secondary"><i class="fas fa-eye"></i>&nbsp;View</a>
							
								<?php $upload_grade = base_url() . 'excel_import/uploadGrade/2' ?>
								<a href="<?= $upload_grade ?>">
									<button class="btn btn-info">Upload Grade</button>
								</a>
							</td>
							
						</tr>
						<tr>
							<td>Third Quarter</td>
							<td>
								<?php $third = base_url() . 'excel_import/view_uploaded_grades?quarter=3&subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
								<a href="<?= $third ?>" class="btn btn-secondary"><i class="fas fa-eye"></i>&nbsp;View</a>
							
								<?php $upload_grade = base_url() . 'excel_import/uploadGrade/3' ?>
								<a href="<?= $upload_grade ?>">
									<button class="btn btn-info">Upload Grade</button>
								</a>
							</td>
							
						</tr>
						<tr>
							<?php $fourth = base_url() . 'excel_import/view_uploaded_grades?quarter=4&subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
							<td>Fourth Quarter</td>
							<td>
								<a href="<?= $fourth ?>" class="btn btn-secondary"><i class="fas fa-eye"></i>&nbsp;View</a>
							
								<?php $upload_grade = base_url() . 'excel_import/uploadGrade/4' ?>
								<a href="<?= $upload_grade ?>">
									<button class="btn btn-info">Upload Grade</button>
								</a>
							</td>
							
						</tr>
						<tr>
							<td>Final Quarter</td>
							<td>
								<?php $final = base_url() . 'excel_import/view_uploaded_grades?quarter=5&subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id; ?>
								<a href="<?= $final ?>" class="btn btn-secondary"><i class="fas fa-eye"></i>&nbsp;View</a>
							
								<?php $upload_grade = base_url() . 'excel_import/uploadGrade/5' ?>
								<a href="<?= $upload_grade ?>">
									<button class="btn btn-info">Upload Grade</button>
								</a>
							</td>
							
						</tr>
					</tbody>
				</table>
			</div><br>


		
		
	<?php $back = base_url() . 'excel_import/' ?>
			<a href="<?= $back ?>">
				<button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
			</a>
	</div>
</body>
</html>

<script>
$(document).ready(function(){

	load_data();

	function load_data()
	{
		$.ajax({
			url:"<?php echo base_url(); ?>excel_import/fetch",
			method:"POST",
			success:function(data){
				$('#customer_data').html(data);
			}
		})
	}

	$('#import_form').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url:"<?php echo base_url(); ?>excel_import/import",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				$('#file').val('');
				load_data();
				alert(data);
			}
		})
	});

});
</script>
