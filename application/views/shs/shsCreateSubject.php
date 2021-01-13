<?php
if (isset($_SESSION['shSectionCreated'])) {
    echo "<script>";
    echo "alert('Subject Created successfully');";
    echo "</script>";
    unset($_SESSION['shSectionCreated']);
}
if (isset($_SESSION['shsSectionDuplication'])) {
    echo "<script>";
    echo "alert('Subject name has duplicates for this year level');";
    echo "</script>";
    unset($_SESSION['shsSectionDuplication']);
}
if (isset($_SESSION['shsSectionDeleted'])) {
    echo "<script>";
    echo "alert('Subject Delete Successfully');";
    echo "</script>";
    unset($_SESSION['shsSectionDeleted']);
}
?>

<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-1 rounded">
        <h1>Shs Subject Management</h1>
        <hr width="60%" style="margin:5px 5px;">
        <h3><?= $yearLevelName ?>&nbsp; <?= $strandName ?></h3>
    </center>
    <div style="margin-bottom:10px"></div>
    <?php $back = base_url() . "shs/subjectSelectStrand?yearLevelId=$yearLevelId" ?>
    <div class="col-md-12 bg-info p-3 rounded-top">
        <form action="" method="post">
            <div class="form-group">
                <label style="font-size:20px">Create Subject for this strand:</label>
                <input type="text" name="newSection" placeholder="Enter new section" required autocomplete="off" autofocus class="form-control">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success col-md-12" name="submit">Create</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-dark col-md-12" id="viewSection"><i class="fas fa-eye"></i>&nbsp; View</button>
                </div>
            </div>
        </form>
    </div>
    <div style="margin-bottom:10px"></div>
    <div class="col-md-12 bg-dark  p-3" id="table">
        <div class="table table-responsive text-light">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Section Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody class="bg-light">
                    <?php
                    foreach ($shSubjectsTable->result() as $row) { ?>
                        <tr align="center">
                            <td><?= $row->subject_name ?></td>
                            <td>
                                <?php
                                $enter = base_url() . "";
                                $delete = base_url() . "";
                                ?>
                                <div class="row col-md-11">
                                    <div class="col-md-6">
                                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Edit</button></a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?= $delete ?>"><button class="btn btn-danger col-md-12"><i class="fas fa-trash"></i>&nbsp; Delete</button></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#table").hide();

        $("#viewSection").click(function() {
            $("#table").slideToggle('6000');
        });
    });
</script>