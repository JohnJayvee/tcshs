<div class="container">
    <div style="margin-bottom:80px;"></div>
    <h1>Edit Year Name</h1><br>
    <?php $form = base_url() . 'classes/editYearLevel/' . $schoolGradeId ?>
    <form action="<?= $form ?>" method="post" autocomplete="off">
        <div class="form-group">
             <label>Year Name</label>
            <input type="text" class="form-control" name="gradeName" value="<?= $name ?>" >
        </div>
        <button type="submit" class="btn btn-primary col-md-12">Update</button>    
    </form>
    <?php $delete = base_url() . 'classes/DeleteYearGrade/' . $schoolGradeId; ?>
    <?php $cancel = base_url() . 'classes/selectYearLevel' ?>
    <div class="row p-3 m-2">
        <div class="col-md-6 pull-left">
            <a href="<?= $cancel ?>"><button class="btn btn-secondary col-md-12">Cancel</button></a>
        </div>
        <div class="col-md-6 pull-right">
            <a href="<?= $delete ?>"><button class="btn btn-danger col-md-12">Delete</button></a>
        </div>
    </div>

    

</div>