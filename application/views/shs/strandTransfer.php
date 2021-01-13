<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Strand transfer', 'Select Student'); ?>
    <div style="margin-bottom:30px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
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
                        <td><?= $this->Main_model->getFullName('sh_student', 'account_id',$row->account_id) ?></td>
                        <td><?= $this->Main_model->getTrackName($row->track_id) ?></td>
                        <td><?= $this->Main_model->getStrandName($row->strand_id) ?></td>
                        <td>
                            <?php
                                $transfer = base_url() . "shs/transferStudentStrand?accountId=$row->account_id";
                            ?>
                                <a href="<?= $transfer ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-exchange-alt"></i> Transfer</button></a>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs"; ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>