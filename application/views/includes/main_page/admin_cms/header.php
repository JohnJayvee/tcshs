<!DOCTYPE html>
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
<style>
        input[type=checkbox] {
            transform: scale(2);
            -ms-transform: scale(2);
            -webkit-transform: scale(2);
            padding: 10px;
        }
    </style>
</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <?php $frontPage = base_url() . "homeController" ?>
    <a class="navbar-brand mr-1" href="<?= $frontPage ?>">Administrator</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     
    </form>

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
    <?php
        //nav bar links ->
        $dashboard = base_url() . 'manage_user_accounts/dashboard';
        $manage_account = base_url() . 'Manage_user_accounts/login';
        $upload_grade = base_url() . 'excel_import';
      ?>
  <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= $dashboard ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php if ($_SESSION['credentials_id'] == 4) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $manage_account ?>">
              <i class="fas fa-users-cog"></i>
              <span>Accounts</span>
            </a>
          </li>
        <?php } else { ?>
            <?php
            
            $adviserOrNot = $this->Main_model->adviserOrNot();
            if ($adviserOrNot) { 
              $yearLevelId = $this->Main_model->getAdviserSchoolGradeId();
              $sectionId = $this->Main_model->getSectionIdFromAdviser();
              $register = base_url() . "manage_user/register?yearLevelId=$yearLevelId&sectionId=$sectionId";
              $batchRegister = base_url() . "registerBatch?yearLevelId=$yearLevelId&sectionId=$sectionId";
              $transferees = base_url() . "manage_user_accounts/viewTransferees";
              $aquireStudents = base_url() . "manage_user_accounts/aquireStudents";
              $view = base_url() . "manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId";?>
              
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-cog"></i>
                <span>Manage Accounts</span>
              </a>

              <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <?php
                if ($this->Main_model->CurrentLogedInAdviserOrNot()) { ?>
                  <a class="dropdown-item" href="<?= $batchRegister ?>">Batch Register</a>
                  <a class="dropdown-item" href="<?= $register ?>">Register Account</a>

                  <!-- check if there are no more students to be aquired -->
                  <?php if ($this->Main_model->noStudentsToBeAcquired() == True) { ?>
                  <!-- wala nabang student na makukuha pa? that will return true. kaya kapag nag false meaning may ma aaquire pa -->
                    <a href="<?= $aquireStudents ?>" class="dropdown-item">Aquire students</a>  
                  <?php } ?>

                <?php } ?>
               
                <a class="dropdown-item" href="<?= $view ?>">View Account</a>

            <?php } ?>
            <?php 
              //determine if there are transferee students
              if ($this->Main_model->thereAreTransferees()) {?>
                <!-- //mag true true siya kapag merong mga nag transfer -->
                  <a href="<?= $transferees ?>" class="dropdown-item">View transferees</a>
                
          </div>
            
          </li>
          <?php }} ?>

          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-camera"></i>
            <span>
              CMS

              <?php
              $notif_table = $this->Main_model->get_where('sbar_notif', 'notif_id', 1);
              foreach ($notif_table->result_array() as $row) {
                $no_new_items = $row['no_new_items'];
              }

              if ($no_new_items > 0) { ?>
                <?php if ($_SESSION['credentials_id'] == 4) : ?>
                  <span class=" badge badge-danger" style="font-size: 12px;"></span>
                <?php endif ?>
              <?php } ?>

            </span>
          </a>
          <?php
          $add_content = base_url() . 'main_controller/cms_add';
          $manage_content = base_url() . 'main_controller/manage_content';
          $approve_content = base_url() . 'manage_user_accounts/approve_content';
          ?>

          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?= $add_content ?>">Add Content</a>
            <a class="dropdown-item" href="<?= $manage_content ?>">Manage Content</a>
            <?php if ($_SESSION['credentials_id'] == 4) { ?>
              <a class="dropdown-item" href="<?= $approve_content ?>">
                Approve Content

                <?php


                if ($no_new_items > 0) { ?>
                  <span class=" badge badge-danger" style="font-size: 12px;"><?= $no_new_items ?></span>
                <?php } ?>
              </a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-home"></i>
            <span>Classes</span>
          </a>
          <?php
          $add_subject = base_url() . 'classes/selectYearSubject';
          $add_section = base_url() . 'classes/schoolManagement'; //selectYearLevel

          $manage_classes = base_url() . 'classes/selectYearSubjectClasses';
          $teacher_load = base_url() . 'classes/yearSelectionTeacherLoad';
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?= $teacher_load ?>">Teacher Load</a>

            <a class="dropdown-item" href="<?= $manage_classes ?>">Manage Classes</a>
          </div>
        </li>
        <i class="fas fa-file-csv"></i>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-school"></i>
            <span>Academics</span>
          </a>
          <?php

          $view_student_grades = base_url() . 'classes/selectYearLevelStudentGrades';
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <?php if ($_SESSION['credentials_id'] != 4) : ?>
              <a class="dropdown-item" href="<?= $upload_grade ?>"><span style="font-size: 90%;">Upload Grade</span></a>
            <?php endif ?>

            <a class="dropdown-item" href="<?= $view_student_grades ?>">View Student's Grade</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fingerprint"></i>
            <span>Attendance</span>
          </a>
          <?php
          $view_ar = base_url() . 'attendance_monitoring/yearSelectionAttendanceRecord';
          $record_attendance = base_url() . 'attendance_monitoring/';
          ?>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <?php
            if ($_SESSION['credentials_id'] != 4) { ?>
              <a class="dropdown-item" href="<?= $record_attendance ?>">Record Attendance</a>
            <?php } ?>
            <a class="dropdown-item" href="<?= $view_ar ?>"><span style="font-size: 90%;">View Attendance Record</span></a>
          </div>
        </li>

        <?php
        //determine kung adviser or not
          if ($this->Main_model->CurrentLogedInAdviserOrNot()) {

            $failed = base_url() . "manage_user_accounts/failedStudents";
            //determine kung merong mga students na hindi pumasa
            $failedStudents = $this->Main_model->getFailedStudents();
            if (count($failedStudents->result_array()) != 0) { ?>
              
              <a href="<?= $failed ?>"><button class="btn btn-outline-danger col-md-10 m-3"><i class="fas fa-times"></i>&nbsp; Failed students</button></a>
          <?php }
          }
        ?>




        <?php if ($_SESSION['credentials_id'] == 4) : ?>
          <?php $year_grade = base_url() . 'manage_user_accounts/update_grade_class' ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $year_grade ?>">
              <i class="fas fa-user-graduate"></i>
              <span style="font-size: 14"> &nbsp; Level up students</span>
            </a>
          </li>

        <?php endif ?>



       
          <li class="nav-item">


            <?php
            $enterParentMode = base_url() . 'manage_user_accounts/enterParentMode';
            $this->load->model('Main_model');
            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $_SESSION['faculty_account_id']);
            foreach ($faculty_table->result_array() as $row) {
              $parent_id = $row['parent_id'];
            }

            //mag gregreen kapag na register na yung anak mo
            if ($parent_id != 0) { 
              if ($this->Main_model->checkIfTheTeacherHasAChild()) { ?>
                <a href="<?= $enterParentMode ?>"><button class="btn btn-outline-success m-1"><i class="fas fa-user-graduate"></i> &nbsp; Parent Mode</button></a>
              <?php }else{ ?>
                <button class="btn btn-outline-dark m-1"><i class="fas fa-user-graduate"></i> &nbsp; Parent Mode</button>
              <?php } ?>
            <?php } ?>


          </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

     