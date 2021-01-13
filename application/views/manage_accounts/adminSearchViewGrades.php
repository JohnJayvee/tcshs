
<div style="margin-bottom: 40px"></div>
 <div class="container">
 	
 	<div class="alert alert-warning" align="center">

	<h1><?= $facultyName ?></h1>
    <hr width="50%">
    <span style="font-size:30px"><b><?= $studentNameFullName ?></b> Year level: <b><?= $yearLevelName ?></b> Section: <b><?= $sectionName ?></b></span>
    <br><span style="font-size:30px">Subject: <b><?= $subjectName ?></b></span>
 	</div> <!-- yellow top -->

 	<div style="margin-bottom: 20px"></div>

		
	<div style="margin-bottom:40px"></div>
	<div class="col-md-12" align="center">
	

    <!-- insert table -->
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <td>First</td>
                    <td>Second</td>
                    <td>Third</td>
                    <td>Fourth</td>
                    <td>Final</td>
                    
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($studentGradesTable->result() as $row) {?>
                
           
                <tr align="center">
                   <td><?= $this->Main_model->gradeFixer($row->quarter1); ?></td>
                   <td><?= $this->Main_model->gradeFixer($row->quarter2); ?></td>
                   <td><?= $this->Main_model->gradeFixer($row->quarter3); ?></td>
                   <td><?= $this->Main_model->gradeFixer($row->quarter4); ?></td>
                   <td><?= $this->Main_model->gradeFixer($row->final_grade); ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "searchStudent/adminGradesSubjectSelection?studentId=$studentId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
 </div>
