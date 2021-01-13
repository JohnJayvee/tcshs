<div style="margin-bottom: 20px"></div>

<div class="container">
	<!-- <h1>Update parent's children</h1>
	<h3><?= ucfirst($ParentFullName) ?></h3> -->
	<!-- <?php $this->Main ?> -->

	<?php $this->Main_model->banner("Update parent's children", ucfirst($ParentFullName)); ?>
	
		<form action="" method="post">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Student name</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$this->load->model('Main_model');
						foreach ($student_table as $row) {
							$student_id = $row['account_id'];
							$firstname = $row['firstname'];
							$middlename = $row['middlename'];
							$lastname = $row['lastname'];
							$studentParentId = $row['parent_id']?>
						<tr>
							<td>
								<?php 
								echo ucfirst("$firstname $middlename $lastname");
								 ?>
							</td>
							<td>
								<?php 
										if ($studentParentId == $parent_id) {?>
											<input type="checkbox" name="students[]" value="<?= $student_id ?>" class="form-control" style="width: 20px; height: 20px;" checked>
										<?php }else{?>
											<input type="checkbox" name="students[]" value="<?= $student_id ?>" class="form-control" style="width: 20px; height: 20px;">
										<?php }?>
									
								 
								
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div><br>
			<div class="row">
				<div class="col-md-6">
					<?php $back = base_url() . "manage_user/parentEdit/$parent_id/2?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
					<a href="<?= $back ?>">
						<button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
					</a>
				</div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary col-md-12" name="studentList"><i class="fas fa-edit"></i>&nbsp; Edit</button>
				</div>
			</div>
		</form>
		<div style="margin-bottom: 20px;"></div>
</div>