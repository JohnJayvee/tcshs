<div class="container">
    <?php $this->Main_model->banner("Custom class management", "$customClassName | $customClassSubjectName"); ?>

   <form action="" method="post">
    <div class="table table-responsive">
            <table class="table table-bordere" id="dataTable">
                <thead>
                    <tr align="center" style="font-style:10px;color:white" class="bg-dark p-1">
                        <th colspan="2">Select student</th>
                    </tr>
                    <tr>
                        <th>Student name</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($studentTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullName("sh_student", 'account_id', $row->account_id); ?></td>
                        <td>
                            <input type="checkbox" name="students[]" value="<?= $row->account_id ?>">
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $back = base_url() . "shs/viewSpecialClass?customClassId=$customClassId" ?>
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-success col-md-12"><i class="fas fa-user-plus"></i> Add students</button>
            </div>
        </div>
   </form>
</div>