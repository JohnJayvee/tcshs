
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	<h1><?= $facultyName ?></h1>

 	</div> <!-- yellow top -->

 	<hr>
 	<div class="form-group">
			<?php if (isset($_SESSION['alert_message'])): ?>
				<p class='p-3 mb-2 bg-success text-white' align="center" style="font-size: 25px;">
					<?= $_SESSION['alert_message'] ?>
					<!-- <?php unset($_SESSION['alert_message']) ?> -->
				</p>		
			<?php endif ?>
		</div>
 	<div style="margin-bottom: 20px"></div>

		
	<div style="margin-bottom:40px"></div>
	<div class="col-md-12" align="center">
	<?php $studentSearch = base_url() . "searchStudent/adminSelectStudent" ?>
		<form action="<?= $studentSearch ?>" method="post">
        <?= validation_errors("<p class='alert alert-danger'>"); ?>
				<div class="form-group">
					<input required type="text" name="studentName" placeholder="Search Student" class="form-control">
				</div>
				<button class="btn btn-outline-primary col-md-12" style="color:black"><i class="fas fa-search"></i>&nbsp; Search</button>
		</form>
	</div>

    <!-- insert table -->
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <td>Student Name</td>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($studentTable->result() as $row) {?>
                
           
                <tr align="center">
                    <td><?= $this->Main_model->getFullname('student_profile', 'account_id', $row->account_id); ?></td>
                    <td>
                    <?php 
                    
                    $grade = base_url() . "searchStudent/adminGradesSubjectSelection?studentId=$row->account_id";
                    $attendance = base_url() . "searchStudent/adminSubjectSelection?studentId=$row->account_id";
                    ?>
                        <a href="<?= $grade ?>"><button class="btn btn-primary col-md-3"><i class="fas fa-graduation-cap"></i> &nbsp; Grades</button></a>
                        <a href="<?= $attendance ?>"><button class="btn btn-warning col-md-3"><i class="fas fa-fingerprint"></i>&nbsp; Attendance</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
 </div>
