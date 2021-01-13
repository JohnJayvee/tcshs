<div style="margin-bottom:20px"></div>



<div class="container">

	<?php $this->Main_model->banner("View classes", "$yearLevelName | $sectionName"); ?>
	
	
	<div style="margin-bottom:10px"></div>
    <button class="btn btn-primary col-md-12" id="ddBtn">Filter students &nbsp;<i class="fas fa-angle-down"></i></button>
    <div style="margin-bottom:5px"></div>
    <div class="col-md-12 bg-primary p-4" id="ddDiv">
        <div class="form-group">
            <label style="font-size: 20px">Filter by subject:</label>
            <select name="subjectDd" id="subjectDd" class="form-control">
                <option value="">Select subject</option>
                <?php foreach ($subjectTable->result() as $row) { ?>
                    <option value="<?= $row->subject_id ?>"><?= $row->subject_name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div style="margin-bottom:25px"></div>
	

	<div class="card-body">
		<div class="table-responsive">
			<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
				<thead>
					<tr>
						<th> Subject Name</th>
						<th> Teacher</th>
						<th> Student</th>
						<th> Class Schedule</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($classTable->result() as $row) { ?>

					<tr>
						<td>
							<?= $this->Main_model->grade10SubjectRepositoryManager($row->subject_id);?>
						</td>

						<td>
							<?= $this->Main_model->facultyRepository($row->faculty_id);?>
						</td>

						<td>
							<?= $this->Main_model->g10StudentRepositoryManager($row->student_profile_id);?>
						</td>

						<td>
							<?= strtoupper($row->class_sched);?>
						</td>
					</tr>
				 <?php } ?>
				</tbody>

			</table>
		</div>
	</div><br>
	<?php $back = base_url() . "classes/selectSectionClasses?yearLevelId=$yearLevelId"; ?>
	<a href="<?= $back ?>"><button class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i>&nbsp; Back</button></a>
</div>
<?php $filterTableSubj = base_url() . "classes/filterClassWithSubject" ?>
<script>
	$(document).ready(function(){
		 //toggle filter dropdown
		 $('#ddDiv').hide();

		$('#ddBtn').click(function(){
			$('#ddDiv').fadeToggle('slow');
		});


		$("#subjectDd").change(function(){
            
            var subjectaydi = $("#subjectDd").val();
            //change the tables.
            $.post("<?= $filterTableSubj ?>",
            {
                subjectId: subjectaydi,
                yearLevel: <?= $_GET['yearLevelId'] ?>,
                sectiionId: <?= $sectionId ?>
            },function(data){
                $('tbody').html(data);
            }); 
        }); //change  
	});
</script>