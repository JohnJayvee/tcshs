<?php
if (isset($_SESSION['shSectionCreated'])) {
    echo "<script>";
    echo "alert('Section Created successfully');";
    echo "</script>";
    unset($_SESSION['shSectionCreated']);
}
if (isset($_SESSION['shsSectionDuplication'])) {
    echo "<script>";
    echo "alert('Section name has duplicates for this year level');";
    echo "</script>";
    unset($_SESSION['shsSectionDuplication']);
}
if (isset($_SESSION['shsSectionDeleted'])) {
    echo "<script>";
    echo "alert('Section Delete Successfully');";
    echo "</script>";
    unset($_SESSION['shsSectionDeleted']);
}

$this->Main_model->alertPromt('Section updated successfully', 'sectionUpdate');
?>

<div class="container">
    <div style="margin-bottom:10px"></div>
    <?php $this->Main_model->banner('Year and Section management', "$yearLevelName | $strandName"); ?>
    <div style="margin-bottom:10px"></div>
    <?php $back = base_url() . "shs/sectionsSelectStrand?yearLevelId=$yearLevelId" ?>
    <div class="col-md-12 bg-info p-3 rounded-top">
    <?php $form = base_url() . "shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId" ?>
        <form action="<?= $form ?>" method="post">
            <div class="form-group">
                <label style="font-size:20px">Create new section</label>
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
                    foreach ($shSectionTable->result() as $row) { ?>
                        <tr align="center">
                            <td><?= $row->section_name ?></td>
                            <td>
                                <?php
                                $view = base_url() . "shs/viewStudentSections?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$row->section_id";
                                $edit = base_url() . "shs/editShsSection?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$row->section_id";
                                $delete = base_url() . "shs/deleteSection/?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$row->section_id";
                                ?>
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <a href="<?= $view ?>"><button class="btn btn-info col-md-12"><i class="fas fa-eye"></i>&nbsp; View Students</button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= $edit ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Edit</button></a>
                                    </div>
                                    <div class="col-md-4">
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