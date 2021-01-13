<div class="container">
    <?php $this->Main_model->banner("Custom class management", "$customClassName | $customClassSubjectName"); ?>

    <p style="font-size:30px">Are you sure you want to delete <b><?= $customClassName ?></b> class?</p>
    <?php 
        $back = base_url() . "shs/viewSpecialClass?customClassId=$customClassId";
        $confirm = base_url() . "shs/deleteSpecialClass?customClassId=$customClassId&confirm=1";
    ?>

    <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>&nbsp;
    <a href="<?= $confirm ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp; Confirm</button></a>
</div>