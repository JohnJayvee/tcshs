<?php
class Shs extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('excel_import_model');
        $this->load->library('excel');
        $this->load->library('Main_model');
        $this->Main_model->accessGranted();
        
    }
   

    function index()
    {
        //objective dapat i aactivate niya yung career_track table
        $data['careerTrackTable'] = $this->Main_model->get('career_track', 'track_id');

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/TrackAndStrand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function strand()
    {
        $trackId = $this->input->get('trackId');

        $data['trackName'] = $this->Main_model->getTrackName($trackId);
        $data['strandTable'] = $this->Main_model->get_where('strand', 'track_id', $trackId);
        $data['trackId'] = $trackId;

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/strand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function activatedStrands() //para maging real time lang po
    {
        //get all activated strands in the strand table
        $strandTable = $this->Main_model->get_where('strand', 'status', 1);
        $strandTableCount = count($strandTable->result_array());

        if ($strandTableCount > 0) {
            //meron ng naactivate
            foreach ($strandTable->result() as $row) {
                echo "<tr>";
                echo "<td>" . $row->strand_name . "</td>";
                echo "</tr>";
            }
        } else {
            //wala pang na aactivate
            echo "<td>Table Empty</td>";
        }
    }

    function sectionsSelectYearLevel() //select muna ng year level
    {
        $data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/sectionsSelectYearLevel', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function sectionsSelectStrand()
    {
        $yearLevelId = $this->input->get('yearLevelId');

        $data['yearLevelId'] = $yearLevelId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['activatedStrands'] = $this->Main_model->get_where('strand', "status", 1);

        //will get all the activated strands by the school. 
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/sectionsSelectStrand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function viewStudentSections()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
        $sectionId = $this->input->get('sectionId');

        $where['year_level'] = $yearLevelId;
        $where['sh_section_id'] = $sectionId;
        $data['shClassSectionTable'] = $this->Main_model->multiple_where('sh_class_section', $where);
        
        
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['sectionId'] = $sectionId;

        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['sectionName'] = $this->Main_model->getShSectionName($sectionId);

        //remove deactivated students; dont forget
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/viewStudentSections', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function createShsSection()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');

        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandName']  = $this->Main_model->getStrandName($strandId);

        //get sh_section
        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $data['shSectionTable'] = $this->Main_model->multiple_where('sh_section', $where);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/createShsSection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

        if (isset($_POST['submit'])) {
            //get the track id, 
            $yearLevelId = $this->input->get('yearLevelId');
            $strandId = $this->input->get('strandId');
            $trackId = $this->Main_model->getTrackIdFromStrandId($strandId);
            $sectionName = $this->input->post('newSection');
            
            //insert into the database
            $insert['section_name'] = $sectionName;
            $insert['year_level_id'] = $yearLevelId;
            $insert['track_id'] = $trackId;
            $insert['strand_id'] = $strandId;

            //DUPLICATION CHECKER
            if ($this->Main_model->shSectionDuplicationChecker($insert)) {
                //kapag nag true siya meaning may nahanap siya
                $this->session->set_userdata('shsSectionDuplication', 1);
                redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId");
            }

            $this->Main_model->_insert('sh_section', $insert);

            //notify the user
            $this->session->set_userdata('shSectionCreated', 1);
            redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=2");
        }
    }

    function editShsSection()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
        $sectionId = $this->input->get('sectionId');

        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandName']  = $this->Main_model->getStrandName($strandId);

        //get sh_section
        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $data['shSectionTable'] = $this->Main_model->multiple_where('sh_section', $where);

        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['sectionId'] = $sectionId;

        $data['sectionName'] = $this->Main_model->getShsSectionNameFromId($sectionId);

        if (isset($_POST['submit'])) {
            $newSectionName = $this->input->post('newSection');

            $update['section_name'] = $newSectionName;
            $this->Main_model->_update('sh_section', 'section_id', $sectionId, $update);
            
            $this->session->set_userdata('sectionUpdate', 1);
            redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId");
        }

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/editShsSection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

        if (isset($_POST['submit'])) {
            //get the track id, 
            $yearLevelId = $this->input->get('yearLevelId');
            $strandId = $this->input->get('strandId');
            $trackId = $this->Main_model->getTrackIdFromStrandId($strandId);
            $sectionName = $this->input->post('newSection');
            
            //insert into the database
            $insert['section_name'] = $sectionName;
            $insert['year_level_id'] = $yearLevelId;
            $insert['track_id'] = $trackId;
            $insert['strand_id'] = $strandId;

            //DUPLICATION CHECKER
            if ($this->Main_model->shSectionDuplicationChecker($insert)) {
                //kapag nag true siya meaning may nahanap siya
                $this->session->set_userdata('shsSectionDuplication', 1);
                redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId");
            }

            $this->Main_model->_insert('sh_section', $insert);

            //notify the user
            $this->session->set_userdata('shSectionCreated', 1);
            redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=2");
        }
    }

    function deleteSection()
    {
        $sectionId = $this->input->get('sectionId');
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');

        if (isset($_GET['confirm'])) {
            //note: you must also delete students in the sh_class_section table
            $this->Main_model->_delete('sh_section', 'section_id', $sectionId);
            
            //notify the user
            $this->session->set_userdata('shsSectionDeleted', 1);
            redirect("shs/createShsSection?yearLevelId=$yearLevelId&strandId=$strandId");
        }

        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;

        $data['sectionName'] = $this->Main_model->getShsSectionNameFromId($sectionId); //section ng shs
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandName'] = $this->Main_model->getStrandName($strandId);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/deleteSection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
        
    }

    function shsCreateSubject()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');

        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandName']  = $this->Main_model->getStrandName($strandId);

        //get sh_subjects
        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $where['track_id'] = $this->Main_model->getTrackIdFromStrandId($strandId);
        $data['shSubjectsTable'] = $this->Main_model->multiple_where('sh_subjects', $where);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/shsCreateSubject', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

        if (isset($_POST['submit'])) {
            //get the track id, 
            $trackId = $this->Main_model->getTrackIdFromStrandId($strandId);
            $sectionName = $this->input->post('newSection'); //subject na ito

            //insert into the sh_subject
            $insert['subject_name'] = $sectionName;
            $insert['track_id'] = $trackId;
            $insert['strand_id'] = $strandId;
            $insert['general_subject'] = 0; // meaning hindi siya general subject. 
            $insert['year_level_id'] = $yearLevelId;

            //DUPLICATION CHECKER
            if ($this->Main_model->shSubjectDuplicationChecker($insert)) {
                //kapag nag true siya meaning may nahanap siya
                $this->session->set_userdata('shsSectionDuplication', 1);
                redirect("shs/shsCreateSubject?yearLevelId=$yearLevelId&strandId=$strandId");
            }

            $this->Main_model->_insert('sh_subjects', $insert);

            //notify the user
            $this->session->set_userdata('shSectionCreated', 1);
            redirect("shs/shsCreateSubject?yearLevelId=$yearLevelId&strandId=$strandId");
        }
    }

    function subjectYearSelection()
    {
        $data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/subjectYearSelection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function subjectSelectStrand()
    {
        $yearLevelId = $this->input->get('yearLevelId');

        $data['yearLevelId'] = $yearLevelId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['activatedStrands'] = $this->Main_model->get_where('strand', "status", 1);

        $data['generalSubjectsTable'] = $this->Main_model->get_where('sh_subjects', 'general_subject', 1);

        //will get all the activated strands by the school. 
        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/subjectSelectStrand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

        if (isset($_POST['submit'])) {
            $generalSubjName = $this->input->post('newGeneralSubject');


            $insert['subject_name'] = $generalSubjName;
            $insert['track_id'] = 0;
            $insert['strand_id'] = 0;
            $insert['general_subject'] = 1;
            $insert['year_level_id'] = $yearLevelId;

            //general subject duplication checker
            if ($this->Main_model->shGeneralSubjectDuplicationChecker($insert)) {
                // kapag true meron siyang nahanap na kapareho
                $this->session->set_userdata('generalSubjectDuplicate', 1);
                redirect("shs/subjectSelectStrand?yearLevelId=$yearLevelId");
            }

            $this->Main_model->_insert('sh_subjects', $insert);

            //redirect the page and notify
            $this->session->set_userdata('generalSubjectInserted', 1);
            redirect("shs/subjectSelectStrand?yearLevelId=$yearLevelId");
        }
    }

    function activateTrack()
    {
        $trackId = $this->uri->segment(3);

        //update status track into activated = 1;
        $data['status'] = 1;

        $this->Main_model->_update('career_track', 'track_id', $trackId, $data);

        //redirect and perform user notification
        $this->session->set_userdata('trackActivated', 1);
        redirect('shs');
    }

    function deactivateTrack()
    {
        $trackId = $this->uri->segment(3);
        $send['trackName'] = $this->Main_model->getTrackName($trackId);
        $send['trackId'] = $trackId;

        if (isset($_GET['deactivate'])) {
            
            //if there are students in the track hindi dapat siya mag dedeactivate. unless deactivated na lahat 
            //ng mga students sa track na yun
            $conditions['track_id'] = $trackId;
            $conditions['status'] = 1; // active students
            $shStudentTable = $this->Main_model->multiple_where('sh_student', $conditions);
            if (count($shStudentTable->result_array()) != 0) {
                //meron pang nag aaral na mga students sa track na ito
                $this->session->set_userdata('stillStudents', 1);
                redirect("shs");
            }
           
            //update status track into activated = 1;
            $data['status'] = 0;

            //status == 0
            $this->Main_model->_update('career_track', 'track_id', $trackId, $data);

            //deactivate all of the strands of that deactivated track
            $strandtable = $this->Main_model->get_where('strand', 'track_id', $trackId);
            $strandTableCount = count($strandtable->result_array());

            //check if there is data
            if ($strandTableCount != 0) {
                //meron siyang nahanap

                //deactivate all of the STRAND
                foreach ($strandtable->result() as $row) {
                    $update['status'] = 0; //deactivated status

                    $this->Main_model->_update('strand', 'track_id', $trackId, $update);
                }
                
                //delete teacher loads of that track. and notify the user that the teacher load has been deleted
                $shTeacherLoadTable = $this->Main_model->get_where('sh_teacher_load', 'track_id', $trackId);
                if (count($shTeacherLoadTable->result_array()) != 0) {
                    //delete every teacher load that matched with the conditions. 
                    $this->Main_model->_delete('sh_teacher_load', 'id', $row->id);
                }

                //delete sh advisers that met the conditions; get the strands of that track
                $strandTable = $this->Main_model->get_where('strand', 'track_id', $trackId);
                foreach ($strandTable->result() as $row) {
                    //lahat ng may strand id na teacher load ma dedelete
                    $this->Main_model->_delete('sh_adviser', 'strand_id', $row->strand_id);
                }

                //delete sections of that track
                $this->Main_model->_delete('sh_section', 'track_id', $trackId);

                //redirect and perform user notification
                $this->session->set_userdata('trackDeactivated', 1);
                redirect('shs');
            } else {
                // wala siyang nahanap

                //redirect and perform user notification
                $this->session->set_userdata('trackStrandEmpty', 1);
                redirect('shs');
            }
        } else {
            //hindi pa na coconfirm
            $this->load->view('includes/main_page/admin_cms/secretaryNav');
            $this->load->view('shs/confirmTrackDeactivation', $send);
            $this->load->view('includes/main_page/admin_cms/footer');
        }
    }

    //strand management

    function activateStrand()
    {
        $trackId = $this->input->get('trackId');
        $strandId = $this->uri->segment(3);

        //update status track into activated = 1;
        $data['status'] = 1;

        $this->Main_model->_update('strand', 'strand_id', $strandId, $data);

        //redirect and perform user notification
        $this->session->set_userdata('strandActivated', 1);
        redirect("shs/strand?trackId=$trackId");
    }

    function deactivateStrand()
    {
        $trackId = $this->input->get('trackId');
        $strandId = $this->uri->segment(3);

        //update status track into activated = 1;
        $data['status'] = 0;

        $this->Main_model->_update('strand', 'strand_id', $strandId, $data);

        //redirect and perform user notification
        $this->session->set_userdata('strandDeactivated', 1);
        redirect("shs/strand?trackId=$trackId");
    }

    function manageShsAdviser() //select year level
    {
        //get the data in the school grade table
        $data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2);

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/manageShsAdviser', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function manageAdviserStrandSelection()
    {
        $yearLevelId = $this->input->get('yearLevelId');

        $data['yearLevelId'] = $yearLevelId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandTable'] = $this->Main_model->get('strand', 'strand_id');

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/manageAdviserStrandSelection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function manageAdviserSelectSection()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
        
        //configure where statements
        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $shSectionTable = $this->Main_model->multiple_where('sh_section', $where);


        //send data to the view
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['shSectionTable'] = $shSectionTable;
        $data['yearLevelId'] = $yearLevelId;

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/manageAdviserSelectSection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function shsAssignAdviser() //for Senior highschool students
	{
		$yearLevelId = $this->input->get('yearLevelId');
        $sectionId = $this->input->get('sectionId');
        $strandId = $this->input->get('strandId');

		//get the names
		$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getSectionNameFromIdShs($sectionId);
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;

		$multipleWhere['administration_id'] = 1;
		$multipleWhere['academic_grade_id'] = 2; //para SeniorHigh lang
		$data['facultyTable'] = $this->Main_model->multiple_where('credentials', $multipleWhere);


		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/shsAssignAdviser', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		//perform assignment of adviser
		if (isset($_POST['submit'])) {
			$adviserId = $this->input->post('teacherId');
			$sectionId = $this->input->get('sectionId');
            // echo "sectionId: $sectionId";
            // die;
			$insert['section_id'] = $sectionId;
			$insert['faculty_account_id'] = $adviserId;
			$insert['academic_grade_id'] = 2; 

			//parameter if the teacher is already an adviser
            //WHERE CONDITIONS
            // $where['section_id'] = $sectionId;
            // $where['academic_grade_id'] = 2;
            $where['faculty_account_id'] = $adviserId;
            $where['academic_grade_id'] = 2;

			//check if there are already present adviser tapos mag uupdate nalang siya  // hindi ito gumagana.
			$adviserTable = $this->Main_model->multiple_where('adviser_section', $where);
            $adviserTableCount = count($adviserTable->result_array());
            
            
			if ($adviserTableCount == 0) {
                //wala pang na crecreate
                $this->Main_model->_delete('adviser_section', 'section_id', $sectionId);
                $this->Main_model->_insert('adviser_section', $insert);
                
			} else {
				//meron ng na create
				foreach ($adviserTable->result() as $row) {
					$adviserDbId = $row->adviser_id; //primary key
				}
				$update['faculty_account_id'] = $adviserId;
                $update['section_id'] = $sectionId;

                //delete the section where the adviser is currently there.

                $deleteWhere['faculty_account_id'] = $adviserId;
                $deleteWhere['academic_grade_id'] = 2;
                $this->Main_model->multiple_delete('adviser_section', $deleteWhere);
                
                $this->Main_model->_delete('adviser_section', 'section_id', $sectionId);

                $this->Main_model->_insert("adviser_section", $insert);
             
			}


			$this->session->set_userdata('adviserAssign', $adviserId);
			redirect("shs/manageAdviserSelectSection?yearLevelId=$yearLevelId&strandId=$strandId");
		}
    }
    
    function transferTeacherJhsToShs()
    {
        //get all junior higshchool teacher.
        //determine conditions
        $where['academic_grade_id'] = 1;
        $where['administration_id'] = 1;

        $jhsTeacherTable = $this->Main_model->multiple_where('credentials', $where);

        //send the needed data
        $data['jhsTeacherTable'] = $jhsTeacherTable;

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/transferTeacherJhsToShs', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
        
        if (isset($_POST['submit'])) {
            $selectedTeacherCredentials = $this->input->post('teacher');//

            //if there are no checked teachers
            if (count($selectedTeacherCredentials) == 0) {
                $this->session->set_userdata('noCheckMarks', 1);
                redirect('manage_user_accounts/viewSeniorHighSchoolFaculty');
            }

            // echo "<pre>";
            // print_r($selectedTeacherCredentials);
            // echo "</pre>";
            
            //update the selected teacher's academic_grade_id   
            foreach ($selectedTeacherCredentials as $row) {
                $update['academic_grade_id'] = 2;
                $this->Main_model->_update('credentials', 'credentials_id', $row, $update);
            }

            //notify success.
            $this->session->set_userdata('jhsToShs', 1);
            redirect("manage_user_accounts/viewJuniorHighSchoolFaculty");
        }
    }

    function transferTeacherShsToJhs()
    {
        //get all junior higshchool teacher.
        //determine conditions
        $where['academic_grade_id'] = 2;
        $where['administration_id'] = 1;

        $jhsTeacherTable = $this->Main_model->multiple_where('credentials', $where);

        //send the needed data
        $data['jhsTeacherTable'] = $jhsTeacherTable;

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/transferTeacherShsToJhs', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
        
        if (isset($_POST['submit'])) {
            $selectedTeacherCredentials = $this->input->post('teacher');//

            //if there are no checked teachers
            if (count($selectedTeacherCredentials) == 0) {
                $this->session->set_userdata('noCheckMarks', 1);
                redirect('manage_user_accounts/viewSeniorHighSchoolFaculty');
            }

            // echo "<pre>";
            // print_r($selectedTeacherCredentials);
            // echo "</pre>";
            
            //update the selected teacher's academic_grade_id   
            foreach ($selectedTeacherCredentials as $row) {
                $update['academic_grade_id'] = 1;
                $this->Main_model->_update('credentials', 'credentials_id', $row, $update);
            }

            //notify success.
            $this->session->set_userdata('jhsToShs', 1);
            redirect("manage_user_accounts/viewJuniorHighSchoolFaculty");
        }
    }

    function shsTeacher() //this will serve as a dashboard
	{
        $accountId = $_SESSION['faculty_account_id'];
        $data['teacherName'] = $this->Main_model->getFullNameWithId('faculty', 'account_id', $accountId);
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/shsTeacher', $data);
        $this->load->view('includes/main_page/admin_cms/footer'); 
    }

    function registerShsStudent()
    {
        $this->form_validation->set_rules('firstname','First name','required');
        $this->form_validation->set_rules('middlename','Middle name','required');
        $this->form_validation->set_rules('lastname','Last name','required');
        $this->form_validation->set_rules('mobileNumber','Mobile number','required');

        if ($this->form_validation->run()) {

            //get the post data
            $firstname = $this->input->post("firstname");// this will also be the username
            $middlename = $this->input->post("middlename");
            $lastname = $this->input->post("lastname");
            $mobileNumber = $this->input->post("mobileNumber");
            
            //get the track and strand id
            $adviserInfo = $this->Main_model->getShsAdviserInformation();
            
            
            $trackId = $adviserInfo['trackId'];
            $strandId = $adviserInfo['strandId'];
            $yearLevelId = $adviserInfo['yearLevelId'];
            $sectionId = $adviserInfo['sectionId'];

            //prepare the data for the sh_student table
            $student['firstname'] = $firstname;
            $student['middlename'] = $middlename;
            $student['lastname'] = $lastname;
            $student['mobile_number'] = $mobileNumber;
            $student['year_level_id'] = $yearLevelId; 
            $student['section_id'] = $sectionId;
            $student['track_id'] = $trackId;
            $student['strand_id'] = $strandId;
            $student['parent_id'] = 0;

            //FAIL SAFE: STUDENT DUPLICATION CHECKER
            $find['firstname'] = $firstname;
            $find['middlename'] = $middlename;
            $find['lastname'] = $lastname;
            $find['year_level_id'] = $yearLevelId; 
            $find['section_id'] = $sectionId;
            $find['track_id'] = $trackId;
            $find['strand_id'] = $strandId;

            $this->Main_model->shDuplicationChecker($find);
            //FALE SAFE END STUDENT DUPLICATION CHECKER

            //store it in a session data
            $this->session->set_userdata('studentInfo', $student);

            //redirect it into the parent account creation.
            $this->session->set_userdata('ShsStudentPending', 1); 
            redirect('shs/registerShsParent');
        }

            //FAIL SAFE: ADVISER TEACHER CHECKER; will just check if the teacher is an adviser or not. 
            $adviserOrNot = $this->Main_model->shsAdviserOrNot();

            if ($adviserOrNot == false) {
                //meaning nito hindi siya adviser
                $this->session->set_userdata('notAdviser', 1); 
                redirect("shs/shsTeacher");               
            }
            //FAIL SAFE ENDS HERE. 

            

            //get the necessary id
            $adviserInfo = $this->Main_model->getShsAdviserInformation();

            $trackId = $adviserInfo['trackId'];
            $strandId = $adviserInfo['strandId'];
            $yearLevelId = $adviserInfo['yearLevelId'];
            $sectionId = $adviserInfo['sectionId'];

            //convert the id into meaningfull information. 
            $send['yearLevelName'] = $adviserInfo['yearLevelName'];
            $send['strandName'] = $adviserInfo['strandName'];
            $send['sectionName'] = $adviserInfo['sectionName'];

            $this->load->view('includes/main_page/admin_cms/shsNav');
            $this->load->view('shs/registerShsStudent', $send);
            $this->load->view('includes/main_page/admin_cms/footer'); 
    }

    function registerShsParent()
    {
        //notification
        if (isset($_SESSION['ShsStudentPending'])) {
            echo "<script>";
            echo "alert('Enter the parent of the student that you have just currently registered');";
            echo "</script>";
            unset($_SESSION['ShsStudentPending']);
        }

        //get the student session data
        $currentStudentData = $_SESSION['studentInfo'];

        //disect the array to get STUDENT INFORMATION
        $studentFirstname = $currentStudentData['firstname'];
        $studentMiddlename = $currentStudentData['middlename'];
        $studentLastname = $currentStudentData['lastname'];

        $studentFullName = "$studentFirstname $studentMiddlename $studentLastname";

        //PERFORM POST OPERATION
        $this->form_validation->set_rules('firstname','First name','required');
        $this->form_validation->set_rules('middlename','Middle name','required');
        $this->form_validation->set_rules('lastname','Last name','required');
        $this->form_validation->set_rules('mobileNumber','Mobile number','required');
        if ($this->form_validation->run()) {
            //get post data
            $data['firstname'] = $this->input->post('firstname');
            $data['middlename'] = $this->input->post('middlename');
            $data['lastname'] = $this->input->post('lastname');
            $data['mobile_number'] = $this->input->post('mobileNumber');
            $data['status'] = 1;

            $this->Main_model->manageParentData($data);
        }
        
        $send['studentFullName'] = $studentFullName;
        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/registerShsParent', $send);
        $this->load->view('includes/main_page/admin_cms/footer'); 
        
    }

    function parentStudentLink() //for parents
    {   
        //get the full name of the student that is being registered
        $studentTable = $_SESSION['studentInfo'];

        $firstname = $studentTable['firstname'];
        $middlename = $studentTable['middlename'];
        $lastname = $studentTable['lastname'];

        $send['studentFullName'] = "$firstname $middlename $lastname";

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/parentStudentLink', $send);
        $this->load->view('includes/main_page/admin_cms/footer');

        if (isset($_POST['submit'])) {
            //get the id
            $parentId = $this->input->post('parentId');
            
            //STUDENT REGISTRATION. 
            
            //get the student that is currently registering
            $student = $_SESSION['studentInfo'];

            //change the student's parent_id
            $student['parent_id'] = $parentId;

            //insert student into the sh_student
            $this->Main_model->_insert('sh_student', $student);

            //get the newly registrated student
            $shStudentTable = $this->Main_model->just_get_everything('sh_student');
            foreach ($shStudentTable->result() as $row) {
                $lastestStudentId = $row->account_id;
            }

            $classSection['sh_section_id'] = $_SESSION['studentInfo']['section_id'];
            $classSection['year_level'] = $_SESSION['studentInfo']['year_level_id'];
            $classSection['sh_student_id'] = $lastestStudentId;
            $this->Main_model->_insert('sh_class_section', $classSection);
            
            //dapat kapag merong class yung mga student na meron sa section na yun sapag mailagay narain siya doon
            $shClassTable = $this->Main_model->get_where('sh_class', 'sh_section_id', $classSection['sh_section_id']);
            if (count($shClassTable->result_array()) != 0) {
                //meron ng mga class yung andoon sa section na yun
                foreach ($shClassTable->result() as $row) {
                    $insert['sh_faculty_id'] = $row->sh_faculty_id;
                    $insert['sh_section_id'] = $row->sh_section_id;
                    $insert['strand_id'] = $row->strand_id;
                    $insert['track_id'] = $row->track_id;
                    $insert['year_level'] = $row->year_level;
                    $insert['schedule'] = $row->schedule;
                    $insert['semester'] = $row->semester;
                    $insert['quarter'] = $row->quarter;
                    $insert['sh_student_id'] = $lastestStudentId;
                    
                    $this->Main_model->_insert('sh_class', $insert);
                } 
            }

            //insert student into credentials
            $username = $student['firstname'];

            $this->Main_model->shInsertIntoCredentials($username, $lastestStudentId);

            //redirect and notify
            $this->session->set_userdata('accountCreated', 1);
            redirect('shs/registerSHsStudent');
        }
    }

    function parentStudentLinkRealTime()
    {
        $parentTable =  $this->Main_model->just_get_everything('parent');
        foreach ($parentTable->result() as $row) {
        $firstname = $row->firstname;
        $middlename = $row->middlename;
        $lastname = $row->lastname;
        $fullname = "$firstname $middlename $lastname";

         echo      "<tr>";
         echo      "     <td>$fullname</td>";
         echo      "     <td>";
         echo      "         <input type='radio' name='parentId' value=". $row->account_id . ">";
         echo      "     </td>";
         echo      " </tr>";
        }
    }

    function viewAccountControl()// will just determine if the user is adviser or not. 
    {
        $adviserOrNot = $this->Main_model->adviserOrNot();
        if (false) {
            //user logged in is an adviser
            $this->load->view('includes/main_page/admin_cms/shsNav');
            $this->load->view('shs/viewShsAccountsAdviser');
            $this->load->view('includes/main_page/admin_cms/footer');
        }else{
            //user is not an adviser
            $data['yearLevelId'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2);
            $this->load->view('includes/main_page/admin_cms/shsNav');
            $this->load->view('shs/viewShsAccountsNotAdviser', $data);
            $this->load->view('includes/main_page/admin_cms/footer');
        }
    }

    function selectStrand()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        
        $data['strandTable'] = $this->Main_model->get_where('strand', 'status', 1);
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['yearLevelId'] = $yearLevelId;
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/selectStrand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function shsSelectSection()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');

        $multiWhere['year_level_id'] = $yearLevelId;
        $multiWhere['strand_id'] = $strandId;
        $shSectionTable = $this->Main_model->multiple_where('sh_section', $multiWhere);

        //FAIL SAFE: there are no created sections for this strand
        $url = base_url() . "shs/selectStrand";
        $sessionName = "noSectionAvailable";
        $this->Main_model->redirectArrayEmpty($shSectionTable, $url, $sessionName);

        $data['shSectionTable'] = $shSectionTable;
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/shsSelectSection', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function viewShsStudentAccounts()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
        $sectionId = $this->input->get('sectionId');

        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $where['section_id'] = $sectionId;
        $shStudentTable = $this->Main_model->multiple_where('sh_student', $where);

        //FAIL SAFE: REDIRECT RETURNED EMPTY 
        $url = base_url() . "shs/shsTeacher";
        $sessionName = "noStudent";
        $this->Main_model->redirectArrayEmpty($shStudentTable, $url, $sessionName);

        //send the needed data
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['shsStudentTable'] = $shStudentTable;
        $data['sectionName'] = $this->Main_model->getShSectionName($sectionId);
        $data['sectionId'] = $sectionId;

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/viewShsStudentAccounts', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

    }

    function editShsStudent()
    {
        $yearLevelId = $this->input->get("yearLevelId");
        $strandId = $this->input->get("strandId");
        $sectionId = $this->input->get("sectionId");
        $studentId = $this->uri->segment(3);

        //get the name of the student.
        $studentFullName = $this->Main_model->getFullname('sh_student', 'account_id', $studentId);
        $slice = $this->Main_model->getFullNameSliced('sh_student', 'account_id', $studentId);

        //section names
        $yearLevelName = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $strandName = $this->Main_model->getStrandName($strandId);
        $sectionName = $this->Main_model->getShSectionName($sectionId);
        
        //send data
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['sectionId'] = $sectionId;
        $data['studentId'] = $studentId;

        $data['studentFullname'] = $studentFullName;
        $data['slice'] = $slice;
        
        $data['yearLevelName'] = $yearLevelName;
        $data['strandName'] = $strandName;
        $data['sectionName'] = $sectionName;
        
        if (isset($_POST['submit'])) {
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');

            $update['firstname'] = $firstname;
            $update['middlename'] = $middlename;
            $update['lastname'] = $lastname;

            $this->Main_model->_update('sh_student', 'account_id', $studentId, $update);
            
            //redirect and notify
            $this->session->set_userdata("shStudentUpdate", 1);
        
            $redirect = "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId";
            redirect($redirect);
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/editShsStudent', $data);
        $this->load->view('includes/main_page/admin_cms/footer');

        
    }

    function viewShsParents()
    {
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
        $sectionId = $this->input->get('sectionId');

        //define where conditions
        $where['year_level_id'] = $yearLevelId;
        $where['strand_id'] = $strandId;
        $where['section_id'] = $sectionId;
        $shStudentTable = $this->Main_model->multiple_where('sh_student', $where);

        //manage the array so that there would be no duplicates. for the parent id;
        $parentIdArray = array();

        foreach ($shStudentTable->result() as $row) {
            $parentId = $row->parent_id;

            if (!in_array($parentId, $parentIdArray)) {
                array_push($parentIdArray, $parentId);
            }
        }

        

        //send the needed data
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['parentIdTable'] = $parentIdArray;
        $data['sectionName'] = $this->Main_model->getShSectionName($sectionId);
        $data['sectionId'] = $sectionId;

        if (isset($_POST['submit'])) {
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');

            $update['firstname'] = $firstname;
            $update['middlename'] = $middlename;
            $update['lastname'] = $lastname;

            $this->Main_model->_update('sh_student', 'account_id', $studentId, $update);
            
            //redirect and notify
            $this->session->set_userdata("shStudentUpdate", 1);
        
            $redirect = "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId";
            redirect($redirect);
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/viewShsParents', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }
    
    function editShParent()
    {
        $yearLevelId = $this->input->get("yearLevelId");
        $strandId = $this->input->get("strandId");
        $sectionId = $this->input->get("sectionId");
        $parentId = $this->uri->segment(3);

        //get the name of the student.
        $parentFullName = $this->Main_model->getFullname('parent', 'account_id', $parentId);
        $slice = $this->Main_model->getFullNameSliced('parent', 'account_id', $parentId);

        //section names
        $yearLevelName = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $strandName = $this->Main_model->getStrandName($strandId);
        $sectionName = $this->Main_model->getShSectionName($sectionId);
        
        //send data
        $data['yearLevelId'] = $yearLevelId;
        $data['strandId'] = $strandId;
        $data['sectionId'] = $sectionId;
        $data['parentId'] = $parentId;

        $data['parentFullName'] = $parentFullName;
        $data['slice'] = $slice;
        
        $data['yearLevelName'] = $yearLevelName;
        $data['strandName'] = $strandName;
        $data['sectionName'] = $sectionName;

        if (isset($_POST['submit'])) {
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');

            $update['firstname'] = $firstname;
            $update['middlename'] = $middlename;
            $update['lastname'] = $lastname;

            $this->Main_model->_update('parent', 'account_id', $parentId, $update);
            
            //redirect and notify
            $this->session->set_userdata("shParentUpdate", 1);
        
            $redirect = "shs/viewShsStudentAccounts?yearLevelId=$yearLevelId&strandId=$strandId&sectionId=$sectionId";
            redirect($redirect);
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/editShParent', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function batchRegister()
    {
        $teacherId = $_SESSION['faculty_account_id'];
        
        $adviserInfo = $this->Main_model->getShsAdviserInformation(); //sectionId, sectionName, yearLevelId, trackId, strandId

        //disect array
        $sectionId = $adviserInfo['sectionId'];
        $sectionName = $adviserInfo['sectionName'];
        $yearLevelId = $adviserInfo['yearLevelId'];
        $trackId = $adviserInfo['trackId'];
        $strandId = $adviserInfo['strandId'];

        //get names
        $yearLevelName = $adviserInfo['yearLevelName'];
        $trackName = $adviserInfo['trackName'];
        $strandName = $adviserInfo['strandName'];

        //send into views
        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevelId;
        $data['trackId'] = $trackId;
        $data['strandId'] = $strandId;

        //send names
        $data['sectionName'] = $sectionName;
        $data['yearLevelName'] = $yearLevelName;
        $data['trackName'] = $trackName;
        $data['strandName'] = $strandName;

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/batchRegister', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function createAccount()
    {

        if (isset($_POST['import'])) {
            $yearLevelId = $this->input->post('yearLevelId');
            $sectionId = $this->input->post('sectionId');
            $strandId = $this->input->post('strandId');
            $trackId = $this->input->post('trackId');

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
                            'firstname'                =>    strtolower($parentFirstname),
                            'middlename'            =>    strtolower($parentMiddlename),
                            'lastname'                =>    strtolower($parentLastname),
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
                        redirect("shs/batchRegister?yearLevelId=$yearLevelId&sectionId=$sectionId");
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

                        $parentCredentialsData['username'] = $parentFirstname;
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
                            'status'    =>    1,
                            'parent_id'            =>    0,
                            'year_level_id'    =>    $yearLevelId, //return "Grade 10" kailangan ma alis
                            'section_id'        =>    $sectionId, //ang ibabalik nito ay "Matalino"
                            'mobile_number'     => $mobileNumber,
                            'strand_id'      => $strandId,
                            'track_id'          => $trackId
                        );
                    }
                }
                // echo "<pre>";
                // print_r($studentData);
                // echo "</pre>";

                //REMOVING ALL NULL VALUES
                $iterator = 0;
                foreach ($studentData as $key => $value) {

                    if (($value['mobile_number'] == null) || ($value['section_id'] == null) || ($value['year_level_id'] == null) || ($value['firstname'] == null) || ($value['middlename'] == null) || ($value['lastname'] == null)) {
                        unset($studentData[$iterator]);
                    }
                    $iterator++;
                }

                // echo "<br>after removing all values<br>";
                // echo "<pre>";
                // print_r($studentData);
                // echo "</pre>";

                // filter out white space of $studentData
                $filteredStudentData = $this->excel_import_model->studentFilterWhiteSpaceShs($studentData);
                $i = 0;
                //$players yung babaguhin. $players->$studentData
                foreach ($filteredStudentData as &$row) { //yung $player is just a variable to address the keys
                    $row["parent_id"] = $parentIdTable[$i]; // basta ganito lang yung pag bago

                    $i++;
                }
                $this->db->insert_batch('sh_student', $filteredStudentData);




                //PARE DITO NA YUNG CREDENTIALS REGISTRATION PARA SA MGA STUDENT
                foreach ($filteredStudentData as $row) {
                    $where['firstname'] = $row['firstname'];
                    $where['middlename'] = $row['middlename'];
                    $where['lastname'] = $row['lastname'];
                    $where['mobile_number'] = $row['mobile_number'];


                    $studentTable = $this->Main_model->multiple_where('sh_student', $where);
                    $this->Main_model->array_show($studentTable);
                    
                    //getting the parent's credentials ready also texting
                    $studentPasswordRegular = rand(13828, 99990);
                    foreach ($studentTable->result_array() as $row) {
                        $studentId = $row['account_id'];
                        array_push($parentIdTable, $studentId);

                        //parent credentials registration  and texting
                        $studentFirstname = $row['firstname'];
                        $studentMiddlename = $row['middlename'];
                        $studentLastname = $row['lastname'];
                        $studentMobileNumber = $row['mobile_number'];

                        $studentCredentialsData['username'] = strtolower($studentFirstname);
                        $studentCredentialsData['password'] = $this->Main_model->passwordEncryptor($studentPasswordRegular, 0, 999);
                        $studentCredentialsData['administration_id'] = 2;
                        $studentCredentialsData['account_id'] = $studentId;

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
            redirect("shs/SUCCESS?yearLevelId=$yearLevelId&sectionId=$sectionId");
        } //post data isset
    } //end of import

    function SUCCESS()
    {
        echo "registry success";
    }

    function cms_add()
    {
        $data['tags'] = $this->Main_model->just_get_everything('post_tags');
        $data['error'] = ' ';

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/cms_add', $data);
        $this->load->view('includes/main_page/admin_cms/footer.php');
    }

    function do_upload() // will receive the post data of cms_add.
    {

            $config['upload_path']          = './cms_uploads/';
            $config['allowed_types']        = 'gif|jpg|png|JPEG';
            $this->load->library('upload', $config);
            $this->upload->do_upload('userfile');
            $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
            $file_name = $upload_data['file_name'];


            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['file_name']             = $file_name;
            $config['overwrite']            = True;
            $config['remove_spaces']          = True;




            $data['post_title'] = $this->input->post('post_title');
            $data['post_tags'] = $this->input->post('post_tags');
            $data['post_image'] = $file_name;
            $data['post_content'] = $this->input->post('post_content');
            $data['faculty_id'] = $this->session->userdata('faculty_account_id');
            $data['post_date'] = $this->input->post('post_date');

            if ($_SESSION['credentials_id'] == 4) {
                $data['post_status'] = 1;
            } else {
                $data['post_status'] = 0;
            }





            $this->Main_model->_insert('post', $data);

            $notif_table_content = $this->Main_model->get_where('sbar_notif', 'notif_id', 1);

            foreach ($notif_table_content->result_array() as $row) {
                $notif_id = $row['notif_id'];
                $approve_content = $row['approve_content'];
                $no_new_items = $row['no_new_items'];
                // use this to add to the current number
            }

            $update['no_new_items'] = $no_new_items + 1;
            if ($_SESSION['credentials_id'] != 4) {
                $this->Main_model->_update('sbar_notif', 'notif_id', '1', $update);
            }

            redirect('shs/cms_upload_success');





            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('includes/main_page/admin_cms/shsNav');
                $this->load->view('shs/cms_add', $error);
                $this->load->view('includes/main_page/admin_cms/footer.php');
            }
    }

    function cms_upload_success()
    {
        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/cms_upload_success');
        $this->load->view('includes/main_page/admin_cms/footer.php');
    }

    function manage_content()
    {
        $account_id = $_SESSION['faculty_account_id'];

        $data['teacherName'] = $this->Main_model->getFullNameWithId('faculty', 'account_id', $account_id);
        $data['my_post'] = $this->Main_model->get_where('post', 'faculty_id', $account_id);

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/manage_content', $data);
        $this->load->view('includes/main_page/admin_cms/footer.php');
    }

    function content_view()
    {
        $data['post_id'] = $this->uri->segment(3);

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('includes/old_css/header');
        $this->load->view('shs/content_view', $data);

        $this->load->view('includes/main_page/admin_cms/footer.php');
       
    }

    function delete_post()
    {
        $post_id = $this->uri->segment(3);
        $classifier = $this->uri->segment(4);

        if ($classifier == 0) {

            $post_table = $this->Main_model->get_where('post', 'post_id', $post_id);

            foreach ($post_table->result_array() as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $faculty_id = $row['faculty_id'];
                $post_date = $row['post_date'];
            }


            $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);

            foreach ($faculty_table->result_array() as $row) {
                $account_id = $row['account_id'];
                $firstname = $row['firstname'];
                $middlename = $row['middlename'];
                $lastname = $row['lastname'];
            }
            $fullname = "$firstname $middlename $lastname";

            $data['post_id'] = $post_id;
            $data['post_title'] = $post_title;
            $data['post_status'] = $post_status;
            $data['post_tags'] = $post_tags;
            $data['post_image'] = $post_image;
            $data['post_content'] = $post_content;
            $data['fullname'] = $fullname;
            $data['post_date'] = $post_date;


            $this->load->view('includes/main_page/admin_cms/shsNav');
            $this->load->view('includes/old_css/header');
            $this->load->view('shs/delete_post', $data);
            $this->load->view('includes/main_page/admin_cms/footer.php');
        } elseif ($classifier == 1) {

            $post_table = $this->Main_model->get_where('post', 'post_id', $post_id);

            foreach ($post_table->result_array() as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $faculty_id = $row['faculty_id'];
                $post_date = $row['post_date'];
            }

            // syntax for deleting a picture in the folder. 

            // unlink("name_of_folder", $NameOfPicture);

            $this->Main_model->_delete('post', 'post_id', $post_id);
            unlink('cms_uploads/' . $post_image);

            $this->session->set_userdata("postDelete", 1);
            redirect('shs/manage_content');
        }
    }
    function getSectionFromYearLevel()
    {
        if (isset($_POST['yearLevelId'])) {
			$sectionTable = $this->Main_model->get_where('sh_section', 'year_level_id', $_POST['yearLevelId']);
			echo "<option value=''>Select student section </option>";
			foreach ($sectionTable->result() as $row) {
				echo "<option value='". $row->section_id ."'>". $row->section_name ."</option>";
			}
		}
    }

    function appendTableWithYearLevel()
	{
		if (isset($_POST['yearLevelId'])) {
			$teacherLoadTable = $this->Main_model->get_where('sh_teacher_load', 'year_level', $_POST['yearLevelId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "	<tr>";
                
                echo "        <td> ". $this->Main_model->facultyRepository($row->faculty_account_id) ."</td>";
                
                echo "        <td>" . $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) . "</td>";
                
                echo "        <td>". $row->schedule ."</td>";
                
                echo "        <td>". $this->Main_model->getYearLevelNameFromId($row->year_level) ."</td>";
                echo "        <td>". $this->Main_model->getShSectionName($row->sh_section_id) ."</td>";
                echo "    </tr>";
			}
		}
	}
    
    function changeTableWithSectionId()
	{
		if (isset($_POST['sectionId'])) {
			$teacherLoadTable = $this->Main_model->get_where('sh_teacher_load', 'sh_section_id', $_POST['sectionId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "	<tr>";
                
                echo "        <td> ". $this->Main_model->facultyRepository($row->faculty_account_id) ."</td>";
                
                echo "        <td>" . $this->Main_model->getShSubjectNameFromId($row->sh_subject_id) . "</td>";
            
                echo "        <td>". $row->schedule ."</td>";
                echo "        <td>". $this->Main_model->getYearLevelNameFromId($row->year_level) ."</td>";
                echo "        <td>". $this->Main_model->getShSectionName($row->sh_section_id) ."</td>";
                echo "    </tr>";
			}
		}
	}

    function viewOtherTeacherLoad()
    {   
        $data['teacherLoadTable'] = $this->Main_model->get('sh_teacher_load', 'id');
        $data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');
        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/viewOtherTeacherLoad', $data);
        $this->load->view('includes/main_page/admin_cms/footer'); 
    }

    function selectStrandTeacherLoad()
    {
        $data['strandTable'] = $this->Main_model->get_where('strand', 'status', 1);

        $this->load->view('includes/main_page/admin_cms/shsNav');
        $this->load->view('shs/selectStrandTeacherLoad', $data);
        $this->load->view('includes/main_page/admin_cms/footer'); 
    }
    
    function yearSelectionTeacherLoad()
	{
        $strandId = $this->uri->segment(3);
        $data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');
        $data['strandId'] = $strandId;
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        
		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/yearSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }
    
    function sectionSelectionTeacherLoad()
	{
        $yearLevelId = $this->input->get('yearLevelId');
        $strandId = $this->input->get('strandId');
	    
		$data['sectionTable'] = $this->Main_model->get_where('sh_section', 'year_level_id', $yearLevelId);
		$data['yearLevelId'] = $yearLevelId;
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
        $data['strandId'] = $strandId;
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        
		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/sectionSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }
    
    function subjectSelectionTeacherLoad()
	{
        $strandId = $this->input->get('strandId');
		$yearLevelId = $this->input->get('yearLevelId');
        $sectionId = $this->input->get('sectionId');
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

		$data['subjectTable'] = $this->Main_model->get_where('sh_subjects', 'year_level_id', $yearLevelId);
        $data['currentSchoolYear'] = $currentSchoolYear;

        $data['strandId'] = $strandId;
		$data['yearLevelId'] = $yearLevelId;
        $data['sectionId'] = $sectionId;
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getShsSectionNameFromId($sectionId);

		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/subjectSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    //for the dynamic dropdown
	function selectSection()
	{
		if (isset($_POST['gradeLevel'])) {
			$yearLevelId = $this->input->post('gradeLevel');
			$sectionTable = $this->Main_model->get_where('sh_section', 'year_level_id', $yearLevelId);
			foreach ($sectionTable->result() as $row) {
				echo "<option value=" . $row->section_id . ">" . $row->section_name . " </option>";
			}
		}
    }
    
    //for the dynamic dropdown
	function selectSubject()
	{

		if (isset($_POST['gradeLevelId'])) {
			$yearLevelId = $this->input->post('gradeLevelId');
			$subjectTable = $this->Main_model->get_where('sh_subjects', 'year_level_id', $yearLevelId);
			foreach ($subjectTable->result() as $row) {
                //remove already taken teacher loads
                if ($this->Main_model->checkIfTeacherLoadIsTaken($row->id) == true) {
                    continue;
                }
				echo "<option value=" . $row->subject_id . ">" . $row->subject_name . " </option>";
			}
		}
	}
    
    function teacher_load()
	{
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();
        
		if (isset($_GET['edit'])) {
			$teacher_id = $_SESSION['faculty_account_id'];
			$teacher_load_id = $this->input->get('edit');
			$data['sh_subject_id'] = $this->input->post('subject');
			$data['year_level'] = $this->input->post('school_year_grade');
			$data['schedule'] = $this->input->post('schedule');
			// $data['faculty_account_id'] = $this->input->post('teacher_id');
			$data['faculty_account_id'] = $teacher_id;
			$data['sh_section_id'] = $this->input->post('section');

			//class update
            $teacherLoadTable = $this->Main_model->get_where('sh_teacher_load', 'id', $teacher_load_id);
            
			foreach ($teacherLoadTable->result() as $row) {
				$updateWhere['sh_faculty_id'] = $row->faculty_account_id;
				$updateWhere['sh_subject_id'] = $row->sh_subject_id;
				$updateWhere['year_level'] = $row->year_level;
				$updateWhere['sh_section_id'] = $row->sh_section_id;
			}

			//update class
			$update['sh_subject_id'] = $this->input->post('subject');
			$update['schedule'] =  $this->input->post('schedule');
			$update['sh_section_id'] = $this->input->post('section');
			$update['year_level'] = $this->input->post('school_year_grade');

			$this->Main_model->_multi_update('sh_class', $updateWhere, $update);
            
			$this->Main_model->_update('sh_teacher_load', 'id', $teacher_load_id, $data);
			redirect('shs/viewPersonalTeacherLoad');
		} //edit teacher load

        
		$this->form_validation->set_rules('schedule', 'Schedule', 'required');
		if ($this->form_validation->run()) {
            //para sa teacher load table.
            $strandId = $this->input->get('strandId');
            $semester = $this->input->post('semester');
            $quarter = $this->input->post('quarter');
           
            $data['track_id'] = $this->Main_model->getTrackIdFromStrandId($strandId);
            $data['strand_id'] = $strandId;
            $data['semester'] = $semester;
            $data['quarter'] = $quarter;
			$data['sh_subject_id'] = $this->input->get('subjectId');
			$data['schedule'] = $this->input->post('schedule');
			$data['year_level'] = $this->input->get('yearLevelId');
			$data['faculty_account_id'] = $this->input->post('teacher');
			$data['sh_section_id'] = $this->input->get('sectionId');
			$data['school_year'] = $currentSchoolYear;

			$array['subject_id'] = $this->input->get('subjectId');
			$array['schedule'] = $this->input->post('schedule');
			$array['grade_level'] = $this->input->get('yearLevelId');
			$array['faculty_account_id'] = $this->input->post('teacher');
            $array['section_id'] = $this->input->get('sectionId');

			//CLASS CREATOR LOOPING FOR SECTIONS
			$class_section_table = $this->Main_model->get_where('sh_class_section', 'sh_section_id', $data['sh_section_id']);
            $this->Main_model->array_show($class_section_table);
            
            //dapat popultated na agad yung sh_class_section. kapag mag reregister ka ng student account dapat meron na siya sa 
            //sh_class_section table. 
			foreach ($class_section_table->result_array() as $row) {
				$class_section_id = $row['sh_section_id'];
				$student_profile_id = $row['sh_student_id'];

                //semester and quarter is required
                $classData['semester'] = $semester;
                $classData['quarter'] = $quarter;
                $classData['strand_id'] = $strandId;
                $classData['track_id'] = $data['track_id'];
				$classData['sh_subject_id'] = $data['sh_subject_id'];
				$classData['sh_faculty_id'] = $data['faculty_account_id'];
				$classData['schedule'] = $data['schedule'];
				$classData['sh_student_id'] = $student_profile_id;
				$classData['sh_section_id'] = $data['sh_section_id'];
                $classData['year_level'] = $data['year_level'];
                $classData['school_year'] = $currentSchoolYear;

				$this->Main_model->_insert('sh_class', $classData);
			}

			$this->Main_model->_insert('sh_teacher_load', $data);
			$this->session->set_userdata('teacherLoad', 1);
			redirect("shs/selectStrandTeacherLoad");
		}

		$teacher_id = $_SESSION['faculty_account_id'];

		$data['teacher_fullname'] = $this->Main_model->getFullName('faculty', 'account_id', $teacher_id);
		$data['subject_table'] = $this->Main_model->get('subject', 'subject_id');
		$data['faculty_account_id'] = $_SESSION['faculty_account_id'];
		$data['section_table'] = $this->Main_model->get('section', 'section_id');
		$data['school_grade_table'] = $this->Main_model->get('school_grade', 'school_grade_id');

        //pang check kung meron nabang nagawang subjects yung secretary
		$subject_table = $this->Main_model->just_get_everything('subject');
		foreach ($subject_table->result_array() as $row) {
			$subject_id = $row['subject_id'];
		}

		if (!isset($subject_id)) {
			$this->load->view('includes/main_page/admin_cms/shsNav');
			$this->load->view('classes/no_subjects_yet');
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');
            $subjectId = $this->input->get('subjectId');
            $strandId = $this->input->get('strandId');

			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;
			$data['subjectId'] = $subjectId;

			$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
			$data['sectionName'] = $this->Main_model->getShsSectionNameFromId($sectionId);
            $data['subjectName'] = $this->Main_model->getShSubjectNameFromId($subjectId);
            $data['strandId'] = $strandId;
			$this->load->view('includes/main_page/admin_cms/shsNav');
			$this->load->view('shs/assign_teacher_load', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
    }
    
    //yung walang kahit anong get values
	function viewPersonalTeacherLoad()
	{
		$teacherId = $_SESSION['faculty_account_id'];
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        $data['currentSchoolYear'] = $currentSchoolYear;
        
        //get personal teacher load;
        $where['school_year'] = $currentSchoolYear;
        $where['faculty_account_id'] = $teacherId;
		$data['personalTeacherLoadTable'] = $this->Main_model->multiple_where('sh_teacher_load', $where);

		//teacher name
		$data['teacherName'] = $this->Main_model->getFullname('faculty', 'account_id', $teacherId);

		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/viewPersonalTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function delete_teacher_load()
    {
        $teacherLoadId = $this->uri->segment(3);

        $shTeacherLoadTable = $this->Main_model->get_where('sh_teacher_load', 'id', $teacherLoadId);

        if(isset($_GET['confirm'])){
            
            //remove students that are in that class
            $subjectOfTeacherLoad = $this->Main_model->getSubjectFromTeacherLoad($teacherLoadId);
            $this->Main_model->_delete('sh_class', 'sh_subject_id', $subjectOfTeacherLoad);
            
            //remove teacher load
            $this->Main_model->_delete('sh_teacher_load', 'id', $teacherLoadId);


            $this->session->set_userdata('deleteSuccess', 1);
            redirect("shs/viewPersonalTeacherLoad");
        }

        //send data to view
        $data['shTeacherLoadTable'] = $shTeacherLoadTable;
        $data['teacherLoadId'] = $teacherLoadId;

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/delete_teacher_load', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }
    
    function edit_teacher_load()
	{
		$teacher_load_id = $this->uri->segment(3);
        $data['teacher_load_id'] = $teacher_load_id;
        
		$data['teacher_load_table'] = $this->Main_model->get_where('sh_teacher_load', 'id', $teacher_load_id);
		$data['subject_table'] = $this->Main_model->get('sh_subjects', 'subject_id');
		$data['faculty_table'] = $this->Main_model->get_where('faculty', 'account_id', $_SESSION['faculty_account_id']);

		$data['teacher_fullname'] = $this->Main_model->getFullName('faculty', 'account_id', $_SESSION['faculty_account_id']);
		$data['section_table'] = $this->Main_model->just_get_everything('sh_section');
		$data['school_grade_table'] = $this->Main_model->get('school_grade', 'school_grade_id');

        // $this->Main_model->array_show($data['school_grade_table']);
		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/edit_teacher_load', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }
    
    function strandTransfer()
    {
        $data['shsTable'] = $this->Main_model->get('sh_student', 'account_id');

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/strandTransfer', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function transferStudentStrand()
    {   
        //get id
        $studentAccountId = $this->input->get('accountId');

        //send names
        $data['studentName'] = $this->Main_model->getFullNameWithId('sh_student', 'account_id', $studentAccountId);
       
        //send table
        $data['studentTable'] = $this->Main_model->get_where('sh_student', 'account_id', $studentAccountId)->result_array();
        $data['trackTable'] = $this->Main_model->get_where('career_track', 'status', 1);

        $where['status'] = 1;
        $where['track_id'] = $data['studentTable'][0]['track_id'];
        $data['strandTable'] = $this->Main_model->multiple_where('strand', $where);

        //send student id
        $data['studentId'] = $studentAccountId;
        
        if (isset($_POST['submit'])) {
            //update student table
            $update['track_id'] = $this->input->post("trackId");
            $update['strand_id'] = $this->input->post("strandId");
            $this->Main_model->_update('sh_student', 'account_id', $studentAccountId);
            //kailangan mo rin kunin yung current year level nung bata. 

            //sh_class_section


            //tapos yung sh_class_
        }

        $this->load->view('includes/main_page/admin_cms/secretaryNav');
        $this->load->view('shs/transferStudentStrand', $data);
        $this->load->view('includes/main_page/admin_cms/footer');
    }

    function transferStudentAjax()
    {
        if (isset($_POST['trackId'])) {
            $trackId = $this->input->post('trackId');
            
            $where['track_id'] = $trackId;
            $where['status'] = 1;
            $strandTable = $this->Main_model->multiple_where('strand', $where);
            
            foreach ($strandTable->result() as $row) {
                echo "<option value='". $row->strand_id ."'>" . $this->Main_model->getStrandName($row->strand_id) . "</option>";
            }
        }
    }

    function manageClassesStrand()
    {
        
        $data['strandTable'] = $this->Main_model->get_where('strand', 'status', 1);
        
		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/manageClassesStrand', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function manageClassesYearLevel()
    {
        //notifications
        $this->Main_model->alertPromt('There are no sections created.', 'noSections');

        //get get data
        $strandId = $this->input->get('strandId');

        //send names
        $data['strandName'] = $this->Main_model->getStrandName($strandId);

        $data['strandId'] = $strandId;
        $data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2);
        
		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/manageClassesYearLevel', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function manageClassesSection()
    {
        //get get data
        $yearLevel = $this->input->get('yearLevel');
        $strandId = $this->input->get('strandId');

        $data['strandId'] = $strandId;
        $data['yearLevel'] = $yearLevel;

        //send names
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['yearLevelname'] = $this->Main_model->getYearLevelNameFromId($yearLevel);

        $where['strand_id'] = $strandId;
        $where['year_level_id'] = $yearLevel;
        $data['sectionTable'] = $this->Main_model->multiple_where('sh_section', $where);

        //trap  if year level has no sections an alert message would pop up
        if (count($data['sectionTable']->result_array()) == 0) {
            $this->session->set_userdata('noSections', 1);
            redirect("shs/manageClassesYearLevel?strandId=$strandId");
        }

		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/manageClassesSection', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function manageClasses()
    {
        //notifications
        $this->Main_model->alertPromt('There are no sections created.', 'noSections');
        
        //get get data
        $strandId = $this->input->get('strandId');
        $yearLevel = $this->input->get('yearLevel');
        $sectionId = $this->input->get('sectionId');

        //send id
        $data['strandId'] = $strandId;
        $data['yearLevelId'] = $yearLevel;
        $data['sectionId'] = $sectionId;

        //where conditions for sh class table
        $where['strand_id'] = $strandId;
        $where['year_level'] = $yearLevel;
        $where['sh_section_id'] = $sectionId;
        $where['school_year'] = $this->Main_model->getCurrentSchoolYear();

        //send names    
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevel);
        $data['sectionName'] = $this->Main_model->getShSectionName($sectionId);

        //subject table
        $conditions['strand_id'] = $strandId;
        $conditions['year_level_id'] = $yearLevel;
        $data['subjectTable'] = $this->Main_model->multiple_where('sh_subjects', $conditions);
        
        $data['shClassTable'] = $this->Main_model->multiple_where('sh_class', $where);

		$this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/manageClasses', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function filterClassWithSubject()
    {   
        
        if (isset($_POST['subjectId'])) {
            $subjectId = $this->input->post('subjectId');
            
            $where['sh_subject_id'] = $subjectId;
            $where['sh_section_id'] = $this->input->post('sectiionId');
            $where['year_level'] = $this->input->post('yearLevel');
            $where['strand_id'] = $this->input->post('strandId');
            $where['school_year'] =  $this->Main_model->getCurrentSchoolYear();

            $classTable = $this->Main_model->multiple_where('sh_class', $where);

            if (count($classTable->result_array()) == 0) {
                echo "<td><h6>There are no records for that subject</h6></td>";
            }else{
                foreach ($classTable->result() as $row) {
                    echo "<tr>";
                    echo "    <td>" .$this->Main_model->getFullName('faculty', 'account_id', $row->sh_faculty_id). "</td>";
                    echo "    <td>" .$this->Main_model->getShSubjectNameFromId($row->sh_subject_id). "</td>";
                    echo "    <td>" .$this->Main_model->getFullName('sh_student', 'account_id', $row->sh_student_id). "</td>";
                    echo "    <td>" .$row->schedule. "</td>";
                    echo "    <td>" .$row->quarter. "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    function viewPsYearLevel()
    {
        //notification
        $this->Main_model->alertPromt('Custom class created', 'customRegister');
        $this->Main_model->alertPromt('Special class deleted', 'customClassDeleted');

        $accountId = $_SESSION['faculty_account_id'];
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        $where['faculty_account_id'] = $accountId;
        $where['school_year'] = $currentSchoolYear;
        $data['shTeacherLoadTable'] = $this->Main_model->multiple_where('sh_teacher_load', $where);

        //send custom class table
        $data['customClassTable'] = $this->Main_model->get_where('custom_class', 'sh_faculty_id', $accountId);
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/viewPsYearLevel', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }   
    
    function sortBySubjectsPs()
    {
        $accountId = $_SESSION['faculty_account_id'];
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        if (isset($_POST['subjectId'])) {
            $subjectId = $this->input->post('subjectId');

            $where['faculty_account_id'] = $accountId;
            $where['sh_subject_id'] = $subjectId;
            $where['faculty_account_id'] = $accountId;
            $where['school_year'] = $currentSchoolYear;
            $teacherLoadTable = $this->Main_model->multiple_where('sh_teacher_load', $where);

             //create class
             echo "<div class='m-1'>";
             echo "    <div class='card' style='width: 18rem;'>";
             echo "        <div style='display: flex; flex-direction: column;' class='card-body d-flex flex-column'>";
             echo "            <div style='width: 100%;height:150px'>";
             echo "                <h5 class='card-title'>Create custom class</h5>";
             echo "                <h6 class='card-subtitle mb-2 text-muted'>Select students that will be in your custom class</h6>";
             echo "            </div>";
             $custom = base_url() . "shs/createCustomClass";
             echo "            <a href='". $custom ."'><button style='margin-top: auto;' class='btn btn-success col-md-12'><i class='fas fa-plus'></i>&nbsp; Create</button></a>";
             echo "        </div>";
             echo "    </div>";
             echo "</div>";

            if (count($teacherLoadTable->result_array()) != 0) {
                foreach ($teacherLoadTable->result() as $row) { 
                    echo "<div class='m-1>'";
                    echo "<div class='card' style='width: 18rem;'> ";
                    echo "    <div class='card-body'> ";
                    echo "<div style='width:100%;height:150px'>";
                    echo "        <h5 class='card-title'>".$this->Main_model->getShSubjectNameFromId($row->sh_subject_id)."</h5> ";
                    echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getShSectionName($row->sh_section_id) ."</h6> ";
                    echo "        <p class='card-text'> ". $this->Main_model->getYearLevelNameFromId($row->year_level) ." |  ". $this->Main_model->getStrandName($row->strand_id) ."</p> ";
                    echo "</div>";
                    $enter = base_url() . "shs/viewPesonalSubjects?subjectId=$row->sh_subject_id&sectionId=$row->sh_section_id&yearLevel=$row->year_level&strandId=$row->strand_id";
                    echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
                    echo "    </div> ";
                    echo "</div> ";
                    echo "</div>";
                    echo "</div>";
                }
            }else{
                
                //walang sinelect yun user
                $loadTable = $this->Main_model->get_where('sh_teacher_load', 'faculty_account_id', $accountId);
                foreach ($loadTable->result() as $row) {
                    echo "<div class='m-1>'";
                    echo "<div class='card' style='width: 18rem;'> ";
                    echo "    <div class='card-body'> ";
                    echo "<div style='width:100%;height:150px'>";
                    echo "        <h5 class='card-title'>".$this->Main_model->getShSubjectNameFromId($row->sh_subject_id)."</h5> ";
                    echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getShSectionName($row->sh_section_id) ."</h6> ";
                    echo "        <p class='card-text'> ". $this->Main_model->getYearLevelNameFromId($row->year_level) ." |  ". $this->Main_model->getStrandName($row->strand_id) ."</p> ";
                    echo "</div>";
                    $enter = base_url() . "shs/viewPesonalSubjects?subjectId=$row->sh_subject_id&sectionId=$row->sh_section_id&yearLevel=$row->year_level&strandId=$row->strand_id";
                    echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
                    echo "    </div> ";
                    echo "</div> ";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
    }

    function viewPesonalSubjects()
    {
        //notifications
        $this->Main_model->alertPromt('Student removed from class', 'studDeleted');
        $this->Main_model->alertPromt('Student successfully registered to your class', 'studentRegistered');

        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        //collect id
        $accountId = $_SESSION['faculty_account_id'];
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
        $yearLevel = $this->input->get('yearLevel');
        $strandId = $this->input->get('strandId');

        //get classes table
        $where['sh_subject_id'] = $subjectId;
        $where['sh_section_id'] = $sectionId;
        $where['year_level'] = $yearLevel;
        $where['strand_id'] = $strandId;
        $where['sh_faculty_id'] = $accountId;
        $where['school_year'] = $currentSchoolYear;

        $data['shClassTable'] = $this->Main_model->multiple_where('sh_class', $where);
        
        
        $data['subjectTable'] = $this->Main_model->get_where('sh_teacher_load', 'faculty_account_id', $accountId);

        //send names
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevel);
        $data['strandName'] = $this->Main_model->getStrandName($strandId);
        $data['sectionName'] = $this->Main_model->getShSectionName($sectionId);
        $data['subjectName'] = $this->Main_model->getShSubjectNameFromId($subjectId);

        //send id
        $data['subjectId'] = $subjectId;
        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevel;
        $data['strandId'] = $strandId;

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/viewPesonalSubjects', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function addStudentInClass()
    {
        //notification
        if (isset($_SESSION['classRepeated'])) {
            $studentName = $this->Main_model->getFullName('sh_student', 'account_id', $_SESSION['classRepeated']);
            $message = "$studentName is already in this class";
            $this->Main_model->alertPromt( $message, 'classRepeated');
        }
        

        //get id
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
        $yearLevel = $this->input->get('yearLevel');
        $strandId = $this->input->get('strandId');

        //get names
        $data['subjectName'] = ucfirst($this->Main_model->getShSubjectNameFromId($subjectId));
        $data['sectionName'] = ucfirst($this->Main_model->getShSectionName($sectionId));
        $data['yearLevelName'] = ucfirst($this->Main_model->getYearLevelNameFromId($yearLevel));
        $data['strandName'] = ucfirst($this->Main_model->getStrandName($strandId));

        //send id
        $data['subjectId'] = $subjectId;
        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevel;
        $data['strandId'] = $strandId;

        //get all of the sh shs student
        $data['shStudentTable'] = $this->Main_model->get('sh_student', 'account_id');

        if (isset($_POST['submit'])) {
            $studentsAdded = $this->input->post('checkBox');

            //duplication checker
            foreach ($studentsAdded as $row) {
                $selectedStudent = $row;

                //add duplication catcher. check if id has already there in the sh_class and sh_class_section
                //where 1 = sh_class
                $where1['sh_faculty_id'] = $_SESSION['faculty_account_id'];
                $where1['sh_section_id'] = $sectionId;
                $where1['sh_subject_id'] = $subjectId;
                $where1['strand_id'] = $strandId;
                $where1['track_id'] = $this->Main_model->getTrackIdFromStrandId($strandId);
                $where1['year_level'] = $yearLevel;
                $where1['sh_student_id'] = $selectedStudent;
                $shClassTable = $this->Main_model->multiple_where('sh_class', $where1);
                $this->Main_model->array_show($shClassTable);
                
                if (count($shClassTable->result_array()) != 0) {
                    $this->session->set_userdata('classRepeated', $selectedStudent);
                    redirect("shs/addStudentInClass?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevel&strandId=$strandId");
                }
                //end of student class duplication trap
            }
            
            foreach ($studentsAdded as $row) {
                $selectedStudent = $row;

                //register student into sh_class_section
                $classSection['sh_section_id'] = $sectionId;
                $classSection['year_level'] = $yearLevel;
                $classSection['sh_student_id'] = $selectedStudent;
                $this->Main_model->_insert('sh_class_section', $classSection);

                //regiser the student into sh_class
                $shClass['sh_faculty_id'] = $_SESSION['faculty_account_id'];
                $shClass['sh_section_id'] = $sectionId;
                $shClass['sh_subject_id'] = $subjectId;
                $shClass['strand_id'] = $strandId;
                $shClass['track_id'] = $this->Main_model->getTrackIdFromStrandId($strandId);
                $shClass['year_level'] = $yearLevel;

                //get schedule
                $where['track_id'] = $shClass['track_id'];
                $where['strand_id'] = $strandId;
                $where['year_level'] = $yearLevel;
                $where['sh_subject_id'] = $subjectId;
                $where['sh_section_id'] = $sectionId;
                $where['faculty_account_id'] = $_SESSION['faculty_account_id'];
                $teacherLoadData = $this->Main_model->getSubjectDataFromShTeacherLoad($where);
                $this->Main_model->showNormalArray($teacherLoadData);
                
                $shClass['schedule'] = $teacherLoadData['schedule'];
                $shClass['semester'] = $teacherLoadData['semester'];
                $shClass['quarter'] = $teacherLoadData['quarter'];
                $shClass['sh_student_id'] = $selectedStudent;
                $shClass['school_year'] = $teacherLoadData['school_year'];
                $this->Main_model->_insert('sh_class', $shClass);
            } //end of foreach

            $this->session->set_userdata('studentRegistered', 1);
            redirect("shs/viewPesonalSubjects?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevel&strandId=$strandId");
        } //end of if condition

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/addStudentInClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function removeStudentFromClass()
    {
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
        $yearLevel = $this->input->get('yearLevel');
        $strandId = $this->input->get('strandId');
        $studentId = $this->uri->segment(3);

        //send id
        $data['subjectId'] = $subjectId;
        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevel;
        $data['strandId'] = $strandId;
        $data['studentId'] = $studentId;

        //get names
        $data['studentName'] = $this->Main_model->getFullName('sh_student', 'account_id', $studentId);
        $data['subjectName'] = ucfirst($this->Main_model->getShSubjectNameFromId($subjectId));

        if (isset($_GET['confirm'])) {
            //remove from the sh_class
            $where['sh_faculty_id'] = $_SESSION['faculty_account_id'];
            $where['sh_section_id'] = $sectionId;
            $where['sh_subject_id'] = $subjectId;
            $where['strand_id'] = $strandId;
            $where['sh_student_id'] = $studentId;
            $this->Main_model->multiple_delete('sh_class', $where);
            
            //remove from sh_class_section
            $condition['sh_section_id'] = $sectionId;
            $condition['year_level'] = $yearLevel;
            $condition['sh_student_id'] = $studentId;
            $this->Main_model->multiple_delete('sh_class_section', $condition);

            $this->session->set_userdata('studDeleted', 1);
            redirect("shs/viewPesonalSubjects?subjectId=$subjectId&sectionId=$sectionId&yearLevel=$yearLevel&strandId=$strandId");
            
        }
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/removeStudentFromClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function createCustomClass()
    {
        $data['strandTable'] = $this->Main_model->get_where('strand', 'status', 1); //activated strands lang

        //get post data
        $this->form_validation->set_rules('className','Class name','required');
        $this->form_validation->set_rules('strandId','Strand','required');
        $this->form_validation->set_rules('subjectId', 'Subject','required');
        $this->form_validation->set_rules('semester', 'Semester','required');
        if ($this->form_validation->run()) {
            $ses['className'] = $this->input->post('className');
            $ses['strandId'] = $this->input->post('strandId');
            $ses['subjectId'] = $this->input->post('subjectId');
            $ses['semester'] = $this->input->post('semester');
            
            $this->session->set_userdata('createClass', $ses);
            redirect("shs/createCustomClass2");
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/createCustomClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function loadSubjectsOfStrand()
    {
        if (isset($_POST['strandId'])) {
            $strandId = $this->input->post('strandId');
            $subjectTable = $this->Main_model->get_where('sh_subjects', 'strand_id', $strandId);

            echo "<option value=''>Select subject</option>";
            foreach ($subjectTable->result() as $row) {
                echo "<option value='". $row->subject_id ."'>". $this->Main_model->getShSubjectNameFromId($row->subject_id) ."</option>";
            }
        }
    }

    function createCustomClass2()
    {
        $createClassSess = $_SESSION['createClass'];

        if (isset($_POST['submit'])) {
            $students = $this->input->post('students');
            
            //insert into custom_class
            $cs['name'] = $createClassSess['className'];
            $cs['sh_subject_id'] = $createClassSess['subjectId'];
            $cs['sh_faculty_id'] = $_SESSION['faculty_account_id'];
            $cs['semester'] = $createClassSess['semester'];
            $cs['school_year'] = $this->Main_model->getCurrentSchoolYear();
            $this->Main_model->_insert('custom_class', $cs);

            $customClassId = $this->Main_model->findId('custom_class', $cs, 'id');

            foreach ($students as $row) {
                $studentId = $row;
                
                //insert custom_class_group
                $ccg['custom_class_id'] = $customClassId;
                $ccg['sh_student_id'] = $studentId;
                $ccg['school_year'] = $this->Main_model->getCurrentSchoolYear();
                $this->Main_model->_insert('custom_class_group', $ccg);
            }


            //redirect and notify
            $this->session->set_userdata('customRegister', 1);
            redirect("shs/viewPsYearLevel");
        }

        $data['studentTable'] = $this->Main_model->get('sh_student', 'account_id');
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/createCustomClass2', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function viewSpecialClass()
    {
        //notification
        $this->Main_model->alertPromt('Student deleted from class', 'studDelete');
        $this->Main_model->alertPromt('Student added successfully', 'studentAdded');

        $customClassId = $this->input->get('customClassId');

        $where['custom_class_id'] = $customClassId;
        $data['customClassGroupTable'] = $this->Main_model->multiple_where('custom_class_group', $where);

        //send id
        $data['customClassId'] = $customClassId;

        //send names
        $data['customClassName'] = $this->Main_model->getCustomClassName($customClassId);
        $data['customClassSubjectName'] = $this->Main_model->getCustomClassSubjectName($customClassId);
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/viewSpecialClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function deleteSpecialClass()
    {
        $customClassId = $this->input->get('customClassId');

        //send id
        $data['customClassId'] = $customClassId;
        
        //send names
        $data['customClassName'] = $this->Main_model->getCustomClassName($customClassId);
        $data['customClassSubjectName'] = $this->Main_model->getCustomClassSubjectName($customClassId);

        if (isset($_GET['confirm'])) {
            //delete custom_class
            $this->Main_model->_delete('custom_class', 'id', $customClassId);

            //delete cutom class group
            $this->Main_model->_delete('custom_class_group', 'custom_class_id', $customClassId);

            //redirect and notify
            $this->session->set_userdata('customClassDeleted', 1);
            redirect('shs/viewPsYearLevel');
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/deleteSpecialClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function addCustomClassStudents()
    {
        //notification
        $this->Main_model->alertPromt('Please select a student', 'noSelected');
        if (isset($_SESSION['classDuplicate'])) {
            $message = $this->Main_model->getFullName('sh_student', 'account_id', $_SESSION['classDuplicate']) . " is already in this class";
            $this->Main_model->alertPromt($message, "classDuplicate");
        }

        $customClassId = $this->input->get('customClassId');
        
        //send id
        $data['customClassId'] = $customClassId;
        
        //send names
        $data['customClassName'] = $this->Main_model->getCustomClassName($customClassId);
        $data['customClassSubjectName'] = $this->Main_model->getCustomClassSubjectName($customClassId);
        $data['studentTable'] = $this->Main_model->get('sh_student', 'account_id');

        if (isset($_POST['submit'])) {
            $selectedStudents = $this->input->post('students');
            $this->Main_model->showNormalArray($selectedStudents);
            
            //TRAP: nothing is selected redirect the page. 
            if (empty($selectedStudents)) {
                $this->session->set_userdata('noSelected', 1);
                redirect("shs/addCustomClassStudents?customClassId=$customClassId");
            }

            //TRAP: if student is already in the class
            foreach ($selectedStudents as $row) {
                $studentId = $row;

                $where['custom_class_id'] = $customClassId;
                $where['sh_student_id'] = $studentId; 
                $customClassTable = $this->Main_model->multiple_where('custom_class_group', $where);

                if (count($customClassTable->result_array()) != 0) {
                    //meron na siya sa class
                    $this->session->set_userdata('classDuplicate', $studentId);
                    redirect("shs/addCustomClassStudents?customClassId=$customClassId");
                }
            }

            //end of traps

            //add students into custom_class_group
            foreach ($selectedStudents as $row) {
                $studentId = $row;

                $insert['custom_class_id'] = $customClassId;
                $insert['sh_student_id'] = $studentId;
                $insert['school_year'] = $this->Main_model->getCurrentSchoolYear();
                $this->Main_model->_insert('custom_class_group', $insert);
            }

            //notify and redirect
            $this->session->set_userdata('studentAdded', 1);
            redirect("shs/viewSpecialClass?customClassId=$customClassId");

        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/addCustomClassStudents', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function removeStudentCustomClass()
    {
        $customClassGroupId = $this->input->get('customClassId');
        $customClassId = $this->Main_model->getCustomClassIdFromGroupId($customClassGroupId);
        
        //send id
        $data['customClassGroupId'] = $customClassGroupId;
        $data['customClassId'] = $customClassId;
        
        //send names
        $data['customClassName'] = $this->Main_model->getCustomClassName($customClassId);
        $data['customClassSubjectName'] = $this->Main_model->getCustomClassSubjectName($customClassId);
        $data['studentName'] = $this->Main_model->getStudentNameFromCustomClassGroup($customClassGroupId);
        
        if (isset($_GET['confirm'])) {
            $this->Main_model->_delete('custom_class_group', 'id', $customClassGroupId);

            //redirect and notify
            $this->session->set_userdata('studDelete', 1);
            redirect("shs/viewSpecialClass?customClassId=$customClassId");
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/removeStudentCustomClass', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function uploadGrade()
    {
        if (isset($_POST['submit'])) {
            $schoolYear = $this->input->post("school_year");
            $secondSchoolYear = $schoolYear + 1;
            $fullSchoolYear = "$schoolYear-$secondSchoolYear";
            
            //store into session variable and redirect
            $this->session->set_userdata("uploadSchoolYear", $fullSchoolYear);
            redirect("shs/uploadGradePartTwo");
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/uploadGrade');
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function uploadGradePartTwo()
    {
        $uploadSchoolYear = $_SESSION['uploadSchoolYear'];
        $teacherId = $_SESSION['faculty_account_id'];

        //send Id
        $data['uploadSchoolYear'] = $uploadSchoolYear;
        $data['teacherId'] = $teacherId;

        //get table
        $data['shTeacherLoadTable'] = $this->Main_model->get_where('sh_teacher_load', 'faculty_account_id', $teacherId);
        $data['customClassTable'] = $this->Main_model->get_where('custom_class', 'sh_faculty_id', $teacherId);
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/uploadGradePartTwo', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function sortBySubjectsPsUploadGrade()
    {
        $accountId = $_SESSION['faculty_account_id'];
        $currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        if (isset($_POST['subjectId'])) {
            $subjectId = $this->input->post('subjectId');

            $where['faculty_account_id'] = $accountId;
            $where['sh_subject_id'] = $subjectId;
            $where['faculty_account_id'] = $accountId;
            $where['school_year'] = $currentSchoolYear;
            $teacherLoadTable = $this->Main_model->multiple_where('sh_teacher_load', $where);

            if (count($teacherLoadTable->result_array()) != 0) {
                foreach ($teacherLoadTable->result() as $row) { 
                    echo "<div class='m-1>'";
                    echo "<div class='card' style='width: 18rem;'> ";
                    echo "    <div class='card-body'> ";
                    echo "<div style='width:100%;height:150px'>";
                    echo "        <h5 class='card-title'>".$this->Main_model->getShSubjectNameFromId($row->sh_subject_id)."</h5> ";
                    echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getShSectionName($row->sh_section_id) ."</h6> ";
                    echo "        <p class='card-text'> ". $this->Main_model->getYearLevelNameFromId($row->year_level) ." |  ". $this->Main_model->getStrandName($row->strand_id) ."</p> ";
                    echo "</div>";
                    $enter = base_url() . "shs/selectQuarter?subjectId=$row->sh_subject_id&sectionId=$row->sh_section_id&yearLevel=$row->year_level&strandId=$row->strand_id&semester=$row->semester";
                    echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
                    echo "    </div> ";
                    echo "</div> ";
                    echo "</div>";
                    echo "</div>";
                }
            }else{
                //walang sinelect yun user
                $loadTable = $this->Main_model->get_where('sh_teacher_load', 'faculty_account_id', $accountId);
                foreach ($loadTable->result() as $row) {
                    echo "<div class='m-1>'";
                    echo "<div class='card' style='width: 18rem;'> ";
                    echo "    <div class='card-body'> ";
                    echo "<div style='width:100%;height:150px'>";
                    echo "        <h5 class='card-title'>".$this->Main_model->getShSubjectNameFromId($row->sh_subject_id)."</h5> ";
                    echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getShSectionName($row->sh_section_id) ."</h6> ";
                    echo "        <p class='card-text'> ". $this->Main_model->getYearLevelNameFromId($row->year_level) ." |  ". $this->Main_model->getStrandName($row->strand_id) ."</p> ";
                    echo "</div>";
                    $enter = base_url() . "shs/selectQuarter?subjectId=$row->sh_subject_id&sectionId=$row->sh_section_id&yearLevel=$row->year_level&strandId=$row->strand_id&semester=$row->semester";
                    echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
                    echo "    </div> ";
                    echo "</div> ";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }
    }

    function recordSpecialClass() // para sa mga summer classes.
    {
        echo "you are going to record special class here";
    }

    function selectQuarter() //para sa mga regular students
    {
        //get get id
        $sectionId = $this->input->get('sectionId');
        $subjectId = $this->input->get("subjectId");
        $semester = $this->input->get('semester');
        
        //put the id into session variable
        $ses['sectionId'] = $sectionId;
        $ses['subjectId'] = $subjectId;
        $ses['semester'] = $semester;
        $this->session->set_userdata('shsUpload', $ses);
        
        
        //configure semester name
        if ($semester == 1) {
            $semesterName = "1st sem";
        }else{
            $semesterName = "2nd sem";
        }

        //send id
        $data['sectionId'] =  $sectionId;
        $data['subjectId'] =  $subjectId;
        $data['semester']=   $semester;

        //send names
        $data['sectionName'] = ucfirst($this->Main_model->getShSectionName($sectionId));
        $data['subjectName'] = ucfirst($this->Main_model->getShSubjectNameFromId($subjectId));
        $data['semesterName'] = $semesterName;
        
        //get the list of students.
        $where['sh_section_id'] = $sectionId;
        $where['sh_subject_id'] = $subjectId;
        $where['semester'] = $semester;
        $data['listOfStudents'] = $this->Main_model->multiple_where('sh_class', $where);
        
        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/selectQuarter', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

    }

    function uploadShsGrade()
    {
        $quarter = $this->uri->segment(3);
        
        $sectionId = $_SESSION['shsUpload']['sectionId'];
        $subjectId = $_SESSION['shsUpload']['subjectId'];
        $semester = $_SESSION['shsUpload']['semester'];        

        //send id's
        $data['sectionId'] = $sectionId;
        $data['subjectId'] = $subjectId;
        $data['semester'] = $semester;     
        
        //send names
        $data['sectionName'] = ucfirst($this->Main_model->getShSectionName($sectionId));
        $data['subjectName'] = ucfirst($this->Main_model->getShSubjectNameFromId($subjectId));
        
        //configure semester
        if ($semester == 1) {
            $data['semesterName'] = "1st semester";
        }else{
            $data['semesterName'] = "2nd semester";
        }

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('shs/uploadShsGrade', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

    function importStudentGrades()
    {
        $sectionId = $_SESSION['shsUpload']['sectionId'];
        $subjectId = $_SESSION['shsUpload']['subjectId'];
        $semester = $_SESSION['shsUpload']['semester']; 
        $quarter = $this->uri->segment(3);
        echo "semester: $semester";
        
        //pull all students accordingly
        $where['sh_section_id'] = $sectionId;
        $where['sh_subject_id'] = $subjectId;
        $where['semester'] = $semester;
        $studentTable = $this->Main_model->multiple_where("sh_class", $where);

        $this->Main_model->array_show($studentTable);

        //READ EXCEL FILE
        if(isset($_FILES["file"]["name"]))
			{
				$path = $_FILES["file"]["tmp_name"];
				$object = PHPExcel_IOFactory::load($path);
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();
					for($row=2; $row<=$highestRow; $row++)
					{
						$student_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$quarter_grade = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$subject_id = $_SESSION['subject_selection'];
						$faculty_id = $_SESSION['faculty_account_id'];
						$section_id = $_SESSION['section_selection'];
						
						
						$data[] = array(
							'student_name'		=>	trim($student_name, ' '),
							'quarter1'			=>	$quarter_grade,
							'quarter2'			=>	0,
							'quarter3'			=>	0,
							'quarter4'			=>	0,
							'final_grade'		=>	0,
							'subject_id'		=>	$subject_id,
							'faculty_id'		=>	$faculty_id,
							'section_id'		=>	$section_id,
							'school_year_grade'	=>	$_SESSION['school_year_grade_selection'],
							'school_year' 		=>  $_SESSION['school_year_selection']
						);
					}
				} // end of gathering of data for the excel
                $this->Main_model->showNormalArray($data);
                die;
				//remove empty data in the array
				$data = $this->excel_import_model->removeEmptyArrays($data);

				//perform student authenticator
				$url = base_url() . "excel_import/upload_view";
				$this->excel_import_model->studentNameAuthenticator($data, $url);
				
				$where['subject_id'] = $subject_id;
				$where['section_id'] = $section_id;
				$where['faculty_id'] = $faculty_id;
				$where['school_year_grade'] = $_SESSION['school_year_grade_selection'];
				$where['school_year'] = $_SESSION['school_year_selection'];
				$student_grades_table = $this->Main_model->multiple_where('student_grades', $where);

				foreach ($student_grades_table->result_array() as $row) {
					$quarter1 = $row['quarter1'];
				}
				//you will know if you dont have uploaded any grade yet
				if (isset($quarter1)) {
				// kapag nakapag upload na
				
				foreach ($student_grades_table->result_array() as $row) {
					$student_grades_id = $row['student_grades_id'];
					foreach ($data as $row) {
						$quarter_grade = $row['quarter1'];
						$student_name = $row['student_name'];

						$update_data['quarter1'] = $quarter_grade;
						$where['student_name'] = ltrim($student_name, ' ');
						$where['student_grades_id'] = $student_grades_id;
						$this->Main_model->_multi_update('student_grades', $where, $update_data);
					}

				}
				
				

				redirect('excel_import/import_success');
				}else{
					// kasi meron ng na upload
					$load_where['subject_id'] = $_SESSION['subject_selection'];
					$load_where['faculty_account_id'] = $_SESSION['faculty_account_id'];
					$load_where['section_id'] = $_SESSION['section_selection'];
					$load_where['grade_level'] = $_SESSION['school_year_grade_selection'];

					$teacher_load_table = $this->Main_model->multiple_where('teacher_load', $load_where);
					foreach ($teacher_load_table->result_array() as $row) {
						$teacher_load_id = $row['teacher_load_id'];
						
					}

					$this->load->model('Excel_import_model');
					$this->Excel_import_model->insert($data);
					redirect('excel_import/import_success');
					echo "student name: " . $data['student_name'];
					
				}
				
				
				
				
			}
    }

}
