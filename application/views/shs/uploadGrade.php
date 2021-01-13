<div class="container">
    <?php $this->Main_model->banner("Upload student grade", "Select school year"); ?>
    <div style="margin-bottom:-10px"></div>
    <div class="col-md-12 bg-info p-4" align="center">

        <form action="" method='post'>
            <span style="font-size: 30px; font-weight: bold;">Select school year</span>
            <div style="margin-bottom:20px"></div>
            <input class="date-own form-control" style="width: 60%;" type
            ="text" name="school_year" placeholder="Click to insert school year" autocomplete="off" required>


            <script type="text/javascript">
                $('.date-own').datepicker({
                    minViewMode: 2,
                    format: "yyyy"
                });
            </script>
            <div style="margin-bottom: 20px;"></div>
            <button type="submit" class="col-md-6 btn btn-dark" name="submit">Enter</button>
        </form>
    </div>
</div>