<div class="container">
  <div class="jumbotron">
    <h1 align="center">Manage academic year</h1>
    <br>
    <?= validation_errors("<p class='alert alert-danger'>"); ?>
    <form action="" method="post">
        <div class="form-group">
            <label>Enter academic year</label>
            <?php 
                if ($academicYear == 0) {?>
                    <!-- hindi pa na seset -->
                    <input type="text" name="academicYear" class="form-control col-md-12" placeholder="Enter Academic year Ex. 2020 - 2021">
                <?php }else{ ?>
                    <!-- na set na -->
                    <input type="text" name="academicYear" class="form-control col-md-12" value="<?= $academicYear ?>">
                <?php } ?>
            
            
        </div>
        <button class="btn btn-primary col-md-12" type="submit">Submit</button>
    </form><div style="margin-top:-10px"></div>
    <?php $back = base_url() . "/manage_user_accounts/dashboard" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
  </div>
</div>