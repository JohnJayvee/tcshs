<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View classes', "$yearLevelName | $sectionName | $subjectName") ?>

    
    <div style="margin-bottom:25px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Student</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $numbering = 0; 
                foreach ($ClassTable->result() as $row) {
                $numbering+= 1;
            ?>
                <tr>
                    <td><?= $numbering ?>. <?= $this->Main_model->getFullName('student_profile', 'account_id', $row->student_profile_id) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "classes/personalSubjects" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>

