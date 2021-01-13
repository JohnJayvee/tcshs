<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View classes', "$strandName") ?>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($yearLevelTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->getYearLevelNameFromId($row->school_grade_id) ?></td>
                    <td align="center">
                        <?php $enter = base_url() . "shs/manageClassesSection?strandId=$strandId&yearLevel=$row->school_grade_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/manageClassesStrand" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>