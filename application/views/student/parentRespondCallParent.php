<div class="container">
    <div style="margin-bottom:40px"></div>
    <div class="bg-warning p-4">
        <h1 align="center">View teacher's Mobile Number</h1>
    </div>

    <div style="margin-bottom:40px"></div>

    <div class="row">
        <div class="col-sm-4 m-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <!-- The text field -->
                    <input type="text" value="12345678912" id="myInput" readonly="readyonly" class="form-control"><br>

                    <!-- The button used to copy the text -->
                    <button onclick="myFunction()" class="btn btn-primary col-md-12"><i class="fas fa-clipboard-list"></i>&nbsp; Copy text</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4 m-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <!-- The text field -->
                    <input type="text" value="12345678912" id="myInput" readonly="readyonly" class="form-control"><br>

                    <!-- The button used to copy the text -->
                    <button onclick="myFunction()" class="btn btn-primary col-md-12"><i class="fas fa-clipboard-list"></i>&nbsp; Copy text</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4 m-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <!-- The text field -->
                    <input type="text" value="12345678912" id="myInput" readonly="readyonly" class="form-control"><br>

                    <!-- The button used to copy the text -->
                    <button onclick="myFunction()" class="btn btn-primary col-md-12"><i class="fas fa-clipboard-list"></i>&nbsp; Copy text</button>
                </div>
            </div>
        </div>
    </div><!--  card body -->

</div>

<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    }
</script>