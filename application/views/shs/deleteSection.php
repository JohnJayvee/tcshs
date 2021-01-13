<div class="container">
    <div style="margin-bottom:10px"></div>
    <?php $this->Main_model->banner("Year and Section management", 'Delete Section'); ?>
    <div style="margin-bottom:10px"></div>
    <span style="font-size: 30px">Are you sure you want to delete section: <b><?= $sectionName ?></b>?</span><br>
    <div style="margin-bottom:20px"></div>
    <?php 
        $back = base_url() . "shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId";
        $confirm = base_url() . "shs/deleteSection?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId&confirm=1";
    ?>

    <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
    &nbsp;
    <a href="<?= $confirm ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Confirm</button></a>
</div>