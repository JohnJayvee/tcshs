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
      $dashboard = base_url() . 'shs/shsTeacher';
      $manage_account = base_url() . 'Manage_user_accounts/secManageAccount';
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

        <!-- cms -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-camera"></i> &nbsp;
              <span>CMS</span>
            </a>
            <?php
              $addContent = base_url() . "shs/cms_add";
              $manageContent = base_url() . "shs/manage_content";
            ?>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="<?= $addContent ?>">Add content</a>
              <a class="dropdown-item" href="<?= $manageContent ?>">Manage content</a>
            </div>
        </li>

     <?php if ($this->Main_model->shsAdviserOrNot()) { ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user-cog"></i>
              <span>Manage Accounts</span>
            </a>
            <?php
            $batchRegister = base_url() . "shs/batchRegister";
            $register = base_url() . 'shs/registerShsStudent';
            

            //get the section and year level of the adviser
            $adviserYearLevelId = $this->Main_model->getShAdviserSchoolGradeId();
            $adviserSectionId = $this->Main_model->getSectionIdFromAdviser();

            // get the strand and the track id
            $adviserInfo = $this->Main_model->getShsAdviserInformation();
            $trackId = $adviserInfo['trackId'];
            $strandId = $adviserInfo['strandId'];
            $yearLevel = $adviserInfo['yearLevelId'];
            $sectionId = $adviserInfo['sectionId'];

            $view = base_url() . "shs/viewShsStudentAccounts?yearLevelId=$yearLevel&strandId=$strandId&sectionId=$sectionId";
            ?>

            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="<?= $batchRegister ?>">Batch register</a>
              <a class="dropdown-item" href="<?= $register ?>">Register Account</a>
              <a class="dropdown-item" href="<?= $view ?>">View Account</a>
            </div>
          </li>
        <?php } ?>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-home"></i>
              <span>Classes</span>
            </a>
          <?php  
            $teacherLoad = base_url() . "shs/selectStrandTeacherLoad";
            $manageClasses = base_url() . "shs/manageClassesStrand";
          ?>
          
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?= $teacherLoad ?>">Teacher load</a>
            <a class="dropdown-item" href="<?= $manageClasses ?>">Manage classes</a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-school"></i>
            <span>Academics</span>
          </a>
          <?php
          $uploadGrade = base_url() . "shs/uploadGrade";
          $view_student_grades = base_url() . 'classes/selectYearLevelStudentGrades';
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
              <a class="dropdown-item" href="<?= $uploadGrade ?>"><span style="font-size: 90%;">Upload Grade</span></a>
              <a class="dropdown-item" href="<?= $view_student_grades ?>">View Student's Grade</a>
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
            if ($parent_id > 0) { ?>
              <a href="<?= $enterParentMode ?>"><button class="btn btn-outline-success m-3"><i class="fas fa-user-graduate"></i> &nbsp; Parent Mode</button></a>
            <?php } else { ?>
              <a href=""><button class="btn btn-outline-secondary m-3"><i class="fas fa-user-graduate"></i> &nbsp; Parent mode</button></a>
            <?php } ?>

            </a>
          </li>
        <?php endif ?>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">