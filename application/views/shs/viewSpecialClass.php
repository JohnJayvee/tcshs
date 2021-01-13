<div class="container">
    <?php $this->Main_model->banner("Create custom class", "$customClassName | $customClassSubjectName"); ?>
    <?php
        $addStudents = base_url() . "shs/addCustomClassStudents?customClassId=$customClassId";
        $deleteClass = base_url() . "shs/deleteSpecialClass?customClassId=$customClassId"; 
    ?>
    <a href="<?= $addStudents ?>"><button class="btn btn-success"><i class="fas fa-plus"></i>&nbsp; Add</button></a> &nbsp;
    <a href="<?= $deleteClass ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Delete this class</button></a>
    <div style="margin-bottom:20px"></div>
        <div class="table table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Student name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($customClassGroupTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullName('sh_student', 'account_id', $row->sh_student_id) ?></td>
                        <td width="20%" align="center">
                        <?php $remove = base_url() . "shs/removeStudentCustomClass?customClassId=$row->id" ?>
                            <a href="<?= $remove ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Remove</button></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php $back = base_url() . "shs/viewPsYearLevel" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>