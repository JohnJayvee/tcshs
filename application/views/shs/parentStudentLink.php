<div class="container">
    <div style="margin-bottom:20px"></div>
    <center class="bg-warning p-3">
        <h1>Parent and Student link</h1>
        <hr width="50%" style="margin: 5px 5px">
        <h2>Select a parent for <strong><?= $studentFullName ?></strong></h2>
    </center>
    <div style="margin-bottom:20px"></div>
    <form action="" method="post">
    <div class="table table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Parent Name</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <!-- this is already in jquery -->
            </tbody>
        </table>
    </div>
    <div class="row">
    <?php $back = base_url() . "shs/registerShsParent" ?>
        <div class="col-md-6"><a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a></div>
        <div class="col-md-6">
            <input type="submit" name="submit" class="btn btn-primary col-md-12" value="Link">
        </div>
    </div>
</form>
</div>

<script>
    $(document).ready(function(){
      $('tbody').load("<?= base_url() . "shs/parentStudentLinkRealTime" ?>");
    });
</script>