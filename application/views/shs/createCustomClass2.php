<div class="container">
    <?php $this->Main_model->banner("Create custom class", "Configure class"); ?>

    <form action="" method="post">
        <div class="table table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr align="center">
                        <th class="bg-dark" style="color: white;font-size:20px" colspan="2">Select student</th>
                    </tr>
                    <tr>
                        <th>Student name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($studentTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullName('sh_student', 'account_id', $row->account_id) ?></td>
                        <td>
                            <input type="checkbox" name="students[]" value="<?= $row->account_id ?>">
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom:20px"></div>
        <div class="row">
            <div class="col-md-6">
                <?php $back = base_url() . "shs/createCustomClass" ?>
                <a href="<?= $back ?>">
                    <button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button>
                </a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" id="firstButton" class="btn btn-success col-md-12">Register &nbsp; <i class="fas fa-check"></i></button>
            </div>
        </div>
    </form>
</div>