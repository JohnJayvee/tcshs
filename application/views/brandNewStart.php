<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Begin the academic master system</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
    <div style="margin-bottom:30px"></div>
        <center class="bg-primary p-3">
            <h1>Deploy academic master system</h1>
            <hr style="margin:5px 5px" width="40%">
            <h2>Register head administrator's account</h2>
        </center>
        <div style="margin-bottom:20px"></div>
        <form action="" method="post" onsubmit="return checkMobileNumber()">
            <?= validation_errors("<p class='alert alert-warning'>"); ?>
            <div class="form-group">
                <label for="">First name</label>
                <input type="text" name="firstname"  placeholder="Enter First name" autofocus="on" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="">Middle name</label>
                <input type="text" name="middlename"  placeholder="Enter Middle name" autofocus="on" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="">Last name</label>
                <input type="text" name="lastname"  placeholder="Enter Last name" autofocus="on" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="">Mobile number</label>
                <span class="bg-warning p-1" id='status'></span>
                <input id="characterCount" type="number" name="mobileNumber"  placeholder="Enter Mobile number" autofocus="on" class="form-control" autocomplete="off">
            </div>
            <?php $back = base_url() . "login" ?>
            <div class="row">
                <div class="col-md-6"><a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fa fa-arrow-left"></i>&nbsp; Back</button></a></div>
                <div class="col-md-6"><button type="submit" name="submit" class="btn btn-success col-md-12"><i class="fa fa-check"></i>&nbsp;Proceed</button></div>
            </div>
        </form>
    </div>
</body>
</html>
<script>
	function checkMobileNumber()
	{
		var mobileNumber = $("#characterCount").val().length;
		if (mobileNumber > 11) {
			alert('Mobile number GREATER THAN 11 characters');
			return false;
		}else if(mobileNumber < 11){
			alert('Mobile Number LESS THAN 11 characters');
			return false;
		}else{
			return true;
		}
	}
</script>

<script>
    $(document).ready(function(){
        var maxLen = 11;
        var textBox = $('#characterCount');
        var status = $('#status');

        status.text(maxLen + " Characters left");
        
        textBox.keyup(function() {
            var characters = $(this).val().length;

            status.text((maxLen - characters) + " Characters Left");

            if (maxLen < characters) {
                status.css('color', 'red');
            }else{
                status.css('color', 'black');
            }
        });
	});
</script>