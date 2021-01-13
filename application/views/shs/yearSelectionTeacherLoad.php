
<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3"> 
        <h1>Manage Teacher Load</h1>
        <hr width="50%" style="margin:5px 5px">
        <span style="font-size:20;"><b><?= $strandName; ?></b></span>
    </center>

    <div style="margin-bottom:20px"></div>
    
    <!-- navigations -->
    <?php
     $managePersonalLoad = base_url() . 'classes/viewPersonalTeacherLoad';
     $viewTeacherLoads = base_url() . 'classes/viewOtherTeacherLoad';
    ?>
    

    <?php 
        $this->load->model('Main_model');
        $this->Main_model->alertSuccess('teacherLoad', 'Teacher load added successfully');
        $this->Main_model->alertWarning('noStudents', 'There are no enrolled students for that particular section');
    ?>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($yearLevelTable->result() as $row) {?>
                <!-- remove empty year levels -->
                <?php 
                    // determine if there is a student in that particular year level
                    $studentProfileTable = $this->Main_model->get_where('sh_student', 'year_level_id', $row->school_grade_id);
                    if (count($studentProfileTable->result_array()) == 0) {
                        continue;
                    }
                ?>

            
                <tr>
                    <td><?= $row->name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'shs/sectionSelectionTeacherLoad?yearLevelId=' . $row->school_grade_id . "&strandId=$strandId" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/selectStrandTeacherLoad" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>