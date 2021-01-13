
<div class="container">
<div style="margin-bottom: 20px"></div>

	<?php $this->Main_model->banner('Manage student academic year', "<strong>$yearLevelName | $sectionName</strong>"); ?>

	<div class="table-responsive">

		<?php $form = base_url() . 'manage_user_accounts/update_grade_class_plus/' . $grade . '/' . $section  ; ?>
		<form action="<?= $form  ?>" method="post">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Section</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($student_table as $row) {
						$student_profile_id = $row['account_id'];
						$firstname = ucfirst($row['firstname']);
						$middlename = ucfirst($row['middlename']);
						$lastname = ucfirst($row['lastname']);
						$student_status = $row['student_status'];
						$school_grade_id = $row['school_grade_id'];
						$section_id = $row['section_id'];?>
						
					
					<tr>
						<td>
							<?php
								$student_fullname = "$firstname $middlename $lastname";
							 	echo ucfirst($student_fullname);
							  ?>
						</td>
						
						<td>
							<?php 
							$this->load->model('Main_model');
							$section_table = $this->Main_model->get_where('section','section_id', $section_id);

							foreach ($section_table->result_array() as $row) {
								$section_id = $row['section_id'];
								$section_name = $row['section_name'];
							}

							echo $section_name;
							 ?>
						</td>
						<td>
							<input type="checkbox" name="bagsak[]" value="<?= $student_profile_id ?>" />
						</td>
					</tr>

					<?php } ?>
				</tbody>
			</table>
			
	</div>
		<div style="margin-bottom: 20px"></div>
		<div class="row">
			<div class="col-md-4">
			<?php
				$back = base_url() . 'manage_user_accounts/update_grade_class'; 
				$all_have_passed = base_url(). 'manage_user_accounts/all_have_passed/' . $grade . '/' . $section;
			?>
				<a href="<?= $back ?>">
					<button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
				</a>
			</div>
			<div class="col-md-4">
				<button type="submit" class="btn btn-primary col-md-12" name="check">Submit</button>
			</div>
			<div class="col-md-4">
				<a href="<?= $all_have_passed ?>">
					<button type="button" class="btn btn-success col-md-12"><i class="fas fa-check"></i>&nbsp; All Have Passed</button>
				</a>
			</div>
		</div>
	</form>
</div>
