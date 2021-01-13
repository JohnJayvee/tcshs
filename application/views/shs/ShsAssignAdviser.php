<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-3">
        <h1>Manage section Advisers</h1>
        <hr width="50%">
        <h3><?= $yearLevelName ?> | <?= $strandName ?></h3>
    </center>
    <div style="margin-bottom:40px"></div>
        <div class="table table-responsive">
            <table class="table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Section name</th>
                        <th>Section Adviser</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($shsSections->result() as $row) { ?>
                        <tr align="center">
                            <td><?= $row->section_name; ?></td>
                            <td>
                                <?php
                                $adviserAssign = $this->Main_model->ShsCheckAssignAdviser($row->section_id);
                                $academicLevel = $this->input->get('academicLevel');
                                if ($adviserAssign == false) { ?>
                                    <div class="bg-danger p-2" style="color:aliceblue;font-weight:bold; border-radius:5px;">Unassigned</div>
                                <?php } else { ?>
                                    <div class="bg-success p-2" style="color:aliceblue;font-weight:bold; border-radius:5px;"><?= ucfirst($adviserAssign) ?></div>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                //manage links
                                $assign = base_url() . "manage_user_accounts/chooseShsAdviser?yearLevelId=" . $yearLevelId . "&sectionId=" . $row->section_id . "&strandId=$strandId";

                                if ($adviserAssign == false) { ?>
                                    <a href="<?= $assign ?>"><button class="btn btn-info col-md-12"><i class="fas fa-edit"></i>&nbsp; Assign</button></a>
                                <?php } else { ?>
                                    <a href="<?= $assign ?>"><button class="btn btn-success col-md-12"><i class="fas fa-edit"></i>&nbsp; Reassign</button></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom:30px"></div>
        <?php $back = base_url() . "manage_user_accounts/shsSectionAdviserStrand?yearLevel=$yearLevelId" ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back </button></a>
</div>