
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	 	

	<h1><?= $fullname ?></h1>

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

	
		
		<div class="row">
			<!-- student search -->
			<div style="margin-bottom:30px"></div>
			<!-- other buttons -->
			<div class="col-md-6">
				<?php $change_password = base_url() . 'manage_user_accounts/change_password/' . $faculty_id ?>
				<a href="<?= $change_password ?>">
					<button class="btn btn-primary col-md-12"><i class="fas fa-key" style="color: white;"></i>&nbsp; Change Password</button>
				</a><div style="margin-bottom:5px"></div>
				<?php $batch = base_url() . 'manage_user_accounts/facultyRegisterBatch' ?>
				<a href="<?= $batch ?>"><button class="btn btn-success col-md-12 p-3"><i class="fas fa-user"> &nbsp;Faculty batch register</i></button></a>
			</div>

			<div class="col-md-6" align="center">
            <?php $studentSearch = base_url() . "SearchStudent" ?>
				<form action="<?= $studentSearch ?>" method="post">
					<div class="form-group">
						<input type="text" autocomplete="off" placeholder="Search student" name="search" class="form-control">
					</div>
					<button class="btn btn-outline-info col-md-12" style="color:black"><i class="fas fa-search" style="color: black;"></i>&nbsp; Search a Student</button>
				</form>
			</div>
            <div style="margin-bottom:30px"></div>&nbsp;
            <!-- search table -->
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr align="center">
                            <th>Student Name</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach ($studentTable->result() as $row) {?>
                        <tr>
                            <td>
                                <h3 class="m-1" align="center"><?= "$row->firstname $row->middlename $row->lastname "?></h3>
                            </td>
                            <?php
                                $grade = base_url() . "searchstudent/selectSubjectGrades?studentId=$row->account_id";
                                $attendance = base_url() . "searchStudent/selectSubjectAttendance?studentId=$row->account_id";
                            ?>
                            <td align="center">
                                <a href="<?= $grade ?>"><button class="btn btn-Secondary col-md-3 m-1"><i class="fas fa-graduation-cap"></i>&nbsp;Grades</button></a>
                                <a href="<?= $attendance ?>"><button class="btn btn-warning col-md-3 m-1"><i class="fa fa-fingerprint" style="font-size:11px"></i>&nbsp;Attendance</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
	<br>
 	
 </div>

 <div style="margin-bottom: 40px"></div>
 