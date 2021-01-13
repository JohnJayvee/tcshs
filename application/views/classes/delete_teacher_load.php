<div class="container" style="margin-right:10px">
    <div class="row bg-warning m-4 p-4">
        <div class="col-md-12">
            <h1>Teacher load <span class="text-danger">deletion</span></h1>
            <h4><?= $teacherName ?>, Are you sure you want to delete the following teacher load:</h4>
        </div>
        <div style="font-size:30px" class="col-md-12">
            <ul>
                <li><?= ucfirst($subjectName); ?></li>
                <li><?= ucfirst($schedule); ?></li>
                <li><?= ucfirst($sectionName); ?></li>
                <li><?= ucfirst($yearLevelName); ?></li>
            </ul>
        </div>
    <?php
        $back = base_url() . "classes/viewPersonalTeacherLoad";
        $delete = base_url() . "classes/delete_teacher_load/$teacherLoadId?confirm=1";
    ?>
        <div class="col-md-12">
                <a href="<?= $back ?>"><button class="btn btn-secondary col-md-5 m-4">Back</button></a>
                <a href="<?= $delete ?>"><button class="btn btn-danger col-md-5 m-4"><i class="fas fa-trash"></i>&nbsp; Delete</button></a>
        </div> <!-- navigations -->

    </div>     <!-- row -->
</div>