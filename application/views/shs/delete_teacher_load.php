<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner('Manage personal teacher load', 'Delete teacher load'); ?>
    <div style="margin-bottom:20px"></div>
    
    <?php
        $loadInfo = $shTeacherLoadTable->result_array();
        $back = base_url() . "shs/viewPersonalTeacherLoad";
        $delete = base_url() . "shs/delete_teacher_load/$teacherLoadId?confirm=1";
    ?>
    <span style="font-size:30px">Are you sure you want to delete your teacher load: <b><?= $this->Main_model->getShSubjectNameFromId($loadInfo[0]['sh_subject_id']) ?></b> </span>

    <br>
    <div style="margin-bottom:20px"></div>
    <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> &nbsp;Back</button></a>&nbsp;
    <a href="<?= $delete ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i> &nbsp;Delete</button></a>
</div>