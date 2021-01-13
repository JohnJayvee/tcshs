<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Student selection</h1>
        <hr width="30%" style="margin: 5px 5px">
        <h2>Select a student</h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <!-- card body -->
    <div class="row">
    <?php 
        foreach ($allStudent as $row) {
        $academicGradeId = $row['academic_grade_id'];
        $sectionId = $row['section_id'];
        $studentId = $row['account_id'];
        $fight = base_url() . "parent_student/selectStudent?accountId=$studentId&academicGradeId=$academicGradeId";?>

        <div class="col-sm-4" align="center">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $row['fullname'] ?></h5>
                <p class="card-text">Year level: <strong><?= $this->Main_model->getYearLevelNameFromId($row['school_grade_id']) ?></strong> <br> Section: <strong><?= $this->Main_model->exclempetut($academicGradeId, $sectionId); ?></strong></p>
                <a href="<?= $fight ?>" class="btn btn-primary col-md-12"><i class="fas fa-eye"></i> &nbsp;View</a>
            </div>
            </div>
        </div>

    <?php } ?>
    </div>
    <!-- card body -->
    <div style="margin-bottom:20px"></div>
    <?php $back = base_url() . "parent_student/student_page" ?>
<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
