<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Strand transfer', 'Select Student'); ?>
    <div style="margin-bottom:10px"></div>
    <div class="alert alert-success"><span><i class="fas fa-exclamation p-1"></i></span>
        Activate a Learning Strand that is offered by the school
    </div>
    <div style="margin-bottom:10px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" width="80%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student name</th>
                    <th>Track</th>
                    <th>Strand</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($shsTable->result() as $row) { ?>
                    <tr>
                        <td><?= $this->Main_model->getFullNameWithId($row->strand_name) ?></td>
                        <td><?= getTrackName($row->track_id) ?></td>
                        <td><?= getStrandName($row->strand_id) ?></td>
                        <td>
                            <?php
                            //urls.
                            $activate = base_url() . "shs/activateStrand/$row->account_id";
                            $deactivate = base_url() . "shs/deactivateStrand/$row->account_id";
                            if ($row->status == 0) { ?>
                                <a href="<?= $activate ?>"><button class="btn btn-success col-md-12"><i class="fas fa-check"></i> Activate</button></a>
                            <?php } else { ?>
                                <a href="<?= $deactivate ?>"><button class="btn btn-Danger col-md-12"><i class="fas fa-times"></i> Deactivate</button></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs"; ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>