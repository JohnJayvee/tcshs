
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	<h1><?= $facultyName ?></h1>
    <hr width="50%">
    <span style="font-size:30px"><b><?= $studentNameFullName ?></b> Year level: <b><?= $yearLevelName ?></b> Section: <b><?= $sectionName ?></b></span>
    <br><span style="font-size:30px">Subject: <b><?= $subjectName ?></b></span>
 	</div> <!-- yellow top -->

 	<hr>
 	
 	<div style="margin-bottom: 20px"></div>

		
	<div style="margin-bottom:40px"></div>
	<div class="col-md-12" align="center">
	

    <!-- insert table -->
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($attendanceTable->result() as $row) {?>
                
           
                <tr align="center">
                    <td><?= $row->date; ?></td>
                    <td> <?php $this->Main_model->attendanceFixer($row->attendance_status); ?> </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/dashboard" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
 </div>
