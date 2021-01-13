<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View classes', "$yearLevelName | $strandName | $sectionName") ?>

    <div style="margin-bottom:10px"></div>
    <button class="btn btn-primary col-md-12" id="ddBtn">Filter students &nbsp;<i class="fas fa-angle-down"></i></button>
    <div style="margin-bottom:5px"></div>
    <div class="col-md-12 bg-primary p-4" id="ddDiv">
        <div class="form-group">
            <label style="font-size: 20px">Filter by subject:</label>
            <select name="subjectDd" id="subjectDd" class="form-control">
                <option value="">Select subject</option>
                <?php foreach ($subjectTable->result() as $row) { ?>
                    <option value="<?= $row->subject_id ?>"><?= $row->subject_name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div style="margin-bottom:25px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Subject</th>
                    <th>Student</th>
                    <th>Schedule</th>
                    <th>Quarter</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shClassTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->getFullName('faculty', 'account_id', $row->sh_faculty_id) ?></td>
                    <td><?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) ?></td>
                    <td><?= $this->Main_model->getFullName('sh_student', 'account_id', $row->sh_student_id) ?></td>
                    <td><?= $row->schedule ?></td>
                    <td><?= $row->quarter ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/manageClassesSection?strandId=$strandId&yearLevel=$yearLevelId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<?php
    $filterStudentsBySubject = base_url() . "shs/filterClassWithSubject";
?>
<script>
    $(document).ready(function(){
        //toggle filter dropdown
        $('#ddDiv').hide();

        $('#ddBtn').click(function(){
            $('#ddDiv').fadeToggle('slow');
        });

        
        
        $("#subjectDd").on('change', function(){
            
            var subjectaydi = $("#subjectDd").val();
            
           
            //change the tables.
            $.post("<?= $filterStudentsBySubject ?>",
            {

                subjectId: subjectaydi,
                strandId: <?= $strandId ?>,
                yearLevel: <?= $yearLevelId ?>,
                sectiionId: <?= $sectionId ?>
            },function(data){
                $('tbody').html(data);
            }); 
        }); //change  
    });
</script>