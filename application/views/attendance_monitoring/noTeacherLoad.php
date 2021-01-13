<div class="container">
    <div class="col-md-12 bg-warning p-3">
        <h1>You must first input your teacher load</h1>
        <div style="margin-bottom:20px"></div>
        <?php
            $back = base_url() . "manage_user_accounts/dashboard";
            $manageTeacherLoad = base_url() . "classes/yearSelectionTeacherLoad";
        ?>
        <div class="row m-1">
            <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; back</button></a>
            <div style="margin-right:20px"></div>
            <a href="<?= $manageTeacherLoad ?>"><button class="btn btn-success"><i class="fas fa-plus"></i>&nbsp; Manage teacher load</button></a>
        </div>
    </div>
</div>