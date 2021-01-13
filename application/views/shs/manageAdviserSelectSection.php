<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Manage Shs Advisers</h1>
        <hr style="margin: 5px 5px" width="40%">
        <h2><strong><?= $yearLevelName ?></strong> <strong><?= $strandName ?></strong></h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Section name</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($shSectionTable->result() as $row) { ?>
                    <tr align="center">
                        <td><?= $row->section_name; ?></td>
                        <td>
                            <?php
                            $adviserAssign = $this->Main_model->checkAssignAdviser($row->section_id, 2);
                            if ($adviserAssign == false) { ?>
                                <div class="bg-danger p-2" style="color:aliceblue;font-weight:bold; border-radius:5px;">Unassigned</div>
                            <?php } else { ?>
                                <div class="bg-success p-2" style="color:aliceblue;font-weight:bold; border-radius:5px;"><?= ucfirst($adviserAssign) ?></div>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            //manage links
                            $assign = base_url() . "shs/shsAssignAdviser?sectionId=" . $row->section_id  . "&yearLevelId=$yearLevelId&strandId=$strandId";

                            if ($adviserAssign == false) { ?>
                                <a href="<?= $assign ?>"><button class="btn btn-primary col-md-12"><i class="fas fa-edit"></i>&nbsp; Assign</button></a>
                            <?php } else { ?>
                                <a href="<?= $assign ?>"><button class="btn btn-success col-md-12"><i class="fas fa-edit"></i>&nbsp; Reassign</button></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>  
    <?php $back  = base_url() . "shs/manageAdviserStrandSelection?yearLevelId=$yearLevelId" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>