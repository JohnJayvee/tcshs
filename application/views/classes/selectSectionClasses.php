<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View classes</h1>
        <hr width="40%" style="margin:5px 5px">
        <h2><?= $yearLevelName ?></h2>
    </center>
    <div style="margin-bottom:20px"></div>    
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($sectionTable->result_array() as $row) {
                        $sectionId = $row['section_id'];
                        $sectionName = $row['section_name'];?>
                   <!-- remove rows that does not contain any students -->
                        <?php 
                            $studentTable = $this->Main_model->get_where('student_profile', 'section_id', $sectionId);
                            if (count($studentTable->result_array()) == 0) {
                                continue;
                            }
                        ?>
                <tr>
                    <td><?= $sectionName ?></td>
                    <td>
                        <?php $enter = base_url() . "classes/manage_classes?yearLevelId=$yearLevelId&sectionId=$sectionId"?>
                        <a href="<?= $enter ?> "><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "classes/selectYearSubjectClasses" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>