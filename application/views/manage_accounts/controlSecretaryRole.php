<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner("Manage faculty accounts", "Faculty acount control") ?>

    <div class="col-md-12 bg-info p-4">
        <p style="font-size:30px;font-weight:bold;"><?= $message ?></p><br>

        <?php 
            $back = base_url() . "manage_user_accounts/manage_account";
            $confirm = base_url() . "manage_user_accounts/controlSecretaryRole?confirm=1";
        ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; back</button></a>
        &nbsp;
        <a href="<?= $confirm ?>"><button class="btn btn-success"><i class="fas fa-check"></i>&nbsp; Confirm</button></a>
    </div>
</div>