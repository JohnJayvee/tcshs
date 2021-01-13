<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3">
        <h1>Manage Teacher Load</h1>
        <hr width="40%" style="margin: 5px 5px">
        <div class="col-md-12">
            <span style="font-size:20px;"><strong><?= $yearLevelName ?> | <?= $strandName ?></span>
        </div>
    </center>

    <div style="margin-bottom:40px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Section Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sectionTable->result() as $row) {?>
                <?php 
                    //remove yung walan mga wala namang laman na students
                    $studentTable = $this->Main_model->get_where('sh_student', 'section_id', $row->section_id);    
                    if (count($studentTable->result_array()) == 0) {
                        continue;
                    }
                ?>
            
                <tr>
                    <td><?= $row->section_name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'shs/subjectSelectionTeacherLoad?yearLevelId=' . $yearLevelId . '&sectionId=' . $row->section_id . "&strandId=$strandId"?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/yearSelectionTeacherLoad" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>