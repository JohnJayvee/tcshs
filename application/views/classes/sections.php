

<div style="margin-bottom: 20px;"></div>


<div class="container">
    <?php $this->Main_model->banner('View student grades', "<strong>$yearLevelName</strong>"); ?>
    
    <div style="margin-bottom:40px;"></div>
    <?php
        $this->load->model('Main_model');
        $this->Main_model->alertWarning('SectionNoStudents','Section has no students');
    ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Section Name</th>
                    <th>Options</th>
                </tr>            
            </thead>
            <tbody>
            <?php
                foreach ($sectionTable->result_array() as $row) {
                    $sectionId = $row['section_id'];
                    $sectionName = $row['section_name'];
                    $schoolYear = $row['school_year'];?>

                      <!-- remove rows that are empty para kapag walang enrolled student dapat hindi siya mag papakita-->
                    
                    <?php 
                        $studentTable = $this->Main_model->get_where('student_profile', 'section_id', $sectionId);
                        if (count($studentTable->result()) == 0) {
                            continue;
                        }
                    ?>
               
            
                <tr>
                    <td><?= $sectionName?></td>
                    <td>
                    <?php $enterClass = base_url() . "classes/view_student_grades?yearLevelId=$yearLevelId&sectionId=" . $row['section_id']?>
                        <a href="<?= $enterClass ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>

<div style="margin-bottom:10px"></div>&nbsp;
    <?php $back = base_url() . 'classes/selectYearLevelStudentGrades' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>