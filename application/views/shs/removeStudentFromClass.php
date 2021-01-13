<div class="container">
    <?php $this->Main_model->banner('Manage classes', "Remove student from class"); ?>
    <p style="font-size: 30px">Are you sure you want to remove <b><?= ucfirst($studentName) ?></b><br> From your <b><?= $subjectName ?></b> class?</p>
    <br>
    <?php
        $back = base_url() . "shs/viewPesonalSubjects?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevelId&strandId=$strandId";
        $confirm = base_url() . "shs/removeStudentFromClass/$studentId?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevelId&strandId=$strandId&confirm=1";
    ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>&nbsp;
    <a href="<?= $confirm ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Confirm</button></a>
</div>