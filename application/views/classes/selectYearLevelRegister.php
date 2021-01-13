<div class="container">
    <div style="margin-bottom:40px;"></div>

    <h1 align="center">Single student account registration</h1>
    <hr width="70%">
    <h2 align="center">Select Year Level</h2>

    <div style="margin-bottom:40px;"></div>
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach ($yearLevelTable->result() as $row) {?>
                    <tr>
                        <td><?= $row->name ?></td>
                        <td>
                            <?php $enter = base_url() . 'manage_user/selectSectionRegister?yearLevelId=' . $row->school_grade_id ?>
                            <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                    
            </tbody>
        </table>
    </div>
</div>