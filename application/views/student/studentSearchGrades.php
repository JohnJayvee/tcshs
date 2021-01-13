<div class="conatiner m-3">
    <center>
        <h1>Student Grades</h1>
        <hr width="60%">
        <span style="font-size:30px;"><strong><?= $studentName ?></strong><br> Section: <b><?= $sectionName ?></b> Year Level: <b><?= $yearLevelName ?></b> Subject: <b>Subject1</b></span>
    </center>
    <div style="margin-bottom:40px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>First</th>
                    <th>Second</th>
                    <th>Third</th>
                    <th>Fourth</th>
                    <th>Final</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($studentGradesTable->result() as $row) {?>
                    
                
            
                    <tr>
                        <td>
                            <?= $this->Main_model->gradeFixer($row->quarter1) ?></td>
                        <td>
                            <?= $this->Main_model->gradeFixer($row->quarter2) ?>
                        </td>
                        <td>
                            <?= $this->Main_model->gradeFixer($row->quarter3) ?>
                        </td>
                        <td>
                            <?= $this->Main_model->gradeFixer($row->quarter4) ?>
                        </td>
                        <td>
                            <?= $this->Main_model->gradeFixer($row->final_grade) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div style="margin-bottom:40px"></div>
        <?php $back = base_url() . "searchstudent/selectSubjectGrades?studentId=$studentId;" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
    </div>
</div>