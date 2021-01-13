<div class="container">
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->banner("Manage failed students", "$yearLevelName | $sectionName"); ?>
    <div style="margin-bottom:20px"></div>
    <?php $this->Main_model->alertSuccess('transferee', "Student's account has been moved into the student transferees table and the account has been deactivated"); ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($failedStudents->result() as $row) { 
                    $transfer = base_url() . "manage_user_accounts/transferStudents/" . $row->student_profile_id;
                    $reassign = base_url() . "";
                    $studentName = $this->Main_model->getFullNameSliced('student_profile', "account_id", $row->student_profile_id);?>

                    <tr>
                        <td><?= ucfirst($studentName['firstname']) ?></td>
                        <td><?= ucfirst($studentName['middlename']) ?></td>
                        <td><?= ucfirst($studentName['lastname']) ?></td>
                        <td>
                            
                            <a href="<?= $transfer ?>"><button class="btn btn-primary col-md-12"> Transfer</button></a>
                            <div style="margin-bottom:10px"></div>
                            <a href="<?= $reassign ?>"><button class="btn btn-info col-md-12">Reassign section</button></a>
                            
                        </td>
                    </tr>
                <?php } ?>
                
            </tbody>
        </table>
    </div>
    <div style="margin-bottom:20px"></div> &nbsp;
    <?php $back = base_url() . "manage_user_accounts/dashboard" ?>
    <a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>