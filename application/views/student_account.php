<div align="center">
	<h1 align="center"> you are in Student Profile manager</h1>
<?php 
$url = base_url() . 'main_controller/index';
$log_out = base_url() . 'main_controller/student_account?logout=1';
?>
<a href="<?= $url ?>">
	<button>
		back
	</button>
</a>	<br><br>

<a href="<?= $log_out ?>">
	<button>
		Log Out
	</button>
</a>
</div>