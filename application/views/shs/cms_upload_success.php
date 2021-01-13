

 <div class="container">
 	
 	<div class="alert alert-warning">
 		<strong>Content Successfully Uploaded</strong><br><br>
 		<?php 
 		if ($_SESSION['credentials_id'] == 4) {
 			echo "<p>Content Uploaded and can be viewed already from the website</p>";
 		}else{
 			echo "<p>Your Upload will be posted after the approval of the principal</p>";
 		}


 		 ?>
 		<br><br>

 		<?php $back = base_url() . 'shs/cms_add' ?>
 	<a href="<?= $back ?>">
 		<button class="btn btn-secondary col-md-12">
         <i class="fas fa-arrow-left"></i>&nbsp;
 			Back
 		</button>
 	</a>
 	</div>
 </div>
