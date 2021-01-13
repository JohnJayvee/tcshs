<div style="margin-bottom: 20px;"></div>

<div class="container">
	
	<?php  
        $lowerText = "<strong>" . ucfirst($teacher_fullname) . "</strong> | <strong>" . ucfirst($subject_name) . "</strong>";
        $this->Main_model->banner('View Attendance record', $lowerText);
    ?>
	<div style="margin-bottom: 20px;"></div>
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					
					<th>Date</th>
					<th>Status</th>
					<th>Excuse</th>
				</tr>
			</thead>
			<tbody>
				<!-- jqery already taken care of -->
			</tbody>
		</table>
	</div>
	<div style="margin-bottom: 40px;"></div>
	<?php $back = base_url() . 'parent_student/view_attendance' ?>
	<a href="<?= $back  ?>">
		<button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
	</a>
</div> <!-- container -->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- load the jqery table -->
<script>
	$(document).ready(function(){
		setInterval(function(){
			$('tbody').load("http://localhost/tcshs/parent_student/sendStudentAttendance");
		}, 1000);
	});
</script>