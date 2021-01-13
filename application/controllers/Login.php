<?php 

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("Main_model");
	}

	function changePasswords()
	{
		$table = $this->Main_model->get('credentials', 'account_id');
		foreach ($table->result() as $row) {
			$data['password'] = $this->Main_model->passwordEncryptor('potpot');
			$this->Main_model->_update('credentials', 'account_id', $row->account_id, $data);
		}

		$this->session->set_userdata('password', 1);
		$this->Main_model->alertPromt('Passwords have been changed to potpot', 'password');

		redirect("login");
	}

    public function index()
	{	
    
		
		$this->Main_model->alertPromt("Principal and secretary registered successfully", 'principalCreated');

         if (isset($_SESSION['notLogin'])) {
             unset($_SESSION['notLogin']);
         }

		 $this->session->set_userdata('loginActive',1);
		 $this->Main_model->setCurrentDate();
  		 $this->Main_model->checkDayHasPassed();
		 $this->Main_model->setCurrentYear();
		 
 		$this->form_validation->set_rules('username', 'Username', 'required');
 		$this->form_validation->set_rules('password', 'Password', 'required');

 		if ($this->form_validation->run()) {
 			$data['username'] = $this->input->post('username');
			 $data['password'] = $this->Main_model->passwordEncryptor($this->input->post('password'));
			 
 				// kukunin mo yung buong table ng credentials where
 				// username is equal to the db and also with the 
 				// password

 			$user_validation_result = $this->Main_model->get_where_user_pass('credentials', $data);
			
			
			 $userValidationCount = count($user_validation_result->result_array());
 			if ($userValidationCount > 0) {
 				

 				foreach ($user_validation_result->result_array() as $row) {
 					$credentials_id = $row['credentials_id'];
 					$username = $row['username'];
 					$password = $row['password'];
 					$administration_id = $row['administration_id'];
 					$account_id = $row['account_id'];
				 }
				 

 				
 				

 				if ($administration_id == 1) {
 					
 					$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $account_id);

 					foreach ($faculty_table->result_array() as $row) {
 						$faculty_account_id = $row['account_id'];
 						$firstname = $row['firstname'];
 						$middlename = $row['middlename'];
 						$lastname = $row['lastname'];
                        $status = $row['status'];
 					}
 					
 					$status_active['faculty_account_id'] = $faculty_account_id;
 					$status_active['firstname'] = $firstname;
 					$status_active['middlename'] = $middlename;
 					$status_active['lastname'] = $lastname;
 					$status_active['stats'] = TRUE;
					$status_active['credentials_id'] = 1;
					
					
                    if ($status == 0) {
						$this->Main_model->setCurrentDate();
                        $this->session->set_userdata('account_deactivated',1);
                        redirect('login');
                    }else{
						$this->Main_model->setCurrentDate();
						$this->session->set_userdata($status_active);
						//determine if the teacher is shs teacher or not. 

						if ($this->Main_model->shsTeacherOrNot()) {
							//if this is true shs she is a shs teacher
							redirect("shs/shsTeacher");
						}else{
							redirect('manage_user_accounts/dashboard');
						}
                    }

 					
 					

 				}elseif ($administration_id == 2) {
 					$student_table = $this->Main_model->get_where('student_profile', 'account_id', $account_id);

 					foreach ($student_table->result_array() as $row) {
 						$student_account_id = $row['account_id'];
 						$firstname = $row['firstname'];
 						$middlename = $row['middlename'];
 						$lastname = $row['lastname'];
                        $student_status = $row['student_status'];
 					}
					
 					$status_active['student_account_id'] = $student_account_id;
 					$status_active['firstname'] = $firstname;
 					$status_active['middlename'] = $middlename;
 					$status_active['lastname'] = $lastname;
 					$status_active['stats'] = TRUE;
                    $status_active['credentials_id'] = 2;
 						
					echo "student_status: $student_status";
					
                    if ($student_status == 0) {
						$this->Main_model->setCurrentDate();
                        $this->session->set_userdata('account_deactivated','Sorry your account has been deactivated');
                        redirect('login');
                    }else{
						$this->Main_model->setCurrentDate();
                        $this->session->set_userdata($status_active);
                        redirect('parent_student/student_page');

                    } 


 					

 				}elseif ($administration_id == 3) {
 					
 					$parent_table = $this->Main_model->get_where('parent', 'account_id', $account_id);

 					foreach ($parent_table->result_array() as $row) {
 						$parent_account_id = $row['account_id'];
 						$firstname = $row['firstname'];
 						$middlename = $row['middlename'];
 						$lastname = $row['lastname'];
                        $parent_status = $row['status'];
 					}
					
 					$status_active['parent_account_id'] = $parent_account_id;
 					$status_active['firstname'] = $firstname;
 					$status_active['middlename'] = $middlename;
 					$status_active['lastname'] = $lastname;
 					$status_active['stats'] = TRUE;
                    $status_active['credentials_id'] = 3;
 						// mas maganda yung ganito. kailangan true or false siya para sa mga hacker. 
                     if ($parent_status == 0) {
						$this->Main_model->setCurrentDate();
                        $this->session->set_userdata('account_deactivated','Sorry your account has been deactivated');
                        redirect('login');
                    }else{
						$this->Main_model->setCurrentDate();
                        $this->session->set_userdata($status_active);
                        redirect('parent_student/parent_page');

                    } 


 					

 				}elseif ($administration_id == 4) {
 					$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $account_id);

 					foreach ($faculty_table->result_array() as $row) {
 						$faculty_id = $row['account_id'];
 						$firstname = $row['firstname'];
 						$middlename = $row['middlename'];
 						$lastname = $row['lastname'];
 					}
					
 					$status_active['faculty_account_id'] = $faculty_id;
 					$status_active['firstname'] = $firstname;
 					$status_active['middlename'] = $middlename;
 					$status_active['lastname'] = $lastname;
 					$status_active['stats'] = TRUE;
 					$status_active['credentials_id'] = 4;
 						 

					 $this->Main_model->setCurrentDate();
 					$this->session->set_userdata($status_active);

						// echo "putang ina pumasok ka sa number 4";
 					redirect('manage_user_accounts/dashboard');

 				}elseif ($administration_id == 5) {
                    $faculty_table = $this->Main_model->get_where('faculty', 'account_id', $account_id);

                    foreach ($faculty_table->result_array() as $row) {
                        $faculty_id = $row['account_id'];
                        $firstname = $row['firstname'];
                        $middlename = $row['middlename'];
						$lastname = $row['lastname'];
						$status = $row['status'];
					}
					if ($status == 0) {
						$this->session->set_userdata('account_deactivated',1);
						redirect("login");
					}
                    
                    $status_active['faculty_account_id'] = $faculty_id;
                    $status_active['firstname'] = $firstname;
                    $status_active['middlename'] = $middlename;
                    $status_active['lastname'] = $lastname;
                    $status_active['stats'] = TRUE;
                    $status_active['credentials_id'] = 5;
                        // mas maganda yung ganito. kailangan true or false siya para sa mga hacker. 

					$this->Main_model->setCurrentDate();
                    $this->session->set_userdata($status_active);


                    redirect('manage_user_accounts/secretaryView');

                }


 				



 				
 			}else{
                $this->session->set_userdata('pass_wrong',1);
                redirect('login');
            }
 			
 		}


 		// pasok ka dito
	 		
	 		$this->load->view('login');
	 		


	 		$logout_control = $this->input->get('logout');

	 		if ($logout_control == 1) {
				 
				//delete temporary files. fetch data
				$teacherId = $_SESSION['faculty_account_id'];
				$tempTable = $this->Main_model->get_where('temp_upload_manager', 'faculty_account_id', $teacherId);
				foreach ($tempTable->result() as $row) {
					unlink("temp_upload/" . $row->file_name);
				}
				$this->Main_model->_delete('temp_upload_manager', 'faculty_account_id', $teacherId);
	 			$this->session->sess_destroy();
	 			redirect('login');
	 		}

	 		if (isset($_SESSION['faculty_account_id'])) {
				if ($_SESSION['credentials_id'] == 5) {
					redirect('manage_user_accounts/secretaryView');
				}elseif ($_SESSION['credentials_id'] == 1) {
					//determine if the teacher is shs or jhs
					if ($this->Main_model->shsTeacherOrNot()) {
						//if true he she is a shs teacher
						redirect("shs/shsTeacher");
					}else{
						// he is jhs teacher
						redirect('manage_user_accounts/dashboard');
					}
				}elseif ($_SESSION['credentials_id'] == 4) {
					redirect('manage_user_accounts/dashboard');
				}
	 		}elseif (isset($_SESSION['student_account_id'])) {
	 			redirect('parent_student/student_page');
	 		}
	 }//end of login function
	 
	 function brandNewStart()
	 {
		$this->form_validation->set_rules('firstname','First name','required');
		$this->form_validation->set_rules('middlename','Middle name','required');
		$this->form_validation->set_rules('lastname','Last name','required');
		$this->form_validation->set_rules('mobileNumber','Mobile number','required');
		if ($this->form_validation->run()) {
			$data['firstname'] = ucfirst($this->input->post('firstname'));
			$data['middlename'] = ucfirst($this->input->post('middlename'));
			$data['lastname'] = ucfirst($this->input->post('lastname'));
			$data['mobile_number'] = $this->input->post('mobileNumber');
			$data['status'] = 1;


			//prepare for session storage
			$this->session->set_userdata('principalInfo', $data);
			redirect('login/registerSecretary');
		}
		$this->load->view('brandNewStart');
	 }

	 function registerSecretary()
	 {
		$this->form_validation->set_rules('firstname','First name','required');
		$this->form_validation->set_rules('middlename','Middle name','required');
		$this->form_validation->set_rules('lastname','Last name','required');
		$this->form_validation->set_rules('mobileNumber','Mobile number','required');
		if ($this->form_validation->run()) {
			$insert['firstname'] = ucfirst($this->input->post('firstname'));
			$insert['middlename'] = ucfirst($this->input->post('middlename'));
			$insert['lastname'] = ucfirst($this->input->post('lastname'));
			$insert['mobile_number'] = $this->input->post('mobileNumber');
			$insert['status'] = 1;
			
			//if secretary will be a teacher or not.
			$teacherConfirm = $this->input->post('confirmTeacher');
			if ($teacherConfirm) {
				$insert['sec_account'] = 1;
				$this->Main_model->secTeacherPrincipalRegister($insert);
			}else{
				//prepare for insertion faculty.sec_account == 1
				$this->Main_model->registerPrincipalAndSecretary($insert);
			}
		}
		$this->load->view('registerSecretary');
	 }
} // end of class
