
<?php
	if (isset($_SESSION['noSelection'])) {
		echo "<script>alert('Please select students to transfer');</script>";
		unset($_SESSION['noSelection']);
	}
?>
<div style="margin-bottom: 40px;"></div>


<div class="container">
	
	<?php $this->Main_model->banner("Student sectioning", "Select a student you want to move"); ?>
	<div style="margin-bottom:20px"></div>
	<?php $add_students = base_url() . 'classes/add_student_section/' . $sectionId ?>
	<?php $form =  base_url() . 'classes/studentMoveSection?yearLevelId=' . $yearLevelId?>
	<form action="<?= $form ?>" method="post">
	<div class="bg-primary p-4">
	<span style="font-size: 30px;font-weight:bold;">Move to section: </span>
		<div class="form-group">
			<select name="moveSection" id="section" class="form-control" required><!-- D                    VCROPDOWN -->
				<option value="<?= $sectionId ?>"><?= ucfirst($sectionName) ?> (Current section)</option>
				<!-- load the other sections correlated to the yearlevel -->
				<?php
					foreach ($sectionTableDropDown->result() as $row) {
						echo "<option value=" . $row->section_id . "> " . $row->section_name ." </option>";
					}
				?>
			</select>
		</div>
	</div>
	
	<div style="margin-bottom: 40px"></div>
	
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Student Name</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
			
			
				<?php 
				foreach ($class_section_table->result_array() as $row) {
					$class_section_id = $row['class_section_id'];
					$student_profile_id = $row['student_profile_id'];?>
				
				 
				<tr>
					<td>
						<?= $this->Main_model->getFullname('student_profile', 'account_id', $student_profile_id); ?>
					</td>
					<td>
						<input type="checkbox" name="students[]" value="<?= $student_profile_id ?>">
					</td>
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div><br>
		<input type="hidden" name="yearLevelId" value="<?= $yearLevelId ?>">
		<input type="hidden" name="getSection" value="<?= $sectionId ?>">
		<div class="row">
			<div class="col-md-6">
			<?php $back = base_url() . "classes/add_section?yearLevelId=$yearLevelId" ?>
				<a href="<?= $back ?>">
					<button type="button" class="btn btn-secondary col-md-12">Back</button>
				</a>
			</div>
			<div class="col-md-6">
			<button type="submit" name="submit" class="btn btn-primary col-md-12">Move &nbsp; <i class="fas fa-truck-moving"></i></button>			
			</div>
		</div>
	</form> 
	<div style="margin-bottom:5px"></div>
	
</div>