<?php $this->load->model("Main_model") ?>
<div class="container">
    <div style="margin-bottom: 20px"></div>

    <center class="bg-warning p-3">
        <h1>Manage personal teacher load</h1>
        <hr width="50%" style="margin: 5px 5px">
        <h3><?= ucfirst($currentSchoolYear) ?></h3>
    </center>
    <div style="margin-bottom: 40px"></div>

    <!-- notificaiton -->
    <?php 
        $this->Main_model->alertDanger('deleteSuccess', "Teacher load delete successfully");
    ?>

    <!-- here is the table -->
    <div class="table table-responsive">
        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Schedule</th>
                    <th>Year level</th>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($personalTeacherLoadTable->result() as $row) { ?>
                <tr>
                    <!-- subject -->
                    <td>
                        <?= $this->Main_model->getShSubjectNameFromId($row->sh_subject_id); ?>
                    </td>
                    <td><?= $row->schedule ?></td>
                    <td><?= $this->Main_model->getYearLevelNameFromId($row->year_level) ?></td>
                    <td><?= $this->Main_model->getShSectionName($row->sh_section_id) ?></td>
                    <td>
                        <?php
                            $edit = base_url() . "shs/edit_teacher_load/" . $row->id;
                            $delete = base_url() . "shs/delete_teacher_load/" . $row->id;
                       ?>
                        <a href="<?= $edit ?>"><button class="btn btn-primary col-md-5"><i class="fas fa-edit"></i> &nbsp; Edit</button></a>
                        <a href="<?= $delete ?>"><button class="btn btn-danger col-md-5"><i class="fas fa-trash"></i> &nbsp; Delete</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div> <div style="margin-bottom:10px"></div>&nbsp;
    <?php $back = base_url() . 'shs/selectStrandTeacherLoad' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>