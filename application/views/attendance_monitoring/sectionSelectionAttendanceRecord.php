<div class="container">
    <div style="margin-bottom:20px"></div>

    <?php
        $lowerText = "<strong>$yearLevelName</strong>"; 
        $this->Main_model->banner('View attendance record', $lowerText);
    ?>

    <div style="margin-bottom:40px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sectionTable->result() as $row) {?>
                <tr>
                    <td><?= $row->section_name ?></td>
                    <td>
                        <?php $enter = base_url() . "attendance_monitoring/subjectSelectionAttendanceRecord?yearLevelId=$yearLevelId&sectionId=$row->section_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "attendance_monitoring/yearSelectionAttendanceRecord" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>