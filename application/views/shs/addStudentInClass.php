<div class="container">
    <?php $this->Main_model->banner('Manage classes', "$sectionName | $subjectName | $strandName"); ?>
    <div style="margin-bottom:20px"></div>
    <form action="" method="post">
    
        <div class="table table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Student name</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($shStudentTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullName('sh_student', 'account_id', $row->account_id); ?></td>
                        <td width="10%">
                            <input type="checkbox" name="checkBox[]" value="<?= $row->account_id ?>" class="form-control">
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php $back = base_url() . "shs/viewPesonalSubjects?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevelId&strandId=$strandId" ?>
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-primary col-md-12"><i class="fas fa-check"></i>&nbsp; Add students</button>
            </div>
        </div>
    </form>
</div>