<div class="container">
    <?php $this->Main_model->banner("Create custom class", "Configure class"); ?>

    <form action="" method="post">
    <?= validation_errors("<p class='alert alert-warning'>") ?>
        <div id="firstForm">
            <div class="form-group">
                <label>Enter class name:</label>
                <input type="text" name="className" id="" class="form-control" autocomplete="off" placeholder="Enter class name">
            </div>
            <div class="form-group">
                <label>Select strand</label>
                <select name="strandId" id="strandDd" class="form-control">
                    <option value="">Select strand</option>
                    <?php foreach ($strandTable->result() as $row) { ?>
                        <option value="<?= $row->strand_id ?>"><?= $this->Main_model->getStrandName($row->strand_id) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Select subject</label>
                <select name="subjectId" id="subjectDd" class="form-control">
                    <option value="">Select subject</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select semester</label>
                <select name="semester" class="form-control">
                    <option value="">Select semester</option>
                    <option value="1">1st semester</option>
                    <option value="2">2nd semester</option>
                </select>
            </div>
        </div>
        <div style="margin-bottom:20px"></div>
        <div class="row">
            <div class="col-md-6">
                <?php $back = base_url() . "shs/viewPsYearLevel" ?>
                <a href="<?= $back ?>">
                    <button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
                </a>
            </div>
            <div class="col-md-6">
                <button type="submit" id="firstButton" class="btn btn-dark col-md-12">Proceed &nbsp; <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </form>
</div>
<?php $loadSubjectsOfStrand = base_url() . "shs/loadSubjectsOfStrand" ?>
<script>
    $(document).ready(function(){
        $("#strandDd").change(function(){
            var strand_id = $("#strandDd").val();
            $.post("<?= $loadSubjectsOfStrand ?>", {strandId: strand_id}, function(data){
                $("#subjectDd").html(data);
            });
        });
    });
</script>