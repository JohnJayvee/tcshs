
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	<h1><?= $facultyName ?></h1>

 	</div> <!-- yellow top -->

 	<div style="margin-bottom: 20px"></div>

		
	<div style="margin-bottom:40px"></div>
	<div class="col-md-12" align="center">
	<?php $studentSearch = base_url() . "searchStudent/adminSelectStudent" ?>
		<form action="<?= $studentSearch ?>" method="post">
        <?= validation_errors("<p class='alert alert-danger'>"); ?>
				<div class="form-group">
					<input autocomplete="off" autofocus="on" required type="text" name="studentName" placeholder="Search Student" class="form-control">
				</div>
				<button class="btn btn-outline-primary col-md-12" style="color:black"><i class="fas fa-search"></i>&nbsp; Search</button>
		</form>
	</div>

    <!-- insert table -->
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student Name</th>
					<th>Year Level</th>
					<th>Section</th>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($studentTable->result() as $row) {?>
                
           
                <tr align="center">
                    <td><?= $this->Main_model->getFullname('student_profile', 'account_id', $row->account_id); ?></td>
                    <td><?= $this->Main_model->getYearLevelNameFromId($row->school_grade_id) ?></td>
					<td><?= $this->Main_model->getSectionNameFromId($row->section_id) ?></td>
					<td>
                    <?php 
                    
                    $grade = base_url() . "searchStudent/adminGradesSubjectSelection?studentId=$row->account_id";
                    $attendance = base_url() . "searchStudent/adminSubjectSelection?studentId=$row->account_id";
                    ?>
                        <a href="<?= $grade ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-graduation-cap"></i> &nbsp; Grades</button></a>
						<div style="margin-bottom:10px"></div>
                        <a href="<?= $attendance ?>"><button class="btn btn-warning col-md-12"><i class="fas fa-fingerprint"></i>&nbsp; Attendance</button></a>
						<div style="margin-bottom:10px"></div>
                    <!-- insert activate parent here -->

                    <?php 
				$this->load->model('Main_model');
				$deactivate = base_url() . 'classes/deactivate_call_parent/' . $row->account_id . "/$row->section_id?yearLevelId=$row->school_grade_id&sectionId=$row->section_id";
				$activateCallParent = base_url() . 'classes/activate_call_parent/' . $row->account_id . "/$row->section_id?yearLevelId=$row->school_grade_id&sectionId=$row->section_id";
				$where['faculty_id'] = $_SESSION['faculty_account_id'];
				$where['student_profile_id'] = $row->account_id;

				$callParentTable = $this->Main_model->multiple_where('call_parent', $where);
				?> <!-- dito ka mag lagay------------ -->
				

				<?php 
				foreach ($callParentTable->result_array() as $row) {
					$callParentId = $row['call_parent_id'];
					$putangInangStatusTo = $row['status'];
					$student_profile_id = $row['student_profile_id'];
				}
				
				$cp_count = count($callParentTable->result_array());
				
					
					if ($cp_count > 0) {?>

						<?php 
						
						if ($putangInangStatusTo == 1) {?>
							<a href="<?= $deactivate ?>">
								<button class="btn btn-success col-md-12" style="font-size:12px;padding:8px">							
									Deactivate Call Parent
								</button>
							</a>
						<?php }else{?>
							<a href="<?= $activateCallParent ?>">
								<button class="btn btn-danger col-md-12"style="font-size:13px;padding:7.5px">
									<i class="fa fa-phone"></i>
									Activate Call Parent
								</button>
							</a>&nbsp;
						<?php }?>

						 

				<?php }else{ ?>
					
				 	<a href="<?= $activateCallParent ?>">
						<button class="btn btn-danger col-md-12" style="font-size:13px;padding:7.5px">
						<i class="fa fa-phone"></i>
							Activate Call Parent
						</button>
					</a>
				<?php }  ?>
				 


                    </td>
                </tr>

            <?php }  ?>
            </tbody>
        </table>
    </div>
 </div>
