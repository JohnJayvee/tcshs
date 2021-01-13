<?php

class Manage_user_accounts extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		$this->load->model('excel_import_model');
		$this->Main_model->accessGranted();
	}

	function login()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run()) {
				$data['username'] = $this->input->post('username');
				$data['password'] = $this->input->post('password');


				$this->load->model('Main_model');
				$user_table = $this->Main_model->get_where_user_pass('credentials', $data);




				foreach ($user_table as $row) {
					$data['credentials_id'] = $row['credentials_id'];
					$data['username'] = $row['username'];
					$data['password'] = $row['password'];
					$data['administration_id'] = $row['administration_id'];
					$data['account_id'] = $row['account_id'];
				}



				$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $data['account_id']);

				foreach ($faculty_table->result_array() as $row) {
					$account_id = $row['account_id'];
					$firstname = $row['firstname'];
					$middlename = $row['middlename'];
					$lastname = $row['lastname'];
				}



				if ($data['administration_id'] == 4) {
					$user_data['account_id'] = $account_id;
					$user_data['firstname'] = $firstname;
					$user_data['middlename'] = $middlename;
					$user_data['lastname'] = $lastname;
					$user_data['credentials_id'] = $data['credentials_id'];

					$this->session->set_userdata($user_data);

					redirect('manage_user_accounts/manage_account');
				}
			}

			if (isset($_SESSION['credentials_id']) == 4) {
				redirect('manage_user_accounts/manage_account');
			}

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/manage_account_login');
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}




	function manage_account()
	{
			$search1 = $this->Main_model->get_where('credentials', 'administration_id', 5);
			$search2 = $this->Main_model->get_where('faculty', 'sec_account', 1);

			if (count($search1->result_array()) != 0) {
				
				//secretary lang
				$secretaryTable = $search1;
				$this->Main_model->ifSecTeacherSetUnsetIt();
				$this->session->set_userdata('secretaryTeacher', 0); //kapag secreatry lang
				//set ng session notifying the system that the secretary is is just a secretary
			}elseif (count($search2->result_array()) != 0) {
				
				//secretary teacher siya.
				$secretaryTable = $search2;
				//set ng session notifying the system that the secretary is a secretary teacher
				$this->session->set_userdata('secretaryTeacher', 1); //kapag secreatry teacher
			}
			
			foreach ($secretaryTable->result_array() as $row) {
				$secretaryAccountId = $row['account_id'];
			}

			
			$data['secretaryName'] = $this->Main_model->getFullname('faculty', 'account_id', $secretaryAccountId);
			

			$data['faculty_table'] = $this->Main_model->get('faculty', 'account_id');
			$data['credentials'] = $this->Main_model->get_where('credentials', 'administration_id', 4);


			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/manage_account_options', $data);
			$this->load->view('includes/main_page/admin_cms/footer');	
	}

	function controlSecretaryRole()
	{
		//control message that will be rendered.
		if ($_SESSION['secretaryTeacher'] == 1) {
			//secretary teacher siya
			$data['message'] = "Are you sure you want the current secretary to just be a secretary?";
		}else{
			//secretary lang siya.
			$data['message'] = "Are you sure you want the current secretary to also be a teacher?";
		}

		//perform updating of accounts
		if (isset($_GET['confirm'])) {
			
			if ($_SESSION['secretaryTeacher'] == 1) {
				//secretary teacher siya gagawin mo nalang siya bilang secretary nalang
				$cred['administration_id'] = 5;
				$cred['academic_grade_id'] = 0;
				$fac['sec_account'] = 0;

				//get the secretary id
				$secretaryId = $this->Main_model->GetPreviousSecretaryId();

				//perform update
				$this->Main_model->_update('credentials', 'account_id', $secretaryId, $cred);
				$this->Main_model->_update('faculty', 'account_id', $secretaryId, $fac);
				
				$this->session->set_userdata("secretaryAccountUpdated", 1);
				redirect("manage_user_accounts/manage_account");
			
			}else{
				//secretary lang siya. gagawin mo na siyang secretary teacher
				$cred['administration_id'] = 1;
				$cred['academic_grade_id'] = 1;
				$fac['sec_account'] = 1;

				//get the secretary id
				$secretaryId = $this->Main_model->GetPreviousSecretaryId();

				//perform update
				$this->Main_model->_update('credentials', 'account_id', $secretaryId, $cred);
				$this->Main_model->_update('faculty', 'account_id', $secretaryId, $fac);
				
				$this->session->set_userdata("secretaryAccountUpdated", 1);
				redirect("manage_user_accounts/manage_account");
			}

		}
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/controlSecretaryRole', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function register_faculty()
	{

		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {



			//remove password 
			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('middlename', 'Middle Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');
			$this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'required');

			if ($this->form_validation->run()) {
				$academicGradeId = $this->uri->segment(3);

				$firstname = ucfirst($this->input->post('firstname'));
				$middlename = ucfirst($this->input->post('middlename'));
				$lastname = ucfirst($this->input->post('lastname'));
				$mobileNumber = $this->input->post('mobileNumber');

				//duplication checker
				$redirectUrl = 'manage_user_accounts/register_faculty/' . $academicGradeId;
				$this->Main_model->facultyDuplicationChecker($firstname, $middlename, $lastname, $redirectUrl);

				$data['firstname'] = $firstname;
				$data['middlename'] = $middlename;
				$data['lastname'] = $lastname;
				$data['status'] = 1;
				$data['mobile_number'] = $mobileNumber;


				$this->load->model('Main_model');
				$this->Main_model->_insert('faculty', $data);

				$user_table = $this->Main_model->get_where_custom('faculty', 'firstname', $data['firstname']);


				foreach ($user_table->result_array() as $row) {
					$account_id = $row['account_id'];
				}


				$randomPassword = rand(11111, 99999);
				$encryptedPassword = $this->Main_model->passwordEncryptor($randomPassword);

				$datum['username'] = strtolower($firstname[0].$lastname);
				$datum['password'] = $encryptedPassword;
				$datum['administration_id'] = 1;
				$datum['account_id'] = $account_id;
				$datum['academic_grade_id'] = $academicGradeId;

				//text the teacher for his password
				$mobileNumber = $this->input->post('mobileNumber');
				$message = "Username: " . $datum['username'];
				$message .=  " your password is: $randomPassword";
				$this->Main_model->itexmo($mobileNumber, $message);

				$this->Main_model->_insert('credentials', $datum);
				$this->session->set_userdata('facultyCreated', 1);
				redirect('manage_user_accounts/register_faculty/' . $academicGradeId);
			}

			//if uri segment is 1 => junior highschool; 2=> senior highschool
			$academic_grade = $this->uri->segment(3);

			if ($academic_grade == 1) {
				$acad['academic_name'] = "Junior Highschool";
			} else {
				$acad['academic_name'] = "Senior Highschool";
			}

			$acad['academicGradeId'] = $academic_grade;

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('manage_accounts/register_faculty', $acad);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function activate_faculty()
	{
		$faculty_account_id = $this->uri->segment(3);
		$data['status'] = 1;
		$this->Main_model->_update('faculty', 'account_id', $faculty_account_id, $data);
		redirect('manage_user_accounts/manage_account');
	}

	function deactivateFaculty()
	{
		$faculty_account_id = $this->input->get('id');

		$data['status'] = 0;
		$this->Main_model->_update('faculty', 'account_id', $faculty_account_id, $data);
		redirect('manage_user_accounts/manage_account');
	}

	//sure deleteion of the faculty member
	function sureDeletion()
	{

		//perform deletiong
		if (isset($_GET['confirm'])) {
			$facultyId = $this->input->get('confirm');

			//get the teacher's information
			$teacherTable = $this->Main_model->get_where('faculty', 'account_id', $facultyId);
			foreach ($teacherTable->result() as $row) {

				//store in the faculty repository
				$fakrepo['faculty_account_id'] = $facultyId;
				$fakrepo['firstname'] = $row->firstname;
				$fakrepo['middlename'] = $row->middlename;
				$fakrepo['lastname'] = $row->lastname;
				$fakrepo['status'] = $row->status;
				$fakrepo['parent_id'] = $row->parent_id;
				$fakrepo['mobile_number'] = $row->mobile_number;
				$this->Main_model->_insert('faculty_repository', $fakrepo);
			}

			//store in the credentials table
			$credTable = $this->Main_model->get_where('credentials', 'account_id', $facultyId);
			$this->Main_model->array_show($credTable);
			foreach ($credTable->result() as $row) {

				//store in the credentials repository
				$credRepo['faculty_account_id'] = $facultyId;
				$credRepo['credentials_id'] = $row->credentials_id;
				$credRepo['username'] = $row->username;
				$credRepo['password'] = $row->password;
				$credRepo['administration_id'] = $row->administration_id;
				$credRepo['academic_grade_id'] = $row->academic_grade_id;
				$credRepo['account_id'] = $row->account_id;
				$this->Main_model->_insert('credentials_repository', $credRepo);
			}

			//delete from faculty table
			$this->Main_model->_delete('faculty', 'account_id', $facultyId);

			//delete from credentials table
			$this->Main_model->_delete('credentials', 'account_id', $facultyId);

			//redirect page
			$this->session->set_userdata('fakDeleted', 1);

			//remove from adviser section
			$this->Main_model->_delete('adviser_section', 'faculty_account_id', $facultyId);

			//classify where it will be redirected
			if ($credRepo['academic_grade_id']  == 1) {
				$redirectUrl = "manage_user_accounts/viewJuniorHighSchoolFaculty";
			} else {
				$redirectUrl = "manage_user_accounts/viewSeniorHighSchoolFaculty";
			}


			redirect($redirectUrl);
		} else {

			$facultyId = $this->input->get('id');
			$facultyName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $facultyId);

			$data['facultyId'] = $facultyId;
			$data['facultyName'] = $facultyName;

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/sureDeletion', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}



	function delete_faculty()
	{

		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$id = $this->input->get('id');
			$this->load->model('Main_model');
			$data['faculty_table'] = $this->Main_model->get_where(
				'faculty',
				'account_id',
				$id
			);

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/confirm_delete', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function deletion()
	{

		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {


			$update_id = $this->input->get('id');
			$this->load->model('Main_model');
			$data['status'] = 0;
			$this->Main_model->_update('faculty', 'account_id', $update_id, $data);


			redirect('manage_user_accounts/manage_account');
		} else {
			redirect('main_controller/login');
		}
	}


	function update_faculty()
	{

		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$update_id = $this->uri->segment(3);


			$this->load->model('Main_model');
			$data['user_table'] = $this->Main_model->get_where('faculty', 'account_id', $update_id);




			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('middlename', 'Middle Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required');

			if ($this->form_validation->run()) {
				$account['firstname'] = ucfirst($this->input->post('firstname'));
				$account['middlename'] = ucfirst($this->input->post('middlename'));
				$account['lastname'] = ucfirst($this->input->post('lastname'));

				$this->load->model('Main_model');
				$this->Main_model->_update('faculty', 'account_id', $update_id, $account);

				$this->session->set_userdata('facUpdate', 1);
				redirect('manage_user_accounts/viewJuniorHighSchoolFaculty');
			}

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('manage_accounts/update_faculty', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}


	function change_principal()
	{
			$credentials_table =  $this->Main_model->get_where('credentials', 'administration_id', 4);

			foreach ($credentials_table->result_array() as $row) {
				$administration_id = $row['administration_id'];
				$account_id = $row['account_id'];
			}

			$data['principal_id'] = $this->Main_model->get_where('faculty', 'account_id', $account_id);

			$this->form_validation->set_rules('firstname', 'First Name', 'required');
			$this->form_validation->set_rules('middlename', 'Middle Name', 'required');
			$this->form_validation->set_rules('lastname', 'Last name', 'required');
			$this->form_validation->set_rules('mobileNumber', 'Mobile number', 'required');

			if ($this->form_validation->run()) {

				$user_data['firstname'] = $this->input->post('firstname');
				$user_data['middlename'] = $this->input->post('middlename');
				$user_data['lastname'] = $this->input->post('lastname');
				$user_data['mobile_number']  = $this->input->post('mobileNumber');

				$credentials['administration_id'] = $administration_id;
				$credentials['account_id'] = $account_id;

				// configure username and password
				$credentials['username'] = $user_data['firstname'][0] . $user_data['lastname'];
				$randomPassword = rand(0, 99999);
				$credentials['password'] = $this->Main_model->passwordEncryptor($randomPassword);

				//send text message 
				$message = "Username: " . $credentials['username'] . "  Password:  "   .  $randomPassword;
				$mobileNumber  = $user_data['mobile_number'];
				$this->Main_model->itexmo($mobileNumber,$message);

				$this->Main_model->_update('credentials', 'administration_id', $administration_id, $credentials);

				$this->Main_model->_update('faculty', 'account_id', $account_id, $user_data);

				$this->session->set_userdata('changePrincipal', 1);
				redirect('manage_user_accounts/secretaryView');
			}

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('manage_accounts/change_principal', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
	}

	function pendingRequestPosts()
	{
		if (isset($_POST['getPendingPost'])) {
			$pendingTable = $this->Main_model->get_where('post', 'post_status', 0);
			$pendingPostCount = count($pendingTable->result_array());
			echo $pendingPostCount;
		}
	}

	function approve_content()
	{
		$principalId = $_SESSION['faculty_account_id'];
		
		
		$datum['no_new_items'] = 0;
		$this->Main_model->_update('sbar_notif', 'notif_id', 1, $datum);
		
		$data['principalName'] = $this->Main_model->getFullNameWithId('faculty', 'account_id', $principalId);
		$data['post_table'] = $this->Main_model->order_by_desc('post', 'post_id');
		$data['disapproveTable'] = $this->Main_model->get_where('post', 'post_status', 0);
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/approve_content', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function approved_content()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$this->load->model('Main_model');
			$data['post_table'] = $this->Main_model->get_where('post', 'post_status', 1);

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/approved_content', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function disapproved_content()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$this->load->model('Main_model');
			$data['post_table'] = $this->Main_model->get_where('post', 'post_status', 0);

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/disapproved_content', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function content_view()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$id = $this->uri->segment(3);
			$this->load->model('Main_model');
			$data['post_table'] = $this->Main_model->get('post', 'post_id');
			$data['post_id'] = $id;

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('includes/old_css/header');
			$this->load->view('manage_accounts/content_view', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function remove()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$this->load->model('Main_model');
			$post_id = $this->uri->segment(3);
			$confirmation = $this->uri->segment(4);

			if ($confirmation == 1) {

				$post_get = $this->Main_model->get_where('post', 'post_id', $post_id);

				foreach ($post_get->result_array() as $row) {
					$image = $row['post_image'];
				}

				$this->Main_model->_delete('post', 'post_id', $post_id);
				unlink('cms_uploads/' . $image);
				redirect('manage_user_accounts/approve_content');
			} elseif ($confirmation == 0) {

				$data['post_table'] = $this->Main_model->get_where('post', 'post_id', $post_id);
				// $this->Main_model->array_show($post_table);

				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('manage_accounts/confirm_delete_post', $data);
				$this->load->view('includes/main_page/admin_cms/footer');
			}
		} else {
			redirect('main_controller/login');
		}
	}

	function post_activate()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$id = $this->uri->segment(3);
			$result = $this->Main_model->get_where('post', 'post_id', $id);



			$data['post_status'] = 1;


			$this->Main_model->_update('post', 'post_id', $id, $data);

			$this->session->set_userdata('postActivated', 1);
			redirect('manage_user_accounts/approve_content');
		} else {
			redirect('main_controller/login');
		}
	}

	function post_deactivate()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$id = $this->uri->segment(3);
			$result = $this->Main_model->get_where('post', 'post_id', $id);



			$data['post_status'] = 0;


			$this->Main_model->_update('post', 'post_id', $id, $data);

			$this->session->set_userdata('postDeactivated', 1);
			redirect('manage_user_accounts/approve_content');
		} else {
			redirect('main_controller/login');
		}
	}

	function dashboard()
	{
		$faculty_id = $_SESSION['faculty_account_id'];
		$credentialsId = $_SESSION['credentials_id'];
		$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);
		foreach ($faculty_table->result_array() as $row) {
			$firstname = ucfirst($row['firstname']);
			$middlename = ucfirst($row['middlename']);
			$lastname = ucfirst($row['lastname']);
		}

		$fullname = "$firstname $middlename $lastname";
		$data['fullname'] = $fullname;
		$data['faculty_id'] = $faculty_id;

		//principal identifier
		if ($credentialsId == 4) { //principal
			
			$data['accademicYear'] = $this->Main_model->getAcademicYear();
			
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/principalDashboard', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/dashboard', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function configureSecretaryCreds()
	{
		$this->session->set_userdata("credentials_id", 5);
		echo "dapat nabago na yung session data";
		
		redirect("manage_user_accounts/secretaryView");
	}


	function change_password()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$faculty_id = $this->uri->segment(3);


			$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);
			$credentials_table = $this->Main_model->get_where('credentials', 'account_id', $faculty_id);
			foreach ($faculty_table->result_array() as $row) {
				$firstname = $row['firstname'];
				$middlename = $row['middlename'];
				$lastname = $row['lastname'];
			}

			foreach ($credentials_table->result_array() as $row) {
				$username = $row['username'];
				$password = $row['password'];
			}

			$data['firstname'] = $firstname;
			$data['middlename'] = $middlename;
			$data['lastname'] = $lastname;
			$data['username'] = $username;
			$data['password'] = $password;
			$data['faculty_id'] = $faculty_id;

			// credentials validation
			$this->form_validation->set_rules('oldPassword','Previous password','required');
			$this->form_validation->set_rules('newPassword','New password','required');
			$this->form_validation->set_rules('confirmPassword','Confirm password','required');

			//personal info validation
			$this->form_validation->set_rules('firstname','First name','required');
			$this->form_validation->set_rules('middlename','Middle name','required');
			$this->form_validation->set_rules('lastname','Last name','required');			

			if ($this->form_validation->run()) {

					$dbPassword = $this->Main_model->getPassword($faculty_id);
					$previousPassword = $this->input->post('oldPassword');
					$oldPassword = $this->input->post('oldPassword');

					//validate db password and old password input
					if ($dbPassword != $this->Main_model->passwordEncryptor($previousPassword)) {
						//hindi pareho i redirect mo siya
						$this->session->set_userdata('oldPasswordNoMatch', 1);
						redirect("Manage_user_accounts/change_password/$faculty_id");
					}
					

					//pasword confirmation 
					$password1 = $this->input->post('newPassword');
					$password2 = $this->input->post('confirmPassword');
					
					//confirm password validator
					if ($password1 != $password2) {
						$this->session->set_userdata("p1notp2", 1);
						redirect('manage_user_accounts/change_password/' . $faculty_id);
					}
					
					$password = $_POST['password'];
					$firstname = $_POST['firstname'];
					$middlename = $_POST['middlename'];
					$lastname = $_POST['lastname'];
					$fac_id = $_SESSION['faculty_account_id'];

					$faculty_array['firstname'] = $firstname;
					$faculty_array['middlename'] = $middlename;
					$faculty_array['lastname'] = $lastname;
					
					//UPDATE FACULTY INFORMATION
					$this->Main_model->_update('faculty', 'account_id', $fac_id, $faculty_array);
					
					$credentials_array['password'] = $this->Main_model->passwordEncryptor($password2);
					
					//UPDATE CREDENTIALS
					$this->Main_model->_update('credentials', 'account_id', $fac_id, $credentials_array);

					$session_array['alert_message'] = 'Update Successful';
					$this->session->set_userdata($session_array);


					//manage redirection
					if ($_SESSION['credentials_id'] == 4) {
						$redirect = "manage_user_accounts/dashboard";
					}elseif($_SESSION['credentials_id'] == 1) {
						$redirect = "manage_user_accounts/dashboard";
					}elseif($_SESSION['credentials_id'] == 5) { // secretary
						$redirect = "manage_user_accounts/secretaryView";
					}
					redirect($redirect);
			}

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('manage_accounts/change_password', $data);
			$this->load->view('includes/main_page/admin_cms/footer');

		} else {
			redirect('main_controller/login');
		}
	}



	function getGradeAndHaveSection()
	{
		if (isset($_POST['yearLevelId'])) {
			$yearLevelId = $this->input->post('yearLevelId');
			//kung anong i eecho mo yun yung lalabas
			$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
			foreach ($sectionTable->result() as $row) {
				echo "<option value=" . $row->section_id . ">" . $row->section_name . "</option>";
			}
		}
	}

	function update_grade_class()
	{
		$this->form_validation->set_rules('grade', 'Grade', 'required');
		$this->form_validation->set_rules('section', 'Section', 'required');

		if ($this->form_validation->run()) {

			$grade = $_POST['grade'];
			$section = $_POST['section'];

			$array['section_id'] = $section;
			$array['school_grade_id'] = $grade;
			$array['student_status'] = 1;

			$student_table = $this->Main_model->multiple_where('student_profile', $array);
			
			//REMOVE ALREADY PROCESSED STUDENTS.
			$student_table = $this->Main_model->removeProcessedStudents($student_table);
			

			// catcher para kapag walang laman yung table redirect siya
			if (empty($student_table)) {

				$this->session->set_userdata('empty', 'selection empty');
				redirect('manage_user_accounts/update_grade_class');
			} else {

				$data['grade'] = $grade;
				$data['section'] = $section;
				$data['student_table'] = $student_table;

				$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($grade);
				$data['sectionName'] = $this->Main_model->getSectionNameFromId($section);
				
				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('manage_accounts/update_year_grade', $data);
				$this->load->view('includes/main_page/admin_cms/footer');
			} // pag walang laman

		} else {

			$this->load->model('Main_model');
			$data['school_grade_table'] = $this->Main_model->get('school_grade', 'school_grade_id');

			$data['section_table'] = $this->Main_model->get('section', 'section_id');

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/section_year_selection', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function update_grade_class_plus()
	{

		$school_grade = $this->uri->segment(3);
		$section = $this->uri->segment(4);

		if (isset($_POST['check'])) {

			$where['school_year'] = $school_grade;
			$where['section_id'] = $section;

			$studentTable = $this->Main_model->multiple_where('class_section', $where);
			
			foreach ($studentTable->result_array() as $row) {
				$student_account_id = $row['student_profile_id'];
				
				$bagsak_table = $_POST['bagsak']; //listahan ng mga hindi pumasa. 
				
				//kapag hindi pumasa. 

				foreach ($bagsak_table as $row) {

					$bagsak_id = $row;
					
					if ($student_account_id == $bagsak_id) {
						//hindi na siya pumasa (yung status lang yung mag babago magiging 0)
						
						//DELETE the student from the class_section table
						$this->Main_model->_delete('class_section', 'student_profile_id', $bagsak_id);

						//INSERT the students into the "student_section_reassignment" table
						$insert['student_profile_id'] = $bagsak_id;
						$insert['year_level_id'] = $school_grade; //katumbas ng year level id
						$insert['section_id'] = $section;
						$insert['status'] = 0;
						$insert['academic_grade_id'] = 1;

						//insert into the table
						$this->Main_model->_insert('student_section_reassignment', $insert);

					} else {
						//pumasa siya. 
						
						//remove the student from the class_section table
						$this->Main_model->_delete('class_section', 'student_profile_id', $student_account_id);

						//store the students into the "student_section_reassignment" table
						$insert['student_profile_id'] = $student_account_id;
						$insert['year_level_id'] = $school_grade; //katumbas ng year level id
						$insert['section_id'] = $section;
						$insert['status'] = 1; //pasado siya
						$insert['academic_grade_id'] = 1;

						//insert to the table
						$this->Main_model->_insert('student_section_reassignment', $insert);
						
					}
				}
			} //foreach
			redirect("manage_user_accounts/update_grade_class");
		}
	} //update grade class plus

	function all_have_passed()
	{
		$school_grade = $this->uri->segment(3);
		$section = $this->uri->segment(4);

		//get all of the students in the section. 
		$where['school_grade_id'] = $school_grade;
		$where['section_id'] = $section;
		$where['student_status'] = 1; // para yung mga na deactivated at nag transfer na hindi na siya makukuha
		$studentTable = $this->Main_model->multiple_where('student_profile', $where);
		$this->Main_model->array_show($studentTable);
		
		foreach ($studentTable->result() as $row) {
			$studentAccountId = $row->account_id;
			
			//DELETE the student from the class_section table
			$this->Main_model->_delete('class_section', 'student_profile_id', $studentAccountId);

			//INSERT the students into the "student_section_reassignment" table
			$insert['student_profile_id'] = $studentAccountId;
			$insert['year_level_id'] = $school_grade; //katumbas ng year level id
			$insert['section_id'] = $section;
			$insert['status'] = 1; //kasi pasado siya. 
			$insert['academic_grade_id'] = 1;

			//insert into the table
			$this->Main_model->_insert('student_section_reassignment', $insert);
		}

		//notify the principal. 
		$this->session->set_userdata('allHavePassed', 1);
		redirect('manage_user_accounts/update_grade_class');
	}

	function facultyRegistryControl()
	{
		$this->form_validation->set_rules('pas1', 'Password One', 'required');
		$this->form_validation->set_rules('pas2', 'Confirm Password', 'required');
		if ($this->form_validation->run()) {
			$password1 = $this->input->post('pas1');
			$password2 = $this->input->post('pas2');

			if ($password1 == $password2) {
				$data['password'] = $password1;
				$data['status'] = 1;
				$this->Main_model->_update('faculty_secure_register', 'id', 1, $data);
				redirect('manage_user_accounts/manage_account');
			}
		}
		if (isset($_GET['deactivate'])) {
			$data['status'] = 0;
			$this->Main_model->_update('faculty_secure_register', 'id', 1, $data);
			redirect('manage_user_accounts/manage_account');
		} else {
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/registry_password');
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function assignChild()
	{
		$faculty_account_id = $_SESSION['faculty_account_id'];
		$this->load->model('Main_model');

		$data['student_table'] = $this->Main_model->get('student_profile', 'account_id');
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('student/teacherParent', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function enterParentMode()
	{
		$faculty_id = $_SESSION['faculty_account_id'];
		$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $faculty_id);
		
		// if (!isset($_SESSION['student_account_id'])) {
			//hindi niya pa na prepress yung parent button.
			foreach ($faculty_table->result_array() as $row) {
				$parent_id = $row['parent_id'];
			}
			echo "parent id: $parent_id";
			
			$student_table = $this->Main_model->get_where('student_profile', 'parent_id', $parent_id);
			foreach ($student_table->result_array() as $row) {
				$student_account_id = $row['account_id'];
			}
			$studentName = $this->Main_model->getFullNameWithId('student_profile', 'account_id', $student_account_id);
			echo "<br>the name of the student is: $studentName";
			echo "student account id: $student_account_id";
			// die;
			$this->session->set_userdata('student_account_id', $student_account_id);
			$this->session->set_userdata('parent_account_id', $parent_id);
			$this->session->set_userdata('academic_grade_id', 1);
			redirect('parent_student/student_page');
		// }else{
		// 	//na press niya na yung parent button.
		// 	redirect('parent_student/student_page');
		// }
	}

	function assignSecretary()
	{
		$data['faculty_table'] = $this->Main_model->get('faculty', 'account_id');
		$data['credentials'] = $this->Main_model->get_where('credentials', 'administration_id', 4);
		$search1 = $this->Main_model->getId('credentials', 'administration_id', 5, 'account_id');
		$search2 = $this->Main_model->getId('faculty', 'sec_account', 1, 'account_id');

		//determine if secretaryTeacher or secretary only
		if ($search1 != "") {
			$data['secretaryId'] = $search1;
		}elseif ($search2 != "") {
			$data['secretaryId'] = $search2;
		}
		
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/assignNewSecretary', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function updateSecretaryAccount()
	{
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('middlename', 'Middlename', 'required');
		$this->form_validation->set_rules('lastname', 'lastname', 'required');
		$this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'required');
		if ($this->form_validation->run()) {

			$firstname = $this->input->post('firstname');
			$middlename = $this->input->post('middlename');
			$lastname = $this->input->post('lastname');
			$mobileNumber = $this->input->post('mobileNumber');
			$teacherConfirm = $this->input->post('teacherConfirm'); // previous secretary
			$newSecConfirm = $this->input->post('newSecConfirm'); // new secretary
			
			//determine if seecretary teacher
			if (isset($_SESSION['secretaryTeacher'])) { //case 1
				if ($teacherConfirm == true) { 
					//yes, magiging teacher parin siya
					
					//get the previous teacher secretary
					$previousTeacherSecretary = $this->Main_model->getId('faculty', 'sec_account', 1, 'account_id');

					//faculty table update
					$facUpdateOldSec['sec_account'] = 0;
					$this->Main_model->_update('faculty', 'account_id', $previousTeacherSecretary, $facUpdateOldSec);

					//credentials table update
					$credUpdateOldSec['administration_id'] = 1;
					$this->Main_model->_update('credentials', 'account_id', $previousTeacherSecretary, $credUpdateOldSec);

					//create new secretary (insert new record from input), 'will the new sec be a teacher?' if condition
					if ($newSecConfirm == true) {
						//new secretary will be a teacher; yes ; perform new secretary insertion

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 1;
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretaryId = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 1;
						$newSecCred['academic_grade_id'] = 1;//
						$newSecCred['account_id'] = $newSecretaryId;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						$this->session->set_userdata('secretaryTeacherReg', 1); //secretary teacher ang nilagay
						redirect("manage_user_accounts/manage_account");

					}else{
						//new secretary will NOT be a teacher; no ; perform new secretary insertion

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 0; //kasi hindi naman siya magiging teacher
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretaryId = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['account_id'] = $newSecretaryId;
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 5;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");
						
					}


				}else{
					//no, hindi na siya magiging teacher mag reresign na siya sa school. kasi hindi narin naman na siya magiging sec

					//get the previous teacher secretary
					$previousTeacherSecretary = $this->Main_model->getId('faculty', 'sec_account', 1, 'account_id');
					
					//put into the repository and delete.
					
					//put into the repository
					$oldSecInfoData = $this->Main_model->getFullNameSliced('faculty', 'account_id', $previousTeacherSecretary); //with mobile number
					
					$oldSecRepo['faculty_account_id'] = $previousTeacherSecretary;
					$oldSecRepo['firstname'] = $oldSecInfoData['firstname'];
					$oldSecRepo['middlename'] = $oldSecInfoData['middlename'];
					$oldSecRepo['lastname'] = $oldSecInfoData['lastname'];
					$oldSecRepo['mobile_number'] = $oldSecInfoData['mobileNumber'];
					$this->Main_model->_insert('faculty_repository', $oldSecRepo);

					//delete previous secretary ; faculty table & credentials table
					$this->Main_model->_delete('faculty', 'account_id', $previousTeacherSecretary);
					$this->Main_model->_delete('credentials', 'account_id', $previousTeacherSecretary);

					//create new secretary (insert new record from input), 'will the new sec be a teacher?' if condition
					if ($newSecConfirm == true) {
						//new secretary will be a teacher; yes ; perform new secretary insertion

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 1;
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 1; //teacher siya
						$newSecCred['academic_grade_id'] = 1; // jhs teacher muna
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");

					}else{
						//new secretary will NOT be a teacher; no ; perform new secretary insertion

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 0; //kasi hindi naman siya magiging teacher
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 5;
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");
						
					}

				}

			}else{
				//CASE 2; PREVIOUS SECRETARY IS NOT A TEACHER
				if ($teacherConfirm == true) {
					//"Previous sec will become a teahcer"; YES; 
					//get the previous secretary id
					$previousSecretary = $this->Main_model->getId('credentials', 'administration_id', 5, 'account_id');
					
					//update previous secretary account

					//faculty table update
					$facOldSecUpdate['sec_account'] = 0;
					$this->Main_model->_update('faculty', 'account_id', $previousSecretary, $facOldSecUpdate);

					//credentials table update
					$credOldSecUpdate['administration_id'] = 1;
					$credOldSecUpdate['academic_grade_id'] = 1;

					$this->Main_model->_update('credentials', 'account_id', $previousSecretary, $credOldSecUpdate);

					//WILL NEW SECRETARY BE A TEACHER "CONFIGURATION"
					if ($newSecConfirm == true) {
						//new secretary will become a teacher

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 1;
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 1; //teacher siya
						$newSecCred['academic_grade_id'] = 1; // jhs teacher muna
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						$this->session->set_userdata('secretaryTeacherReg', 1);
						redirect("manage_user_accounts/manage_account");

					}else{
						//new secretary WILL NOT be a teacher

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 0; //kasi hindi naman siya magiging teacher
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 5;
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");

					}
					

				}else{

					//"Previous sec will NOT become a teacher"; previous secretary will RESIGN;
					$previousSecretary = $this->Main_model->getId('credentials', 'administration_id', 5, 'account_id');

					//delete the previous secretary since he will not be a teacher nor a secretary anymore
					$this->Main_model->_delete('faculty', 'account_id', $previousSecretary);
					$this->Main_model->_delete('credentials', 'account_id', $previousSecretary);

					//WILL NEW SECRETARY BE A TEACHER "CONFIGURATION"
					if ($newSecConfirm == true) {
						//new secretary will become a teacher

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 1;
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 1; //teacher siya
						$newSecCred['academic_grade_id'] = 1; // jhs teacher muna
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");

					}else{
						//new secretary WILL NOT be a teacher

						//faculty table insertion
						$newSecFaculty['firstname'] = $firstname;
						$newSecFaculty['middlename'] = $middlename;
						$newSecFaculty['lastname'] = $lastname;
						$newSecFaculty['mobile_number'] = $mobileNumber;
						$newSecFaculty['sec_account'] = 0; //kasi hindi naman siya magiging teacher
						$newSecFaculty['status'] = 1;
						$this->Main_model->_insert('faculty', $newSecFaculty);

						$newSecretary = $this->Main_model->findId('faculty', $newSecFaculty, 'account_id');

						//credentials table insertion
						$newSecCred['username'] = $firstname;
						$randPassword = rand(0, 99999);
						$newSecCred['password'] = $this->Main_model->passwordEncryptor($randPassword);
						$newSecCred['administration_id'] = 5;
						$newSecCred['account_id'] = $newSecretary;
						$this->Main_model->_insert('credentials', $newSecCred);

						// notify and redirect
						$this->session->set_userdata('newSecReg', 1);
						redirect("manage_user_accounts/manage_account");

					}
					
				}
			}

		} //form validation end

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/registerNewSecretary');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function assignNewSecretary()
	{
		$teacherId = $this->uri->segment(3); //new teacher id
		$oldSecretaryId = $this->Main_model->GetPreviousSecretaryId();

		$data['teacherName'] = $this->Main_model->getFullNameWithId('faculty', 'account_id', $teacherId);

		if (isset($_POST["submit"])) {
			$tNameSlice = $this->Main_model->getFullNameSliced('faculty', 'account_id', $teacherId);

			$firstname = $tNameSlice['firstname'];
			$middlename = $tNameSlice['middlename'];
			$lastname = $tNameSlice['lastname'];
			$mobileNumber = $tNameSlice['mobileNumber'];
			$teacherConfirm = $this->input->post('teacherConfirm'); // previous secretary
			$newSecConfirm = $this->input->post('newSecConfirm'); // new secretary
			//secretary db management
			$this->Main_model->assignNewSecretary($firstname, $middlename, $lastname, $mobileNumber, $teacherConfirm, $newSecConfirm, $teacherId);
		}

		//handle previous secretary text
		if ($this->Main_model->secretaryTeacherChecker()) {
			$prevSecText = "will still be a teacher";
		}else{
			$prevSecText = "will be a teacher";
		}

		$data['teacherId'] = $teacherId;
		$data['prevSecText'] = $prevSecText;

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/getNewSec', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function registerSecretary()
	{
		$this->form_validation->set_rules('firstname', 'Firstname', 'required');
		$this->form_validation->set_rules('middlename', 'Middlename', 'required');
		$this->form_validation->set_rules('lastname', 'lastname', 'required');
		$this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'required');
		if ($this->form_validation->run()) {
			$firstname = $this->input->post('firstname');
			$middlename = $this->input->post('middlename');
			$lastname = $this->input->post('lastname');
			$fullname = "$firstname $middlename $lastname";

			$randomPassword = rand(0, 99999);

			$credentials['username'] = $this->input->post('firstname');
			$credentials['password'] = $this->Main_model->passwordEncryptor($randomPassword);
			$credentials['administration_id'] = 5;

			$data['firstname'] = ucfirst($this->input->post('firstname'));
			$data['middlename'] = ucfirst($this->input->post('middlename'));
			$data['lastname'] = ucfirst($this->input->post('lastname'));
			$data['status'] = 1;
			$data['parent_id'] = 0;
			$data['mobile_number'] = $this->input->post('mobileNumber');

			$secretaryTable = $this->Main_model->get_where('credentials', 'administration_id', 5);

			if (count($secretaryTable->result_array()) > 0) {
				$this->session->set_userdata('secretaryAvailable', 1);
				redirect('manage_user_accounts/manage_account');
			} else {

				$this->Main_model->_insert('faculty', $data);

				$facutlyTable = $this->Main_model->get('faculty', 'account_id');
				foreach ($facutlyTable->result_array() as $row) {
					$newFacultyId = $row['account_id'];
				}

				$credentials['account_id'] = $newFacultyId;
				$this->Main_model->_insert('credentials', $credentials);
				$message = "Hi $fullname your username is $firstname and your password is: $randomPassword";
				$this->Main_model->itexmo($data['mobile_number'], $message);
				$this->session->set_userdata('secretaryCreated', 1);
				redirect('manage_user_accounts/manage_account');
			}
		} else {

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('manage_accounts/registerSecretary');
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function secretaryView()
	{
		$secId = $_SESSION['faculty_account_id'];
		$data['faculty_id'] = $secId;
		$data['fullname'] = $this->Main_model->getFullname('faculty', 'account_id', $secId);
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/secretaryView', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function secManageAccount()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/secManageAccount');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function facultyBatchRegisterOption()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/facultyBatchRegisterOption');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function viewJuniorHighSchoolFaculty()
	{
		//notification
		$this->Main_model->alertPromt('Reset password success', 'resetAccount');

		//define where conditions
		$where['academic_grade_id'] = 1;
		$where['administration_id'] = 1;

		$jhsFaculty = $this->Main_model->multiple_where('credentials', $where);
		$data['jhsFacultyCredentials'] = $jhsFaculty;
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/viewJuniorHighSchoolFaculty', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function viewSeniorHighSchoolFaculty()
	{
		$shsFaculty = $this->Main_model->get_where('credentials', 'academic_grade_id', 2);
		$data['shsFacultyCredentials'] = $shsFaculty;

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/viewSeniorHighSchoolFaculty', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function seniorHighFacultyBatchRegister()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/seniorHighFacultyBatchRegister');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	//mag pa pili ka muna bago ka pupunta dito
	function facultyRegisterBatch()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/facultyRegisterBatch');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function facultyBatchImport()
	{
		echo "hello world";
	}

	function resetPassword()
	{

		$facultyId = $this->uri->segment(3);

		if (isset($_GET['confirm'])) {

			$facultyId = $this->input->get('confirm');


			//get the information of the teacher
			$teacherTable = $this->Main_model->get_where('faculty', 'account_id', $facultyId);
			foreach ($teacherTable->result() as $row) {
				$teacherFullname = $this->Main_model->getFullname('faculty', 'account_id', $row->account_id);
				$teacherMobileNumber = $this->Main_model->getTheNumber('faculty', 'account_id', $facultyId);
			}

			//generate a random number for password
			$randomPassword = rand(11111, 99999);
			$encryptedPassword = $this->Main_model->passwordEncryptor($randomPassword);

			//update the password in the database
			$data['password'] = $encryptedPassword;
			$this->Main_model->_update('credentials', 'account_id', $facultyId, $data);

			//text the teacher 
			$message = "$teacherFullname, Your password has been changed into: $randomPassword";
			$this->Main_model->itexmo($teacherMobileNumber, $message);


			$this->session->set_userdata('resetAccount', 1);
			redirect('manage_user_accounts/viewJuniorHighSchoolFaculty');
		} 
			$facultyId = $facultyId;
			$data['facultyId'] = $facultyId;
			$data['teacherName'] = $this->Main_model->getFullname('faculty', 'account_id', $facultyId);
			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('manage_accounts/confirmChangePassword', $data);
			$this->load->view('includes/main_page/admin_cms/footer');

	}

	function manageAcademicYear()
	{
		$this->form_validation->set_rules('academicYear', 'Academic year', 'required');
		if ($this->form_validation->run()) {

			//collect post data
			$academicYear = $this->input->post('academicYear');

			//remove white spaces
			$academicYear = str_replace(' ', '', $academicYear);

			//update the time table
			$data['time'] = $academicYear;
			$this->Main_model->_update('time', 'id', 2, $data);

			//redirect and notify
			$this->session->set_userdata('aySuc', 1);
			redirect('manage_user_accounts/dashboard');
		}
		$data['academicYear'] = $this->Main_model->getAcademicYear();
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/manageAcademicYear', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function chooseYearLevelAdviserManager()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/chooseYearLevelAdviserManager');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function manageSectionAdvisers() // just for the junior highchool
	{
		$academicLevel = $this->uri->segment(3);
		$data['academicLevel'] = $academicLevel;
		
		$data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', $academicLevel);
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/manageSectionAdvisers', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function manageSectionAdvisersTwo()
	{
		$yearLevelId = $this->input->get('yearLevelId');
		$yearLevelName = $this->Main_model->getSchoolNameWithId($yearLevelId);

		$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
		$academicLevel = $this->uri->segment(3);

		//kinukuha niya sa adviser section. 

		//send data
		$data['yearLevelId'] = $yearLevelId;
		$data['yearLevelName'] = $yearLevelName;
		$data['sectionTable'] = $sectionTable;

		//check if a section is pressent.
		if (count($sectionTable->result_array()) == 0) {
			redirect("manage_user_accounts/noSectionsForGradeLevel/$academicLevel?yearLevelId=$yearLevelId");
		}

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/manageSectionAdvisersTwo', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function noSectionsForGradeLevel()
	{
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view("manage_accounts/noSectionsForGradeLevel");
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function shsSectionAdviserYearLevel()
	{
		$data['yearLevelTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 2); //para grade 11 & 12 lang

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view("shs/shsSectionAdviserYearLevel", $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function shsSectionAdviserStrand()
	{
		$yearLevel = $this->input->get('yearLevel');

		//get track table
		$data['strandTable'] = $this->Main_model->get_where('strand', 'status', 1); // kukunin niya lang yung mga activated
		$data['yearLevel'] = $yearLevel;

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view("shs/shsSectionAdviserTrack", $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function shsSectionAdviserSection()
	{
		$yearLevel = $this->input->get('yearLevel');
		$strandId = $this->input->get('strandId');

		$where['year_level_id'] = $yearLevel;
		$where['strand_id'] = $strandId;
		$data['shSectionTable'] = $this->Main_model->multiple_where('sh_section', $where);

		$data['yearLevel'] = $yearLevel;
		$data['trackId'] = $trackId;

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view("shs/shsSectionAdviserSection", $data);
		$this->load->view('includes/main_page/admin_cms/footer');
		
	}

	function ShsAssignAdviser() 
	{
		$yearLevelId = $this->input->get('yearLevel');
		$strandId = $this->input->get('strandId');
		
		//get shs sections
		$conditions['year_level_id'] = $yearLevelId;
		$conditions['strand_id'] = $strandId;
		$data['shsSections'] = $this->Main_model->multiple_where('sh_section', $conditions);

		//TRAP: if there are no sections notify the user
		if (count($data['shsSections']->result_array()) == 0) {
			$this->session->set_userdata('noSections', 1);
			redirect("manage_user_accounts/shsSectionAdviserStrand?yearLevel=$yearLevelId");
		}

		//get the names
		$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
		$data['strandName'] = $this->Main_model->getStrandName($strandId);
		
		$data['yearLevelId'] = $yearLevelId;
		$data['strandId'] = $strandId;

		$multipleWhere['administration_id'] = 1;
		$multipleWhere['academic_grade_id'] = 2; //para shs lang
		$data['facultyTable'] = $this->Main_model->multiple_where('credentials', $multipleWhere);

		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('shs/ShsAssignAdviser', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		//perform assignment of adviser
		if (isset($_POST['submit'])) {
			$adviserId = $this->input->post('teacherId'); //selected teacher
			$yearLevel = $this->input->get('yearLevel');
			$sectionId = $this->input->get('sectionId'); 
			$strandId = $this->input->get('strandId');

			$insert['faculty_id'] = $adviserId;
			$insert['year_level'] = $yearLevel;
			$insert['strand_id'] = $strandId; 
			$insert['section_id'] = $sectionId;
			
			
			//parameter if the teacher is already an adviser
			//check if there are already present adviser tapos mag uupdate nalang siya 
			$adviserTable = $this->Main_model->multiple_where('sh_adviser', 'faculty_id', $adviserId);
			
			$adviserTableCount = count($adviserTable->result_array());
			
			if ($adviserTableCount == 0) {
				//wala pang na crecreate
				$this->Main_model->_delete('sh_adviser', 'faculty_id', $adviserId);
				$this->Main_model->_insert('sh_adviser', $insert);

			} else {
				//meron ng na create
				foreach ($adviserTable->result() as $row) {
					$adviserDbId = $row->adviser_id; //primary key
					$sectionDbId = $row->section_id;
				}

				$update['faculty_account_id'] = $adviserId;
				$update['section_id'] = $sectionId;

			//delete the section where the adviser is currently there.
			echo "adviserDbId = $adviserDbId <br> sectionId: $sectionId";

				$deleteMultiWhere['adviser_id'] = $adviserDbId;
				$deleteMultiWhere['academic_grade_id'] = 1;  
				$this->Main_model->multiple_delete('sh_adviser', $deleteMultiWhere);

				//kapag yung section na yun wala namang nakalagay para i update yung faculty id dapat gagawa nalng siya ng bago
				
				$sectionTable = $this->Main_model->get_where('sh_adviser', 'section_id', $sectionId);

				//check kung meron nabang naka assign sa section na yun o wala pa 
				if (count($sectionTable->result_array()) == 0) {
					//walang naka assign na teacher para sa section na yun
					$this->Main_model->_insert('sh_adviser', $insert);//gagamitin mo nalang yung dating assoc array
				}else{
					//meron kanang nakahanp na adviser na naka assign sa section na yun
					$this->Main_model->_update('sh_adviser', 'section_id', $sectionId, $update); //kung sinong pinili mo na ilagay sa section na yun 
				}

			}


			$this->session->set_userdata('adviserAssign', $adviserId);
			redirect("manage_user_accounts/ShsAssignAdviser?yearLevel=$yearLevel&strandId=$strandId");
		}
	}

	function chooseShsAdviser() //for shs
	{
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');
		$strandId = $this->input->get('strandId');

		//get the names
		$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getShsSectionNameFromId($sectionId);

		$data['yearLevelId'] = $yearLevelId;
		$data['strandId'] = $strandId;
		$data['sectionId'] = $sectionId;

		$multipleWhere['administration_id'] = 1;
		$multipleWhere['academic_grade_id'] = 2; //para juniorHigh lang
		$data['facultyTable'] = $this->Main_model->multiple_where('credentials', $multipleWhere);


		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/chooseShsAdviser', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}


	function assignAdviser() 
	{
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');
		$academicLevel = $this->input->get('academicLevel');

		//if academic level is for shs redirect it with the get values
		if ($academicLevel == 2) {
			redirect("manage_user_accounts/ShsAssignAdviser?yearLevelId=22&sectionId=77&academicLevel=2");	
		}

		//get the names
		$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
		$data['yearLevelId'] = $yearLevelId;

		$multipleWhere['administration_id'] = 1;
		$multipleWhere['academic_grade_id'] = 1; //para juniorHigh lang
		$data['facultyTable'] = $this->Main_model->multiple_where('credentials', $multipleWhere);


		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('manage_accounts/assignAdviser', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		//perform assignment of adviser
		if (isset($_POST['submit'])) {
			$adviserId = $this->input->post('teacherId');
			$sectionId = $this->input->get('sectionId');
			$academicLevel = $this->input->get('academicLevel');
			
			$insert['section_id'] = $sectionId;
			$insert['faculty_account_id'] = $adviserId;
			$insert['academic_grade_id'] = 1; 

			//parameter if the teacher is already an adviser
			 
			//WHERE CONDITIONS
			 $where['faculty_account_id'] = $adviserId; 
			 $where['academic_grade_id'] = 1;

			//check if there are already present adviser tapos mag uupdate nalang siya 
			$adviserTable = $this->Main_model->multiple_where('adviser_section', $where);

			$this->Main_model->array_show($adviserTable);
			
			$adviserTableCount = count($adviserTable->result_array());

			if ($adviserTableCount == 0) {
				//wala pang na crecreate
				echo "con 1";
				$this->Main_model->_delete('adviser_section', 'section_id', $sectionId);
				$this->Main_model->_insert('adviser_section', $insert);
			} else {
				//meron ng na create
				echo "con 2";
				foreach ($adviserTable->result() as $row) {
					$adviserDbId = $row->adviser_id; //primary key
					$sectionDbId = $row->section_id;
				}

				$update['faculty_account_id'] = $adviserId;
				$update['section_id'] = $sectionId;

			//delete the section where the adviser is currently there.
			echo "adviserDbId = $adviserDbId <br> sectionId: $sectionId";

				$deleteMultiWhere['adviser_id'] = $adviserDbId;
				$deleteMultiWhere['academic_grade_id'] = 1;  
				$this->Main_model->multiple_delete('adviser_section', $deleteMultiWhere);

				//kapag yung section na yun wala namang nakalagay para i update yung faculty id dapat gagawa nalng siya ng bago
				
				$sectionTable = $this->Main_model->get_where('adviser_section', 'section_id', $sectionId);

				//check kung meron nabang naka assign sa section na yun o wala pa 
				if (count($sectionTable->result_array()) == 0) {
					//walang naka assign na teacher para sa section na yun
					$this->Main_model->_insert('adviser_section', $insert);//gagamitin mo nalang yung dating assoc array
				}else{
					//meron kanang nakahanp na adviser na naka assign sa section na yun
					$this->Main_model->_update('adviser_section', 'section_id', $sectionId, $update); //kung sinong pinili mo na ilagay sa section na yun 
				}

			}

			
			$this->session->set_userdata('adviserAssign', $adviserId);
			redirect("manage_user_accounts/manageSectionAdvisersTwo?yearLevelId=$yearLevelId&academicLevel=$academicLevel");
		}
	}

	function teacherRegisterAsParent()
	{
		$trigger = $this->uri->segment(3);
		if ($trigger != null) {
			//kapag registered as parent na siya dapat wala na yung button. 
			//tapos meron na yung button na 

			//PREPARE FOR PARENT TABLE INSERTION
			$teacherName = $this->Main_model->getFullNameSliced('faculty', 'account_id', $_SESSION['faculty_account_id']);

			$insert['firstname'] = $teacherName['firstname'];
			$insert['middlename'] = $teacherName['middlename'];
			$insert['lastname'] = $teacherName['lastname'];
			$insert['mobile_number'] = $teacherName['mobileNumber'];
			$insert['status'] = 1;

			$this->Main_model->_insert('parent', $insert);

			//find the inserted id. 
			$parentId = $this->Main_model->findId('parent', $insert, 'account_id');
			
			//update the faculty parent_id
			$update['parent_id'] = $parentId;
			$this->Main_model->_update('faculty', 'account_id', $_SESSION['faculty_account_id'], $update);

			//redirect
			$this->session->set_userdata('registeredAsParent', 1);
			
			//manipulate redirection for different types of users
			if ($_SESSION['credentials_id'] == 5) {
                //secretary siya
                $redirect = base_url() . "manage_user_accounts/secretaryView";
            }elseif($_SESSION['credentials_id'] == 4){
                //principal siya
                $redirect = base_url() . "manage_user_accounts/dashboard";
            }else{
                //teacher siya
                $redirect = base_url() . "manage_user_accounts/dashboard";
            }

			redirect($redirect);
		}

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/teacherRegisterAsParent');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function failedStudents()
	{	
		$yearLevelId = $this->Main_model->getAdviserSchoolGradeId();
		$sectionId = $this->Main_model->getAdviserSectionJhs();

		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
		
		//get the failed students
		
		//define where conditions for the failed students
		$where['year_level_id'] = $yearLevelId;
		$where['section_id'] = $sectionId;
		$failedStudents = $this->Main_model->multiple_where('student_section_reassignment', $where);
		
		//send the table
		$data['failedStudents'] = $failedStudents;
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/failedStudents', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function transferStudents()
	{
		$studentId = $this->uri->segment(3);
		
		//ACCOUNT DEACTIVATION
		$update['student_status'] = 0;
		$this->Main_model->_update('student_profile', 'account_id', $studentId, $update);

		//TRANSFEREE TABLE INSERTION
		$insert['student_profile_id'] = $studentId;
		$insert['transfer_date'] = date("Y/m/d");
		$this->Main_model->_insert('transferee', $insert);

		//row DELETION
		$this->Main_model->_delete('student_section_reassignment', 'student_profile_id', $studentId);

		//notify and redirect
		$this->session->set_userdata('transferee', 1);
		redirect("manage_user_accounts/failedStudents");
	}

	function viewTransferees()
	{
		//get all transferees that are junior highschool
		$transfereeTable = $this->Main_model->get_where('transferee', 'academic_grade_id', 1);
		
		$data['transfereeTable'] = $transfereeTable;	
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/viewTransferees', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}
	
	function transfereeGrades()
	{
		$studentId = $this->uri->segment(3);
		
		$studentName = $this->Main_model->getFullname('student_profile', 'account_id', $studentId);

		//ayusin yung pangalan para mahanap sa student grades table
		$studentNameSliced = $this->Main_model->getFullNameSliced('student_profile', 'account_id', $studentId);
		$firstname = $studentNameSliced['firstname'];
		$middlename = $studentNameSliced['middlename'];
		$lastname = $studentNameSliced['lastname'];

		$fixedStudentName = "$lastname,$firstname$middlename";
		
		//find the name in the database
		$student_grades_table = $this->Main_model->get_where('student_grades', 'student_name', $fixedStudentName);
		
		$data['studentFullName'] = $studentName;
		$data['student_grades_table'] = $student_grades_table;
		
		//configure the school year selection for the filter
		$schoolYear = array();
			
		foreach ($data['student_grades_table']->result() as $row) {
			$sy = $row->school_year;
			if (in_array($sy, $schoolYear) == false) {
				//ilalagay mo na sa school year yun sy na wala pa doon 
				array_push($schoolYear, $sy);
			}
		}
		
		//send the non-duplicate school year
		$data['schoolYear'] = $schoolYear;

		$data['studentId'] = $studentId;
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/transfereeGrades', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function studentAquisitionRealTime()
	{
		if (isset($_POST['sectionId'])) {
		
			
			$sectionId = $this->input->post("sectionId");
			$yearLevelId = $this->input->post("yearLevelId");
			
			$where['section_id'] = $sectionId;
			$where['year_level_id'] = $yearLevelId;
			$ssrTable = $this->Main_model->multiple_where("student_section_reassignment", $where);

			if (count($ssrTable->result_array()) != 0) {
				// meron siyang nahanap

				foreach ($ssrTable->result() as $row) {
					echo "<tr>";
					echo "    <td>" . $this->Main_model->getFullNameWithId('student_profile', 'account_id', $row->student_profile_id) ."</td>";
					echo "    <td>";
					echo "        <input type='checkbox' name='aquiredStudents[]' value='" .$row->student_profile_id . "'>";
					echo "    </td>";
					echo "</tr>";
				}
			}else{
				//wala siyang nahanap
				echo "No data found";
			}

			
		}
	}

	function aquireStudents()
	{
		//get year level of the adviser
		$adviserYearLevel = $this->Main_model->getYearLevelOfAdviser();
		$aquisitionYearLevel = $adviserYearLevel - 1;

		//get the section and yearLevelId advisee
		$sectionId = $this->Main_model->getAdviserSectionJhs();
		$yearLevelId = $adviserYearLevel;
		
		//get all of the students that are in the ssr table that has a year level same as the $aquisitionYearLevel
		$ssrTable = $this->Main_model->get_where('student_section_reassignment', 'year_level_id', $aquisitionYearLevel);
		
		//send the data
		$data['ssrTable'] = $ssrTable;

		//provide sections for drop down
		$sectionArray = array();
		foreach ($ssrTable->result() as $row) {
			if (in_array($row->section_id, $sectionArray) == false) {
				array_push($sectionArray, $row->section_id);
			}
		}

		//send data
		$data['sectionArray'] = $sectionArray;
		$data['yearLevelId'] = $yearLevelId - 1;

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('manage_accounts/aquireStudents', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		if (isset($_POST['submit'])) {
			
			$aquiredStudents = $this->input->post("aquiredStudents");

			//TRAPPINGS: kapag walang student na chineck throw error
			$this->Main_model->noCheckedStudents($aquiredStudents, 'manage_user_accounts/aquireStudents');
			
			//INSERTION: CLASS_SECTION
			foreach ($aquiredStudents as $row) {
				
				$insert['student_profile_id'] = $row;
				$insert['section_id'] = $sectionId;
				$insert['school_year'] = $yearLevelId;

				$this->Main_model->_insert('class_section', $insert);

				//UPDATE the student_profile
				$update['school_grade_id'] = $yearLevelId;
				$update['section_id'] = $sectionId;
				$this->Main_model->_update('student_profile', 'account_id', $row, $update);

				//DELETE: their records at the ssr table
				$this->Main_model->_delete("student_section_reassignment", 'student_profile_id', $row);
			}

			$this->session->set_userdata('aquiredStudents', 1);
			redirect("manage_user_accounts/dashboard");	
		}
	}
}//end of the class
