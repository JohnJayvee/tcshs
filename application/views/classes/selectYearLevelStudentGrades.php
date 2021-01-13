

<div style="margin-bottom: 20px;"></div>


<div class="container">
    <!-- <div align="center">
        <h1>View Student Gradaes</h1>
        <hr width="50%">
        <span style="font-size: 30px">Select Year Level</span><br>
    </div> -->
    <?php $this->Main_model->banner('View student grades', 'Select year level'); ?>
    
    <div style="margin-bottom:20px;"></div>
    <?php
        $this->load->model('Main_model');
        $this->Main_model->alertWarning('SectionNoStudents','Section has no students');
    ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Options</th>
                </tr>            
            </thead>
            <tbody>
            <?php foreach ($yearLevelTable->result() as $row) { ?>
            <!-- remove rows that are empty para kapag walang enrolled student dapat hindi siya mag papakita-->
            
            <?php 
                $studentTable = $this->Main_model->get_where('student_profile', 'school_grade_id', $row->school_grade_id);
                if (count($studentTable->result()) == 0) {
                    continue;
                }
            ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td>
                    <?php $enter = base_url() . "classes/selectStudentSection?YearLevelId=$row->school_grade_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>