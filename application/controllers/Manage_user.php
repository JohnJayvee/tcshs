<?php


class Manage_user extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		$this->Main_model->accessGranted();
	}

	function section_no_entry()
	{
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/section_empty');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function get_sub_category()
	{
		$category_id = $this->input->post('id', TRUE);
		$data = $this->Main_model->get_sub_category($category_id)->result();
		echo json_encode($data);
	}

	function selectYearLevelRegister()
	{
		$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/selectYearLevelRegister', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function selectSectionRegister()
	{
		if (isset($_GET['yearLevelId'])) {
			$yearLevelId = $this->input->get('yearLevelId');

			$data['yearLevelId'] = $yearLevelId;
			$data['sectionTable'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/selectSectionRegister', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function register()
	{
		$this->load->model('Main_model');
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$section_table = $this->Main_model->get('section', 'section_id');


			foreach ($section_table->result_array() as $row) {
				$section_id = $row['section_id'];
			}

			if (!isset($section_id)) {
				redirect('manage_user/section_no_entry');
			}

				$this->form_validation->set_rules('firstname', 'First Name', 'required');
				$this->form_validation->set_rules('middlename', 'Middle Name', 'required');
				$this->form_validation->set_rules('lastname', 'Last Name', 'required');
				$this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'required');

				// student form validation
				if ($this->form_validation->run()) {
					//get all the post data
					$firstname = $this->input->post('firstname');
					$middlename = $this->input->post('middlename');
					$lastname = $this->input->post('lastname');
					$mobileNumber = $this->input->post('mobileNumber');

					//get all of the get data
					$yearLevelId = $this->input->get('yearLevelId');
					$sectionId = $this->input->get('sectionId');

					//prepare for the student_profile table
					$sessionSend['firstname'] = $firstname;
					$sessionSend['middlename'] = $middlename;
					$sessionSend['lastname'] = $lastname;
					$sessionSend['parent_id'] = 0; // will be updated later
					$sessionSend['school_grade_id'] = $yearLevelId;
					$sessionSend['section_id'] = $sectionId;
					$sessionSend['mobile_number'] = $mobileNumber;
					$sessionSend['student_status'] = 1; //means that it is already activated
					$sessionSent['school_grade_id'] = $yearLevelId;

					//FAIL SAFE: DUPLICATION CHECKER
					$this->Main_model->jhsDuplicationChecker($sessionSend, $yearLevelId, $sectionId);

					// //prepare for session sending. 
					$this->session->set_userdata('studentInfo', $sessionSend);

					redirect("manage_user/registerParent?yearLevelId=$yearLevelId&sectionId=$sectionId");
					
				}

			

				
				$sectionId = $this->input->get('sectionId');
				
				$sectionTable = $this->Main_model->get_where('section', 'section_id', $sectionId);

				foreach ($sectionTable->result() as $row) {
					$sectionName = $row->section_name;
					$yearLevelId = $row->school_grade_id;
				}
				$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
				$data['sectionName'] = $sectionName;
				$this->load->model('Main_model');
				$data['tags'] = $this->Main_model->just_get_everything('post_tags');
				$data['error'] = ' ';

				//FAILSAFE: STUDENT DUPLICATION ERROR
				$alertMessage = "Junior highschool student already existing";
				$this->Main_model->alertPromt($alertMessage, 'jhsStudentDuplicate');
				//FAILSAFE: STUDENT DUPLICATION ERROR

				$data['sectionId'] = $sectionId;
				$data['yearLevelId'] = $yearLevelId;
				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('manage_accounts/register_student', $data);
				$this->load->view('includes/main_page/admin_cms/footer');
			

			// pare dito ang parent ha--------------------------------->

		} else {
			redirect('main_controller/login');
		}
	}

	function registerParent()
	{
		//get all get data
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');

		//send data needed
		$data['yearLevelId'] = $yearLevelId;
		$data['sectionId'] = $sectionId;

		//FORM VALIDATIONS
		$this->form_validation->set_rules('firstname','First Name','required');
		$this->form_validation->set_rules('middlename','Middle Name','required');
		$this->form_validation->set_rules('lastname','Last name','required');
		$this->form_validation->set_rules('mobileNumber','Mobile Number','required');
		if ($this->form_validation->run()) {
			$firstname = $this->input->post('firstname');
			$middlename = $this->input->post('middlename');
			$lastname = $this->input->post('lastname');
			$mobileNumber = $this->input->post('mobileNumber');

			//prepare for insertion
			$insert['firstname'] = $firstname;
			$insert['middlename'] = $middlename;
			$insert['lastname'] = $lastname;
			$insert['status'] = 1;
			$insert['mobile_number'] = $mobileNumber;
			
			
			$this->Main_model->manageJhsParent($insert, $yearLevelId, $sectionId);

			
		}

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/register_parent', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

	}

	function parent_student_link()
	{

		$this->load->model('Main_model');

		$studentInfo = $_SESSION['studentInfo'];
		$yearLevelId = $this->input->get('yearLevelId');

		if (isset($_POST['link'])) {
			$parent_id = $_POST['optradio'];

			$studentInfo['parent_id'] = $parent_id;
			
			$this->Main_model->_insert('student_profile', $studentInfo);

			$studentAccountId = $this->Main_model->findId('student_profile', $studentInfo, 'account_id');

			//CLASS_SECTION INSERTION
			$insert['student_profile_id'] = $studentAccountId;
			$insert['section_id'] = $studentInfo['section_id'];
			$insert['school_year'] = $studentInfo['school_grade_id']; 
			
			$this->Main_model->_insert('class_section', $insert);

			//CLASS table INSERTION
			$this->Main_model->checkIfTheSectionHasAClassAlready($studentInfo['section_id'], $studentAccountId);

			//credentials creation
			$cred['username'] = $studentInfo['firstname'][0] . $studentInfo['lastname'];
			$password = rand(00000,99999);
			$cred['password'] = $this->Main_model->passwordEncryptor($password);
			$cred['administration_id'] = 2;
			$cred['academic_grade_id'] = 1;
			$cred['account_id'] = $studentAccountId;
			
			//CREDENTIALS INSERTION
			$this->Main_model->_insert('credentials', $cred);

			//text message
			$number = $studentInfo['mobile_number'];
			$message = "your username is: " . $cred['username'] . " and your password is: $password";

			//test puroposes only
			if ($number != "00000000000") {
				$result = $this->Main_model->itexmo($number, $message);
			}
			redirect('Manage_user/register_success?yearLevelId=' . $_GET['yearLevelId'] . '&sectionId=' . $_GET['sectionId']);
		}

			
			//OBTAIN NAME
			$firstname = $studentInfo['firstname'];
			$middlename = $studentInfo['middlename'];
			$lastname = $studentInfo['lastname'];
			$data['studentFullName'] = "$firstname $middlename $lastname";
			
			$parent_table = $this->Main_model->get('parent', 'account_id');

			$data['parent_table'] = $parent_table->result_array();

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/parent_student_link', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		
	}

	function facultyLink()
	{
		$this->load->model('Main_model');

		if (isset($_POST['link'])) {
			$faculty_id = $_POST['optradio'];

			//get get data
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);
			foreach ($faculty_table->result_array() as $row) {
				$firstname = $row['firstname'];
				$middlename = $row['middlename'];
				$lastname = $row['lastname'];
				$parent_id = $row['parent_id'];
			}

			//meaning wala pang account sa parent table
			if ($parent_id == 0) {

				// data ng teacher
				$data['firstname'] = $firstname;
				$data['middlename'] = $middlename;
				$data['lastname'] = $lastname;
				$data['status'] = 1;

				$this->Main_model->_insert('parent', $data);


				$parent_table = $this->Main_model->just_get_everything('parent');

				foreach ($parent_table->result_array() as $row) {
					$latest_parent_id = $row['account_id'];
				}

				//parent id
				$update_array['parent_id'] = $latest_parent_id;

				//update sa foreign key ng faculty table
				$this->Main_model->_update('faculty', 'account_id', $faculty_id, $update_array);

				$student_table = $this->Main_model->just_get_everything('student_profile');
				foreach ($student_table->result_array() as $row) {
					$latest_student_id = $row['account_id'];
				}

				$update['parent_id'] = $latest_parent_id;
				$this->Main_model->_update('student_profile', 'account_id', $latest_student_id, $update);

				$additionalLink  = "Manage_user/register_success?yearLevelId=$yearLevelId&sectionId=$sectionId";

				redirect($additionalLink);
			} else {

				$student_table = $this->Main_model->just_get_everything('student_profile');
				foreach ($student_table->result_array() as $row) {
					$latest_student_id = $row['account_id'];
				}


				// parent id ng sinelect na teacher yung nakuha dito
				$update['parent_id'] = $parent_id;
				$this->Main_model->_update('student_profile', 'account_id', $latest_student_id, $update);
				$additionalLink  = "Manage_user/register_success?yearLevelId=$yearLevelId&sectionId=$sectionId";

				redirect($additionalLink);
			}
		} else {

			$faculty_table = $this->Main_model->get('faculty', 'account_id');
			$data['faculty_table'] = $faculty_table->result_array();

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/facultyParent', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function register_parent()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$data['yearLevelId'] = $this->input->get('yearLevelId');
			$data['sectionId'] = $this->input->get('sectionId');
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/register_parent', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}


	function register_success()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {


			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/register_success');
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function view_parent_account()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$where['school_grade_id'] = $yearLevelId;
			$where['section_id'] = $sectionId;

			$data['studentTable'] = $this->Main_model->multiple_where('student_profile', $where);

			//create storage array for parents not duplicating
			$parentId = array();
			$parentTable = array();

			//get the student table as iterator
			$studentTable = $this->Main_model->multiple_where('student_profile', $where);
			foreach ($studentTable->result_array() as $row) {
				//do disable duplications
				if (in_array($row['parent_id'], $parentId)) {
				} else {
					array_push($parentId, $row['parent_id']);
				}
			}

			//get the parent table using the parentId
			foreach ($parentId as $row) {
				$parentData = $this->Main_model->get_where('parent', 'account_id', $row);
				array_push($parentTable, $parentData->result_array());
			}

			//note: yung sa view natin dapat yung iterator dapat zero lang siya kasi 
			//multidimensional array siya. 

			//send data
			$data['table'] = $parentTable;
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/view_account_parent', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function view_student_account()
	{
			$sectionId = $this->input->get('sectionId');
			$yearLevelId = $this->Main_model->getJhsYearLevelWithSectionId($sectionId);
		
			$where['school_grade_id'] = $yearLevelId;
			$where['section_id'] = $sectionId;
			$data['table'] = $this->Main_model->multiple_where('student_profile', $where);
		
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/view_account_student', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
	}

	function student_account_edit()
	{
		//get student id
		$studentId = $this->uri->segment(3);

		//get credentials
		$credentialsTable = $this->Main_model->get_where('credentials', 'account_id', $studentId);
		foreach ($credentialsTable->result() as $row) {
			$username = $row->username;
			$password = $row->password;
		}

		//get firstname etc..
		$studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentTable->result() as $row) {
			$firstname = $row->firstname;
			$middlename = $row->middlename;
			$lastname = $row->lastname;
			$school_grade_id = $row->school_grade_id;
		}

		//send the variables to the view
		$data['account_id'] = $studentId;
		$data['firstname'] = $firstname;
		$data['middlename'] = $middlename;
		$data['lastname'] = $lastname;
		$data['school_grade_id'] = $school_grade_id;
		$data['section_id'] = $this->input->get('sectionId');


		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/student_edit', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		//perform post registration
		if (isset($_POST['submit'])) {
			//get post data
			$studentId = $this->uri->segment(3);
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$firstname = $this->input->post('firstname');
			$middlename = $this->input->post('middlename');
			$lastname = $this->input->post('lastname');
			$school_grade_id = $this->input->post('school_grade');
			$section_id = $this->input->post('section');

			//manage parameters of _update function
			$update['firstname'] = $firstname;
			$update['middlename'] = $middlename;
			$update['lastname'] = $lastname;

			//perform update
			$this->Main_model->_update('student_profile', 'account_id', $studentId, $update);

			$this->session->set_userdata('updateSuc', 1);
			redirect("manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
		}
	}

	function getYearLevelId()
	{
		if (isset($_POST['school_grade_id'])) {
			$yearLevelId = $this->input->post('school_grade_id');
			$section = $this->Main_model->getSectionWhere($yearLevelId);
			echo json_encode($section);
		}
	}




	function account_delete() //waiting the confirmation
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {


			$this->load->model('Main_model');
			$id = $this->uri->segment(3);
			$classify = $this->uri->segment(4);

			if ($classify == 1) {
				$data['account_name'] = $this->Main_model->get_where('student_profile', 'account_id', $id);
			} elseif ($classify == 2) {
				$data['account_name'] = $this->Main_model->get_where('parent', 'account_id', $id);
			}




			$data['classify'] = $classify;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/confirm_delete_user', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function delete() //dito siya papasok kapag nag confirm ka
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$classify = $this->uri->segment(3);
			$student_id = $this->uri->segment(4);
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$this->Main_model->checkParentNoLeftChild($student_id);
			
			if ($classify == 1) {
				//get the student info
				$studentTable = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
				foreach ($studentTable->result() as $row) {

					//populate the g10_repository
					$repository['account_id'] = $student_id;
					$repository['firstname'] = $row->firstname;
					$repository['middlename'] = $row->middlename;
					$repository['lastname'] = $row->lastname;
					$repository['parent_id'] = $row->parent_id;
					$repository['school_grade_id'] = $row->school_grade_id;
					$repository['section_id'] = $row->section_id;
					$repository['mobile_number'] = $row->mobile_number;

					//get the parent id of the student
					$parentId = $row->parent_id;
				}

				//repository insertion
				$this->Main_model->_insert('g10_repository', $repository);

				//find whether the student has a faculty parent
				$facultyCheck = $this->Main_model->get_where('faculty', 'parent_id', $parentId);
				$this->Main_model->array_show($facultyCheck);
				echo "student id is: $student_id";

				$this->Main_model->_delete('student_profile', 'account_id', $student_id);
				$this->Main_model->_delete('credentials', 'account_id', $student_id);
				$this->Main_model->_delete('class_section', 'student_profile_id', $student_id);
				$this->Main_model->_delete('class', 'student_profile_id', $student_id);

				//faculty parent checker
				// kapag one nalang yung anak niya syempre i dedelete mo ulit odi wala na siyang anak kaya siya magiging zero
				if (count($facultyCheck->result_array()) == 1) {
					//update the faculty account parent id into 0 to notify the system that the faculty member has no child
					foreach ($facultyCheck->result() as $row) {
						$update['parent_id'] = 0;
						$this->Main_model->_update('faculty', 'account_id', $row->account_id, $update);
					}
					$this->session->set_userdata("parentFacultyDeactivated", 1);
					redirect("manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
				}

				//find whether the parent of the student has no more child left studying in the school hence delete
				$parentTable = $this->Main_model->get_where('student_profile', 'parent_id', $parentId);
				if (count($parentTable->result_array()) == 0) {
					//yung parent na yun wala na siyang anak na natitira
					$this->Main_model->_delete('parent', 'account_id', $parentId);
					$this->Main_model->_delete('credentials', 'account_id', $parentId);

					//notify the user that the system deleted the parent
					$this->session->set_userdata('parentDeleted', 1);
				}

				$this->session->set_userdata('accountDeleted', 1);
				redirect("manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			} elseif ($classify == 2) {
				//parent naman yung i dedelete mo
				$parent_id = $student_id;

				$this->Main_model->_delete('parent', 'account_id', $parent_id);
				$this->Main_model->_delete('credentials', 'account_id', $parent_id);

				$this->session->set_userdata('accountDeleted', 1);
				redirect("manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			}
		} else {
			redirect('main_controller/login');
		}
	}

	function activate()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			//get the get values
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$id = $this->uri->segment(3);
			$classify = $this->uri->segment(4);

			$this->load->model('Main_model');

			if ($classify == 1) {
				$table_student = $this->Main_model->get_where('student_profile', 'account_id', $id);

				// foreach ($table_student->result_array() as $row) {
				// 	$id_student = $row['account_id'];
				// 	$parent_id = $row['parent_id'];
				// }





				$data['student_status'] = 1;

				$this->Main_model->_update('student_profile', 'account_id', $id, $data);



				redirect("manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			} elseif ($classify == 2) {
				$parent_id = $this->uri->segment(3);







				$datum['status'] = 1;

				$this->Main_model->_update('parent', 'account_id', $id, $datum);

				redirect("manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			}
		} else {
			redirect('main_controller/login');
		}
	} //end of function active

	function deactivate()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {
			//get the get data
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$id = $this->uri->segment(3); //student-> account_id
			$classify = $this->uri->segment(4);

			$this->load->model('Main_model');

			if ($classify == 1) {
				$table_student = $this->Main_model->get_where('student_profile', 'account_id', $id);





				$data['student_status'] = 0;

				$this->Main_model->_update('student_profile', 'account_id', $id, $data);



				redirect("manage_user/view_student_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			} elseif ($classify == 2) {
				$parent_id = $this->uri->segment(3);

				$table_student = $this->Main_model->get_where('student_profile', 'parent_id', $parent_id);
				$table_parent = $this->Main_model->get_where('parent', 'account_id', $parent_id);


				$datum['status'] = 0;

				$this->Main_model->_update('parent', 'account_id', $id, $datum);








				redirect("manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
			}
		} else {
			redirect('main_controller/login');
		}
	} //end of function deactivate

	function parentEdit()
	{
		$this->load->model('Main_model');
		$parent_id = $this->uri->segment(3);

		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');

		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('middlename', 'Middlename', 'required');
		$this->form_validation->set_rules('lastname', 'Lastname', 'required');
		if ($this->form_validation->run()) {
			$data['firstname'] = $this->input->post('firstname');
			$data['middlename'] = $this->input->post('middlename');
			$data['lastname'] = $this->input->post('lastname');

			$this->Main_model->_update('parent', 'account_id', $parent_id, $data);
			$this->session->set_userdata('parentUpdate', 1);
			redirect("manage_user/view_parent_account?yearLevelId=$yearLevelId&sectionId=$sectionId");
		}

		$parent_table = $this->Main_model->get_where('parent', 'account_id', $parent_id);
		foreach ($parent_table->result_array() as $row) {
			$firstname = ucfirst($row['firstname']);
			$middlename = ucfirst($row['middlename']);
			$lastname = ucfirst($row['lastname']);
		}

		$data['parentFullName'] = "$firstname $middlename $lastname";
		
		//get and send the yearlevel id etc.
		$data['yearLevelId'] = $this->input->get('yearLevelId');
		$data['sectionId'] = $this->input->get('sectionId');

		$data['firstname'] = $firstname;
		$data['middlename'] = $middlename;
		$data['lastname'] = $lastname;
		$data['parent_id'] = $parent_id;
		
		$data['yearLevelId'] = $yearLevelId;
		$data['sectionId'] = $sectionId;
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/parent_update', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function editStudentLink()
	{
		$this->load->model('Main_model');
		$parent_id = $this->uri->segment(3);

		if (isset($_POST['studentList'])) {
			$checkedStudents = $this->input->post('students');
			$parentsStudent = $this->Main_model->get_where('student_profile', 'parent_id', $parent_id);
			foreach ($parentsStudent->result_array() as $row) {
				$oldStudentId = $row['account_id'];

				$update['parent_id'] = 0;
				$this->Main_model->_update('student_profile', 'account_id', $oldStudentId, $update);
			}

			foreach ($checkedStudents as $row) {
				$checkedStudentId = $row;

				$update_2['parent_id'] = $parent_id;
				$this->Main_model->_update('student_profile', 'account_id', $checkedStudentId, $update_2);
			}
			$this->session->set_userdata('studentLinkUpdated', 1);
			redirect('manage_user/view_parent_account');
		} else {
			$parent_table = $this->Main_model->get_where('parent', 'account_id', $parent_id);
			foreach ($parent_table->result_array() as $row) {
				$firstname = $row['firstname'];
				$middlename = $row['middlename'];
				$lastname = $row['lastname'];
			}

			$student_table = $this->Main_model->get('student_profile', 'account_id');
			$data['parent_id'] = $parent_id;
			$data['student_table'] = $student_table->result_array();
			$data['ParentFullName'] = "$firstname $middlename $lastname";
		
			//send yearLevelId and etc..
			$data['yearLevelId'] = $this->input->get('yearLevelId');
			$data['sectionId'] = $this->input->get('sectionId');
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/editStudentLink', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function viewAccountYearlevel()
	{
		$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'name');

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/viewAccountYearLevel', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}
	//para sa auto complete
	function get_autocomplete()
	{
		if (isset($_GET['term'])) {
			$result = $this->Main_model->search_blog($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row)
					$arr_result[] = array(
						'label'	=> "$row->firstname $row->middlename $row->lastname",
					);
				echo json_encode($arr_result);
			}
		}
	}



	function viewAccountSection()
	{
		$yearLevelId = $this->input->get('yearLevelId');
		
		$data['sectionNameId'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
		$data['yearLevelId'] = $yearLevelId;
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/viewAccountSection', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}
	// end ng para sa
	

}//end of class
