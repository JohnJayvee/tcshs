
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	<h1><?= $facultyName ?></h1>
    <hr width="50%">
    <span style="font-size:30px"><b><?= $studentNameFullName ?></b> Year level: <b><?= $yearLevelName ?></b> Section: <b><?= $sectionName ?></b></span>

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
	

    <!-- insert table -->
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <td>Subject Name</td>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($classTable->result() as $row) {?>
                
           
                <tr align="center">
                    <td><?= $this->Main_model->getSubjectNameFromId($row->subject_id); ?></td>
                    <td>
                    <?php $grade = base_url() . "searchStudent/adminViewGrades?subjectId=$row->subject_id&sectionId=$sectionId&facultyId=$row->faculty_id&studentId=$studentId";?>
                        <a href="<?= $grade ?>"><button class="btn btn-primary col-md-3"><i class="fas fa-eye"></i> &nbsp; View</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
 </div>
