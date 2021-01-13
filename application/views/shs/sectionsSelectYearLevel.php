<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning col-md-12 p-1">
        <h1>Year and Section management</h1>
        <hr width="60%" style="margin:5px 5px;">
        <h3>Select year Level</h3>
    </center>
    <div style="margin-bottom:30px"></div>
    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Year level</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($yearLevelTable->result() as $row) { ?>
                    <tr>
                        <td><?= $row->name ?></td>
                        <td>
                            <?php $enter = base_url() . "shs/sectionsSelectStrand?yearLevelId=" . $row->school_grade_id ?>
                            <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter &nbsp;<i class="fas fa-arrow-right"></i></button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>