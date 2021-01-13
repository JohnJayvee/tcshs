<div class="container">
    <div style="margin-bottom:10px"></div>
    <?php $this->Main_model->banner('View classes', "$yearLevelName | $strandName | $sectionName | $subjectName") ?>

    
    <div style="margin-bottom:-10px"></div>
    <?php $addStudent = base_url() . "shs/addStudentInClass?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevelId&strandId=$strandId" ?>
    <a href="<?= $addStudent ?>"><button class="btn btn-success"><i class="fas fa-plus"></i>&nbsp; Add student</button></a>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $numbering = 0; 
                foreach ($shClassTable->result() as $row) {
                $numbering+= 1;
            ?>
                <tr>
                    <td><?= $numbering ?>. <?= $this->Main_model->getFullName('sh_student', 'account_id', $row->sh_student_id) ?></td>
                    <td align="center" width="20%">
                        <?php $remove = base_url() . "shs/removeStudentFromClass/$row->sh_student_id?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevelId&strandId=$strandId" ?>
                        <a href="<?= $remove ?>">
                            <button class="btn btn-danger col-md-12">
                                <fas class="fas fa-trash"></fas>
                                   &nbsp; Remove
                            </button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
        <?php $back = base_url() . "shs/viewPsYearLevel" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
    </div>
</div>

