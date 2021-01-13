<div class="container">
    <div style="margin-bottom:20px"></div>
    <div class="col-md-12 bg-warning p-3">
        <h1>There are no sections for this year level</h1>
        <br>
        <?php
            $academicLevel = $this->uri->segment(3);
            $yearLevelId = $this->input->get('yearLevelId');
            $back = base_url() . "manage_user_accounts/manageSectionAdvisers/$academicLevel";
            $createSections = base_url() . "classes/add_section?yearLevelId=$yearLevelId"; 
        ?>
        <a href="<?= $back ?>"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
        <a href="<?= $createSections ?>"><button class="btn btn-success"><i class="fas fa-plus"></i>&nbsp; Create Sections</button></a>
    </div>
</div>