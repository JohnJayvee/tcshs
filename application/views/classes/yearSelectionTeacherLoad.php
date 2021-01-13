
<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3"> 
        <h1>Manage Teacher Load</h1>
        <hr width="50%" style="margin:5px 5px">
        <span style="font-size:20;"><b><?= $this->Main_model->getFullname('faculty', 'account_id', $_SESSION['faculty_account_id']); ?></b></span>
    </center>

    <div style="margin-bottom:20px"></div>
    
    <!-- navigations -->
    <?php
     $managePersonalLoad = base_url() . 'classes/viewPersonalTeacherLoad';
     $viewTeacherLoads = base_url() . 'classes/viewOtherTeacherLoad';
    ?>
    <div class="row">
        <div class="col-md-6">
            <a href="<?= $managePersonalLoad ?>"><button class="btn btn-outline-primary col-md-12"><i class="fas fa-user"></i> &nbsp;Mange personal Load</button></a>
        </div>
       <div class="col-md-6">
       <a href="<?= $viewTeacherLoads ?>"><button class="btn btn-outline-secondary col-md-12"><i class="fab fa-apple"></i> &nbsp;View teacher Loads</button></a>
       </div>
    </div>
    <div style="margin-bottom:20px"></div>&nbsp;

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
                    $studentProfileTable = $this->Main_model->get_where('student_profile', 'school_grade_id', $row->school_grade_id);
                    if (count($studentProfileTable->result_array()) == 0) {
                        continue;
                    }
                ?>

            
                <tr>
                    <td><?= $row->name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'classes/sectionSelectionTeacherLoad?yearLevelId=' . $row->school_grade_id ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>