<div class="container">
    <div style="margin-bottom:10px"></div>
    <?php $this->Main_model->banner('Year and Section management', "$yearLevelName | $strandName"); ?>
    <div style="margin-bottom:10px"></div>
    <div class="col-md-12 bg-info p-3 rounded-top">
    <?php $form = base_url() . "shs/editShsSection?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId" ?>
        <form action="<?= $form ?>" method="post">
            <div class="form-group">
                <label style="font-size:20px">Update section</label>
                <input type="text" name="newSection" value="<?= $sectionName ?>" required autocomplete="off" class="form-control" required>
            </div>
            <div class="row">
                <?php $back = base_url() . "shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId" ?>
                <div class="col-md-4">
                    <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success col-md-12" name="submit">Update</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-dark col-md-12" id="viewSection"><i class="fas fa-eye"></i>&nbsp; View</button>
                </div>
            </div>
        </form>
    </div>
    <div style="margin-bottom:10px"></div>
    </div>
</div>