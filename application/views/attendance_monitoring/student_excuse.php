
<body>
	 <h1>Excuse a Student</h1>
	 <h2>Name: <?= ucfirst($fullname) ?></h2>
	 <div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Date of Absent</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
						<?php 

			foreach ($absences_table->result_array() as $row) {
				$attendance_id = $row['attendance_id'];
				$class_id = $row['class_id'];
				$date = $row['date'];?>
					<tr>
						<td>
							<?= $date ?>
						</td>
						<td>
							<?php $excuse = base_url() . 'attendance_monitoring/student_excuse/' . $class_id . '/' . 1 . '/' . $attendance_id ?>
							<a href="<?= $excuse ?>">
								<button class="btn btn-success col-md-6">Excuse</button>
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table><br><br>
<?php $back = base_url() . 'attendance_monitoring/class_selection' ?>
		<a href="<?= $back ?>">
			<button class="btn btn-primary col-md-12">Back</button>
		</a>
</body>
</html>