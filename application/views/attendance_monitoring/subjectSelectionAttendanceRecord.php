<div class="container">
    <div style="margin-bottom:20px"></div>

    <?php  
        $lowerText = "<strong>$yearLevelName</strong> | <strong>$sectionName</strong>";
        $this->Main_model->banner('View Attendance record', $lowerText);
    ?>

    <div style="margin-bottom:40px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($subjectTable->result() as $row) {?>
                <tr>
                    <td><?= $row->subject_name ?></td>
                    <td>
                        <?php $enter = base_url() . "attendance_monitoring/view_attendance_record?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$row->subject_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "attendance_monitoring/sectionSelectionAttendanceRecord?yearLevelId=$yearLevelId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>