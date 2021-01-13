

<div style="margin-bottom: 20px;"></div>

<div class="container">
	<?php $this->Main_model->banner("Class attendance", "Enter the excuse of the student");?>

	<?php $form = base_url() . 'attendance_monitoring/excuse_student/' . $class_id . '/' . $date_of_absent; ?>
		<form action="<?= $form ?>" method="post">
			<div class="form-group">
				<textarea class="form-control" rows="3" style="width:100%; height:30%" name="text_box" placeholder="Enter <?= $student_fullname?>'s reason"></textarea>
			</div>
			
			<?php $back = base_url() . "Attendance_monitoring/perform_excuse/$class_id"?>
			<div class="row">
				<div class="col-md-6">
					<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i> &nbsp;Back</button></a>
				</div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary col-md-12"><i class="fas fa-check"></i> &nbsp;Submit</button>
				</div>
			</div>	 
			<input type="hidden" name="class_id" value="<?= $class_id ?>">
		</form>
</div>