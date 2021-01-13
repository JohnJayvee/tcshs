<div class="container bg-warning p-3 m-4">
    <h1>Year Level Deletion</h1>
    <p style="font-size:30px">Are you sure you want to delete: <strong><?= $name ?></strong>?</p>
    <div>
        <?php
        $cancel = base_url() . 'classes/editYearLevel/' . $schoolGradeId;
        $delete = base_url() . 'classes/DeleteYearGrade/' . $schoolGradeId . '?delete=' . $schoolGradeId;
        ?>
        <a href="<?= $cancel ?>"><button class="btn btn-secondary">Cancel</button></a>
        <a href="<?= $delete ?>"><button class="btn btn-danger">Delete</button></a>
    </div>
</div>