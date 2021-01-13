<?php $this->Main_model->alertPromt('There are no students in this section', 'noStudent'); ?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View SHS Accounts</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2><?= $yearLevelName ?> | <?= $strandName ?> | <?= $sectionName ?></h2>
    </center>
    <div style="margin-bottom:10px"></div>
    <?php $viewParent = base_url() . "shs/viewShsParents?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId"; ?>
    <a href="<?= $viewParent ?>"><button class="btn btn-outline-info col-md-12"><i class="fas fa-user"></i>&nbsp; View Parents</button></a>
    <div style="margin-bottom:10px"></div>
    
    <!-- notification -->
    <?php $this->Main_model->alertSuccess('shStudentUpdate', "Student account updated"); ?>
    <?php $this->Main_model->alertSuccess('shParentUpdate', "Parent account updated"); ?>
    
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($shsStudentTable->result() as $row) { 
                    $accountId = $row->account_id;?>
                <tr>
                    <td><?= ucfirst($row->firstname) ?></td>
                    <td><?= ucfirst($row->middlename) ?></td>
                    <td><?= ucfirst($row->lastname) ?></td>
                    <td>
                    <?php  
                        $edit = base_url() . "shs/editShsStudent/$accountId?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId";
                    ?>
                        <div class="row" style="margin: -5px">
                            <div class="col-md-6">
                                 <a href="<?= $edit ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Edit</button></a>
                            </div>
                            <div class="col-md-6">
                                 <a href=""><button class="btn btn-danger col-md-12"><i class="fas fa-phone"></i>&nbsp; Call Parent</button></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>