<div class="container bg-warning p-3 m-4">
    <center>
        <h1>User Batch Registration Success!</h1>
    </center>
    <br>
    <?php
    $yearLevelId = $this->input->get('yearLevelId');
    $sectionId = $this->input->get('sectionId');
    $back = base_url() . "RegisterBatch?yearLevelId=$yearLevelId&sectionId=$sectionId" ?>
    <a href="<?= $back ?>"><button class="btn btn-primary col-md-12">back</button></a>
</div>