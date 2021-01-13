<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3">
        <h1>Subject Management</h1>
        <hr width="40%" style="margin: 5px 5px">
        <h2>Select Year Level</h2>
    </center>

    <div style="margin-bottom:40px"></div>

    <div class="table table-responsive">
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Year Level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($schoolYearTable->result_array() as $row) {
                        $school_year_id = $row['school_grade_id'];
                        $name = $row['name'];?>
                   
                
                <tr>
                    <td><?= $name ?></td>
                    <td>
                        <?php $enter = base_url() . 'classes/add_subject/' . $school_year_id ?>
                        <a href="<?= $enter ?> "><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>