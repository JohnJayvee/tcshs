<div style="margin-bottom: 40px"></div>


<div class="container p-3 m-4 bg-warning">
	<h1>The following data will be removed:</h1>
	<ul style="font-size: 20px;">
		<li>Subject: <strong><?= $subject_name ?></strong></li>
		<li>Section: <strong><?= $section_name ?></strong></li>
		<li>Faculty: <strong><?= $teacher_fullname ?></strong></li>
		<li>Grade Level: <strong><?= $grade_level ?></strong></li>
		<li>Quarter: <?php 
		if ($quarter_level == 1) {
			echo "<strong>First Quarter</strong>";
		}elseif($quarter_level == 2) {
			echo "<strong>Second Quarter</strong>";
		}elseif($quarter_level == 3) {
			echo "<strong>Third Quarter</strong>";
		}elseif($quarter_level == 4) {
			echo "<strong>Fourth Quarter</strong>";
		}elseif($quarter_level == 5) {
			echo "<strong>Final Quarter</strong>";
		}

		 ?></li>
	</ul>
<div style="margin-bottom: 30px"></div>

	<?php 
	$back = base_url() . 'excel_import/view_uploaded_grades?quarter='. $quarter_level . '&subject_id='. $subject_id.'&section_id='. $section_id .'&faculty_id='. $faculty_id .'&grade_level='. $school_year_grade;

	$pull_out = base_url() . 'excel_import/pull_out_early?quarter='. $quarter_level . '&subject_id='. $subject_id.'&section_id='. $section_id .'&faculty_id='. $faculty_id .'&grade_level='. $school_year_grade . '&confirmPullOut=1';

	 ?>

	<a href="<?= $pull_out ?>" class="btn btn-danger col-md-12"><span style="font-size: 20px;font-weight: bold;">Pull Out</span></a><br><br>
	<a href="<?= $back ?>" class="btn btn-info col-md-12"><span style="font-size: 20px;font-weight: bold;">Cancel</span></a>
</div>