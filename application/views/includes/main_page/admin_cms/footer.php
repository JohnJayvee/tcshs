</div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
 

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url() . 'login?logout=1'?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
<?php $url = base_url() . 'assets/admin_template/' ?>
  <!-- Bootstrap core JavaScript-->
  <script src="<?= $url ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= $url ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= $url ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="<?= $url ?>vendor/datatables/jquery.dataTables.js"></script>
  <script src="<?= $url ?>vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= $url ?>js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="<?= $url ?>js/demo/datatables-demo.js"></script>

 
  <!-- scripts for the dynamic drop down -->
  <!-- <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script> -->

<!-- for notification disapear -->
<script>
  $(document).ready(function(){
    setTimeout(function(){
			$("#disappear").fadeOut(3000);
		}, 12000);
  });
</script>


</body>

</html>

