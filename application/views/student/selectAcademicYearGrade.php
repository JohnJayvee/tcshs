<div class="container">
    <div style="margin-bottom:40px"></div>

    <h1>Select Academic year</h1>

    <div style="margin-bottom:40px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>Academic Year</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($academicYears as $key => $value) {?>
            
                <tr>
                    <td align="center"><?= $value ?></td>
                    <td>
                        <?php $enter = base_url() . 'parent_student/view_grades?academicYear=' . $value ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12 m-1">Enter</button></a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>