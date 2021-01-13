<div class="container">
    <div style="margin-bottom:40px"></div>
    <center class="bg-warning p-3">
        <h1>Manage Shs Advisers</h1>
        <hr style="margin: 5px 5px" width="40%">
        <h2>Select Year Level</h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($yearLevelTable->result() as $row) {?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td>
                        <?php $enter = base_url() . "shs/manageAdviserStrandSelection?yearLevelId=" . $row->school_grade_id ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter <i class="fas fa-arrow-right"></i></button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "manage_user_accounts/chooseYearLevelAdviserManager" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>