<div style="margin-bottom: 20px"></div>


<div class="container">
	<!-- <h1 align="center">Assign your teacher Load</h1><hr style="width:50%;">
	<div align="center" style="font-size: 25px"></div> -->

	<center class="bg-warning p-3">
		<h1>Assign your teacher load</h1>
		<hr width="40%" style="margin:5px 5px">
		<h2><?= ucfirst($teacher_fullname) ?></h2>
        <span  style="font-size:20px"> <span><strong> <?= $yearLevelName ?></strong></span> | <span><strong><?= $sectionName ?></strong></span> | <span><strong><?= $subjectName ?></strong></span></span>
	</center>
	 
	<div style="margin-bottom: 10px"></div>
	<?php $form = base_url() . "shs/teacher_load?yearLevelId=$yearLevelId&sectionId=$sectionId&subjectId=$subjectId&strandId=$strandId";  ?>
	<form action="<?= $form ?>" method="post">

		<input type="hidden" name="teacher" value="<?= $faculty_account_id?>" >

        <div class="form-group">
            <label style="font-size:20px;">Enter Schedule: </label>
            <input type="text" autofocus="on" name="schedule" placeholder="Enter Schedule here (MTH 7:30 - 10:30)" class="form-control" autocomplete="off" required>
        </div>
        
        <div class="form-group">
            <label style="font-size:20px;">Select semester: </label>
            <select name="semester" id="semester" class="form-control" required>
                <option value="">Select semester</option>
                <option value="1">First semester</option>
                <option value="2">Second semester</option>
            </select>
        </div>
        
        <div class="form-group">
            <label style="font-size:20px;">Select quarter: </label>
            <select name="quarter" id="quarter" class="form-control" required>
                <option value="">Select quarter</option>
                <option value="1">First quarter</option>
                <option value="2">Second quarter</option>
            </select>
        </div>

		<div style="margin-bottom:30px"></div>
		<button type="submit" name="submit" class="btn btn-primary col-md-12">Submit</button>
		<div style="margin-bottom:10px"></div>
		<?php $view_teacher_load = base_url() ."shs/viewOtherTeacherLoad"; ?>
	
	</form>
		<?php $back = base_url() . "shs/subjectSelectionTeacherLoad?yearLevelId=$yearLevelId&sectionId=$sectionId&strandId=$strandId";?>
	<!-- <div class="d-flex justify-content-between" style="margin-top:-10px;">
		
		
	</div> -->

	<div class="row">
		<div class="col-md-6">
			<a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12">Back</button></a>
		</div>
		<div class="col-md-6">
			<a href="<?= $view_teacher_load ?>"><button type="button" class="btn btn-info col-md-12">View teacher Loads</button></a>
		</div>
	</div>
	
</div>
<?php
 $firstSemester = "<option value=''>Select quarter</option> <option value='1'>1st quarter</option> <option value='2'>2st quarter</option>"; 
 $secondSemester = "<option value=''>Select quarter</option> <option value='3'>3rd quarter</option> <option value='4'>4rth quarter</option>"; 
?>
<script>
    $(document).ready(function(){
        $("#semester").change(function(){
            var semester = $("#semester").val();
            
            if (semester == 1) {
                $("#quarter").html("<?= $firstSemester ?>");
            }else{
                $("#quarter").html("<?= $secondSemester ?>");
            }
        });
    });
</script>



