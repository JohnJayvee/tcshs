<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-3">
        <h1>Manage section Advisers</h1>
        <hr width="50%">
        <h3>Select Year Level</h3>
    </center>
    <div style="margin-bottom:40px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" cellspacing="0">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yearLevelTable->result() as $row) { ?>
                    <tr>
                        <td><?= $row->name; ?></td>
                        <td>
                            <?php $link = base_url() . "manage_user_accounts/manageSectionAdvisersTwo/$academicLevel?yearLevelId=" . $row->school_grade_id . "&academicLevel=$academicLevel" ?>
                            <a href="<?= $link ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i> Enter</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/secretaryView" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>