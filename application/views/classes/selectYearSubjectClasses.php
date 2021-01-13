<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View classes</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2>Select year level</h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <?php
        $sectionId = $this->Main_model-> getAdviserSectionJhs();
        $yearLevelId = $this->Main_model->getAdviserSchoolGradeId();
        $personalSubjects = base_url() . "classes/personalSubjects?yearLevelId=$yearLevelId&sectionId=$sectionId";
    ?>
    <a href="<?= $personalSubjects ?>">
        <button class="btn btn-info col-md-12">Personal Subjects &nbsp;<i class="fas fa-arrow-right"></i> </button>
    </a>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($schoolYearTable->result_array() as $row) {
                        $school_year_id = $row['school_grade_id'];
                        $name = $row['name'];?>
                   <!-- remove rows that does not contain any students -->
                        <?php 
                            $studentTable = $this->Main_model->get_where('student_profile', 'school_grade_id', $school_year_id);
                            if (count($studentTable->result_array()) == 0) {
                                continue;
                            }
                        ?>
                <tr>
                    <td><?= $name ?></td>
                    <td>
                        <?php $enter = base_url() . 'classes/selectSectionClasses?yearLevelId=' . $school_year_id ?>
                        <a href="<?= $enter ?> "><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i> &nbsp; Enter</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>