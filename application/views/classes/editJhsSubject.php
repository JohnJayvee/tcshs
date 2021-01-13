<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Manage Jhs Subjects</h1>
        <hr width="40%" style="margin:5px 5px">
        <h2>Edit Subject name</h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <form action="" method="post" class="bg-info p-3">
        <div class="form-group">
            <label style="font-size:30px">Edit subject name</label>
            <input type="text" name="subjectName" id="" class="form-control" value="<?= $subjectName ?>">
        </div>
        <?php $back = base_url() . "classes/add_subject/$yearLevelId" ?>
        <div class="row">
            <div class="col-md-6"> 
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit"  name="submit" class="btn btn-success col-md-12"><i class="fas fa-check"></i>&nbsp; Update</button>
            </div>
        </div>
    </form>
</div>