<div class="container">
    <div class="col-md-12 bg-primary p-3">
        <h1>Do you also want to register this account as a parent?</h1>
        <div style="margin-bottom:40px"></div>
        <?php 
            if ($_SESSION['credentials_id'] == 5) {
                //secretary siya
                $back = base_url() . "manage_user_accounts/secretaryView";
            }elseif($_SESSION['credentials_id'] == 4){
                //principal siya
                $back = base_url() . "manage_user_accounts/dashboard";
            }else{
                //teacher siya
                $back = base_url() . "manage_user_accounts/dashboard";
            }

            $proceed = base_url() . "manage_user_accounts/teacherRegisterAsParent/1";
        ?>

        <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
        <span style="margig-right:20px"></span>&nbsp;
        <a href="<?= $proceed ?>"><button class="btn btn-success"><i class="fas fa-check"></i>&nbsp; Proceed</button></a>
    </div>
</div>