<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View classes', 'Select strand') ?>
    <div style="margin-bottom:-10px"></div>
    <?php $personalSubjects = base_url() . "shs/viewPsYearLevel" ?>
    <a href="<?= $personalSubjects ?>"><button class="btn btn-info col-md-12">View personal subjects</button></a>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Strand</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($strandTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->getStrandName($row->strand_id) ?></td>
                    <td align="center">
                        <?php $enter = base_url() . "shs/manageClassesYearLevel?strandId=$row->strand_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>