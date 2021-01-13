<div class="container">
    <div style='margin-bottom: 40px;'></div>

    <center class="bg-warning p-3">
        <h1>Manage section advisers</h1>
        <hr style="margin:5px 5px" width="50%">
        <h2>Select year level</h2>
    </center>

    <!-- notification -->
    <?php $this->Main_model->alertSuccess('facUpdate', "Faculty Account updated"); ?>
    <div style="margin-bottom:15px"></div>
    <div class="row">
        <?php
        $juniorHigh = base_url() . "manage_user_accounts/manageSectionAdvisers/1";
        $seniorHigh  = base_url() . "shs/manageShsAdviser";
        ?>

        <!-- left -->
        <div class="col-md-6">
            <a href="<?= $juniorHigh ?>" style="white-space:normal !important; word-wrap:break-word;"><button class="btn btn-outline-primary col-md-12" style="font-size: 60;"><b>Junior</b> <br> high school</button></a>
        </div>
        <div class="col-md-6">
            <a href="<?= $seniorHigh ?>" style="white-space:normal !important; word-wrap:break-word;"><button class="btn btn-outline-success col-md-12" style="font-size: 60;"><b>Senior</b> <br>high school</button></a>
        </div>
    </div>

</div><!--  container -->