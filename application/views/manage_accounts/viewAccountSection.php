<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View Junior high school accounts', "$yearLevelName"); ?>
    
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Section name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sectionNameId->result() as $row) {?>
                <?php 
                    //remove yung walan mga wala namang laman na students
                    $studentTable = $this->Main_model->get_where('student_profile', 'section_id', $row->section_id);    
                    if (count($studentTable->result_array()) == 0) {
                        continue;
                    }
              ?>
                <tr>
                    <td><?= $row->section_name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'manage_user/view_student_account?yearLevelId=' . $yearLevelId . '&sectionId=' . $row->section_id ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . 'Manage_user/viewAccountYearlevel' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>