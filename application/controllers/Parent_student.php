 <?php

    class Parent_student extends CI_Controller
    {

        function __construct()
        {
            parent::__construct();
            $this->load->model('main_model');
            $this->Main_model->accessGranted();
        }

        function student_page()
        {
            $permission = $this->Main_model->access_granted();

            if ($permission == 1) {

                if (isset($_GET['parent_access'])) {
                    $student_id = $_GET['parent_access'];
                    $this->session->set_userdata('student_account_id', $student_id);
                }
                
                $academicGradeId = $this->Main_model->getAcademicGradeId();
                
                
                if ($academicGradeId == 1) {
                    $student_id = $_SESSION['student_account_id'];
                    $student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
                    foreach ($student_table->result() as $row) {
                        //provide the status and the school grade id;
                        $status = $row->student_status;
                        $yearlevelId = $row->school_grade_id;
                    }
                }else{
                    $student_id = $_SESSION['student_account_id'];
                    $student_table = $this->Main_model->get_where('sh_student', 'account_id', $student_id);
                    foreach ($student_table->result() as $row) {
                        //provide the status and the school grade id;
                        $status = $row->status;
                        $yearlevelId = $row->year_level_id;
                    }
                }
                foreach ($student_table->result_array() as $row) {
                    $account_id = $row['account_id'];
                    $firstname = ucfirst($row['firstname']);
                    $middlename = ucfirst($row['middlename']);
                    $lastname = ucfirst($row['lastname']);

                    $student_status = $status;
                    $parent_id = $row['parent_id'];
                    $school_grade_id = $yearlevelId;
                }


                if (isset($_SESSION['parent_account_id'])) {
                    $call_parent_table = $this->Main_model->get_where('call_parent', 'student_profile_id', $_SESSION['student_account_id']);
                    foreach ($call_parent_table->result_array() as $row) {
                        $status = $row['status'];
                    }

                    $parent_table = $this->Main_model->get_where('parent', 'account_id', $_SESSION['parent_account_id']);
                    foreach ($parent_table->result_array() as $row) {
                        $parent_firstname = ucfirst($row['firstname']);
                        $parent_middlename = ucfirst($row['middlename']);
                        $parent_lastname = ucfirst($row['lastname']);
                    }

                    $data['parentName'] = "$parent_firstname $parent_middlename $parent_lastname ";
                } //end of checking count

                $data['account_id'] = $account_id; //student account id
                $data['firstname'] = $firstname; //student firstname
                $data['middlename'] = $middlename; //student middlename
                $data['lastname'] = $lastname; //student lastname

                $data['student_status'] = $student_status; // student status
                $data['parent_id'] = $parent_id; //student table parin
                $data['school_grade_id'] = $school_grade_id; //student table
                $data['student_fullname'] = "$firstname $middlename $lastname";
                if (isset($status)) {
                    $data['call_status'] = $status;
                }


              
                $this->load->view('includes/main_page/user_cms/header', $data);
                $this->load->view('student/student', $data);
                $this->load->view('includes/main_page/user_cms/footer');
            } else {
                redirect('main_controller/login');
            }
        }

        function parentChangePassword()
        {
            $parentId = $_SESSION['parent_account_id'];
            $parentName = $this->Main_model->getFullName('parent', 'account_id', $parentId);
            
            $data['username'] = $this->Main_model->getParentUsernameWithId();
            $data['password'] = $this->Main_model->getParentPasswordWithId();

            
            $this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
            $this->form_validation->set_rules('newPassword', 'New password', 'required');
            $this->form_validation->set_rules('confirmPassword', 'Confirm password', 'required');
            if ($this->form_validation->run()) {
                $accountIdParent = $_SESSION['parent_account_id'];
                $oldPassword = $this->input->post('oldPassword');
                $newPassword = $this->input->post('newPassword');
                $confirmPassword = $this->input->post('confirmPassword');

                //check old password if it matches
                $dbOldPassword = $this->Main_model->getPassword($accountIdParent);
                if ($dbOldPassword != $this->Main_model->passwordEncryptor($oldPassword)) {
                    $this->session->set_userdata('oldPassFalse', 1);
                    redirect('parent_student/parentChangePassword');
                }
                
                //check if new password and confirm password are the same 
                if ($newPassword != $confirmPassword) {
                    $this->session->set_userdata('diffPassword', 1);
                    redirect('parent_student/parentChangePassword');
                } else {
                    $changeCred['password'] = $this->Main_model->passwordEncryptor($newPassword);
                    // echo "accountIdParent: $accountIdParent";
                    $this->Main_model->_update('credentials', 'account_id', $accountIdParent, $changeCred);
                    $session_array['alert_message'] = 'Update Successful';
                    $this->session->set_userdata($session_array);
                    redirect('parent_student/student_page');
                }
            }
            $data['parentFullName'] = $parentName;
            $this->load->view('includes/main_page/user_cms/header', $data);
            $this->load->view('student/parentChangePassword', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        function change_password()
        {
            $student_id = $this->uri->segment(3);

            $student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);

            foreach ($student_table->result_array() as $row) {
                $account_id = $row['account_id'];
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];

                $student_status = $row['student_status'];
                $parent_id = $row['parent_id'];
                $school_grade_id = $row['school_grade_id'];
            }

            $credentials_table = $this->Main_model->get_where('credentials', 'account_id', $student_id);

            foreach ($credentials_table->result_array() as $row) {
                $username = $row['username'];
                $password = $row['password'];
                $credentials_id = $row['administration_id'];
            }

            $data['username'] = $username;
            $data['password'] = $password;


            $data['account_id'] = $account_id;
            $data['firstname'] = $firstname;
            $data['middlename'] = $middlename;
            $data['lastname'] = $lastname;

            $data['student_status'] = $student_status;
            $data['parent_id'] = $parent_id;
            $data['school_grade_id'] = $school_grade_id;
            $data['student_fullname'] = "$firstname $middlename $lastname";


            
            $this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
            $this->form_validation->set_rules('newPassword', 'New Password', 'required');
            $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required');

            if ($this->form_validation->run()) {
                $oldPassword = $this->input->post('oldPassword');
                $newPassword = $this->input->post('newPassword');
                $confirmPassword = $this->input->post('confirmPassword');
                
                //determine if old password is same with db password
                $dbOldPassword = $this->Main_model->getPassword($student_id);
                if ($dbOldPassword != $this->Main_model->passwordEncryptor($oldPassword)) {
                    $this->session->set_userdata('oldPassFalse', 1);
                    redirect('parent_student/change_password/' . $student_id);
                }
                
                if ($newPassword == $confirmPassword) {

                    $student_id = $_SESSION['student_account_id'];

                    $credentials_array['password'] = $this->Main_model->passwordEncryptor($newPassword);

                    $this->Main_model->_update('credentials', 'account_id', $student_id, $credentials_array);

                    $session_array['alert_message'] = 'Update Successful';
                    $this->session->set_userdata($session_array);

                    redirect('parent_student/student_page');
                } else {
                    $this->session->set_userdata('diffPassword', 1);
                    redirect('parent_student/change_password/' . $_SESSION['student_account_id']);
                }
            } //form validation 
            

            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('student/change_password', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        function selectAcademicYearGrade()
        {
            //get student
            $studentId = $_SESSION['student_account_id'];
            $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);

            //arrange the student name
            foreach ($studentTable->result() as $row) {
                $firstname = $row->firstname;
                $middlename = $row->middlename;
                $lastname = $row->lastname;
            }

            $arrangedName = "$lastname,$firstname$middlename";

            //array that will pick the school year
            $academicYears = array();

            //search the grades table
            $studentGradesTable = $this->Main_model->get_where('student_grades', 'student_name', $arrangedName);
            foreach ($studentGradesTable->result() as $row) {
                $school_year = $row->school_year;

                $search = array_search($school_year, $academicYears, true);

                if ($search == null) {
                    array_push($academicYears, $school_year);
                }
            }

            $data['academicYears'] = $academicYears;
            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('student/selectAcademicYearGrade', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        function view_grades()
        {
            $academicYear = $this->Main_model->getAcademicYear();
            $student_id = $_SESSION['student_account_id'];
            $student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
            foreach ($student_table->result_array() as $row) {
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];
            }
            $student_search = "$lastname,$firstname $middlename";
            // echo $student_search;
            $student_search = str_replace(' ', '', $student_search);
            $data['student_grades_table'] = $this->Main_model->get_where('student_grades', 'student_name', $student_search);
                
            foreach ($data['student_grades_table']->result_array() as $row) {
                $q1 = $row['quarter1'];
            }

            if (!isset($q1)) {

                $this->load->view('includes/main_page/user_cms/header');
                $this->load->view('student/noUploadedGrade');
                $this->load->view('includes/main_page/user_cms/footer');
            } else {

                $data['studentFullName'] = $this->Main_model->getFullname('student_profile', 'account_id', $student_id);
                $data['sectionId'] = $this->Main_model->getJhsSection();
                $data['yearLevelId'] = $this->Main_model->getYearLevelId();

                //manage student academic year
                $schoolYear = array();
			
                foreach ($data['student_grades_table']->result() as $row) {
                    $sy = $row->school_year;
                    if (in_array($sy, $schoolYear) == false) {
                        //ilalagay mo na sa school year yun sy na wala pa doon 
                        array_push($schoolYear, $sy);
                    }
                }

                $data['schoolYear'] = $schoolYear;
                $this->load->view('includes/main_page/user_cms/header');
                $this->load->view('student/view_grades', $data);
                $this->load->view('includes/main_page/user_cms/footer');
            }
        }


        function view_attendance()
        {
            //get variables
            $academicYear = $this->Main_model->getAcademicYear();
            $student_id = $_SESSION['student_account_id'];

            //for subject selection
            $where['school_year'] = $this->Main_model->getAcademicYear();
            $where['student_profile_id'] = $student_id;

            //send data
            $data['studentId'] = $student_id;
            $data['academicYear'] = $academicYear;
            $data['class_table'] = $this->Main_model->multiple_where('class', $where);
            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('student/attendance_class_selection', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        function sendStudentAttendance()
        {
            $studentId = $_SESSION['student_account_id'];
            $class_id = $_SESSION['class_id'];
            $attendanceTable = $this->Main_model->get_where('attendance', 'class_id', $class_id);
            foreach ($attendanceTable->result() as $row) {
                echo "<tr>";
                //first column
                echo    "<td>";
                echo        $row->date;
                echo    "</td>";

                //second column
                echo    "<td>";
                $class_table = $this->Main_model->get_where('class', 'class_id', $class_id);
                if ($row->attendance_status == 0) {
                    echo "Absent";
                } else {
                    echo "Present";
                }
                echo    "</td>";

                //third column
                echo "<td>";
                if ($row->attendance_status == 0) {
                    $array['date_of_absent'] = $row->date;
                    $array['class_id']  = $class_id;
                    $excuse_table = $this->Main_model->multiple_where('excuse_attendance', $array);
                    foreach ($excuse_table->result_array() as $row) {
                        $excuse = $row['excuse'];
                    }
                    if ($row['status'] == 0) {
                        echo "Unexcused";
                    } else {
                        echo ucfirst($excuse);
                    }
                } else {
                    echo "Present";
                }
                echo "</td>";
                echo "</tr>";
            }
        }

        function student_view_attendance()
        {
            $class_id = $this->uri->segment(3);
            $this->session->set_userdata('class_id', $class_id);


            $data['class_id'] = $class_id;
            $data['attendance_table'] = $this->Main_model->get_where('attendance', 'class_id', $class_id);

            $class_table = $this->Main_model->get_where('class', 'class_id', $class_id);
            foreach ($class_table->result_array() as $row) {
                $subject_id = $row['subject_id'];
                $faculty_id = $row['faculty_id'];
            }

            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);
            foreach ($faculty_table->result_array() as $row) {
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];
            }

            $subject_table = $this->Main_model->get_where('subject', 'subject_id', $subject_id);
            foreach ($subject_table->result_array() as $row) {
                $subject_name = $row['subject_name'];
            }

            $data['teacher_fullname'] = "$firstname $middlename $lastname";
            $data['subject_name'] = $subject_name;

            if (isset($_GET['subjectId'])) {
                $where['subject_id'] = $this->input->get('subjectId');
                $where['student_id'] = $_SESSION['student_account_id'];

                $this->Main_model->multiWhereDelete('parent_attendance', $where);
            }

            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('student/student_view_attendance', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        function parent_page()
        {
            $parent_id = $_SESSION['parent_account_id'];
            $data['student_table'] = $this->Main_model->get_where('student_profile', 'parent_id', $parent_id);
            $student_count = count($data['student_table']->result_array());

            if ($student_count > 1) {
                $this->load->view('includes/main_page/user_cms/parent_header');
                $this->load->view('student/select_student', $data);
                $this->load->view('includes/main_page/user_cms/footer');
            } else {

                foreach ($data['student_table']->result_array() as $row) {
                    $student_account_id = $row['account_id'];
                }
                redirect('parent_student/student_page?parent_access=' . $student_account_id);
            }
        }

        function callParentRespond()
        {
            if (isset($_GET['callParentId'])) {
                $callParentId = $this->input->get('callParentId');
                $callParentTable = $this->Main_model->get_where('call_parent', 'call_parent_id', $callParentId);

                foreach ($callParentTable->result() as $row) {
                    $facultyId = $row->faculty_id;
                }

                $data['teacherName'] = $this->Main_model->getFullNameWithId("faculty", 'account_id', $facultyId);
                $data['teacherMobileNumber'] = $this->Main_model->getTheNumber("faculty", 'account_id', $facultyId);

                //load view that displays the number of the teacher
                $this->load->view('includes/main_page/user_cms/header');
                $this->load->view('student/parentRespondCallParent', $data);
                $this->load->view('includes/main_page/user_cms/footer');
            } else {
                $parentId = $_SESSION['parent_account_id'];
                $student_account_id = $_SESSION['student_account_id'];
                $where['student_profile_id'] = $student_account_id;
                $where['respond_status'] = 0;
                $callParentTable = $this->Main_model->multiple_where('call_parent', $where);
                $tableCpCount = count($callParentTable->result_array());

                if ($tableCpCount <= 0) {
                    redirect('parent_student/student_page');
                } else {


                    $data['callParentTable'] = $callParentTable->result_array();
                    $this->load->view('includes/main_page/user_cms/header');
                    $this->load->view('student/callParentRespond', $data);
                    $this->load->view('includes/main_page/user_cms/footer');
                }
            }
        }
        //student yung view na ginagalawan.
        function parentUpdateMobileNumber()
        {
            $parentAccountId = $_SESSION["parent_account_id"];
            if (isset($_POST['submit'])) {

                //get the old number to be compared para hindi siya mag text
                $parentTable = $this->Main_model->get_where('parent', 'account_id', $parentAccountId);
                foreach ($parentTable->result() as $row) {
                    $oldNumber = $row->mobile_number;
                }

                $newNumber = $this->input->post('newNumber');

                if (strlen($newNumber) > 11) {
                    $this->session->set_userdata('numberMore', 1);
                    redirect('parent_student/parentUpdateMobileNumber');
                } elseif (strlen($newNumber) < 11) {
                    $this->session->set_userdata('numberLess', 1);
                    redirect('parent_student/parentUpdateMobileNumber');
                } elseif ($oldNumber == $newNumber) {
                    $this->session->set_userdata('sameNumber', 1);
                    redirect("parent_student/student_page");
                } else {
                    $randKey = rand(1111, 9999); //ito na yung sinend

                    //lalagay mo siya sa session
                    //text the message
                    $this->Main_model->itexmo($newNumber, "Your verification code is: $randKey");
                    $this->session->set_userdata('keyCode', $this->Main_model->passwordEncryptor($randKey));
                    redirect("parent_student/phoneAuthenticator?newNumber=$newNumber");
                }
            } //

            //get parent mobile number
            $parentTable = $this->Main_model->get_where('parent', 'account_id', $parentAccountId);
            foreach ($parentTable->result() as $row) {
                $mobileNumber = $row->mobile_number;
            }

            $data['mobileNumber'] = $mobileNumber;
            $data['parentFullName'] = $this->Main_model->getFullNameWithId('parent', 'account_id', $parentAccountId);
            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('manage_accounts/parentChangeNumber', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }

        //para ma authenticate
        function phoneAuthenticator()
        {
            $parentAccountId = $_SESSION['parent_account_id'];
            $newNumber = $this->input->get('newNumber');



            if (isset($_POST['submit'])) {
                $code = $this->input->post('code');
                $encryptedCode = $this->Main_model->passwordEncryptor($code);

                if ($encryptedCode == $_SESSION['keyCode']) {
                    //update content
                    $update['mobile_number'] = $this->input->get('newNumber');
                    $this->Main_model->_update('parent', 'account_id', $parentAccountId, $update);
                    $this->session->set_userdata('numberUpdated', 1);
                    redirect('parent_student/student_page');
                } else {
                    $this->session->set_userdata('wrongCode', 1);
                    redirect("parent_student/student_page");
                }
            }
            $data['newNumber'] = $this->input->get('newNumber');
            $data['parentFullName'] = $this->Main_model->getFullname('parent', 'account_id', $_SESSION['parent_account_id']);
            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('manage_accounts/enterKey', $data);
            $this->load->view('includes/main_page/user_cms/footer');
        }


        function studentChangeNumber()
        {
            //provide neccessary variables
            $studentId = $_SESSION['student_account_id'];
            $studentFullName = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);

            //get mobile number
            $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
            foreach ($studentTable->result() as $row) {
                $mobileNumber = $row->mobile_number;
            }

            //send data
            $data['studentFullName'] = $studentFullName;
            $data['mobileNumber'] = $mobileNumber;

            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('manage_accounts/studentChangeNumber', $data);
            $this->load->view('includes/main_page/user_cms/footer');

            if (isset($_POST['newNumber'])) {
                $newMobileNumber = $this->input->post('newNumber');

                //perform validations
                //validations dito parin siya mag reredirect pero pop up lang
                if ($mobileNumber == $newMobileNumber) {
                    echo "<script>alert('old and new numbers are the same');</script>";
                } elseif (strlen($newMobileNumber) > 11) {
                    echo "<script>alert('your number has more than eleven characters');</script>";
                } elseif (strlen($newMobileNumber) < 11) {
                    echo "<script>alert('your number has less than eleven characters');</script>";
                } else {
                    $randKey = rand(1111, 9999);
                    $encryptedKey = $this->Main_model->passwordEncryptor($randKey);
                    $this->session->set_userdata('keyCode', $encryptedKey);
                    $this->session->set_userdata('answerKey', $randKey);
                    $message = "TCSHS Verification code: $randKey";
                    $this->Main_model->itexmo($newMobileNumber, $message);
                    redirect("parent_student/studentConfirmNumber?newNumber=$newMobileNumber");
                }
            }
        }

        function studentConfirmNumber()
        {
            //provide neccessary variables
            $newNumber = $this->input->get('newNumber');
            $studentId = $_SESSION['student_account_id'];
            $studentFullName = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);

            //get mobile number
            $studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
            foreach ($studentTable->result() as $row) {
                $mobileNumber = $row->mobile_number;
            }

            //send data
            $data['studentFullName'] = $studentFullName;
            $data['mobileNumber'] = $newNumber;

            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('manage_accounts/studentConfirmNumber', $data);
            $this->load->view('includes/main_page/user_cms/footer');

            if (isset($_POST['submit'])) {
                $code = $this->input->post('code');
                $encryptedCode = $this->Main_model->passwordEncryptor($code);
                $studentId = $_SESSION['student_account_id'];
                if ($encryptedCode == $_SESSION['keyCode']) {
                    //update content
                    $update['mobile_number'] = $this->input->get('newNumber');
                    $array['account_id'] = $studentId;
                    $this->Main_model->_multi_update('student_profile', $array, $update);
                    $this->session->set_userdata('numberUpdated', 1);
                    unset($_SESSION['answerKey']);
                    redirect('parent_student/student_page');
                } else {
                    $this->session->set_userdata('wrongCode', 1);
                    redirect("parent_student/student_page");
                }
            }
        }

        function parentAttendanceNotification()
        {
            $studentId = $_SESSION['student_account_id'];
            $attendanceTable = $this->Main_model->get_where('parent_attendance', 'student_id', $studentId);
            $attendanceTableCount = count($attendanceTable->result_array());

            if ($attendanceTableCount != 0) {
                echo "<i class='fas fa-fingerprint'></i> View Attendance <i class='badge badge-danger'>" . $attendanceTableCount . "</i>";
            } else {
                echo "<i class='fas fa-fingerprint'></i> View Attendance";
            }
        }

        function callParentNotification()
        {
            //get the student id
            $studentId = $_SESSION['student_account_id'];
            $where['student_profile_id'] = $studentId;
            $where['school_year'] = $this->Main_model->getAcademicYear();
            $callParentTable = $this->Main_model->multiple_where('call_parent', $where);

            //extract call parent table
            foreach ($callParentTable->result() as $row) {
                $call_status = $row->status;
            }

            if (count($callParentTable->result_array()) > 0) {

                $callParent = base_url() . 'parent_student/callParentRespond';
                if ($call_status == 1) {
                    echo "<a href='" . $callParent . "' class='btn btn-danger'>";
                    echo "Student Status: Call Parent!";
                    echo "</a>";
                } else {
                    echo "<a href='' class='btn btn-success'>";
                    echo "Student Status: Good";
                    echo "</a>";
                }
            } else {
                echo "<a href='' class='btn btn-success'>";
                echo "Student Status: Good";
                echo "</a>";
            }
        } //object end

        function selectStudent()
        {
            $allStudents = $this->Main_model->combineChildJhsShs(); //indexed array containing all of the child of the parent. 
            
            $data['allStudent'] = $allStudents;
 
            $this->load->view('includes/main_page/user_cms/header');
            $this->load->view('student/selectStudent', $data);
            $this->load->view('includes/main_page/user_cms/footer');

            if (isset($_GET['accountId'])) {
                $datum['studentId'] = $this->input->get('accountId');
                $datum['academicGradeId'] = $this->input->get('academicGradeId');

                $this->session->set_userdata('studentPageData', $datum);

                $this->session->set_userdata('student_account_id', $datum['studentId']);
                $this->session->set_userdata('academic_grade_id', $datum['academicGradeId']);
                redirect("parent_student/student_page");
            }

        }


    } //class end
