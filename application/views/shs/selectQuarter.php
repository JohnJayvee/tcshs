<div class="container">
    <?php $this->Main_model->banner("Upload student grade", "$sectionName | $subjectName | $semesterName"); ?>

    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark p-1" style="color: white;" align="center">
                    <th colspan="2">Select quarter</th>
                </tr>
                <tr>
                    <th>Quarter</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if ($semester == 1) {
                    $td1 = "First quarter";
                    $td2 = "Second quarter";

                    $a1 = base_url() . "shs/uploadShsGrade/1";
                    $a2 = base_url() . "shs/uploadShsGrade/2";
                }else{
                    $td1 = "Third quarter";
                    $td2 = "Fourth quarter";

                    $a1 = base_url() . "shs/uploadShsGrade/3";
                    $a2 = base_url() . "shs/uploadShsGrade/4";
                }
            ?>
                <tr>
                    <td><?= $td1 ?></td>
                    <td width="20%">
                        <a href="<?= $a1 ?>"><button class="btn btn-success"><i class="fas fa-upload"></i>&nbsp;Upload grade</button></a>
                    </td>
                </tr>
                <tr>
                    <td><?= $td2 ?></td>
                    <td width="20%">
                        <a href="<?= $a2 ?>"><button class="btn btn-success"><i class="fas fa-upload"></i>&nbsp;Upload grade</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php $back = base_url() . "shs/uploadGradePartTwo" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>