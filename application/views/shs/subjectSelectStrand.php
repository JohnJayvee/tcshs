<?php
if (isset($_SESSION['generalSubjectInserted'])) {
    echo "<script>";
    echo "alert('General Subject Created Successfully');";
    echo "</script>";
    unset($_SESSION['generalSubjectInserted']);
}

if (isset($_SESSION['generalSubjectDuplicate'])) {
    echo "<script>";
    echo "alert('General Subject Created Successfully');";
    echo "</script>";
    unset($_SESSION['generalSubjectDuplicate']);
}
?>

<div class="container-fluid">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-1">
        <h1>Shs Subject Management</h1>
        <hr width="60%" style="margin:5px 5px;">
        <h3><?= $yearLevelName ?></h3>
    </center>
    <div style="margin-bottom:30px"></div>
    <div class="row">
        <!--  general subjects -->
        <div class="col-md-6">
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead align="center">
                        <tr>
                            <th colspan="2" class="bg-dark text-light">General subjects</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label style="font-size:20px">General Subject:</label>
                                        <input type="text" name="newGeneralSubject" class="form-control" placeholder="Enter new General Subject name" required="required" autocomplete="off">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6 float-left">
                                                <a href=""><button type="submit" name="submit" class="btn btn-success col-md-12">Create</button></a>
                                            </div>
                                            <div class="col-md-6 float-right">
                                                <button type="button" class="btn btn-dark col-md-12" id="button"><i class="fas fa-eye"></i>&nbsp;View</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <!--  Non General subjects -->
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead align="center">
                        <tr>
                            <th colspan="2" class="bg-dark text-light">Non-General subjects</th>
                        </tr>
                        <tr>
                            <th>Subject Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php foreach ($activatedStrands->result() as $row) { ?>
                            <tr>
                                <td><?= $row->strand_name ?></td>
                                <td>
                                    <?php $enter = base_url() . "shs/shsCreateSubject?yearLevelId=" . $yearLevelId . "&strandId=" . $row->strand_id ?>
                                    <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter &nbsp;<i class="fas fa-arrow-right"></i></button></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- row para sa dalawang table -->

    <!-- heto na yung drop down table -->
    <div class="col-md-6 bg-dark  p-3" id="table">
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
                    foreach ($generalSubjectsTable->result() as $row) { ?>
                        <tr align="center">
                            <td><?= $row->subject_name ?></td>
                            <td>
                                <?php
                                $enter = base_url() . "";
                                $delete = base_url() . "";
                                ?>
                                <div class="row">
                                    <a href="<?= $enter ?>" style="margin-right:10px"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Edit</button></a>
                                    <a href="<?= $delete ?>"><button class="btn btn-danger col-md-12;"><span><i class="fas fa-trash"></i>&nbsp; Delete</span></button></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-bottom:10px"></div>
    <!-- drop down table -->
    <?php $back = base_url() . "shs/subjectYearSelection" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<script>
    $(document).ready(function() {
        $("#table").hide();

        $("#button").click(function() {
            $("#table").slideToggle('6000');
        });
    });
</script>