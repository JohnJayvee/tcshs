<div class="container">
	<center class="bg-warning p-3">
		<h1>Manage Jhs Subjects</h1>
		<hr width="40%" style="margin: 5px 5px">
		<h2><?= $yearLevelName ?></h2>
	</center>
	<div style="margin-bottom:10px"></div>
<div class="p-3 bg-info">
<?php $back = base_url() . 'classes/selectYearSubject' ?>
	<?php $form_url = base_url() . 'classes/add_subject' ?>
		<form action="<?= $form_url ?>" method="post">
			<div class="form-group">
				<label style="font-size:30px;font-weight:bold;">Enter New Subject:</label>
				<input type="text" name="subject" class="form-control" autocomplete="off" placeholder="Enter Subject"  autofocus="on" required><br>
				
				<div class="row">
					<div class="col-md-4">
						<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
					</div>
					<div class="col-md-4">
						<button type="submit" name="submit" class="btn btn-success col-md-12"><i class="fas fa-check"></i>&nbsp; Submit</button>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-dark col-md-12" id="viewButton"><i class="fas fa-eye"></i>&nbsp; View</button>
					</div>
				</div>
			</div>
			
			<input type="hidden" name="yearLevelId" value="<?= $yearLevelId ?>">
		</form>
</div>
<?php $this->Main_model->alertSuccess('subjectCreated', "Subject Created"); ?>
<?php $this->Main_model->alertSuccess('subjectUpdated', "Subject updated successfully"); ?>
<div class="card-body">
	<div class="table-responsive" id="table">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<!-- for testing purposes lang itong id. -->
					<th> Subject Name</th>
					<th> Options</th>
				</tr>
			</thead>
<tbody>
<?php 
foreach ($subject_table->result_array() as $row) {
	$subject_name = $row['subject_name'];
	$subject_id = $row['subject_id'] ?>	
	 	<tr>
			<td><?= strtoupper($subject_name) ?></td>
			<td>

				<?php $update_url = base_url() . "classes/editJhsSubject?yearLevelId=$yearLevelId&subjectId=$subject_id"?>
				<a href="<?= $update_url ?>">
					<button class="btn btn-primary col-md-5">
						<i class="fas fa-edit"></i>
						Edit
					</button>
				</a>
				&nbsp;&nbsp;&nbsp;
				<?php $delete_url = base_url() . 'classes/delete_subject/' . $subject_id . '/0?yearLevelId=' . $yearLevelId  ?>
				<a href="<?= $delete_url ?>">
					<button class="btn btn-danger col-md-5">
						<i class="fas fa-trash-alt"></i>
						Delete
					</button>
				</a>
			</td>
	</tr>
<?php } ?>
	
	


	
</tbody>
</table>
</div>
</div>
</div>

<script>
	$(document).ready(function(){
		$("#table").hide();
		$('#viewButton').click(function(){
			$("#table").fadeToggle();
		});
	});
</script>