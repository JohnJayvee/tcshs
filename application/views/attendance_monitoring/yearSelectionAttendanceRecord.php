<div class="container">
    <div style="margin-bottom:20px"></div>

    <?php $this->Main_model->banner( 'View attendance record','Select year level'); ?>

    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($yearLevelTable->result() as $row) {
                if ($row->academic_grade_id == 2) {
                    continue;
                }
                ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td>
                        <?php $enter = base_url() . "attendance_monitoring/sectionSelectionAttendanceRecord?yearLevelId=$row->school_grade_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>