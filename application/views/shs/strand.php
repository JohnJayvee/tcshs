<?php
if (isset($_SESSION['strandActivated'])) {
    echo "<script>";
    echo "alert('Learning Strand ACTIVATED');";
    echo "</script>";
    unset($_SESSION['strandActivated']);
}

if (isset($_SESSION['strandDeactivated'])) {
    echo "<script>";
    echo "alert('Learning Strand Deactivated');";
    echo "</script>";
    unset($_SESSION['strandDeactivated']);
}
?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-1">
        <h1>Strand Management</h1>
        <hr width="40%" style="margin:5px 5px;">
        <h3><?= $trackName ?></h3>
    </center>
    <div style="margin-bottom:10px"></div>
    <div class="alert alert-success"><span><i class="fas fa-exclamation p-1"></i></span>
        Activate a Learning Strand that is offered by the school
    </div>
    <div style="margin-bottom:10px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" width="80%" cellspacing="0">
            <thead>
                <tr>
                    <th>Strand Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($strandTable->result() as $row) { ?>
                    <tr>
                        <td><?= $row->strand_name; ?></td>
                        <td>
                            <?php
                            //urls.
                            $activate = base_url() . "shs/activateStrand/" . $row->strand_id . "?trackId=$trackId";
                            $deactivate = base_url() . "shs/deactivateStrand/" . $row->strand_id . "?trackId=$trackId";
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