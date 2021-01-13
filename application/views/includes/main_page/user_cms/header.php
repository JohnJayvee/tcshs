
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
    <a class="navbar-brand mr-1" href="<?= $administrator_url ?>">Student Portal</a>

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

          if (isset($_SESSION['parent_account_id'])) {
            $name = $this->Main_model->getFullNameWithId('parent', 'account_id' ,$_SESSION['parent_account_id']);
          }elseif (isset($_SESSION['student_account_id'])) {
            $name = $this->Main_model->getFullNameWithId('student_profile', 'account_id' ,$_SESSION['student_account_id']);
          }

          ?>
         <p>&nbsp;&nbsp;<?=  $name ?></p>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?= $dashboard ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

     
  
   
        
      


    

    

      <li class="nav-item">
        <a class="nav-link" href="<?= $view_grades ?>">
         <i class="fas fa-graduation-cap"></i>
          <span>View Grades</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link" href="<?= $view_attendance ?>">
       <i class="fas fa-fingerprint"></i>
          <span>View Attendance</span>
        </a>
      </li>

       <?php if (isset($_SESSION['faculty_account_id'])): ?>
        <?php $facultMode = base_url() . 'manage_user_accounts/dashboard' ?>
      <li class="nav-item">
        
          <?php 

          $this->load->model('Main_model');
          $faculty_table = $this->Main_model->get_where('faculty','account_id', $_SESSION['faculty_account_id']);
          foreach ($faculty_table->result_array() as $row) {
            $parent_id = $row['parent_id'];
          }

          //mag gregreen kapag na register na yung anak mo
          if ($parent_id > 0) {?>
            <?php 
              if ($_SESSION['credentials_id'] == 5) {
                $facultMode = base_url().'manage_user_accounts/secretaryView';
              }else{
                $facultMode = base_url() . 'manage_user_accounts/dashboard';
              }
            ?>
            <a href="<?= $facultMode ?>">
              <button class="btn btn-outline-success m-3"> <i class="fas fa-user-graduate"></i> Faculty Mode</button>
            </a>
         <?php } ?>
          
        </a>
      </li>
    <?php endif ?> 

 
   
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">