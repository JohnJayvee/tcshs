<div class="container">
    <div style="margin-bottom:20px"></div>

    <center class="bg-warning p-3">
        <h1>
            View Accounts
        </h1>
        <hr width="40%">
        <h2>Select Year Level</h2>
    </center>
    <div style="margin-bottom:40px"></div>
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
              <!-- remove empty year levels -->
              <?php 
                    // determine if there is a student in that particular year level
                    $studentProfileTable = $this->Main_model->get_where('student_profile', 'school_grade_id', $row->school_grade_id);
                    if (count($studentProfileTable->result_array()) == 0) {
                        continue;
                    }
                ?>
                <tr>
                    <td><?= $row->name; ?></td>
                    <td>
                        <?php $enter = base_url() . 'manage_user/viewAccountSection?yearLevelId=' . $row->school_grade_id ?>
                        <a href="<?= $enter ?>"><button class="btn btn-primary col-md-12">Enter</button></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php $ownSection = base_url() . "manage_user/viewOwnSection" ?>
    <a href="<?= $ownSection ?>"><button class="btn btn-info col-md-12"><i class="fas fa-eye"></i>&nbsp; View own section</button></a>
</div>

<script type="text/javascript">
		$(document).ready(function(){

		    $('#title').autocomplete({
                source: "<?php echo site_url('manage_user/get_autocomplete');?>",
     
                select: function (event, ui) {
                    $(this).val(ui.item.label);
                    $("#form_search").submit(); 
                }
            });

		});
	</script>