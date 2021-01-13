<?php 
class Attendance_monitoring extends CI_Controller
{
		
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('main_model');
		$this->Main_model->accessGranted();
	}

	function index()
	{
		$permission = $this->Main_model->access_granted();

        if ($permission == 1) {
			$where['attendance_status'] = 0;
			$where['faculty_account_id'] = $_SESSION['faculty_account_id'];
			$where['academic_year'] = $this->Main_model->getAcademicYear();
			$data['teacher_load_table'] = $this->Main_model->multiple_where('teacher_load', $where);
			
			//para kahit na nag record na siya kahit hindi attendance status
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $_SESSION['faculty_account_id']);

			//TRAPPINGS: kapag wala pa siyang naggawa na teacher load hindi muna ito lalabas. 
			if (count($teacherLoadTable->result_array()) == 0) {

				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('attendance_monitoring/noTeacherLoad');
				$this->load->view('includes/main_page/admin_cms/footer');

			}else{

				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('attendance_monitoring/attendance_monitoring', $data);
				$this->load->view('includes/main_page/admin_cms/footer');
			}
		}else{
            redirect('main_controller/login');
        }
		
	}


	function class_selection()
	{
		
		

		if (isset($_GET['record'])) {
			$grade = $this->input->get('grade');
			$section = $this->input->get('section');
			$subject = $this->input->get('subject');
			$faculty_id = $_SESSION['faculty_account_id'];

			$array_data['grade'] = $grade;
			$array_data['section'] = $section;
			$array_data['subject'] = $subject;

			$this->session->set_userdata($array_data);
			
			//para sa school_grade table ito
			$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);

			$data['class'] = $this->Main_model->multiple_where('class', $array);
			$grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade);

			foreach ($grade_table->result_array() as $row) {
				$school_grade_name = $row['name'];
			}

			$section_table = $this->Main_model->get_where('section','section_id', $section);

			foreach ($section_table->result_array() as $row) {
				$section_name = $row['section_name'];
			}

			$subject_table = $this->Main_model->get_where('subject','subject_id', $subject);

			foreach ($subject_table->result_array() as $row) {
				$subject_name = $row['subject_name'];
			}


			$data['grade'] = $school_grade_name;
			$data['section'] = $section_name;
			$data['subject'] = $subject_name;

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/class_selection',$data);
			$this->load->view('includes/main_page/admin_cms/footer');

	
		
			}else{
				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('attendance_monitoring/mustCreateClassFirst');
				$this->load->view('includes/main_page/admin_cms/footer');
			}

			if ($class_id = $this->uri->segment(3)) {
				
				$class_id = $this->uri->segment(3);

				$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);

				$student_table = $this->Main_model->multiple_where('class', $array);
				$search_student_query = $this->Main_model->get_where('class','class_id', $class_id);
			 	

			}else{

				$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);
			
				$data['class'] = $this->Main_model->multiple_where('class', $array);

				$class_table = $this->Main_model->multiple_where('class', $array);

			}

			//if class has no absent students
		if (isset($_GET['all_present']) == 1) {
				
			//get data needed for the teacher load
			$facultyAccountId = $_SESSION['faculty_account_id'];
			$subjectId = $this->input->get('subjectId');
			$gradeLevel = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			foreach ($class_table->result_array() as $row) {
				$class_id = $row['class_id'];
				$subject_id = $row['subject_id'];
				$faculty_id = $row['faculty_id'];
				$class_sched = $row['class_sched'];
				$student_profile_id = $row['student_profile_id'];
				$section_id = $row['section_id'];
				$school_grade_id = $row['school_grade_id'];

				date_default_timezone_set("Asia/Manila");
				$insert['class_id'] = $class_id;
				$insert['date'] = date("Y/m/d");
				$insert['attendance_status'] = 1;
				$insert['school_grade_id'] = $school_grade_id;
				$insert['academic_year'] = $this->Main_model->getAcademicYear();

				$this->Main_model->_insert('attendance', $insert);
				
			}

			//update the teacher load table
			$whereUpdate['faculty_account_id'] = $facultyAccountId;
			$whereUpdate['subject_id'] = $subjectId;
			$whereUpdate['grade_level'] = $gradeLevel;
			$whereUpdate['section_id'] = $sectionId;

			$updateDis['attendance_status'] = 1;
			
			//get the teacher load table
			$this->Main_model->_multi_update('teacher_load', $whereUpdate, $updateDis);

			redirect('attendance_monitoring/all_present');

		}
    }
		
	function all_present()
	{
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('student/all_present');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function sendMessageTest()
	{
		$number = '09657943410';
		$this->Main_model->itexmo($number,'sendMessageTest');
		echo "message sent completed";
	}

	function mark_absent()
	{
		$this->load->model('Main_model');
		if (isset($_POST['submit'])) {
			$absent_table = $_POST['absent_students']; //nakuha sa class

			$absentTableCount = count($absent_table);
			
			// texter
			foreach ($absent_table as $row) {
				$classId = $row;
				$message = $this->Main_model->getStudIdAndMessage($classId);
				$parentNumber = $this->Main_model->getParentNumber($classId);
				$this->Main_model->itexmo($parentNumber,$message);
			}
			
			$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);
			
				$class = $this->Main_model->multiple_where('class', $array);


			foreach ($class->result_array() as $row) {
				$all_class_id =$row['class_id'];
				$all_school_grade_id =$row['school_grade_id'];

				
			
				$hanap = in_array($all_class_id, $absent_table);
				// echo "ang lumabas sa hanap ay: $hanap <br>";

				if ($hanap > 0) {
					//get the academic year
					$academicYear = $this->Main_model->getAcademicYear();

					$data['class_id'] = $all_class_id;
					$data['date'] = date('Y-m-d');
					$data['attendance_status'] = 0;
					$data['school_grade_id'] = $all_school_grade_id;
					$data['academic_year'] = $academicYear;

					$excuse_send['date_of_absent'] = $data['date'];
					$excuse_send['class_id'] = $all_class_id;
					$excuse_send['excuse'] = 0;
					$excuse_send['status'] = 0;

					$parentNotif['subject_id'] = $_SESSION['subject'];
					$classTable = $this->Main_model->get_where('class','class_id', $all_class_id);
					$this->Main_model->array_show($classTable);
					foreach ($classTable->result_array() as $row) {
						$studentId = $row['student_profile_id'];
					}
					// echo "<br> studentId: $studentId <br>";
					$parentNotif['student_id'] = $studentId;
					$parentNotif['status'] = 0;

					$this->Main_model->_insert('parent_attendance', $parentNotif);

					$this->Main_model->_insert('excuse_attendance', $excuse_send);
					$this->Main_model->_insert('attendance', $data);

					//update mo yung teacher load para malaman mo na
					//isang beses lang siya pwedeng mag record
					$this->Main_model->updateTeacherLoadAttendanceStatus($all_class_id);



					
				}else{

					//update mo yung teacher load para malaman mo na
					//isang beses lang siya pwedeng mag record
					$this->Main_model->updateTeacherLoadAttendanceStatus($all_class_id);

					//get the academic year
					$academicYear = $this->Main_model->getAcademicYear();
					
					$data['academic_year'] = $academicYear;
					$data['class_id'] = $all_class_id;
					$data['date'] = date('Y-m-d');
					$data['attendance_status'] = 1;
					$data['school_grade_id'] = $all_school_grade_id;
					$this->Main_model->_insert('attendance', $data);
				
				}

			}
			
			 

			 $this->session->unset_userdata($_SESSION['grade']);
			 $this->session->unset_userdata($_SESSION['section']);
			 $this->session->unset_userdata($_SESSION['subject']);

			
			
			 redirect('attendance_monitoring/record_success/' . $absentTableCount);
			
		}else{
			
				redirect('attendance_monitoring/class_selection');
			}
		}

		


		function record_success()
		{
			$data['absentCount'] = $this->uri->segment(3);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/record_success',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}

		function perform_excuse()
		{
			

			$class_id = $this->uri->segment(3);
			
			//only select the unexcused
			$array['class_id'] = $class_id;
			$array['status'] = 0;
			$excuse_table = $this->Main_model->multiple_where('excuse_attendance', $array);
			$data['excuse_attendance_table'] = $excuse_table;
			$data['class_id'] = $class_id;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/excuse_table',$data);
			$this->load->view('includes/main_page/admin_cms/footer');

			
		}

		function excuse_student()
		{
			$class_id = $this->uri->segment(3);
			$date_of_absent = $this->uri->segment(4);

			$data['class_id'] = $class_id;
			$data['date_of_absent'] = $date_of_absent;

			//form submited
			$this->form_validation->set_rules('text_box','Reason','required');
			if ($this->form_validation->run()) {
				
				$excuse_attendance_data['excuse'] = $this->input->post('text_box');
				$excuse_attendance_data['class_id'] = $this->input->post('class_id');
				$excuse_attendance_data['status'] = 1;

				$excuse_attendance_array['class_id'] = $class_id;
				$excuse_attendance_array['date_of_absent'] = $date_of_absent;


				$this->Main_model->_multi_update('excuse_attendance', $excuse_attendance_array, $excuse_attendance_data);
				
				//get the variables for redirect

				$grade = $_SESSION['grade'];
				$section = $_SESSION['section'];
				$subject = $_SESSION['subject'];
				
				redirect("attendance_monitoring/class_selection?record=1&grade=$grade&section=$section&subject=$subject");
				
			}

			$class_table = $this->Main_model->get_where('class','class_id', $class_id);
			foreach ($class_table->result_array() as $row) {
				$subject_id = $row['subject_id'];
				$faculty_id = $row['faculty_id'];
				$class_sched = $row['class_sched'];
				$student_profile_id = $row['student_profile_id'];
				$section_id = $row['section_id'];
				$school_grade_id = $row['school_grade_id'];
			}

			$student_table =  $this->Main_model->get_where('student_profile','account_id', $student_profile_id);
			foreach ($student_table->result_array() as $row) {
				$student_id = $row['account_id'];
				$firstname = ucfirst($row['firstname']);
				$middlename = ucfirst($row['middlename']);
				$lastname = ucfirst($row['lastname']);
			}
			$data['student_fullname'] = "$firstname $middlename $lastname";
			$data['class_id'] = $class_id;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/enter_reason',$data);
			$this->load->view('includes/main_page/admin_cms/footer');


		}
		function yearSelectionAttendanceRecord()
		{	
			$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/yearSelectionAttendanceRecord',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}

		function sectionSelectionAttendanceRecord()
		{
			$yearLevelId = $this->input->get('yearLevelId');
			$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionTable'] = $this->Main_model->get_where('section','school_grade_id', $yearLevelId);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/sectionSelectionAttendanceRecord',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}

		function subjectSelectionAttendanceRecord()
		{
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');
			$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
			$data['sectionName'] = $this->Main_model->getSectionNameWithId($sectionId);
			
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;

			$where['school_grade_id'] = $yearLevelId;
			
			$data['subjectTable'] = $this->Main_model->multiple_where('subject', $where);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/subjectSelectionAttendanceRecord',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}

		function view_attendance_record()
		{
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');
			$subjectId = $this->input->get('subjectId');
			
			$array['school_grade_id'] = $this->input->get('yearLevelId');
			$array['section_id'] = $this->input->get('sectionId');
			$array['subject_id'] = $this->input->get('subjectId');

			$data['yearLevelName'] = $this->Main_model->getSchoolNameWithId($yearLevelId);
			$data['sectionName'] = $this->Main_model->getSectionNameWithId($sectionId);
			$data['subjectName'] = $this->Main_model->getSubjetNameWithId($subjectId);
			
			$data['class_table'] = $this->Main_model->multiple_where('class',$array);
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;
			$data['subjectId'] = $subjectId;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/attendance_record',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}

		function student_view_attendance()
		{
			$class_id = $this->uri->segment(3);
			$data['class_id'] = $class_id;
			$data['attendance_table'] = $this->Main_model->get_where('attendance','class_id', $class_id);

			$class_table = $this->Main_model->get_where('class','class_id', $class_id);
			foreach ($class_table->result_array() as $row) {
				$subject_id = $row['subject_id'];
				$faculty_id = $row['faculty_id'];
			}

			$faculty_table = $this->Main_model->get_where('faculty','account_id', $faculty_id);
			foreach ($faculty_table->result_array() as $row) {
				$firstname = $row['firstname'];
				$middlename = $row['middlename'];
				$lastname = $row['lastname'];
			}

			$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
			foreach ($subject_table->result_array() as $row) {
				$subject_name = $row['subject_name'];
			}

			$data['teacher_fullname'] = "$firstname $middlename $lastname";
			$data['subject_name'] = $subject_name;
			
			$data['yearLevelId'] = $this->input->get('yearLevelId');
			$data['subjectId'] = $this->input->get('subjectId');
			$data['sectionId'] = $this->input->get('sectionId');

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('attendance_monitoring/student_attendance_table',$data);
			$this->load->view('includes/main_page/admin_cms/footer');

		}



		function selectDate()
		{	
			
			$this->form_validation->set_rules('date','Date','required');
			$this->form_validation->set_rules('teacher_load_id','Teacher Load','required');
			if ($this->form_validation->run()) {
				$selected_date = $this->input->post('date');
				$this->session->set_userdata('date',$selected_date);

				$teacher_load_id = $this->input->post('teacher_load_id');
				$teacher_load_table = $this->Main_model->get_where('teacher_load','teacher_load_id', $teacher_load_id);
				foreach ($teacher_load_table->result_array() as $row) {
					$grade_level = $row['grade_level'];
					$section_id = $row['section_id'];
					$subject_id = $row['subject_id'];
					$faculty_id = $row['faculty_account_id'];
				}

				$grade = $grade_level;
				$section = $section_id;
				$subject = $subject_id;
				$faculty_id = $faculty_id;

				$array_data['grade'] = $grade;
				$array_data['section'] = $section;
				$array_data['subject'] = $subject;

				$this->session->set_userdata($array_data);

				$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);

				
				$data['class'] = $this->Main_model->multiple_where('class', $array);
				$grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade);

				foreach ($grade_table->result_array() as $row) {
					$school_grade_name = $row['name'];
				}

				$section_table = $this->Main_model->get_where('section','section_id', $section);

				foreach ($section_table->result_array() as $row) {
					$section_name = $row['section_name'];
				}

				$subject_table = $this->Main_model->get_where('subject','subject_id', $subject);

				foreach ($subject_table->result_array() as $row) {
					$subject_name = $row['subject_name'];
				}


				$data['grade'] = $school_grade_name;
				$data['section'] = $section_name;
				$data['subject'] = $subject_name;

				$this->load->view('includes/main_page/admin_cms/header');
				$this->load->view('attendance_monitoring/old_class_selection',$data);
				$this->load->view('includes/main_page/admin_cms/footer');

		} //form validation

		if (isset($_GET['all_present']) == 1) {
			
				$array = array('school_grade_id' => $_SESSION['grade'], 'section_id' => $_SESSION['section'], 'subject_id' => $_SESSION['subject'],  'faculty_id' => $_SESSION['faculty_account_id']);
				$class_table = $this->Main_model->multiple_where('class', $array);


				foreach ($class_table->result_array() as $row) {
					//get the academic year
					$academicYear = $this->Main_model->getAcademicYear();

					$class_id = $row['class_id'];
					$subject_id = $row['subject_id'];
					$faculty_id = $row['faculty_id'];
					$class_sched = $row['class_sched'];
					$student_profile_id = $row['student_profile_id'];
					$section_id = $row['section_id'];
					$school_grade_id = $row['school_grade_id'];

					date_default_timezone_set("Asia/Manila");
					$insert['academic_year'] = $academicYear;
					$insert['class_id'] = $class_id;
					$insert['date'] = $_SESSION['date'];
					$insert['attendance_status'] = 1;
					$insert['school_grade_id'] = $school_grade_id;

					$this->Main_model->_insert('attendance', $insert);
				}

				//update the teacher load table
				$teacherLoadtable = $this->Main_model->

				redirect('attendance_monitoring/record_success');

			} //all present

	} //object
} //closing hetooo------------------>>>>>>>>>>

// ang tinatapos mo dito ay yung search enter here