<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Manage Shs Advisers</h1>
        <hr style="margin: 5px 5px" width="40%">
        <span style="font-size:30px"><strong><?= $yearLevelName ?></strong> Select Strand</span>
    </center>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Strand</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($strandTable->result() as $row) {
                //dont show deactivated strands
                if ($row->status == 0) {
                    continue;
                }
                ?>
                <tr>
                    <td><?= $row->strand_name ?></td>
                    <td>
                        <?php $enter = base_url() . "shs/manageAdviserSelectSection?yearLevelId=$yearLevelId&strandId=" . $row->strand_id?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter <i class="fas fa-arrow-right"></i></button></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>  
    <?php $back  = base_url() . "shs/manageShsAdviser" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>