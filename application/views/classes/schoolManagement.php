<div class="container">
    <div style="margin-bottom:50px;"></div>
    <center>
        <h1 style="text-align:center">Manage School</h1>
        <hr width="60%">
        <h3>Select Academic Level</h3>
    </center>
    <br>

    <!-- notification -->
    <?php
    $this->Main_model->alertSuccess('seniorHighActivated', 'You can now manage the Senior Highschool Students');
    ?>

    <div class="table table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Academics</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($academicGrade->result() as $row) {
                    $academicName = $row->academic_name;
                    $academicId = $row->academic_grade_id; ?>

                    <tr>
                        <td><?= $academicName ?></td>
                        <td>
                            <?php
                            //url 
                            $create = base_url() . "classes/schoolManagement?instruction=$academicId";

                            //the system should redirect the teachers to manage the strands of the senior highschool
                            if ($academicId == 2) {
                                $enter = base_url() . "classes/seniorHighSchoolManagement";
                            } else {
                                $enter = base_url() . "classes/selectYearLevel?schoolLevel=$academicId";
                            }

                            $yearLevelIdCount = $this->Main_model->checkYearLevel($academicId);

                            if ($yearLevelIdCount == 0) { ?>
                                <!-- //kailangan niya pang mag create -->
                                <a href="<?= $create ?>" id="create"><button class="btn btn-success col-md-12">Activate</button></a>
                            <?php } else { ?>
                                <a href="<?= $enter ?>"><button class="btn btn-info col-md-12">Enter</button></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom:30px"></div>&nbsp;

</div> <!--  container  -->