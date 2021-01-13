<div class="container">
    <div class="bg-warning p-4 m-4 col-md-12">
        <h1 style="text-decoration:underline" class="text-danger">Account Deletion</h1>
        <div style="margin-bottom:10px"></div>
        <p style="font-size:20px;">Are you sure you want to delete faculty account: <strong><?= $facultyName ?></strong></p>

        <?php
        $back = base_url() . "manage_user_accounts/update_faculty/$facultyId";
        $delete = base_url() . "manage_user_accounts/sureDeletion?confirm=$facultyId";
        ?>
        <div style="margin-bottom:40px"></div>
        <div class="row">
            <div class="col-md-4">
                <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-4">
                <a href="<?= $delete ?>"><button class="btn btn-danger col-md-12"><i class="fas fa-trash"></i>&nbsp; Delete</button></a>
            </div>
        </div>
    </div>
</div>