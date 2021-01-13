<div class="container">
    <?php $this->Main_model->banner('View personal classes', 'Select class') ?>
    <div style="margin-bottom:-15px"></div>
    <button class="btn btn-dark col-md-12" style="font-size: 15px" id="filterBtn">Filter students &nbsp; <i class="fas fa-angle-down"></i></button>
    <div style="margin-bottom:5px"></div>
    
    <!-- drop down div -->
    <div class="col-md-12 bg-dark p-4" id="divDd">
        <div class="form-group:">
            <label style="font-size: 20px;color:white;">Filter by subject</label>
            <select name="" id="subjectDd" class="form-control">
                <option value="">Select subject</option>
                <?php foreach ($shTeacherLoadTable->result() as $row) { ?>
                    <option value="<?= $row->sh_subject_id ?>"><?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:20px"></div>

<div class="row col-md-12" id="cardBody">

        <div class="m-1">
            <div class="card" style="width: 18rem;">
                <div style="display: flex; flex-direction: column;" class="card-body d-flex flex-column">
                    <div style="width: 100%;height:150px">
                        <h5 class="card-title">Create custom class</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Select students that will be in your custom class</h6>
                    </div>
                    <?php $custom = base_url() . "shs/createCustomClass"; ?>
                    <a href="<?= $custom ?>"><button style="margin-top: auto;" class="btn btn-success col-md-12"><i class="fas fa-plus"></i>&nbsp; Create</button></a>
                </div>
            </div>
        </div>
    
    <!-- cards -->
    
    <?php foreach ($shTeacherLoadTable->result() as $row) { ?>
        <div class="m-1">
            <div class="card" style="width: 18rem; height:auto; ">
                <div class="card-body">
                    <div style="width:100%;height:150px">
                        <h5 class="card-title"><?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $this->Main_model->getShSectionName($row->sh_section_id) ?></h6>
                        <p class="card-text"><?= $this->Main_model->getYearLevelNameFromId($row->year_level) ?> | <?= $this->Main_model->getStrandName($row->strand_id) ?></p>
                    </div>
                    <?php $enter = base_url() . "shs/viewPesonalSubjects?subjectId=$row->sh_subject_id&sectionId=$row->sh_section_id&yearLevel=$row->year_level&strandId=$row->strand_id"; ?>
                    <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <hr>
    <!-- special class here -->
    <div class="row col-md-12">
        <!-- custom class table -->
        <?php foreach ($customClassTable->result() as $row) { ?>
            <div class="m-1">
                <div class="card" style="width: 18rem; height:auto;">
                <h5 align="center" class="bg-dark p-1" style="color:white;">Special class</h5>
                    <div class="card-body">
                        <div style="width:100%;height:150px">
                            <h5 class="card-title"><?= ucfirst($row->name) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) ?></h6>
                        </div>
                        <?php $enter = base_url() . "shs/viewSpecialClass?customClassId=$row->id"; ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div style="margin-bottom:30px"></div>
<?php $back = base_url() . "shs/manageClassesStrand" ?>
<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<?php $sortBySubjectsPs = base_url() . "shs/sortBySubjectsPs" ?>

<script>
    $(document).ready(function(){
        $('#divDd').hide();

        $("#filterBtn").click(function(){
            $('#divDd').fadeToggle('slow');
        });

        $("#subjectDd").change(function(){
            var subject_id = $("#subjectDd").val();
            
            $.post("<?= $sortBySubjectsPs ?>",
            {

                subjectId: subject_id,
            },function(data){
                $('#cardBody').html(data);
            });
        });  
    });
</script>