
	<!-- in order for you to use this system. a principal should have a credentials id
	to be equal to four as a start up for this system -->
<?php 
	if (isset($_SESSION['sameSection'])) {
		echo "<script>alert('Section already Exists!')</script>";
		unset($_SESSION['sameSection']);		
	}

 ?>

<div style="margin-bottom:20px"></div>



<div class="container"> 

<center class="bg-warning p-3">
	<h1>Manage sections</h1>
	<hr width="40%" style="margin:5px 5px">
	<h2><?= $yearLevelName ?></h2>
</center>
<div style="margin-bottom:20px"></div>
<div class="bg-info p-3">
<?php $form_url = base_url() . 'classes/add_section' ?>
	<form action="<?= $form_url ?>" method="post">
		<div class="form-group">
			<label style="font-size: 30px;font-weight:bold;">Create New Section:</label>
			<input autofocus="on" type="text" name="section" class="form-control" autocomplete="off" placeholder="Create Section"><br>
			<div class="row">
				<div class="col-md-4">
				<?php $back = base_url() . 'classes/selectYearLevel?schoolLevel=1' ?>
				<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
				</div>
				<div class="col-md-4">
					<button type="submit" name="submit" class="btn btn-success col-md-12"> SUBMIT</button>
				</div>
				<div class="col-md-4">
					<button type="button" class="col-md-12 btn btn-dark" id="viewButton"><i class="fas fa-eye"></i>&nbsp; View</button>
				</div>
			</div>
			<input type="hidden" name="YearLevelId" value="<?= $yearLevelId ?>">
		</div>
	</form>
</div>
	
		
	

<div class="card-body">

	<?php 
		if (isset($_SESSION['studentMove'])) {?>
			<p class="alert alert-success" style="font-size: 20px">Student's section Successfuly moved</p>
			<?php unset($_SESSION['studentMove']) ?>
		<?php } ?>
	 <?php
	 	$this->Main_model->alertSuccess('sectionCreated','Section Successfully Created');
		 $this->Main_model->alertDanger('sectionDelete', 'Section has been deleted');
	 ?>

	<div class="table-responsive" id="table">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>

					<!-- for testing purposes lang itong id. -->
					<th> Section Name</th>
					<th> Options</th>
				</tr>
			</thead>

	

<tbody>

	
<?php 
foreach ($section_table->result_array() as $row) {
	$section_name 	= $row['section_name'];
	$section_id 	= $row['section_id'] ?>	



	 	<tr>
			<td><?= strtoupper($section_name) ?></td>
			<td style="width:60%">

				<?php $update_url = base_url() . 'classes/update_section/' . $section_id . '/' . 0 ?>
				<a href="<?= $update_url ?>">
					<button class="btn btn-primary col-md-3" style="width: 300px;">
						<i class="fas fa-edit"></i>
						Edit
					</button>
				</a>
				
				<?php $delete_url = base_url() . 'classes/delete_section/' . $section_id . '/0?yearLevel=' . $yearLevelId ?>
				<a href="<?= $delete_url ?>">
					<button class="btn btn-danger col-md-3" style="width: 300px;">
						<i class="fas fa-trash-alt"></i>
						Delete
					</button>
				</a>
				<?php 
				$this->load->model('Main_model');
				//student profile table ko siya kinuha para kapag latest kung sakaling mag level up yung mga student into next year
				$yearLevelTableCount = $this->Main_model->get_where('student_profile','section_id', $section_id);
				$yearLevelTableCount = count($yearLevelTableCount->result_array());
					if ($yearLevelTableCount >= 1) {?>
						<?php $sectioning = base_url() . "classes/student_sectioning?yearLevelId=$yearLevelId&sectionId=" . $section_id ?>
							<a href="<?= $sectioning ?>">
								<button class="btn btn-info col-md-3" style="width: 300px;">Sectioning</button>
							</a>
					<?php } ?>
				
				
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
