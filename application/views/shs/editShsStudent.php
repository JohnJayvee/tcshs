<div class="container">
    <?php $this->Main_model->banner("Edit user accounts", $studentFullname); ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="">First Name</label>
            <input type="text" name="firstname" id="" value="<?= $slice['firstname'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">Middle Name</label>
            <input type="text" name="middlename" id="" value="<?= $slice['middlename'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">Last Name</label>
            <input type="text" name="lastname" id="" value="<?= $slice['lastname'] ?>" class="form-control" required>
        </div>
        <?php $back = base_url() . "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId" ?>
        <div class="row">
            <div class="col-md-6">
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Edit</button>
            </div>
        </div>
    </form>
</div>