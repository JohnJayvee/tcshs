<div class="container">
    <div style="margin-bottom:40px;"></div>

    <h1 align="center">Single student account registration</h1>
    <hr width="70%">
    <h2 align="center">Select Section</h2>

    <div style="margin-bottom:40px;"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach ($sectionTable->result() as $row) {?>
                    <tr>
                        <td><?= $row->section_name ?></td>
                        <td>
                            <?php $enter = base_url() . 'manage_user/register?yearLevelId=' . $yearLevelId . '&sectionId=' . $row->section_id ?>
                            <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                    
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . 'Manage_user/selectYearLevelRegister' ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12">Back</button></a>
</div>