<div class="container">
    <div style="margin-bottom:20px"></div>
    <div class="m-2 p-3 bg-warning" align="center">
        <h1 >Confirm Call parent</h1>
        <span style="font-size:30px">Are you sure you want to call the parent of <b><?= ucfirst($studentFullName) ?></b>?</span>
    
    <div style="margin-bottom:30px"></div>
    <?php
        $back = base_url() . "classes/view_student_grades/$sectionId?yearLevelId=$yearLevelId&sectionId=$sectionId";
        $activateCallParent = base_url() . 'classes/activate_call_parent/' . $studentId . "/$sectionId";
    ?>
    <div>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-5" style="margin-right:50px">Back</button></a>
        <a href="<?= $activateCallParent ?>"><button class="btn btn-danger col-md-5">Call Parent</button></a>
    </div>

    </div>
</div>