<div class="container">
    <div style="margin-bottom:20px"></div>


    <div class="col-md-12 p-3 bg-warning">
        <span style="font-size: 35px;">Would you like <b><?= $teacherName ?></b> to be your new secretary?</span><br>
        <div style="margin-bottom:20px"></div>
        <?php 
            $back = base_url() . "manage_user_accounts/assignSecretary/";
            $url = base_url() . "manage_user_accounts/assignNewSecretary/$teacherId";
        ?>
        <form action="<?= $url ?>" method="post">
        <div class="row ml-1">
            <div class="col-md-6">
                <input type="checkbox" name="teacherConfirm"> &nbsp;
                <label style="font-size: 20px"><b>Previous</b> secretary <?= $prevSecText ?></label>
            </div>
            <div class="col-md-6">
                <input type="checkbox" name="newSecConfirm"> &nbsp;
                <label style="font-size: 20px"><b>New</b> secretary will be a teacher</label>
            </div>
        </div>

        <div style="margin-bottom:20px"></div>

        <div class="row">
            <div class="col-md-6">
                <a href="<?= $back ?>"><button type="button" class="btn btn-secondary col-md-12"><i class="fas fa-arrow-left"></i> &nbsp; Back</button></a>
            </div>
            <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-success col-md-12"><i class="fas fa-check"></i> &nbsp; Proceed</button>
            </div>
        </div>
        </form>
    </div>

    
</div> <!-- container -->