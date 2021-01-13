

 <div class="container alert alert-warning">
 	
 	<div class="row alert alert-warning">
 		<h1>Class attendance has been recorded successfully</h1>

		<?php 
			if ($absentCount > 0) {?>
				<h2 class="text-danger">The parents of the absent students has already  been informed</h2>		
			<?php }else{ ?>
				<h2 class="text-success">No record of absences!</h2>
			<?php } ?>

 		<br>
			
	</div>
 		<?php $back = base_url() . 'attendance_monitoring' ?>
 	<a href="<?= $back ?>">
 		<button class="btn btn-success col-md-4">
 			Back
 		</button>
 	</a>
 	
 </div>
