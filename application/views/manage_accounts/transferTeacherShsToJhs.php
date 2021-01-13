<div class="container">
    <div style="margin-bottom:30px"></div>
    <center class="bg-warning p-3">
        <h1>Transfer teacher</h1>
        <hr style="margin: 5px 5px" width="40">
        <h2>Senior highschool to Junior highschool</h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <form action="" method="post">
        <div class="table table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Teacher name</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach ($jhsTeacherTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullname('faculty', 'account_id', $row->account_id); ?></td>
                        <td>
                            <input type="checkbox" name="teacher[]" value="<?= $row->credentials_id ?>">
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php $back = base_url() . "manage_user_accounts/viewJuniorHighSchoolFaculty" ?>
        <div class="row">
            <div class="col-md-6"><a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a></div>
            <div class="col-md-6"><button type="submit" name="submit" class="btn btn-success col-md-12"><i class="fas fa-exchange-alt"></i> Transfer</button></div>
        </div>
    </form>
</div>