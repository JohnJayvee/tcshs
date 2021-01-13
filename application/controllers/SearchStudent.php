<?php 

class SearchStudent extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->Main_model->accessGranted();
    }

    // function hashdis()
    // {
    //    echo $this->Main_model->passwordEncryptor('potpot');
    // }
    

    function index()
    {
        $this->form_validation->set_rules('search','Student Search','required');
        if ($this->form_validation->run()) {
            $studentName = $this->input->post('search');
            $data['studentTable'] = $this->Main_model->searchStudent($studentName);
        }
        $secId = $_SESSION['faculty_account_id'];
        $data['faculty_id'] = $secId;
        $data['fullname'] = $this->Main_model->getFullname('faculty', 'account_id', $secId);
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('manage_accounts/secretaryViewSearch',$data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function selectSubjectGrades()
    {
        $studentId = $this->input->get('studentId');
        $studentTable = $this->Main_model->get_where('student_profile','account_id',$studentId);
        
        foreach ($studentTable->result() as $row) {
            $sectionId = $row->section_id;
            $gradeLevelId = $row->school_grade_id;
            
        }
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
        $data['gradeLevelName'] = $this->Main_model->getYearLevelNameFromId($gradeLevelId);

        $data['classTable'] = $this->Main_model->get_where('class', 'student_profile_id', $studentId);
        
        $classTable = $this->Main_model->get_where('class', 'student_profile_id', $studentId);

        if (count($classTable->result_array()) <= 0) {
            $this->session->set_userdata('noGradeAvailable',1);
            redirect("manage_user_accounts/secretaryView");
        }

        $data['studentFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);

        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $gradeLevelId;
        $data['studentId'] = $studentId;
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('student/selectSubjectGrades', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function studentSearchGrades()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $sectionId = $this->input->get('sectionId');
        $subjectId = $this->input->get('subjectId');
        $facultyId = $this->input->get('facultyId');
        $studentId = $this->input->get('studentId');
        
        //submit get for back process
        $data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;
        $data['subjectId'] = $subjectId;
        $data['facultyId'] = $facultyId;
        $data['studentId'] = $studentId;

       
        //get names and send them to data
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
        $data['subjectName'] = $this->Main_model->getSubjectNameFromId($subjectId);
        $data['studentName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);
        
        
        //get name of the student
        $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
        foreach ($studentTable->result() as $row) {
            $studentFirstname = $row->firstname;
            $studentMiddlename = $row->middlename;
            $studentLastname = $row->lastname;
        }

        //arrange name for student;
        $arrangedName = "$studentLastname,$studentFirstname$studentMiddlename";
        

        //define where for searching
        $where['student_name'] = $arrangedName;
        $where['subject_id'] = $subjectId;
        $where['section_id'] = $sectionId;
        $where['faculty_id'] = $facultyId;
        
        //get student grades table
        $data['studentGradesTable'] = $this->Main_model->multiple_where('student_grades', $where);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('student/studentSearchGrades', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function selectSubjectAttendance()
    {
        $studentId = $this->input->get('studentId');
        $classTable = $this->Main_model->get_where('class', 'student_profile_id', $studentId);
        
        //checker kung meron bang data o wala
        if (count($classTable->result_array()) >= 0) {
            $this->session->set_userdata('noAttendanceRecord',1);
            redirect('manage_user_accounts/secretaryView');
        }

        //get student's info
        $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
        foreach ($studentTable->result() as $row) {
            $yearLevelId = $row->school_grade_id;
            $sectionId = $row->section_id;
        }
        
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);


        //send data to view 
        $data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;
        $data['studentId'] = $studentId;
        $data['classTable'] = $classTable;
        $data['studentFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);
        
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('student/selectSubjectAttendance', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function studentSearchAttendance()
    {
        //get recoreds
        $yearLevelId = $this->input->get('yearLevelId');
        $sectionId = $this->input->get('sectionId');
        $subjectId = $this->input->get('subjectId');
        $facultyId = $this->input->get('facultyId');
        $studentId = $this->input->get('studentId');
        $classId = $this->input->get('classId');

        //get year level name and section name
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
        $data['studentFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);
        $data['studentId'] = $studentId;
   
        //get attendance record
        $data['attendanceRecord'] = $this->Main_model->get_where('attendance', 'class_id', $classId);
        

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('student/studentSearchAttendance', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function adminSelectStudent()
    {
        $this->form_validation->set_rules('studentName','Student Name','required');
        if ($this->form_validation->run()) {
            $studentName = $this->input->post('studentName');
            $data['studentTable'] = $this->Main_model->searchStudent($studentName);
            
        }
        $data['facultyName'] = $this->Main_model->getFullNameWithId('faculty','account_id',$_SESSION['faculty_account_id']);
        
        
        $this->load->view('includes/main_page/admin_cms/header');
        $this->load->view("manage_accounts/adminStudentSearchSelectStudent", $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function adminGradesSubjectSelection()
    {
        $studentId = $this->input->get("studentId");
        $classTable = $this->Main_model->get_where('class', 'student_profile_id', $studentId);
        
        //emtpy checker
        if (count($classTable->result_array()) <= 0) {
            $this->session->set_userdata('emptyGrades',1);
            redirect("manage_user_accounts/dashboard");
        }

        //get student's information
        $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
        foreach ($studentTable->result() as $row) {
            $yearLevelId = $row->school_grade_id;
            $sectionId = $row->section_id;   
        }
        
        //get class table para makuha yung subjects
        $data['classTable'] = $this->Main_model->get_where('class', 'student_profile_id', $studentId);
        $data['studentId'] = $studentId;
        $data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
        $data['studentNameFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);
        $data['facultyName'] = $this->Main_model->getFullname('faculty', 'account_id', $_SESSION['faculty_account_id']);
        $this->load->view('includes/main_page/admin_cms/header');
        $this->load->view("manage_accounts/adminSelectSubjectGrades", $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function adminViewGrades()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
        $facultyId = $this->input->get('facultyId');
        $studentId = $this->input->get('studentId');

        //get the arranged name of the student
        $studentTable = $this->Main_model->get_where("student_profile", 'account_id', $studentId);
        foreach ($studentTable->result() as $row) {
            $firstname = $row->firstname;
            $middlename = $row->middlename;
            $lastname = $row->lastname;
        }
        $arrangedName = "$lastname,$firstname$middlename";

        //get the grades according to the name
        $data['studentGradesTable'] = $this->Main_model->get_where('student_grades', 'student_name', $arrangedName);
        
        //send the data
        $data['studentNameFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);
        $data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameWithId($sectionId);        
        $data['facultyName'] = $this->Main_model->getFullNameWithId('faculty','account_id',$_SESSION['faculty_account_id']);
        $data['subjectName'] = $this->Main_model->getSubjetNameWithId($subjectId);   
        $data['studentId'] = $studentId;
        // load view
        $this->load->view('includes/main_page/admin_cms/header');
        $this->load->view("manage_accounts/adminSearchViewGrades", $data);
        $this->load->view('includes/main_page/admin_cms/footer');


    }

    function adminSubjectSelection()
    {
        $studentId = $this->input->get('studentId');
        
        //objective: to display the subjects
        
        //get the full name of the student
        $data['studentNameFullName'] = $this->Main_model->getFullNameWithId('student_profile','account_id',$studentId);
        $data['facultyName'] = $this->Main_model->getFullNameWithId('faculty','account_id',$_SESSION['faculty_account_id']);

        //get the section and the year level
        $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
        foreach ($studentTable->result() as $row) {
            $yearLevelId = $row->school_grade_id;
            $sectionId = $row->section_id;
        }

        //get yearLevelName and SectionName
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);

        //get the subjects using the class table
        $where['student_profile_id'] = $studentId;
        $where['section_id'] = $sectionId;
        $where['school_grade_id'] = $yearLevelId;
        
        $classTable = $this->Main_model->multiple_where('class', $where);
        $data['classTable'] = $classTable;
        
        //give I.D
        $data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;
        $data['studentId'] = $studentId;

        // return kapag walang data
        if (count($classTable->result_array()) <= 0) {
            $this->session->set_userdata('noAttendance', 1);
            redirect('manage_user_accounts/dashboard');
        }

        //load view
        $this->load->view('includes/main_page/admin_cms/header');
        $this->load->view("manage_accounts/adminSubjectSelectionAttendance", $data);
        $this->load->view('includes/main_page/admin_cms/footer');

    }

    function attendanceRecordSearchAdmin()
    {
        //objective: get the attendance record of the student

        //get variables needed
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
        $facultyId = $this->input->get('facultyId');
        $studentId = $this->input->get('studentId');
        $yearLevelId = $this->input->get('yearLevelId');
        $classId = $this->input->get('classId');

        //get the attendance table
        $attendanceTable = $this->Main_model->get_where('attendance', 'class_id', $classId);
        
        //supply data to the view
        $data['facultyName'] = $this->Main_model->getFullname('faculty', 'account_id', $facultyId);
        $data['studentNameFullName'] = $this->Main_model->getFullname('faculty', 'account_id', $facultyId);
        $data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getSectionNameWithId($sectionId);
        $data['attendanceTable'] = $attendanceTable; 
        $data['subjectName'] = $this->Main_model->getSubjectNameFromId($subjectId);
        $data['studentId'] = $studentId;
       
        //create the view
        $this->load->view('includes/main_page/admin_cms/header');
        $this->load->view("manage_accounts/attendanceRecordAdminSearch", $data);
        $this->load->view('includes/main_page/admin_cms/footer');

    }

} //student search end