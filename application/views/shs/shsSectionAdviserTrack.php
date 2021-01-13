<?php 
    //notifications
    $this->Main_model->alertPromt('No sections for this strand', 'noSections');
?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php
        $lowerTxt = $this->Main_model->getYearLevelNameFromId($yearLevel);
        $this->Main_model->banner('Manage shs advisers', $lowerTxt); 
    ?>

    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Track name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($strandTable->result() as $row) { ?>
                <tr>
                    <td><?= $row->strand_name ?></td>
                    <td>
                    <?php $enter = base_url() . "manage_user_accounts/ShsAssignAdviser?yearLevel=$yearLevel&strandId=$row->strand_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/shsSectionAdviserYearLevel" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>