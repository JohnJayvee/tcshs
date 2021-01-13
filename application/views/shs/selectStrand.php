<?php  
    if (isset($_SESSION['noSectionAvailable'])) {
        echo "<script>alert('No Sections for this strand');</script>";
        unset($_SESSION['noSectionAvailable']);
    }
?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>View SHS Accounts</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2><?= $yearLevelName ?></h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($strandTable->result() as $row) { ?>
                    <tr>
                        <td><?= $row->strand_name ?></td>
                        <td>
                        <?php $enter = base_url() . "shs/shsSelectSection?yearLevelId=$yearLevelId&strandId=" . $row->strand_id ?>
                            <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-eye"></i>&nbsp; Enter</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/viewAccountControl" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>