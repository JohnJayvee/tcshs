<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Manage shs advisers', 'Select year level'); ?>

    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($yearLevelTable->result() as $row) { ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td>
                    <?php $enter = base_url() . "manage_user_accounts/shsSectionAdviserStrand?yearLevel=$row->school_grade_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
    </div>
</div>