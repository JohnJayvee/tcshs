<!-- notifications -->
<?php $this->Main_model->alertPromt('You need to select a student', "noCheckedStudents"); ?>
<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner("Manage accounts", "Student aquisition for your section advisee"); ?>
    <button class="btn btn-info col-md-12" id="filterBtn">Filter students</button>
    <div style="margin-bottom:10px"></div>
    <div class="bg-info p-3" id="filterDd">
        <h4>Filter students by their old section</h4>
        <select name="" id="selectBox" class="form-control">
            <option value="">Select Section</option>
            <?php foreach ($sectionArray as $row) { ?>
                <option value="<?= $row ?>"><?= $this->Main_model->getSectionNameFromId($row) ?></option>
            <?php } ?>
        </select>
    </div>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
    <form action="" method="post">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Student name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody id="tbody">
            <?php foreach ($ssrTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->getFullNameWithId('student_profile', 'account_id', $row->student_profile_id); ?></td>
                    <td>
                        <input type="checkbox" name="aquiredStudents[]" value="<?= $row->student_profile_id ?>">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/dashboard" ?>
        <div class="row">
            <div class="col-md-6">
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-primary col-md-12">Proceed</button>
            </div>
        </div>
    </form>
</div>
<?php $realTimeUrl = base_url() . "manage_user_accounts/studentAquisitionRealTime" ?>
<script>
    $(document).ready(function(){
        $("#filterDd").hide();

        //button click perform dropdown
        $("#filterBtn").click(function(){
            $("#filterDd").fadeToggle(1000);
        });

        $("#selectBox").change(function(){
            var sectionId = $("#selectBox").val();
            
            $.post("<?= $realTimeUrl ?>", {
                sectionId : sectionId,
                yearLevelId : <?= $yearLevelId ?>
            },function(data){
                $("#tbody").html(data);
            });
        });
    });
</script>