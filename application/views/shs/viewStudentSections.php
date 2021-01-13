<div class="container">
    <div style="margin-bottom:10px"></div>
    <?php $this->Main_model->banner('Year and Section management', "$yearLevelName | $sectionName"); ?>
    <div style="margin-bottom:10px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Student name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shClassSectionTable->result() as $row) {
                //remove deactivated accounts
                if ($this->Main_model->checkIfShStudentIsActive($row->sh_student_id) == FALSE) {
                    //meaning deactivated na yung student
                    continue;
                }
                ?>
                <tr>
                    <td><?= $this->Main_model->getFullName('sh_student', 'account_id', $row->sh_student_id) ?></td>
                    <td>
                    <?php $transfer = base_url() . "" ?>
                        <a href="<?= $transfer ?>"><button class="btn btn-primary"><i class="fas fa-exchange-alt"></i>&nbsp; Transfer section</button></a>
                    </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    </div>
    <div style="margin-bottom:20px"></div>
    <?php $back = base_url() . "shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back </button></a>
</div>