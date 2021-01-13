<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Manage shs advisers', 'Select year level'); ?>

    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Section name</th>
                    <th>Section adviser</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shSectionTable->result() as $row) { ?>
                <tr>
                    <td><?= $row->section_name ?></td>
                    <td>
                    <?php $enter = base_url() . "manage_user_accounts/shsSectionAdviserSection?yearLevel=$row->school_grade_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/shsSectionAdviserYearLevel" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>