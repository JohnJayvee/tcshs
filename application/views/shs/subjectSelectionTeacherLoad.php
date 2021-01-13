<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3">
        <h1>Manage Teacher Load</h1>
        <hr width="70%" style="margin: 5px 5px">
        <div class="col-md-12">
            <span style="font-size:20px"><strong><?= $yearLevelName ?></strong> &nbsp;| <strong><?= $strandName ?></strong> &nbsp;| <strong><?= $sectionName ?></strong></span>
        </div>
    </center>

    <div style="margin-bottom:40px"></div>
    <?php 
    
    
        if (isset($_SESSION['loadExist'])) {
            echo "<script type='text/javascript'>alert('Subject Already Taken');</script>";
            unset($_SESSION['loadExist']);
        }
    ?>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($subjectTable->result() as $row) {?>
                
            
                <tr>
                    <td><?= $row->subject_name; ?></td>
                    
                    <?php 
                        $teacherFullName = $this->Main_model->checkShsTeacherLoadIfAlreadyTaken($row->subject_id);
                        if ($teacherFullName == true ) {?>
                            <td><button class="btn btn-success col-md-12"><?= $teacherFullName ?></button></td>
                        <?php }else{?>
                            <td>
                                <?php $enter = base_url() . 'shs/teacher_load?yearLevelId=' . $yearLevelId . '&sectionId=' . $sectionId . '&subjectId=' . $row->subject_id . "&strandId=$strandId" ?>
                                <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                            </td>
                        <?php }?>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/sectionSelectionTeacherLoad?yearLevelId=$yearLevelId&strandId=$strandId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>