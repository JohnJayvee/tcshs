<?php 
    if (isset($_SESSION['noCheckMarks'])) {
       echo "<script>";
       echo "alert('No changes were made');";
       echo "</script>";
       unset($_SESSION['noCheckMarks']);
    }
?>

<div class="container">
    <div style='margin-bottom: 20px;'></div>

    <center class="bg-warning p-3">
        <h1>Manage faculty accounts</h1>
        <hr width="50%" style="margin-top:5px;margin-bottom:5px;">
        <h3>Senior Highschool Teachers</h3>
    </center>

    <div style="margin-bottom:15px"></div>

    <?php
    $registerBatch = base_url() . "manage_user_accounts/seniorHighFacultyBatchRegister";
    $singleRegister = base_url() . "manage_user_accounts/register_faculty/2";
    ?>
    <div class="row">
        <div class="col-md-6">
            <a href="<?= $singleRegister ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-user"></i> &nbsp; Register Faculty Member</button></a>
        </div>
        <div class="col-md-6">
            <a href="<?= $registerBatch ?>"><button class="btn btn-dark col-md-12"><i class="fas fa-users"></i> &nbsp; Batch Register Faculty Member</button></a>
        </div>
    </div>

    <div style="margin-bottom:30px"></div>

    <!-- notification -->
    <?php $this->Main_model->alertDanger('fakDeleted', "Faculty account Deleted"); ?>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($shsFacultyCredentials->result() as $row) { ?>

                    <!-- remove the principal -->
                    <?php
                    if ($row->administration_id == 4) {
                        continue;
                    }
                    ?>

                    <tr>  
                    <td><?= $row->account_id; ?></td>
                        <td><?= $this->Main_model->getFirstName('faculty', 'account_id', $row->account_id); ?></td>
                        <td><?= $this->Main_model->getMiddleName('faculty', 'account_id', $row->account_id); ?></td>
                        <td><?= $this->Main_model->getLastName('faculty', 'account_id', $row->account_id); ?></td>
                        <td align='center'>
                            <?php
                            $resetPass = base_url()  . "manage_user_accounts/resetPassword?confirm=" . $row->account_id;
                            $update = base_url() . "manage_user_accounts/update_faculty/" . $row->account_id;
                            ?>
                            <a href="<?= $update ?>"><button class="btn btn-primary"> <i class="fas fa-edit"></i> &nbsp; Edit</button></a>
                            <a href="<?= $resetPass ?>"><button class="btn btn-warning"><i class="fas fa-key"></i> &nbsp; Reset Password</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
     $transfer = base_url() . "shs/transferTeacherShsToJhs";
     $back = base_url() . "Manage_user_accounts/secManageAccount" ;
    ?>

    <div class="row">
        <div class="col-md-6">
            <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
        </div>
        <div class="col-md-6">
            <a href="<?= $transfer ?>"><button class="btn btn-dark col-md-12"><i class="fas fa-exchange-alt"></i>&nbsp; Transfer Teacher to Junior Highschool </button></a>
        </div>
    </div>

</div><!--  container -->