<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Strand transfer', "Transfer student's strand"); ?>
    <div style="margin-bottom:20px"></div>
    <div class="form-group">
        <h3>Student name: <?= $studentName ?></h3>
    </div>
    <?php $form = base_url() . "shs/transferStudentStrand?accountId=$studentId" ?>
    <form action="<?= $form ?>" method="post">
        <div class="form-group">
            <label for="">Track</label>
            <select name="trackId" id="trackDd" class="form-control">
                <option value="<?= $studentTable[0]['track_id'] ?>"><?= $this->Main_model->getTrackName($studentTable[0]['track_id']) ?></option>
                <?php foreach ($trackTable->result() as $row) {
                    //remove current track in options
                    if ($studentTable[0]['track_id'] == $row->track_id) {
                        continue;
                    }
                    ?>
                    <option value="<?= $row->track_id ?>"><?= $this->Main_model->getTrackName($row->track_id) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Strand</label>
            <select name="strandId" id="strandDd" class="form-control">
                <option value="<?= $studentTable[0]['strand_id'] ?>"><?= $this->Main_model->getTrackName($studentTable[0]['strand_id']) ?></option>
                <?php foreach ($strandTable->result() as $row) { 
                    //remove current track in options
                    if ($studentTable[0]['strand_id'] == $row->strand_id) {
                        continue;
                    }
                    ?>
                    <option value="<?= $row->strand_id ?>"><?= $this->Main_model->getStrandName($row->strand_id) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="">Strand</label>
            <select name="strandId" id="strandDd" class="form-control">
                <option value="<?= $studentTable[0]['strand_id'] ?>"><?= $this->Main_model->getTrackName($studentTable[0]['strand_id']) ?></option>
                <?php foreach ($strandTable->result() as $row) { 
                    //remove current track in options
                    if ($studentTable[0]['strand_id'] == $row->strand_id) {
                        continue;
                    }
                    ?>
                    <option value="<?= $row->strand_id ?>"><?= $this->Main_model->getStrandName($row->strand_id) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="">Section</label>
            <select name="sectionId" id="sectionDd" class="form-control">
                <option value="">Select section</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $back = base_url() . "shs/strandTransfer" ?>
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>    
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary col-md-12">Transfer&nbsp;<i class="fas fa-arrow-right"></i> </button>
            </div>
        </div>
    </form>
</div><!--  container -->
<?php $strandAjax = base_url() . "shs/transferStudentAjax" ?>
<script>
    $(document).ready(function(){
        $("#trackDd").change(function(){
            var track_id = $("#trackDd").val();
            
            $.post("<?= $strandAjax ?>", {trackId: track_id}, function(data){
                $("#strandDd").html(data);
            });
        });
    });
</script>