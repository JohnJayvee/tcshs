<?php 
    //notifications
    $this->Main_model->alertPromt('You must be an adviser', 'notAdviser');
    $this->Main_model->alertPromt('There are no students registered in this section', 'noStudent');
?>
<div class="container">
    <div style="margin-bottom:10px"></div>
    <center class="alert-warning p-3">
        <h1><?= $teacherName ?></h1>
    </center>
</div>