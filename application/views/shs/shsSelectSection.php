<?php $this->Main_model->alertPromt('There are no students in this section', 'noStudent'); ?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View SHS Accounts</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2><?= $yearLevelName ?> | <?= $strandName ?></h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($shSectionTable->result() as $row) { ?>
                    <tr>
                        <td><?= $row->section_name ?></td>
                        <td>
                        <?php $enter = base_url() . "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=" . $row->section_id ?>
                            <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/selectStrand?yearLevelId=$yearLevelId&strandId=$strandId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>