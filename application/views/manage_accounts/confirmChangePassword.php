


<div class="container p-3 m-3 bg-warning">
    
    <h1>Reset account's Password</h1>
    <p style="font-size: 40px;">Teacher's Name: <strong style="color: red;"><?= $teacherName ?></strong></p>
    <?php $cancel = base_url() . 'manage_user_accounts/secManageAccount' ?>
    <div style="margin-bottom: 30px;"></div>

    <?php 
    
    $back = base_url() . 'manage_user_accounts/secManageAccount';
    $reset = base_url() . 'manage_user_accounts/resetPassword?confirm=' . $facultyId;
    ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-2">Back</button></a> &nbsp;
    <a href="<?= $reset ?>"><button class="btn btn-danger col-md-2">Reset</button></a>
    
   
    
</div>