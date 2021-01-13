<?php
if (isset($_SESSION['gradeExist'])) {
    redirect('excel_import/upload_view');
}

?>


<div style="margin-bottom: 40px"></div>
<div class="container">

    <div class="bg-warning p-3 m-3">
        <h1 align="center">Batch Account Registration</h1>
        <hr>
        <h2 align="center">For <u>Senior High school</u> faculty members</h2>
        <div style="margin-bottom:20px"></div>



        <?php $form = base_url() . 'RegisterBatch/facultyBatchRegisterSeniorHigh' ?>
        <?php
        $this->load->model('Main_model');
        $this->Main_model->alertSuccess('facultyBatch', 'Faculty registration success');
        ?>
        <form action="<?= $form ?>" method="post" id="import_form" enctype="multipart/form-data">
            <?php
            $this->load->model("Main_model");
            $this->Main_model->alertDanger('facultyDuplicate', 'Faculty data already existing!');
            ?>

            <label style="font-size:30px;font-weight:bold;">Enter Excel File</label><br>

            <?php
            $this->load->model('Main_model');
            $this->Main_model->alertDanger('duplicateDataBatch', "The Data in the excel file has duplicates at the system's database");
            ?>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="file" required accept=".xls, .xlsx">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <br /><br>
            <input type="submit" name="import" value="Import" class="btn btn-info col-md-12" />
        </form>
    </div>
    <?php $back = base_url() . "manage_user_accounts/viewSeniorHighSchoolFaculty" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>