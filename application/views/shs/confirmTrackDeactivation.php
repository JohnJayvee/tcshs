<div class="container">
    <div style="margin-bottom: 20px"></div>
    <div class="col-md-12 p-3 bg-warning">
        <h1>Track Deactivation</h1>
        <p style="font-size:20px">Are you sure you want to deactivate track: <strong><?= $trackName ?></strong> </p>
        <br>
        <?php
        $back = base_url() . "shs";
        $deactivate = base_url() . "shs/deactivateTrack/$trackId?deactivate=1";
        ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
        <a href="<?= $deactivate ?>"><button class="btn btn-danger"><i class="fas fa-times"></i>&nbsp;Deactivate</button></a>
    </div>