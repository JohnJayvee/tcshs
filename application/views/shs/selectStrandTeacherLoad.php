
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
     $managePersonalLoad = base_url() . 'shs/viewPersonalTeacherLoad';
     $viewTeacherLoads = base_url() . 'shs/viewOtherTeacherLoad';
    ?>
    <div class="row">
        <div class="col-md-6">
            <a href="<?= $managePersonalLoad ?>"><button class="btn btn-outline-primary col-md-12"><i class="fas fa-user"></i> &nbsp;Mange personal Load</button></a>
        </div>
       <div class="col-md-6">
       <a href="<?= $viewTeacherLoads ?>"><button class="btn btn-outline-secondary col-md-12"><i class="fab fa-apple"></i> &nbsp;View other teacher Loads</button></a>
       </div>
    </div>
    <div style="margin-bottom:20px"></div>&nbsp;

    <?php 
        $this->Main_model->alertSuccess('teacherLoad', 'Teacher load added successfully');
        $this->Main_model->alertWarning('noStudents', 'There are no enrolled students for that particular section');
    ?>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Strand</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($strandTable->result() as $row) {?>
                <!-- remove empty year levels -->
                <?php 
                    // determine if there is a student in that particular year level
                    $studentProfileTable = $this->Main_model->get_where('sh_student', 'strand_id', $row->strand_id);
                    if (count($studentProfileTable->result_array()) == 0) {
                        continue;
                    }
                ?>

            
                <tr>
                    <td><?= $row->strand_name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'shs/yearSelectionTeacherLoad/' . $row->strand_id ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>