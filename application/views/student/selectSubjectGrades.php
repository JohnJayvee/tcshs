<div class="conatiner m-3">
    <center>
        <h1>Student Grades</h1>
        <hr width="60%">
        <span style="font-size:30px;"><strong class="bg-success p-1"><?= $studentFullName ?></strong> Section: <b><?= $sectionName ?></b> Year Level: <b><?= $gradeLevelName ?></b></span>
    </center>
    <div style="margin-bottom:40px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($classTable->result() as $row) {?>
                <tr>
                    <td><?= $this->Main_model->getSubjectNameFromId($row->subject_id) ?></td>
                    <td>
                    <?php $enter = base_url() . "SearchStudent/studentSearchGrades?subjectId=$row->subject_id&yearLevelId=$yearLevelId&sectionId=$sectionId&facultyId=$row->faculty_id&studentId=$studentId"; ?>
                        <a href="<?= $enter ?>" class="button btn btn-primary col-md-12">Enter</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/secretaryView" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>