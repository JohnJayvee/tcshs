<div class="container">
    <div style='margin-bottom: 40px;'></div>

    <h1 align="center" class="bg-warning p-3">Manage faculty accounts</h1>

    <!-- notification -->
    <?php $this->Main_model->alertSuccess('facUpdate', "Faculty Account updated"); ?>
    <div style="margin-bottom:15px"></div>
    <div class="row">
        <?php
        $juniorHigh = base_url() . "manage_user_accounts/viewJuniorHighSchoolFaculty";
        $seniorHigh  = base_url() . "manage_user_accounts/viewSeniorHighSchoolFaculty";
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