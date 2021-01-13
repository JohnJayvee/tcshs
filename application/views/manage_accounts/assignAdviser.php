<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-3">
        <h1>Manage section Advisers</h1>
        <hr width="50%">
        <h3><?= $yearLevelName ?> <b><?= $sectionName ?></b></h3>
    </center>
    <div style="margin-bottom:40px"></div>
    <form action="" method="post">
        <div class="table responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                    <tr>
                        <th>Teacher Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //credentials table ito beh ah. take care ka always
                    foreach ($facultyTable->result() as $row) { ?>
                        <tr>
                            <td><?= $this->Main_model->getFullname('faculty', 'account_id', $row->account_id); ?></td>
                            <td>
                                <?php
                                if ($this->Main_model->checkAdviserIsAssigned($row->account_id, 1)) { ?>
                                    <input type="radio" name="teacherId" value="<?= $row->account_id ?>" checked required>
                                <?php } else { ?>
                                    <input type="radio" name="teacherId" value="<?= $row->account_id ?>" required>
                                <?php } ?>


                            </td>
                        </tr>
                    <?php  } ?>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom:30px"></div>
        <?php
        $academicLevel = $this->input->get('academicLevel');
        $back = base_url() . "manage_user_accounts/manageSectionAdvisersTwo?yearLevelId=$yearLevelId&academicLevel=$academicLevel";
        ?>
        <div class="row">
            <div class="col-md-6">
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary col-md-12" name="submit"> Assign</button>
            </div>
        </div>

    </form>

</div>