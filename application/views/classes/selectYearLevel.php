<div class="container">
    <div style="margin-bottom:40px;"></div>
    <center class="bg-warning p-3">
        <h1>Manage Year &amp; Section</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2>Select Year Level</h2>
    </center>

    <div style="margin-bottom:40px;"></div>
    <?php
    $this->Main_model->alertSuccess('updateSucc', 'Year Name Updated');
    $this->Main_model->alertDanger('yearDeleted', 'Year Level Deleted');
    ?>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($schoolGradeTable->result_array() as $row) {
                    $gradeId = $row['school_grade_id'];
                    $status = $row['status'];
                    $name = $row['name'];
                    $academicGradeId = $row['academic_grade_id'];
                    //disable all status zero
                    if ($status == 0) {
                        continue;
                    }

                    //dapat ang makukuha niya lang ay yung base sa school level
                    if ($this->input->get('schoolLevel') != $academicGradeId) {
                        continue;
                    }
                ?>

                    <tr>
                        <td><?= $name ?></td>
                        <td>
                            <?php $schoolGradeId = base_url() . "classes/add_section?yearLevelId=$gradeId" ?>
                            <a href="<?= $schoolGradeId ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp;  Enter</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom:10px"></div>&nbsp;
</div> <!--  container  -->