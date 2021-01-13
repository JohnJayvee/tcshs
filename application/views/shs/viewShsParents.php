<?php $this->Main_model->alertPromt('There are no students in this section', 'noStudent'); ?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View SHS Accounts</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2><?= $yearLevelName ?> | <?= $strandName ?> | <?= $sectionName ?></h2>
    </center>
    <div style="margin-bottom:10px"></div>
    <?php $viewParent = base_url() . "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId"; ?>
    <a href="<?= $viewParent ?>"><button class="btn btn-outline-success col-md-12"><i class="fab fa-apple"></i>&nbsp; View Students</button></a>
    <div style="margin-bottom:10px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Parent name</th>
                    <th>Child's Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($parentIdTable as $row) {
                    $parentData = $this->Main_model->getSubdevidedParentName($row);
                    $firstname = ucfirst($parentData['firstname']);
                    $middlename = ucfirst($parentData['middlename']);
                    $lastname = ucfirst($parentData['lastname']) ;
                    $fullName = "$firstname $middlename $lastname";
                    $accountId = $row;
                    ?>
                <tr>
                    <td><?= $fullName ?></td>
                    <td><?php $this->Main_model->getAllTheStudentsOfThatParent($row); ?></td>
                    <td>
                    <?php $edit = base_url() . "shs/editShParent/$accountId?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId" ?>
                        <div class="row" style="margin: 0px -10px 0 -10px">
                            <div class="col-md-6">
                                 <a href="<?= $edit ?>"><button type="button" class="btn btn-primary col-md-12 p-1"><i class="fas fa-edit"></i>&nbsp; Edit</button></a>
                            </div>

                            <div class="col-md-6">
                                 <a href=""><button class="btn btn-danger col-md-12 p-1"><i class="fas fa-phone"></i>&nbsp; Call Parent</button></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>