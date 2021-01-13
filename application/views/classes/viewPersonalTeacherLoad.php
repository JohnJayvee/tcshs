<?php $this->load->model("Main_model") ?>
<div class="container">
    <div style="margin-bottom: 20px"></div>

    <center class="bg-warning p-3">
        <h1>Manage personal teacher load</h1>
        <hr width="50%" style="margin: 5px 5px">
        <h3><?= ucfirst($teacherName) ?></h3>
    </center>
    <div style="margin-bottom: 20px"></div>

    <!-- drop down navigations -->
    <button class="btn btn-primary col-md-12" id="dropDownBtn">Filter teacher load &nbsp; <i class="fas fa-angle-down"></i></button>
    <div style="margin-bottom:10px"></div>
    <div class="col-md-12 bg-primary p-3" id="dropDownMenu">
        <div class="form-group">
            <label for="">Filter student year level:</label>
            <select name="" id="yearLevel" class="form-control">
                <option value="">Select year level</option>
                <?php foreach ($yearLevelTable->result() as $row) { 
                    //remove all of the empty year levels
                    $studentTable = $this->Main_model->get_where('student_profile', 'school_grade_id',$row->school_grade_id);
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

    <!-- notificaiton -->
    <?php $this->Main_model->alertSuccess('deleteSuccess', "Teacher load delete successfully"); ?>

    <!-- here is the table -->
    <div class="table table-responsive">
        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Year level</th>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($personalTeacherLoadTable->result() as $row) { ?>
                <tr>
                    <!-- subject -->
                    <td>
                        <?= $this->Main_model->getSubjectNameFromId($row->subject_id); ?>
                    </td>
                    <td><?= $row->schedule ?></td>
                    <td><?= $this->Main_model->getYearLevelNameFromId($row->grade_level) ?></td>
                    <td><?= $this->Main_model->getSectionNameFromId($row->section_id) ?></td>
                    <td>
                        <?php
                            $edit = base_url() . "classes/edit_teacher_load/" . $row->teacher_load_id;
                            $delete = base_url() . "classes/delete_teacher_load/" . $row->teacher_load_id;
                       ?>
                        <a href="<?= $edit ?>"><button class="btn btn-primary col-md-5"><i class="fas fa-edit"></i> &nbsp; Edit</button></a>
                        <a href="<?= $delete ?>"><button class="btn btn-danger col-md-5"><i class="fas fa-trash"></i> &nbsp; Delete</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div> <div style="margin-bottom:10px"></div>&nbsp;
    <?php $back = base_url() . 'classes/yearSelectionTeacherLoad' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>
<?php
    $yearLevelUrl = base_url() . 'classes/getSectionFromYearLevel/';
    $appendTableWithYearLevelUrl = base_url() . "classes/appendTableWithYearLevelPersonalLoad";
    $changeTableWithSectionIdUrl = base_url() . "classes/changeTableWithSectionIdPersonalLoad";
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