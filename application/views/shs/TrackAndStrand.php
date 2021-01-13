<?php
if (isset($_SESSION['trackActivated'])) {
    echo "<script>";
    echo "alert('Career Track ACTIVATED');";
    echo "</script>";
    unset($_SESSION['trackActivated']);
}

if (isset($_SESSION['trackDeactivated'])) {
    echo "<script>";
    echo "alert('Career Track deactivated, strands of this track are also deactivated as well as the teacher load');";
    echo "</script>";
    unset($_SESSION['trackDeactivated']);
}
if (isset($_SESSION['trackStrandEmpty'])) {
    echo "<script>";
    echo "alert('No Strands registered for this Track');";
    echo "</script>";
    unset($_SESSION['trackStrandEmpty']);
}

$this->Main_model->alertPromt('Cant deactivate, There are still students in this track', 'stillStudents');
?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-1">
        <h1>Track Management</h1>
        <hr width="40%" style="margin:5px 5px;">
        <h3>Career track activation</h3>
    </center>
    <div style="margin-bottom:10px"></div>
    <div class="alert alert-success"><span><i class="fas fa-exclamation p-1"></i></span>
        Activate a career track that is offered by the school
    </div>
    <div style="margin-bottom:10px"></div>

    <div class="row">
        <div class="col-md-6">
            <!--  left -->
            <div class="table table-responsive">
                <table class="table table-bordered" width="80%" cellspacing="0">
                    <thead>
                        <tr align="center">
                            <th colspan="2">Activation Management</th>
                        </tr>
                        <tr align="center">
                            <th>Track Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        foreach ($careerTrackTable->result() as $row) { ?>
                            <tr>
                                <td><?= $row->track_name; ?></td>
                                <td>
                                    <?php
                                    //urls.
                                    $activate = base_url() . "shs/activateTrack/" . $row->track_id;
                                    $deactivate = base_url() . "shs/deactivateTrack/" . $row->track_id;
                                    $enter = base_url() . "shs/strand?trackId=" . $row->track_id;
                                    if ($row->status == 0) { ?>
                                        <a href="<?= $activate ?>"><button class="btn btn-success col-md-12"><i class="fas fa-check"></i> Activate</button></a>
                                    <?php } else { ?>
                                        <a href="<?= $deactivate ?>"><button class="btn btn-Danger col-md-5"><i class="fas fa-times"></i> Deactivate</button></a>
                                        <a href="<?= $enter ?>"><button class="btn btn-Dark col-md-5"> Enter &nbsp;<i class="fas fa-arrow-right"></i></button></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered" width="80%" cellspacing="0">
                    <thead>
                        <tr align="center">
                            <th colspan="2">Activated Strands</th>
                        </tr>
                    </thead>
                    <tbody align="center" id="activeStrands">
                        <!-- this is dynamic -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div><!-- container -->
<?php $activatedStrandsUrl = base_url() . "shs/activatedStrands" ?>

<script>
    $(document).ready(function() {
        $("#activeStrands").load("<?= $activatedStrandsUrl ?>");
    });
</script>