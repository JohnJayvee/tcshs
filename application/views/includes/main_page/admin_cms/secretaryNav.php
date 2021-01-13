<DOCTYPE html>
  <html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator Mode</title>
    <?php $url = base_url() . 'assets/admin_template/' ?>
    <!-- Custom fonts for this template-->
    <link href="<?= $url ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="<?= $url ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url ?>css/sb-admin.css" rel="stylesheet">

    <!-- para doon sa year picker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
      <?php $administrator_url = base_url() ?>
      <a class="navbar-brand mr-1" href="<?= $administrator_url ?>">Administrator</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

      </form>
      <?php
      //nav bar links ->
      $dashboard = base_url() . 'manage_user_accounts/secretaryView';
      //$manage_account = base_url() . 'Manage_user_accounts/secManageAccount'; // ito yung with shs.
      $juniorHighSchool = base_url() . 'manage_user_accounts/viewJuniorHighSchoolFaculty';
      $seniorHighSchool = base_url() . 'manage_user_accounts/viewSeniorHighSchoolFaculty'; 
      $upload_grade = base_url() . 'excel_import';
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
            $faculty_id = $_SESSION['faculty_account_id'];
            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);

            foreach ($faculty_table->result_array() as $row) {
              $faculty_fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
            }
            ?>
            <p>&nbsp;&nbsp;<?= $faculty_fullname ?></p>
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



        <?php if ($_SESSION['credentials_id'] == 5) { ?>
          <li class="nav-item dropdown">
            <!-- <a class="nav-link" href="<?= $manage_account ?>">
              <i class="fas fa-users-cog"></i>
              <span>Accounts</span>
            </a> -->
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-cog"></i>
              <span>Accounts</span>
            </a>
            <?php $changePrincipal = base_url() . "manage_user_accounts/change_principal" ?>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="<?= $juniorHighSchool ?>">JHS faculty members</a>
              <a class="dropdown-item" href="<?= $seniorHighSchool ?>">SHS faculty members</a>
              <a class="dropdown-item" href="<?= $changePrincipal ?>">Change principal</a>
            </div>
          </li>
        <?php } else { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-cog"></i>
              <span>Manage Accounts</span>
            </a>
            <?php
            $register = base_url() . 'Manage_user/register';

            $view = base_url() . 'Manage_user/view_student_account';
            ?>

            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="<?= $register ?>">Register Account</a>
              <a class="dropdown-item" href="<?= $view ?>">View Account</a>
            </div>
          </li>


        <?php  }  ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-home"></i>
            <span>JHS management</span>
          </a>
          <?php
          $yearAndSections = base_url() . "classes/selectYearLevel?schoolLevel=1";
          $subjects = base_url() . "classes/selectYearSubject";
          $sectionAdviser = base_url() . "manage_user_accounts/manageSectionAdvisers/1";
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?= $sectionAdviser ?>" style="font-size:90%;">Section advisers</a>
            <a class="dropdown-item" href="<?= $yearAndSections ?>" style="font-size:90%;">Year &amp; Sections</a>
            <a class="dropdown-item" href="<?= $subjects ?>">Manage subjects</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-home"></i>
            <span>SHS management</span>
          </a>
          <?php
          $trackStrand = base_url() . "shs";
          $section = base_url() . "shs/sectionsSelectYearLevel";
          $subjects = base_url() . "shs/subjectYearSelection";
          $sectionAdviser = base_url() . "manage_user_accounts/shsSectionAdviserYearLevel";
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?= $sectionAdviser ?>" style="font-size:90%;">Section advisers</a>
            <a class="dropdown-item" href="<?= $trackStrand ?>" style="font-size:90%;">Track &amp; Strand</a>
            <a class="dropdown-item" href="<?= $section ?>">Year &amp; Section</a>
            <a class="dropdown-item" href="<?= $subjects ?>">Subjects</a>
          </div>
        </li> 










        <?php if (isset($_SESSION['faculty_account_id'])) : ?>
          <li class="nav-item">


            <?php


            $this->load->model('Main_model');
            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $_SESSION['faculty_account_id']);
            foreach ($faculty_table->result_array() as $row) {
              $parent_id = $row['parent_id'];
            }
            $enterParentMode = base_url() . 'manage_user_accounts/enterParentMode';

            //mag gregreen kapag na register na yung anak mo
            if ($parent_id != 0) { 
              if ($this->Main_model->checkIfTheTeacherHasAChild()) { ?>
                <a href="<?= $enterParentMode ?>"><button class="btn btn-outline-success m-1"><i class="fas fa-user-graduate"></i> &nbsp; Parent Mode</button></a>
              <?php }else{ ?>
                <button class="btn btn-outline-dark m-1"><i class="fas fa-user-graduate"></i> &nbsp; Parent Mode</button>
              <?php } ?>
            <?php } ?>

            </a>
          </li>
        <?php endif ?>

      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">