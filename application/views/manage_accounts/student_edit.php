

<div class="container">

<div style="margin-bottom: 20px"></div>

    <!-- start code on the left side of the page -->
    <?php $this->Main_model->banner('View junior high school accounts', "Edit students"); ?>
    <div class="col-md-12">
        <?php echo form_open_multipart('manage_user/student_account_edit/' . $account_id . "?yearLevelId=$school_grade_id&sectionId=$section_id");?>
    <!-- header title -->
    
    
    
    <!-- Validation Errors here -->
    <div class="form-group">
        <?= validation_errors("<p class='alert alert-danger'>"); ?>
    </div>


    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="firstname" class="form-control" autocomplete="off" placeholder="First name" value="<?= $firstname ?>" required>
    </div>

    <div class="form-group">
        <label>Middle Name</label>
        <input type="text" name="middlename" class="form-control" autocomplete="off" placeholder="Middle Name" value="<?= $middlename ?>" required>
    </div>

    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="lastname" class="form-control" autocomplete="off" placeholder="Last Name" value="<?= $lastname ?>" required>
    </div>
    <?php $back = base_url() . "manage_user/view_student_account?yearLevelId=$school_grade_id&sectionId=$section_id" ?>
    <div class="row">
        <div class="col-md-6"><a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a></div>
        <div class="col-md-6"><button type="submit" name="submit" class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Update</button></div>
    </div>
</form>

</div>




