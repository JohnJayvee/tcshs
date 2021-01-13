<div class="conatiner m-3">
    <center>
        <h1>Student Attendance</h1>
        <hr width="60%">
        <span style="font-size:30px;"><strong class="bg-success p-1"><?= $studentFullName ?></strong> Section: <b><?= $sectionName ?></b> Year Level: <b><?= $yearLevelName ?></b></span>
    </center>
    <div style="margin-bottom:40px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $this->load->model('Main_model'); ?>
            <?php foreach ($attendanceRecord->result() as $row) {?>
                <tr>
                    <td><?= $row->date ?></td>
                    <td>
                        <?php 
                            if ($row->attendance_status == 0) {
                                echo "Absent!";
                            }else{
                                echo "Present";
                            }
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "searchStudent/selectSubjectAttendance?studentId=$studentId" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>