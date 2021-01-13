

<div style="margin-bottom: 50px"></div>

<div class="container">
	<h1>Teacher's child assignment</h1>
	<h4>Search and select the name of your child.</h4>
	<div style="margin-bottom: 50px"></div>
	<div class="table-responsive">
		<form action="" method="post">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$this->load->model('Main_model');
					foreach ($student_table->result_array() as $row) {
						$firstname = $row['firstname'];
						$middlename = $row['middlename'];
						$lastname = $row['lastname'];
						$fullname = "$firstname $middlename $lastname"?>
					
					<tr>
						<td>
							<?= ucfirst($fullname) ?>
						</td>
						<td>
							<input type="checkbox" name="parentChildren" value="1">
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
	</div><br><br>
			<button type="submit" name="submit" class="btn btn-primary col-md-12">Submit</button>
		</form><div style="margin-bottom: 10px;"></div>
			<?php $back = base_url() . 'manage_user_accounts/dashboard' ?>
			<a href="<?= $back ?>">
				<button class="btn btn-secondary col-md-12">Back</button>
			</a>



</div> <!-- container -->