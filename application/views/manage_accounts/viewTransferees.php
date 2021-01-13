<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner("Manage user accounts", "View transferee's account"); ?>
    <!-- <div style="margin-bottom:10px"></div> -->
    <button id="filterBtn" class="col-md-12 btn btn-outline-info">Filter students</button>
    <div style="margin-bottom:10px"></div>
    <div id="dDfilter" class="bg-info p-3">
        <h4>Filter Students</h4>
        <select name="filter" id="selectFilter" class="form-control">
            <option value="">Select jhs or shs</option>
            <option value="1">Junior high school</option>
            <option value="2">Senior highs school</option>
        </select>
    </div>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Student name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($transfereeTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->g10StudentRepositoryManager($row->student_profile_id) ?></td>
                    <td>
                    <?php
                        $grades = base_url() . "manage_user_accounts/transfereeGrades/" . $row->student_profile_id;
                        $attendance = base_url() . "";
                    ?>
                        <a href="<?= $grades ?>"><button class="btn btn-primary col-md-5"><i class="fas fa-graduation-cap"></i>&nbsp; Grades</button></a>
                        <a href=""><button class="btn btn-warning col-md-5"><i class="fas fa-fingerprint"></i>&nbsp; Attendance</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
        //hide the dd div   
        $("#dDfilter").hide();

        //when clicked activate dropdown
        $("#filterBtn").click(function(){
            $("#dDfilter").fadeToggle();
        });
    });
</script>