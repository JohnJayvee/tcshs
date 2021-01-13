
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Student Portal</title>
  <?php $url = base_url() . 'assets/admin_template/' ?>
  <!-- Custom fonts for this template-->
  <link href="<?= $url ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="<?= $url ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= $url ?>css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
<?php $administrator_url = base_url() ?>
    <a class="navbar-brand mr-1" href="<?= $administrator_url ?>">Parent Portal</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    
    </form>
<?php 
  //nav bar links ->
    $dashboard = base_url() . 'parent_student/student_page';
    $view_grades = base_url() . 'parent_student/view_grades';
    $view_attendance = base_url() . 'parent_student/view_attendance';
 ?>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
         <?php 

         $this->load->model('Main_model');
         $parent_id = $_SESSION['parent_account_id'];
         $parent_table = $this->Main_model->get_where('parent','account_id', $parent_id);

          foreach ($parent_table->result_array() as $row) {
            $account_id = $row['account_id'];
            $firstname = $row['firstname'];
            $middlename = $row['middlename'];
            $lastname = $row['lastname'];
          }
          $parent_fullname = "$firstname $middlename $lastname";

          ?>
         <p>&nbsp;&nbsp;<?=  $parent_fullname ?></p>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
   

    <div id="content-wrapper">

      <div class="container-fluid">