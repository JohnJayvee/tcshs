<div class="container">
    <div style="margin-bottom:20px"></div>
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
                <?php foreach ($teacherLoadTable->result() as $row) { ?>
                    <option value="<?= $row->subject_id ?>"><?= $this->Main_model->getSubjectNameFromId($row->subject_id) ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div style="margin-bottom:20px"></div>
    
    <!-- cards -->
    <div class="row col-md-12" id="cardBody">
    <?php foreach ($teacherLoadTable->result() as $row) { ?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $this->Main_model->getSubjectNameFromId($row->subject_id) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $this->Main_model->getSectionNameWithId($row->section_id) ?> | <?= $this->Main_model->getYearLevelNameFromId($row->grade_level) ?></h6>
				<br>
                <?php $enter = base_url() . "classes/viewPesonalSubjects?subjectId=$row->subject_id&sectionId=$row->section_id&yearLevel=$row->grade_level"; ?>
                <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>Enter</button></a>
            </div>
        </div><div style="margin-right: 15px"></div>
    <?php } ?>
    </div>
    <div style="margin-bottom:30px"></div>
<?php $back = base_url() . "classes/selectYearSubjectClasses" ?>
<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<?php $sortBySubjectsPs = base_url() . "classes/sortBySubjectsPs" ?>

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