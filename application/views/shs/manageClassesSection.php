<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('View classes', "$yearLevelname | $strandName") ?>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($sectionTable->result() as $row) { ?>
                <tr>
                    <td><?= $this->Main_model->getShSectionName($row->section_id) ?></td>
                    <td align="center">
                        <?php $enter = base_url() . "shs/manageClasses?strandId=$strandId&yearLevel=$yearLevel&sectionId=$row->section_id" ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/manageClassesYearLevel?strandId=$strandId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>