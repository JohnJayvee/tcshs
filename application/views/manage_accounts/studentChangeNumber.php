<?php 
    if (isset($_SESSION['numberMore'])) {
        echo "<script>alert('Number is MORE than 11 numbers');</script>";
        unset($_SESSION['numberMore']);
    }

    if (isset($_SESSION['numberLess'])) {
        echo "<script>alert('Number is LESS than 11 numbers');</script>";
        unset($_SESSION['numberLess']);
    }
?>

<?php $this->load->model('Main_model'); ?>
<div class="container">
    <div class="row bg-primary m-3 p-3">
    <div class="col-sm-12">
        <h1 align="center">Update mobile number</h1>
        <h3 align="center"><?= ucfirst($studentFullName) ?></h3>
        <div style="margin-botom:10px"></div>&nbsp;
        
            
            
            <?php $back  = base_url() . "parent_student/student_page" ?>
            <?php $form = base_url() . 'parent_student/studentChangeNumber' ?>
                <form action="<?= $form ?>" method="post">
                    <div class="form-group">
                        <label for="">Update Number</label>
                        <span id="status"></span>
                        <input type="number" id="characterCount" name="newNumber" class="form-control" value="<?= $mobileNumber ?>">
                    </div>
            </div>
                <button type="submit" name="submit" class="btn btn-success col-md-12">Update</button>
            </form>
           
    </div>
    </div>
</div>
<!-- to get the character counter -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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

