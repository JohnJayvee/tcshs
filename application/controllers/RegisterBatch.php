<?php

class registerBatch extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('excel_import_model');
        $this->load->library('excel');
        $this->load->library('Main_model');
        $this->Main_model->accessGranted();
    }

    function SUCCESS()
    {

        $this->Main_model->alertSuccess('userBatchRegister', 'User Batch Registration Complete!');

        $this->load->view('includes/main_page/admin_cms/header.php');
        $this->load->view('manage_accounts/userBatchRegisterSuccess');
        $this->load->view('includes/main_page/admin_cms/footer');
    }
    function index()
    {
        $sectionId = $this->input->get('sectionId');

        $sectionId = $this->input->get('sectionId');
				
        $sectionTable = $this->Main_model->get_where('section', 'section_id', $sectionId);

        foreach ($sectionTable->result() as $row) {
            $sectionName = $row->section_name;
            $yearLevelId = $row->school_grade_id;
        }
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $sectionName;

        $data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;

        $this->load->view('includes/main_page/admin_cms/header.php');
        $this->load->view('manage_accounts/gradeSectionRegister', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }
    function createAccount()
    {

        if (isset($_POST['import'])) {
            $yearLevelId = $this->input->post('yearLevelId');
            $sectionId = $this->input->post('sectionId');

            //dito mo ibalik ha? parent section ito
            //parent Information
            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $parentFirstname = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $parentMiddlename = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $parentLastname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $parentMobileNumber = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                        $parentData[] = array(
                            'firstname'                =>    $parentFirstname,
                            'middlename'            =>    $parentMiddlename,
                            'lastname'                =>    $parentLastname,
                            'status'                =>    1,
                            'mobile_number'            =>    $parentMobileNumber
                        );
                    }
                } // end of foreach loop

                //REMOVING ALL NULL VALUES
                $i = 0;
                foreach ($parentData as $key => $value) {

                    if (($value['firstname'] == null) || ($value['middlename'] == null) || ($value['lastname'] == null)) {

                        unset($parentData[$i]);
                    }
                    $i++;
                }

                //DATA DUPLICATION CHECKER parent

                foreach ($parentData as $row) {
                    $where['firstname'] = $row['firstname'];
                    $where['middlename'] = $row['middlename'];
                    $where['lastname'] = $row['lastname'];
                    $where['mobile_number'] = $row['mobile_number'];


                    $parentTable = $this->Main_model->multiple_where('parent', $where);

                    if (count($parentTable->result_array()) > 0) {
                        $this->session->set_userdata('duplicateDataBatch', 1);
                        redirect("RegisterBatch?yearLevelId=$yearLevelId&sectionId=$sectionId");
                    }
                }

               



                //to get the id of the present parents so that it could be used in the student_profile table
                $this->excel_import_model->insertParentBatch($parentData);
                $parentIdTable = array();
                foreach ($parentData as $row) {
                    $where['firstname'] = $row['firstname'];
                    $where['middlename'] = $row['middlename'];
                    $where['lastname'] = $row['lastname'];
                    $where['mobile_number'] = $row['mobile_number'];


                    $parentTable = $this->Main_model->multiple_where('parent', $where);

                    //getting the parent's credentials ready also texting

                    foreach ($parentTable->result_array() as $row) {
                        $parentId = $row['account_id'];

                        $parentPasswordRegular = rand(13828, 99990);
                        //OBTAIN PARENT ID
                        array_push($parentIdTable, $parentId);

                        //parent credentials registration  and texting
                        $parentFirstname = $row['firstname'];
                        $parentMiddlename = $row['middlename'];
                        $parentLastname = $row['lastname'];
                        $parentMobileNumber = $row['mobile_number'];

                        $parentCredentialsData['username'] = strtolower($parentFirstname . $parentLastname);
                        $parentCredentialsData['password'] = $this->Main_model->passwordEncryptor($parentPasswordRegular, 0, 999);
                        $parentCredentialsData['administration_id'] = 3;
                        $parentCredentialsData['account_id'] = $parentId;

                        $message = "Hi $parentFirstname $parentMiddlename $parentLastname ";
                        $message .= "username: " . $parentCredentialsData['username'] . " and your password is: " . $parentPasswordRegular;



                        //credentials faculty manipulation
                        $facSearch['firstname'] = $parentFirstname;
                        $facSearch['middlename'] = $parentMiddlename;
                        $facSearch['lastname'] = $parentLastname;

                        $facTable = $this->Main_model->multiple_where('faculty', $facSearch);

                        if (count($facTable->result_array()) > 0) {
                            foreach ($facTable->result() as $row) {
                                $facId = $row->account_id;
                            }
                            $update['parent_id'] = $parentId;
                            $this->Main_model->_update('faculty', "account_id", $facId, $update);
                        } else {
                            //dito narin siya mag tetext kapag parent account credentials
                            $this->Main_model->_insert('credentials', $parentCredentialsData);
                            if ($parentMobileNumber != 0) {
                                // $this->Main_model->itexmo($parentMobileNumber,$message);  
                            }
                        }
                    }
                } //loob ng foreach credentials. 

            }
            // student Information\


            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $studentFirstname = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $studentMiddlename = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $studentLastname = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $mobileNumber = $worksheet->getCellByColumnAndRow(8, $row)->getValue();




                        $studentData[] = array(
                            'firstname'            =>    $studentFirstname,
                            'middlename'        =>    $studentMiddlename,
                            'lastname'            =>    $studentLastname,
                            'student_status'    =>    1,
                            'parent_id'            =>    0,
                            'school_grade_id'    =>    $yearLevelId, //return "Grade 10" kailangan ma alis
                            'section_id'        =>    $sectionId, //ang ibabalik nito ay "Matalino"
                            'mobile_number'     => $mobileNumber
                        );
                    }
                }
                // echo "<pre>";
                // print_r($studentData);
                // echo "</pre>";

                //REMOVING ALL NULL VALUES
                $iterator = 0;
                foreach ($studentData as $key => $value) {

                    if (($value['mobile_number'] == null) || ($value['section_id'] == null) || ($value['school_grade_id'] == null) || ($value['firstname'] == null) || ($value['middlename'] == null) || ($value['lastname'] == null)) {
                        unset($studentData[$iterator]);
                    }
                    $iterator++;
                }

                // echo "<br>after removing all values<br>";
                // echo "<pre>";
                // print_r($studentData);
                // echo "</pre>";

                // filter out white space of $studentData
                $filteredStudentData = $this->excel_import_model->studentFilterWhiteSpace($studentData);
                $i = 0;
                //$players yung babaguhin. $players->$studentData
                foreach ($filteredStudentData as &$row) { //yung $player is just a variable to address the keys
                    $row["parent_id"] = $parentIdTable[$i]; // basta ganito lang yung pag bago

                 
                    $i++;
                }
                $this->db->insert_batch('student_profile', $filteredStudentData);




                //PARE DITO NA YUNG CREDENTIALS REGISTRATION PARA SA MGA STUDENT
                foreach ($filteredStudentData as $row) {
                    $where['firstname'] = $row['firstname'];
                    $where['middlename'] = $row['middlename'];
                    $where['lastname'] = $row['lastname'];
                    $where['mobile_number'] = $row['mobile_number'];


                    $parentTable = $this->Main_model->multiple_where('student_profile', $where);

                    //getting the parent's credentials ready also texting
                    $studentPasswordRegular = rand(13828, 99990);
                    foreach ($parentTable->result_array() as $row) {
                        $parentId = $row['account_id'];
                        array_push($parentIdTable, $parentId);

                        //parent credentials registration  and texting
                        $studentFirstname = $row['firstname'];
                        $studentMiddlename = $row['middlename'];
                        $studentLastname = $row['lastname'];
                        $studentMobileNumber = $row['mobile_number'];

                        $studentCredentialsData['username'] = strtolower($studentFirstname . $studentLastname);
                        $studentCredentialsData['password'] = $this->Main_model->passwordEncryptor($studentPasswordRegular, 0, 999);
                        $studentCredentialsData['administration_id'] = 2;
                        $studentCredentialsData['account_id'] = $parentId;

                        $message = "Hi $studentFirstname $studentMiddlename $studentLastname ";
                        $message .= "username: " . $studentCredentialsData['username'] . " and your password is: " . $studentPasswordRegular;
                        if ($studentMobileNumber != 0) {
                            // $this->Main_model->itexmo($studentMobileNumber,$message);
                        }
                        $this->Main_model->_insert('credentials', $studentCredentialsData);
                    }
                }

                //batch section insertion 
                //parent table lang kasi ang laman nun ay yung student_profile na meron ng id

                // echo "<pre>";
                // print_r($filteredStudentData);
                // echo "</pre>";
                foreach ($filteredStudentData as $row) {
                    $findStudData['firstname'] = $row['firstname'];
                    $findStudData['middlename'] = $row['middlename'];
                    $findStudData['lastname'] = $row['lastname'];

                    $foundStudentData = $this->Main_model->multiple_where('student_profile', $findStudData);
                    //CLASS SECTION POPULATE
                    foreach ($foundStudentData->result_array() as $row) {
                        $sectionInsert['student_profile_id'] = $row['account_id'];
                        $sectionInsert['section_id'] = $row['section_id'];
                        $first_year = date("Y");
                        $second_year = $first_year + 1;
                        $sectionInsert['school_year'] = "$first_year - $second_year";
                        $studentId =  $row['account_id'];
                        echo "<br>Student id is: $studentId";
                        $this->Main_model->_insert('class_section', $sectionInsert);
                    }
                } //filteredStudentData                    
            }
            $this->session->set_userdata('userBatchRegisterSuccess', 1);
            redirect("RegisterBatch/SUCCESS?yearLevelId=$yearLevelId&sectionId=$sectionId");
        } //post data isset
    } //end of import

    function facultyBatchRegister()
    {
        if (isset($_POST['import'])) {

            //teacher information
            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $parentFirstname = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $parentMiddlename = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $parentLastname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $parentMobileNumber = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                        $facultyData[] = array(
                            'firstname'                =>    $parentFirstname,
                            'middlename'               =>    $parentMiddlename,
                            'lastname'                 =>    $parentLastname,
                            'status'                   =>    1,
                            'parent_id'                =>    0,
                            'mobile_number'            =>    $parentMobileNumber
                        );
                    }
                } // excel loop

                //REMOVING ALL NULL VALUES
                $iterators = 0;
                foreach ($facultyData as $key => $value) {

                    if (($value['mobile_number'] == null) || ($value['firstname'] == null) || ($value['middlename'] == null) || ($value['lastname'] == null)) {
                        unset($facultyData[$iterators]);
                    }
                    $iterators++;
                }


                //extract data
                //perform DUPLICATION CHECKER
                foreach ($facultyData as $row) {
                    //turn them into lower case letters
                    $firstname = strtolower($row['firstname']);
                    $middlename = strtolower($row['middlename']);
                    $lastname = strtolower($row['lastname']);

                    //get all the faculty names and compare it with $row['firstname'] etc.
                    $facultyTable = $this->Main_model->get('faculty', 'account_id');
                    foreach ($facultyTable->result() as $row2) {
                        $dbFirstname = strtolower($row2->firstname);
                        $dbMiddlename = strtolower($row2->middlename);
                        $dbLastname = strtolower($row2->lastname);

                        //turn them into lower case letters

                        if (($dbFirstname  == $firstname) && ($dbMiddlename == $middlename) && ($dbLastname == $lastname)) {
                            $this->session->set_userdata('facultyDuplicate', 1);
                            redirect('manage_user_accounts/facultyRegisterBatch'); //manage_user_accounts/facultyRegisterBatch
                        }
                    }
                } //DUPLICATION CHECKER END

                // faculty table insertion
                $this->excel_import_model->insertFacultyBatch($facultyData);

                //Get Id to be used in credentials and append id to a variable
                $facultyIdTable = array();
                foreach ($facultyData as $row) {
                    $get['firstname'] = $row['firstname'];
                    $get['middlename'] = $row['middlename'];
                    $get['lastname'] = $row['lastname'];
                    $get['mobile_number'] = $row['mobile_number'];

                    $facultyTable = $this->Main_model->multiple_where('faculty', $get);
                    foreach ($facultyTable->result() as $row) {
                        $firstname = $row->firstname;
                        $lastname = $row->lastname;


                        //Credentials Creator
                        $randomPassword = rand(0, 99999);
                        $credentials['username'] = strtolower($firstname[0] . $lastname);
                        $credentials['password'] = $this->Main_model->passwordEncryptor($randomPassword);
                        $credentials['administration_id'] = 1;
                        $credentials['academic_grade_id'] = 1; //kasi nga junior highschool 2 kapag senior highschool
                        $credentials['account_id'] = $row->account_id;
                        $teacherFullName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $row->account_id);

                        //Message Texter
                        $teacherUsername = $credentials['username'];
                        $message = "Hi $teacherFullName your username is: $teacherUsername and your password is: $randomPassword";
                        if ($row->mobile_number != 0) {
                            $this->Main_model->itexmo($row->mobile_number,$message);
                        }

                        //credentials registration
                        $this->Main_model->_insert('credentials', $credentials);
                    }
                }

                //load success page
                $this->session->set_userdata('facultyBatch', 1);
                redirect('manage_user_accounts/facultyRegisterBatch');
            }
        } // post
    } // end of function 


    // for senior high school teachers
    function facultyBatchRegisterSeniorHigh()
    {
        if (isset($_POST['import'])) {

            //parent Information
            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $parentFirstname = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $parentMiddlename = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $parentLastname = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $parentMobileNumber = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                        $facultyData[] = array(
                            'firstname'                =>    $parentFirstname,
                            'middlename'            =>    $parentMiddlename,
                            'lastname'                =>    $parentLastname,
                            'status'                =>    1,
                            'parent_id'                =>    0,
                            'mobile_number'            =>    $parentMobileNumber
                        );
                    }
                } // excel loop

                //REMOVING ALL NULL VALUES
                $iterators = 0;
                foreach ($facultyData as $key => $value) {

                    if (($value['mobile_number'] == null) || ($value['firstname'] == null) || ($value['middlename'] == null) || ($value['lastname'] == null)) {
                        unset($facultyData[$iterators]);
                    }
                    $iterators++;
                }


                //extract data
                //perform DUPLICATION CHECKER
                foreach ($facultyData as $row) {
                    //turn them into lower case letters
                    $firstname = strtolower($row['firstname']);
                    $middlename = strtolower($row['middlename']);
                    $lastname = strtolower($row['lastname']);

                    //get all the faculty names and compare it with $row['firstname'] etc.
                    $facultyTable = $this->Main_model->get('faculty', 'account_id');
                    foreach ($facultyTable->result() as $row2) {
                        $dbFirstname = strtolower($row2->firstname);
                        $dbMiddlename = strtolower($row2->middlename);
                        $dbLastname = strtolower($row2->lastname);

                        //turn them into lower case letters

                        if (($dbFirstname  == $firstname) && ($dbMiddlename == $middlename) && ($dbLastname == $lastname)) {
                            $this->session->set_userdata('facultyDuplicate', 1);
                            redirect('manage_user_accounts/facultyRegisterBatch');
                        }
                    }
                } //DUPLICATION CHECKER END

                //faculty table insertion
                $this->excel_import_model->insertFacultyBatch($facultyData);

                //Get Id to be used in credentials and append id to a variable
                $facultyIdTable = array();
                foreach ($facultyData as $row) {
                    $get['firstname'] = $row['firstname'];
                    $get['middlename'] = $row['middlename'];
                    $get['lastname'] = $row['lastname'];
                    $get['mobile_number'] = $row['mobile_number'];

                    $facultyTable = $this->Main_model->multiple_where('faculty', $get);
                    foreach ($facultyTable->result() as $row) {

                        //Credentials Creator
                        $randomPassword = rand(0, 99999);
                        $credentials['username'] = strtolower($row->firstname);
                        $credentials['password'] = $this->Main_model->passwordEncryptor($randomPassword);
                        $credentials['administration_id'] = 1;
                        $credentials['account_id'] = $row->account_id;
                        $credentials['academic_grade_id'] = 2; // 2 kapag senior highschool
                        $teacherFullName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $row->account_id);

                        //Message Texter
                        $teacherUsername = $credentials['username'];
                        $message = "Hi $teacherFullName your username is: $teacherUsername and your password is: $randomPassword";
                        if ($row->mobile_number != 0) {
                            // $this->Main_model->itexmo($row->mobile_number,$message);
                        }

                        //credentials registration
                        $this->Main_model->_insert('credentials', $credentials);
                    }
                }

                //load success page
                $this->session->set_userdata('facultyBatch', 1);
                redirect('manage_user_accounts/facultyRegisterBatch');
            }
        } // post
    } // end of function 

}// class end
