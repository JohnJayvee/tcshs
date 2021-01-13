<?php 
    if (isset($_SESSION['numberMore'])) {
        echo "<script>alert('Number is MORE than 11 numbers');</script>";
        unset($_SESSION['numberMore']);
    }

    if (isset($_SESSION['numberLess'])) {
        echo "<script>alert('Number is LESS than 11 numbers');</script>";
        unset($_SESSION['numberLess']);
    }
?>

<?php $this->load->model('Main_model'); ?>
<div class="container">
    <div class="row bg-primary m-3 p-3">
    <div class="col-sm-12">
        <h1 align="center">Update mobile number</h1>
        <h3 align="center"><?= ucfirst($parentFullName) ?></h3>
        <div style="margin-botom:10px"></div>&nbsp;
        
            
           
            <?php $form = base_url() ."parent_student/phoneAuthenticator?newNumber=$newNumber"; ?>
                <form action="<?= $form ?>" method="post">
                    <div class="form-group">
                        Enter Verification code:
                        <input type="number"  name="code" class="form-control" autofocus="on">
                    </div>
           
                <button type="submit" name="submit" class="btn btn-success col-md-12">Update</button>
            </form>
        
    </div>
    </div>
</div>


