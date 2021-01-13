<?php $this->load->model("Main_model") ?>
<div class="container">
    <div style="margin-bottom: 20px"></div>

    <center class="bg-warning p-3">
        <h1>Manage teacher load</h1>
        <hr width="60%">
        <h3>View other teacher load</h3>
    </center>
    <div style="margin-bottom: 10px"></div>
    <button class="btn btn-primary col-md-12" id="dropDownBtn">Filter teacher load &nbsp; <i class="fas fa-angle-down"></i></button>
    <div style="margin-bottom:10px"></div>
    <div class="col-md-12 bg-primary p-3" id="dropDownMenu">
        <div class="form-group">
            <label for="">Filter student year level:</label>
            <select name="" id="yearLevel" class="form-control">
                <option value="">Select year level</option>
                <?php foreach ($yearLevelTable->result() as $row) { 
                    //remove all of the empty year levels
                    $studentTable = $this->Main_model->get_where('sh_student', 'year_level_id',$row->school_grade_id);
                    if (count($studentTable->result_array()) == 0) {
                        continue;
                    }?>
                    <option value="<?= $row->school_grade_id ?>"><?= $row->name ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="">Filter student Section:</label>
            <select name="" id="sectionId" class="form-control">
                <option value="">Select student section</option>
            </select>
        </div>
    </div>
    <div style="margin-bottom:20px"></div>
    <!-- here is the table -->
    <div class="table table-responsive">
        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
                <tr>
                    <th>teacher</th>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Year level</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teacherLoadTable->result() as $row) { ?>
                    <?php
                    //exclude your teacher load algorithm
                    if ($row->faculty_account_id == $_SESSION['faculty_account_id']) {
                        continue;
                    }
                    ?>

                    <tr>
                        <!-- teacher -->
                        <td><?= $this->Main_model->facultyRepository($row->faculty_account_id); ?></td>
                        <!-- subject -->
                        <td>
                            <?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id); ?>
                        </td>
                        <td><?= $row->schedule ?></td>
                        <td><?= $this->Main_model->getYearLevelNameFromId($row->year_level) ?></td>
                        <td><?= $this->Main_model->getShSectionName($row->sh_section_id) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom:10px"></div>&nbsp;
    <?php $back = base_url() . 'shs/selectStrandTeacherLoad' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<?php
    $yearLevelUrl = base_url() . 'shs/getSectionFromYearLevel/';
    $appendTableWithYearLevelUrl = base_url() . "shs/appendTableWithYearLevel";
    $changeTableWithSectionIdUrl = base_url() . "shs/changeTableWithSectionId";
?>
<script>
    $(document).ready(function(){
        //toggle dropdown filter
        $("#dropDownMenu").hide();
        $("#dropDownBtn").click(function(){
            $("#dropDownMenu").fadeToggle("slow");
        });

        //get and send ajax request
        $("#yearLevel").change(function(){
            var yearLevelId = $("#yearLevel").val();
            //change selection box
            $.post(
                "<?= $yearLevelUrl ?>",
                {
                    yearLevelId: yearLevelId
                },function(data){
                    $("#sectionId").html(data);
                }
            ); 

            //change table with year level
            $.post(
                "<?= $appendTableWithYearLevelUrl ?>",
                {
                    yearLevelId: yearLevelId
                },function(data){
                    $("tbody").html(data);
                }
            );
        });

        $("#sectionId").change(function(){
            var secId = $('#sectionId').val();
            $.post(
                "<?= $changeTableWithSectionIdUrl ?>",
                { sectionId: secId },
                function(data){
                    $("tbody").html(data);
                }
            );
        });
    });
</script>