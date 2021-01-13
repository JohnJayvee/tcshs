<?php

class Main_model extends CI_Model
{

	function accessGranted()
	{
		$parent = isset($_SESSION['parent_account_id']);
		$student = isset($_SESSION['student_account_id']);
		$faculty = isset($_SESSION['faculty_account_id']);



		if (($student != Null) || ($parent != Null) || ($faculty != Null)) {
			return true;
		} else {
			$this->session->set_userdata('notLogin', 1);
		}


		if (isset($_SESSION['notLogin'])) {
			unset($_SESSION['notLogin']);
			redirect('login');
		}
		// echo "terminated";

	}

	function access_granted()
	{
		return 1;
	}

	function get_where($table, $db_column_name, $value)
	{
		$this->db->where($db_column_name, $value);
		$query = $this->db->get($table);
		return $query;
	}

	function get_sub_category($category_id)
	{
		$query = $this->db->get_where('section', array('section_id' => $category_id));
		return $query;
	}

	function get_like($table, $db_column_name, $value, $array)
	{
		$this->db->like($db_column_name, $value);
		$this->db->where($array);
		$query = $this->db->get($table);
		return $query;
	}

	function get_where_limit($table, $limit, $db_column_name, $value)
	{

		$this->db->where($db_column_name, $value);
		$this->db->limit($limit);
		$query = $this->db->get($table);
		return $query;
	}

	//para sa mga naka lagay sa foreach
	function getFullNameWithId($table, $idColumnName, $id)
	{
		$dbTable = $this->get_where($table, $idColumnName, $id);
		foreach ($dbTable->result_array() as $row) {
			$firstname = ucfirst($row['firstname']);
			$middlename = ucfirst($row['middlename']);
			$lastname = ucfirst($row['lastname']);
		}
		$fullName = "$firstname $middlename $lastname";
		return $fullName;
	}

	function getFullNameSliced($table, $column, $id) //with mobile number
	{
		$tableName = $this->get_where($table, $column, $id);
		foreach ($tableName->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
			$mobileNumber = $row['mobile_number'];
		}

		$data['firstname'] = $firstname;
		$data['middlename'] = $middlename;
		$data['lastname'] = $lastname;
		$data['fullName'] = "$firstname $middlename $lastname";
		$data['mobileNumber'] = $mobileNumber;

		return $data;
	}

	function just_get_everything($table_name)
	{
		$query = $this->db->get($table_name);
		return $query;
	}
	// ako nag lagay dito

	// for extracting table

	function get($table_name, $order_by)
	{
		$table = $table_name;
		$this->db->order_by($order_by);
		$query = $this->db->get($table_name);
		return $query;
	}

	function get_for_register_batch($table_name, $order_by)
	{
		$table = $table_name;
		$this->db->order_by($order_by);
		$query = $this->db->get($table_name);
		return array_unique($query->result_array());
	}

	function get_random_page($table, $orderBy)
	{
		// $this->db->order_by('id', 'RANDOM');
		// or
		$this->db->order_by('rand()');
		$this->db->limit(1);
		$query = $this->db->get($table);
		return $query;
	}

	function order_by_desc($table_name, $column_name)
	{
		$this->db->order_by($column_name, "desc");
		$query = $this->db->get($table_name);
		return $query;
	}

	function orderByDescLimit($tableName, $orderBy, $limit)
	{
		$this->db->order_by($orderBy, "desc");
		$this->db->limit($limit);
		$query = $this->db->get($tableName);
		return $query;
	}

	function get_where_order_by($table, $db_column_name, $value, $order_by, $column_order_by)
	{

		order_by($column_order_by, $order_by);
		$this->db->where($db_column_name, $value);
		$query = $this->db->get($table);
		return $query;
	}

	function get_where_user_pass($table_name, $data)
	{
		$username = $data['username'];
		$password = $data['password'];
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$result = $this->db->get($table_name);
		return $result;
	}
	// pati to

	function get_with_limit($table, $limit, $order_by)
	{
		$this->db->limit($limit);
		$this->db->order_by($order_by);
		$query = $this->db->get($table);
		return $query;
	}



	function multiple_where($table_name, $array)
	{

		$this->db->where($array);

		$query = $this->db->get($table_name);

		return $query;
	}



	function get_where_student($table, $firstname, $middlename, $lastname, $fname, $mname, $lname)
	{
		$table = $table;
		$this->db->where($firstname, $fname);
		$this->db->where($middlename, $mname);
		$this->db->where($lastname, $lname);
		$query = $this->db->get($table);
		return $query;
	}

	function get_where_custom($table, $col, $value)
	{
		$table = $table;
		$this->db->where($col, $value);
		$query = $this->db->get($table);
		return $query;
	}
	// end of table extraction


	// start of database crud
	function _insert($table_name, $data)
	{
		$table = $table_name;
		$this->db->insert($table, $data);
	}

	function _update($table_name, $column_id_name, $id, $data)
	{
		$table = $table_name;
		$this->db->where($column_id_name, $id);
		$this->db->update($table, $data);
	}

	function _multi_update($table_name, $array, $data)
	{
		$this->db->where($array);
		$this->db->update($table_name, $data);
	}

	function _delete($table, $column_id_name, $id)
	{
		$table = $table;
		$this->db->where($column_id_name, $id);
		$this->db->delete($table);
	}

	function multiple_delete($table, $data)
	{
		$this->db->delete($table, $data);
	}

	function multiWhereDelete($table, $where)
	{
		$table = $table;
		$this->db->where($where);
		$this->db->delete($table);
	}

	function array_show($array)
	{
		echo "<pre>";
		print_r($array->result_array());
		echo "</pre>";
	}

	function join($first_table, $second_table, $first_column, $second_column, $where = Null)
	{
		$this->db->select('*');
		$this->db->from($first_table);
		$this->db->join($second_table, "$first_column = $second_column");
		$query = $this->db->get();
		if ($where != NULL) {
			$this->db->where($where);
		}

		return $query;
	}



	function fetch_data($query)
	{
		$this->db->like('firstname', $query);
		$query = $this->db->get('student_profile');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$output[] = array(
					'name'  => $row["firstname"],

				);
			}
			echo json_encode($output);
		}
	}

	function alert($msg)
	{
		$this->session->set_userdata('grade_present', $msg);
	}

	function import_grade()
	{
		$this->session->set_userdata('teacher_load_id_selection', $teacher_load_id);
		$this->session->set_userdata('subject_selection', $subject);
		$this->session->set_userdata('quarter_selection', $quarter);
		$this->session->set_userdata('section_selection', $section_id);
		$this->session->set_userdata('school_year_grade_selection', $school_year_grade);
		redirect('excel_import/upload_view');
	}

	function alertDanger($sessionName, $alert_message)
	{
		if (isset($_SESSION["$sessionName"])) {
			echo "<br><p class='alert alert-danger' id='disappear'>$alert_message</p>";
			unset($_SESSION["$sessionName"]);
		}
	}

	function alertSuccess($sessionName, $alert_message)
	{
		if (isset($_SESSION["$sessionName"])) {
			echo "<br><p class='alert alert-success' id='disappear'>$alert_message</p>";
			unset($_SESSION["$sessionName"]);
		}
	}

	function alertWarning($sessionName, $alert_message)
	{
		if (isset($_SESSION["$sessionName"])) {
			echo "<br><p class='alert alert-warning' id='disappear'>$alert_message</p>";
			unset($_SESSION["$sessionName"]);
		}
	}


	function checkExistingTeacher($subjectId)
	{
		$array['grade_level'] = $this->input->get('yearLevelId');
		$array['section_id'] = $this->input->get('sectionId');
		$array['subject_id'] = $subjectId;
		$teacherLoadTable = $this->multiple_where('teacher_load', $array);



		if (count($teacherLoadTable->result_array()) == 0) {
			return false;
		} else {

			foreach ($teacherLoadTable->result() as $row) {
				$teacherId = $row->faculty_account_id;
			}

			$facultyTable = $this->get_where('faculty', 'account_id', $teacherId);

			foreach ($facultyTable->result() as $row) {
				$firstname = $row->firstname;
				$middlename = $row->middlename;
				$lastname = $row->lastname;
			}

			$teacherFullName = "$firstname $middlename $lastname";
			return $teacherFullName;
		}
	}

	function checkShsTeacherLoadIfAlreadyTaken($subjectId)
	{
		$array['year_level'] = $this->input->get('yearLevelId');
		$array['sh_subject_id'] = $subjectId;
		$array['strand_id'] = $this->input->get('strandId');
		$array['school_year'] = $this->getCurrentSchoolYear();
		$teacherLoadTable = $this->multiple_where('sh_teacher_load', $array);



		if (count($teacherLoadTable->result_array()) == 0) {
			return false;
		} else {

			foreach ($teacherLoadTable->result() as $row) {
				$teacherId = $row->faculty_account_id;
			}

			$teacherName = $this->getFullName('faculty', 'account_id', $teacherId);
			return $teacherName;
		}
	}

	function getFullname($tableName, $column, $id)
	{
		$this->db->where($column, $id);
		$tableName = $this->db->get($tableName);
		foreach ($tableName->result_array() as $row) {
			$firstname = ucfirst($row['firstname']);
			$middlename = ucfirst($row['middlename']);
			$lastname = ucfirst($row['lastname']);
		}
		$fullname = "$firstname $middlename $lastname";
		return $fullname;
	}

	function array_push_assoc($array, $key, $value)
	{
		$array[$key] = $value;
		return $array;
	}

	function passwordEncryptor($string)
	{
		$string = '7m16xm!_442a8,f-1' . hash('sha512', $string) . '4sg6e_1kjf/';
		return $string;
	}

	function getParentUsernameWithId()
	{
		$id = $_SESSION['parent_account_id'];
		$credentialsTable = $this->get_where('credentials', 'account_id', $id);
		foreach ($credentialsTable->result() as $row) {
			$username = $row->username;
		}
		return $username;
	}

	function getParentPasswordWithId()
	{
		$id = $_SESSION['parent_account_id'];
		$credentialsTable = $this->get_where('credentials', 'account_id', $id);
		foreach ($credentialsTable->result() as $row) {
			$password = $row->password;
		}
		return $password;
	}


//##########################################################################
// ITEXMO SEND SMS API - PHP - CURL-LESS METHOD
// Visit www.itexmo.com/developers.php for more info about this API
//##########################################################################
function itexmo($number,$message){
	if ($number != '00000000000') {
		$apicode = "TR-ALLYV622884_CN9LK";
		$passwd = "j95e(hm5fg";
		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
		$param = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($itexmo),
			),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);
	}
}
//##########################################################################
	

	function getYearLevelNameFromId($yearLevelId)
	{
		$schoolGradeTable = $this->get_where('school_grade', 'school_grade_id', $yearLevelId);
		foreach ($schoolGradeTable->result() as $row) {
			$yearLevelName = $row->name;
		}
		return $yearLevelName;
	}


	function getSectionNameFromId($sectionId)
	{
		$sectionTable = $this->get_where('section', 'section_id', $sectionId);
		foreach ($sectionTable->result() as $row) {
			$sectionName = $row->section_name;
		}
		return $sectionName;
	}

	function getShsSectionNameFromId($sectionId)
	{
		$sectionTable = $this->get_where('sh_section', 'section_id', $sectionId);
		foreach ($sectionTable->result() as $row) {
			$sectionName = $row->section_name;
		}
		return $sectionName;
	}

	function getSectionNameFromIdShs($sectionId)
	{
		$sectionTable = $this->get_where('sh_section', 'section_id', $sectionId);
		foreach ($sectionTable->result() as $row) {
			$sectionName = $row->section_name;
		}
		return $sectionName;
	}

	function getSubjectNameFromId($subjectId)
	{
		$subjectTable = $this->get_where('subject', 'subject_id', $subjectId);
		foreach ($subjectTable->result() as $row) {
			$subjectName = $row->subject_name;
		}
		return ucfirst($subjectName);
	}

	function getSubjectFromTeacherLoad($teacherLoadId)
	{
		$table = $this->get_where('sh_teacher_load', 'id', $teacherLoadId);
		foreach ($table->result() as $row) {
			return $row->sh_subject_id;
		}
	}

	function getShSubjectNameFromId($subjectId)
	{
		$subjectTable = $this->get_where('sh_subjects', 'subject_id', $subjectId);
		foreach ($subjectTable->result() as $row) {
			$subjectName = $row->subject_name;
		}
		return ucfirst($subjectName);
	}

	function checkIfTeacherLoadIsTaken($teacherLoadId)
	{
		$table = $this->get_where('sh_teacher_load', 'id', $teacherLoadId);
		if (count($table->result_array()) != 0) {
			//nakuha na siya
			return true;
		}else{
			return false;
		}
	}

	function getTeacherLoadIdFromSubject($subjectId)
	{
		$table = $this->get_where('sh_teacher_load', 'sh_subject_id', $subjectId);
		if (count($table->result_array()) != 0) {
			//meron siyang nahanap
			foreach ($table->result() as $row) {
				return $row->id;
			}
		}else{
			//wala siyang nahanap
			return false;
		}
		
	}

	// para sa auto complete
	// function get_all_blog(){
	// 	$result=$this->db->get('student_profile');
	// 	return $result;
	// }

	function searchStudent($studentName)
	{
		// $this->db->like('firstname', $title);
		$sql = "SELECT * FROM student_profile WHERE ";
		$sql .= "firstname  Like '%$studentName%'or middlename Like '%$studentName%' or lastname   Like '%$studentName%'";


		$this->db->order_by('firstname', 'ASC');
		$this->db->limit(10);
		$result = $this->db->query($sql);
		return $result;
		// return $this->db->get('student_profile')->result_array();
	}
	// para sa auto complete

	function getStudIdAndMessage($classId)
	{
		//class id procedure
		$classTable = $this->get_where('class', 'class_id', $classId);

		foreach ($classTable->result() as $row) {
			$studentId = $row->student_profile_id;
			$facultId = $row->faculty_id;
			$subjectId = $row->subject_id;
		}
		$subjectTable = $this->get_where('subject', 'subject_id', $subjectId);
		foreach ($subjectTable->result() as $row) {
			$subjectName = $row->subject_name;
		}

		$teacherFullName = $this->getFullname('faculty', 'account_id', $facultId);
		$studentTable = $this->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentTable->result() as $row) {
			$studentFirstname = $row->firstname;
			$studentMiddlename = $row->middlename;
			$studentLastname = $row->lastname;
			$parentId = $row->parent_id;
		}
		$studentFullname = "$studentFirstname $studentMiddlename $studentLastname";
		$parentTable = $this->get_where('parent', 'account_id', $parentId);
		foreach ($parentTable->result() as $row) {
			$parentFirstname = $row->firstname;
			$parentMiddlename = $row->middlename;
			$parentLastname = $row->lastname;
			$parentMobileNumber = $row->mobile_number;
		}
		$parentFullname = "$parentFirstname $parentMiddlename $parentLastname";
		$date = date('m-d-Y');

		$message = "Hi $parentFullname your child $studentFullname has been marked ABSENT $date";
		// $message .= " on the subject: $subjectName  of $teacherFullName. Please Login to our Website at www.tcshs.com";
		return $message;
		$this->itexmo($parentMobileNumber,$message);
		// echo "<br><br> the message is: <p>$message</p>";
	}

	function getParentNumber($classId)
	{
		//class id procedure
		$classTable = $this->get_where('class', 'class_id', $classId);

		foreach ($classTable->result() as $row) {
			$studentId = $row->student_profile_id;
			$facultId = $row->faculty_id;
			$subjectId = $row->subject_id;
		}
		$subjectTable = $this->get_where('subject', 'subject_id', $subjectId);
		foreach ($subjectTable->result() as $row) {
			$subjectName = $row->subject_name;
		}

		$teacherFullName = $this->getFullname('faculty', 'account_id', $facultId);
		$studentTable = $this->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentTable->result() as $row) {
			$studentFirstname = $row->firstname;
			$studentMiddlename = $row->middlename;
			$studentLastname = $row->lastname;
			$parentId = $row->parent_id;
		}
		$studentFullname = "$studentFirstname $studentMiddlename $studentLastname";
		$parentTable = $this->get_where('parent', 'account_id', $parentId);
		foreach ($parentTable->result() as $row) {
			$parentFirstname = $row->firstname;
			$parentMiddlename = $row->middlename;
			$parentLastname = $row->lastname;
			$parentMobileNumber = $row->mobile_number;
		}
		return $parentMobileNumber;
	}

	function getSchoolNameWithId($yearLevelId)
	{
		$yearLevelTable = $this->get_where('school_grade', 'school_grade_id', $yearLevelId);
		foreach ($yearLevelTable->result() as $row) {
			$yearLevelName = $row->name;
		}
		return $yearLevelName;
	}



	function getSectionNameWithId($sectionId)
	{
		$sectionTable = $this->get_where('section', 'section_id ', $sectionId);
		foreach ($sectionTable->result() as $row) {
			$sectionName = $row->section_name;
		}
		return $sectionName;
	}

	function getSubjetNameWithId($subjectId)
	{
		$subjectTable = $this->get_where('subject', 'subject_id ', $subjectId);
		foreach ($subjectTable->result() as $row) {
			$subjectName = $row->subject_name;
		}
		return $subjectName;
	}

	function gradeFixer($value)
	{
		if ($value > 0) {
			echo $value;
		} else {
			echo "N/A";
		}
	}

	function attendanceFixer($status)
	{
		$check = base_url() . "assets/images/check.jpg";
		$cross = base_url() . "assets/images/cross.jpg";
		if ($status != 0) {
			echo "<img src=" . $check  . " height='50px' width='50px'>";
		} else {
			echo "<img src=" . $cross  . " height='50px' width='50px'>";
		}
	}

	function getTeacherWithClassId($classId)
	{
		$classTable = $this->get_where('class', 'class_id', $class_id);
		foreach ($classTable->result() as $row) {
			$facultyId = $row->faculty_id;
		}
	}

	function updateTeacherLoadAttendanceStatus($all_class_id)
	{
		//get the class table using the class id
		$classTable = $this->Main_model->get_where('class', 'class_id', $all_class_id);
		foreach ($classTable->result() as $row) {
			$subjectId = $row->subject_id;
			$facultyId = $row->faculty_id;
			$sectionId = $row->section_id;
			$yearLevel = $row->school_grade_id;
		}

		//perform multiple_where to target the teacher load table
		$multiWhere['faculty_account_id'] = $facultyId;
		$multiWhere['subject_id'] = $subjectId;
		$multiWhere['grade_level'] = $yearLevel;
		$multiWhere['section_id'] = $sectionId;

		//data that will be udpated into 1;
		$updateThis['attendance_status'] = 1;

		//perform multiWhereUpdate
		$this->Main_model->_multi_update('teacher_load', $multiWhere, $updateThis);
	}

	function setCurrentDate()
	{
		$this->session->set_userdata('currentDate', date("Y/m/d"));
	}

	function checkDayHasPassed()
	{
		//get the time in the database
		$timeTable = $this->getAscending('time', 'id');
		foreach ($timeTable->result() as $row) {
			$dbTime = $row->time;
		}
		
		//compare the time in db and current time
		$currentTime = date("Y/m/d");
		
		if ($dbTime != $currentTime) {
			//meaning  nakakalagpas na ang isang araw

			//updated all of the teacher load into one. 
			$teacherLoadTable = $this->get('teacher_load', 'teacher_load_id');
			foreach ($teacherLoadTable->result() as $row) {
				$update['attendance_status'] = 0; // pag zero meaning hindi pa siya nag rerecord
				$this->_update('teacher_load', 'teacher_load_id', $row->teacher_load_id, $update);
			}

			//update mo narin yung time sa database mo
			$dbUpdate['time'] = $currentTime;
			$this->_update('time', 'id', 79, $dbUpdate);
		} //if condition

	} //object end

	function setCurrentYear()
	{
		//get server current year
		$firstYear = date('Y');
		$secondYear = $firstYear + 1;
		$serverCurrentYear = "$firstYear-$secondYear";
		
		//get database current year
		$dbCurrentYear = $this->getCurrentSchoolYear();
		
		if ($serverCurrentYear != $dbCurrentYear) {
			//ibang year na kailangan ng palitan 
			$update['time'] = $serverCurrentYear;
			$this->_update('time', 'id', 80, $update);
		}
		
	}

	function getSectionWhere($yearLevelId)
	{
		$result = $this->get_where('section', 'school_grade_id', $yearLevelId);
		return $result->result_array();
	}

	function getAcademicYear()
	{
		//will just get the second row
		$timeTable = $this->get('time', 'id');

		$iterator = 1;
		foreach ($timeTable->result() as $row) {
			
			if ($iterator == 2) {
				return $row->time;
			}
			$iterator = 1 + $iterator;
		}
	} // end of function

	function getNumberOfParent($parentId)
	{
		$parentTable = $this->Main_model->get_where('parent', 'account_id', $parentId);
		foreach ($parentTable->result() as $row) {
			$mobileNumber = $row->mobile_number;
		}
		return $mobileNumber;
	} //end of function

	function getTheNumber($table, $column, $id)
	{
		$table = $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			$mobileNumber = $row->mobile_number;
		}
		return $mobileNumber;
	}

	function facultyRepository($facultyId)
	{
		$facultyTable = $this->get_where('faculty', 'account_id', $facultyId);
		$facultyTableCount = count($facultyTable->result_array());

		if ($facultyTableCount == 0) {
			//walang teacher find it in the repository
			$facultyRepositoryTable  = $this->get_where('faculty_repository', 'faculty_account_id', $facultyId);
			foreach ($facultyRepositoryTable->result() as $row) {
				$firstname = ucfirst($row->firstname);
				$middlename = ucfirst($row->middlename);
				$lastname = ucfirst($row->lastname);
			}
			$fullName = "$firstname $middlename $lastname";
		} else {
			$fullName = $this->Main_model->getFullname('faculty', 'account_id', $facultyId);
		}

		return $fullName;
	}

	function facultyMobileNumberRepositoryManager($facultyId)
	{
		$facultyTable = $this->get_where('faculty', 'account_id', $facultyId);
		$facultyTableCount = count($facultyTable->result_array());

		if ($facultyTableCount == 0) {
			//check the repository
			$facultyRepositoryTable = $this->Main_model->get_where('faculty_repository', 'faculty_account_id', $facultyId);
			foreach ($facultyRepositoryTable->result() as $row) {
				$mobileNumber = $row->mobile_number;
			}

			return $mobileNumber;
		} else {
			foreach ($facultyTable->result() as $row) {
				$mobileNumber = $row->mobile_number;
			}

			return $mobileNumber;
		}
	}

	function g10StudentRepositoryManager($student_profile_id)
	{
		//find it in the student table pag wala hanap ka sa repository
		$studentTable = $this->get_where('student_profile', 'account_id', $student_profile_id);
		$studTableCount = count($studentTable->result_array());

		if ($studTableCount == 0) {
			//walang student find it in the repository
			$studentRepositoryTable  = $this->get_where('g10_repository', 'account_id', $student_profile_id);
			foreach ($studentRepositoryTable->result() as $row) {
				$firstname = ucfirst($row->firstname);
				$middlename = ucfirst($row->middlename);
				$lastname = ucfirst($row->lastname);
			}
			$fullName = "$firstname $middlename $lastname";
		} else {
			$fullName = $this->Main_model->getFullname('student_profile', 'account_id', $student_profile_id);
		}

		return $fullName;
	}

	function grade10SubjectRepositoryManager($subjectId)
	{
		//get subject table
		$subjectTable = $this->Main_model->get_where('subject', 'subject_id', $subjectId);
		$subjectTableCount = count($subjectTable->result_array());
		if ($subjectTableCount == 0) {
			//walang laman kaya dapat hanap ka sa repository
			$repositoryTable = $this->Main_model->get_where('g10_subject_repository', 'subject_id', $subjectId);
			foreach ($repositoryTable->result() as $row) {
				$subjectName = $row->subject_name;
			}
		} else {
			//meron siyang laman
			foreach ($subjectTable->result() as $row) {
				foreach ($subjectTable->result() as $row) {
					$subjectName = $row->subject_name;
				}
			}
		}

		return $subjectName;
	}

	function grade10YearLevelRepositoryManager($yearLevelId)
	{
		$schoolGradeTable = $this->get_where('school_grade', 'school_grade_id', $yearLevelId);
		$schoolGradeCount = count($schoolGradeTable->result_array());

		if ($schoolGradeCount == 0) {
			//search repository
			$repositoryTable = $this->get_where('grade_10_year_level_repository', 'school_grade_id', $yearLevelId);
			foreach ($repositoryTable->result() as $row) {
				$yearLevelName = $row->name;
			}
		} else {
			//meron siyang nahanap;
			foreach ($schoolGradeTable->result() as $row) {
				$yearLevelName = $row->name;
			}
		}
		return $yearLevelName;
	}

	function grade10SectionRepositoryManager($section_id)
	{
		$sectionTable = $this->get_where('section', 'section_id', $section_id);

		$sectionTableCount = count($sectionTable->result_array());

		if ($sectionTableCount == 0) {
			//search repository
			$repositoryTable = $this->get_where('g10_section_repository', 'section_id', $section_id);
			foreach ($repositoryTable->result() as $row) {
				$sectionName = $row->section_name;
			}
		} else {
			//meron siyang nahanap;
			foreach ($sectionTable->result() as $row) {
				$sectionName = $row->section_name;
			}
		}
		return $sectionName;
	}

	function checkYearLevel($academicGradeId)
	{
		//objective: check whether the school grade table has activated
		// you will return the count of the tables
		$array['academic_grade_id'] = $academicGradeId;
		$array['status'] = 1;
		$schoolGradeTable = $this->multiple_where('school_grade', $array);
		$academicGradeCount = count($schoolGradeTable->result_array());
		return $academicGradeCount;
	}

	//for teacher view
	function getFirstName($table, $column, $id)
	{
		$table =  $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			$firstname = $row->firstname;
		}
		return $firstname;
	}

	function getMiddleName($table, $column, $id)
	{
		$table =  $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			$middlename = $row->middlename;
		}
		return $middlename;
	}

	function getLastName($table, $column, $id)
	{
		$table =  $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			$lastname = $row->lastname;
		}
		return $lastname;
	}

	function facultyDuplicationChecker($firstname, $middlename, $lastname, $redirectUrl)
	{
		$facultyTable = $this->get('faculty', 'account_id');
		foreach ($facultyTable->result() as $row) {
			$dbFirstname = strtolower($row->firstname);
			$dbMiddlename = strtolower($row->middlename);
			$dbLastname = strtolower($row->lastname);

			if (($dbFirstname == strtolower($firstname)) && ($dbMiddlename == strtolower($middlename)) && ($dbLastname == strtolower($lastname))) {
				$this->session->set_userdata('facultyDouble', 1);
				redirect($redirectUrl);
			}
		}
	}

	function checkAssignAdviser($sectionId, $academicGradeId)
	{
		//objective: to check the section's adviser

		//check adviser table

		//define where conditions
		$where['section_id'] = $sectionId;
		$where['academic_grade_id'] = $academicGradeId;
		$adviserTable = $this->Main_model->multiple_where('adviser_section', $where);
		$adviserCount = count($adviserTable->result_array());

		if ($adviserCount == 0) {
			return false;
		} else {
			foreach ($adviserTable->result() as $row) {
				$adviserName = $this->getFullNameWithId('faculty', 'account_id', $row->faculty_account_id);
			}
			return $adviserName;
		}
	}

	function ShsCheckAssignAdviser($sectionId)
	{
		//objective: to check the section's adviser

		//check adviser table

		//define where conditions
		$where['section_id'] = $sectionId;
		
		$adviserTable = $this->Main_model->multiple_where('sh_adviser', $where);
		$adviserCount = count($adviserTable->result_array());

		if ($adviserCount == 0) {
			return false;
		} else {
			foreach ($adviserTable->result() as $row) {
				$adviserName = $this->getFullNameWithId('faculty', 'account_id', $row->faculty_id);
			}
			return $adviserName;
		}
	}

	function checkAdviserIsAssigned($facultyId, $academicGradeId)
	{
		// objective: checks faculty id if it is already assigned to the section
		$sectionId = $this->input->get('sectionId');

		$where['section_id'] = $sectionId;
		$where['faculty_account_id'] = $facultyId;
		$where['academic_grade_id'] = $academicGradeId;

		$adviserSectionTable  = $this->multiple_where('adviser_section', $where);
		$adviserCount = count($adviserSectionTable->result_array());

		if ($adviserCount == 0) {
			return false;
		} else {
			return true;
		}
	}

	function CurrentLogedInAdviserOrNot() // wala kasing seciton dito kailangan lang na meron siya sa sa table na adviser
	{
		//get who is loged in
		$facultyId = $_SESSION['faculty_account_id'];

		//check in the adviser table
		$adviserTable = $this->Main_model->get_where('adviser_section', 'faculty_account_id', $facultyId);
		$adviserTableCount = count($adviserTable->result_array());


		if ($adviserTableCount == 0) {
			return false;
		} else {
			return true;
		}
	}

	function adviserOrNot()
	{
		$facultyAccountId = $_SESSION['faculty_account_id'];
		$adviserTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyAccountId);

		//determine if the the teacher logged in is an adviser or not
		if (count($adviserTable->result_array()) == 0) {
			return false;
		}else{
			return true;
		}
	}

	function shsAdviserOrNot()
	{
		$facultyAccountId = $_SESSION['faculty_account_id'];
		$adviserTable = $this->get_where('sh_adviser', 'faculty_id', $facultyAccountId);

		//determine if the the teacher logged in is an adviser or not
		if (count($adviserTable->result_array()) == 0) {
			return false;
		}else{
			return true;
		}
	}

	function getJhsYearLevelWithSectionId($sectionId)
	{
		$table = $this->get_where('section', 'section_id', $sectionId);
		foreach ($table->result() as $row) {
			return $row->school_grade_id;
		}
	}

	function getAdviserSchoolGradeId() //hindi year id yung kinkuha hiya . academic grade id yung kinukuha niya. 
	{
		//get who is loged in
		$facultyId = $_SESSION['faculty_account_id'];
		
		$adviserTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyId);
		
		//determine if teacher is adviser
		if (count($adviserTable->result_array()) != 0) {
			foreach ($adviserTable->result() as $row) {
				$sectionId = $row->section_id;
				$academicGradeId = $row->academic_grade_id;
			}
		
			return $academicGradeId;
		}else{
			return false;
		}
	}

	function getShAdviserSchoolGradeId()
	{
		//get who is loged in
		$facultyId = $_SESSION['faculty_account_id'];
		
		$adviserTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyId);
		
		//determine if teacher is adviser
		if (count($adviserTable->result_array()) != 0) {
			foreach ($adviserTable->result() as $row) {
				$sectionId = $row->section_id;
			}
	
			//get school grade 
			$sectionTable = $this->get_where('sh_section', 'section_id', $sectionId);
			foreach ($sectionTable->result() as $row) {
				$yearLevelId = $row->year_level_id;
			}
			
			return $yearLevelId;
		}else{
			return false;
		}
	}

	function getSectionIdFromAdviser()
	{
		//get who is loged in
		$facultyId = $_SESSION['faculty_account_id'];

		$adviserTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyId);
		if (count($adviserTable->result_array()) != 0) {
			foreach ($adviserTable->result() as $row) {
				$sectionId = $row->section_id;
			}
	
			return $sectionId;
		}else{
			return false;
		}
	}

	function getTrackAndStrandIdFromSection()
	{
		//pwede mo narin makuha yung year level id dito 
	
		$facultyId = $_SESSION['faculty_account_id'];
		
		//find the whether the teacher is an adviser
		$adviserTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyId);
		
		//tell whether the teacher is an adviser or not
		if (count($adviserTable->result_array()) != 0) {
			//adviser yung naka loged in. 
			foreach ($adviserTable->result() as $row) {
				//just get the section id
				$dbSectionId = $row->section_id;
			}

			//find the track and strand from the sh_section table
			$shSectionTable = $this->get_where('sh_section', 'section_id', $dbSectionId);
			foreach ($shSectionTable->result() as $row) {
				$trackId = $row->track_id;
				$strandId = $row->strand_id;
				$yearLevelId = $row->year_level_id;
			}

			$data['trackId'] = $trackId;
			$data['strandId'] = $strandId;
			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $dbSectionId;

			return $data;
		}else{
			return "the teacher is not an adviser";
		}
	}

	function getTrackName($trackId)
	{
		$trackTable = $this->get_where('career_track', 'track_id', $trackId);
		foreach ($trackTable->result() as $row) {
			return $row->track_name;
		}
	}

	function getStrandName($strandId)
	{
		$strandTable = $this->Main_model->get_where('strand', 'strand_id', $strandId);
		foreach ($strandTable->result() as $row) {
			return $row->strand_name;
		}
	}

	function getTrackIdFromStrandId($strandId)
	{
		$strandTable = $this->Main_model->get_where('strand', 'strand_id', $strandId);
		foreach ($strandTable->result() as $row) {
			return $row->track_id;
		}
	}

	function jhsDuplicationChecker($data, $yearLevelId, $sectionId)
	{	
		
		$firstname =  str_replace(' ', '', $data['firstname']);
		$middlename =  str_replace(' ', '', $data['middlename']);
		$lastname =  str_replace(' ', '', $data['lastname']);
		$studentFullName = "$firstname$middlename$lastname";
		
		$studentTable = $this->get('student_profile', 'account_id');
		foreach ($studentTable->result() as $row) {
			$dbFirstname = $row->firstname;
			$dbMiddlename = $row->middlename;
			$dbLastname = $row->lastname;

			$dbFullName = "$dbFirstname$dbMiddlename$dbLastname";

			if ($dbFullName == $studentFullName) {
				$this->session->set_userdata('jhsStudentDuplicate', 1);
				echo "hello world meron siyang nakita";
				redirect("manage_user/register?yearLevelId=$yearLevelId&sectionId=$sectionId");
			}
		}
		
	}

	function shSectionDuplicationChecker($data)
	{
		$shSectionTable = $this->multiple_where('sh_section', $data);
		$shSectionTableCount = count($shSectionTable->result_array());

		if ($shSectionTableCount != 0) {
			//meron siyang nahanap na pareho
			return true;
		} else {
			//wala siyang nahanap na pareho
			return false;
		}
	}

	function shSubjectDuplicationChecker($data)
	{
		$shSectionTable = $this->multiple_where('sh_subjects', $data);
		$shSectionTableCount = count($shSectionTable->result_array());

		if ($shSectionTableCount != 0) {
			//meron siyang nahanap na pareho
			return true;
		} else {
			//wala siyang nahanap na pareho
			return false;
		}
	}

	function shGeneralSubjectDuplicationChecker($data)
	{
		$shSubjectsTable = $this->multiple_where('sh_subjects', $data);
		$shSubjectsTableCount = count($shSubjectsTable->result_array());

		if ($shSubjectsTableCount != 0) {
			//meron siyang nahanap na pareho
			return true;
		} else {
			//wala siyang nahanap na pareho
			return false;
		}
	}

	function shsTeacherOrNot()
	{
		$facultyId = $_SESSION['faculty_account_id'];

		//check the credentials table if he is a shs teacher or not. 
		$credentialsTable = $this->get_where('credentials', 'account_id', $facultyId);
		
		//extract data
		foreach ($credentialsTable->result() as $row) {
			if ($row->academic_grade_id == 2) {
				return true;
			}else{
				return false;
			}
		}
	}

	function getShSectionName($sectionId)
	{
		$shSectionTable = $this->get_where('sh_section', 'section_id', $sectionId);
		foreach ($shSectionTable->result() as $row) {
			$sectionName = $row->section_name;
		}

		return $sectionName;
	}

	function shDuplicationChecker($data)
	{
		$shStudentTable = $this->multiple_where('sh_student', $data);
	
		if (count($shStudentTable->result_array()) != 0) {
			
			$this->session->set_userdata('studentDuplicate', 1);
			redirect('shs/registerShsStudent');
		}
	}

	function maskTags($tagId)
	{
		$tagsTable = $this->get_where('post_tags', 'id', $tagId);
		foreach ($tagsTable->result() as $row) {
			$tagName = $row->tag_name;
		}
		echo $tagName;
	}

	function getImageName($postId)
	{
		$postTable = $this->get_where('post', 'post_id', $postId);
		foreach ($postTable->result() as $row) {
			$imageName = $row->post_image;
		}
		return $imageName;
	}

	function manageParentData($parentData)
	{
		//what you will do. 
		//1. you will insert the parent into the parent table
		//2. get that newly inserted parent id and add it into the credentials table
		//3. the username will be the firstname and the password will be randomized 

		$this->_insert('parent', $parentData); //insertion of post data into the parent table
		$parentTable = $this->just_get_everything('parent');

		foreach ($parentTable->result() as $row) {
			$latestParentId = $row->account_id;
		}

		//prepare assoc array for credentials table
		$cred['username'] = $parentData['firstname'];
		
		$password = rand(00000, 99999); //generate random password
		
		//prepare for message texting
		$number = $parentData['mobile_number'];
		$message = "username is: " . $cred['username'] . " and your password is: $password";
		$this->itexmo($number, $message);

		//encrypt the password
		$cred['password'] = $this->passwordEncryptor($password);
		
		$cred['administration_id'] = 3;
		$cred['academic_grade_id'] = 0;
		$cred['account_id'] = $latestParentId;

		$this->_insert('credentials', $cred);

					//PERFORM: STUDENT REGISTRATION 
		$_SESSION['studentInfo']['parent_id'] = $latestParentId; // update the parent id of the current student
		
		//Insert into the sh_student
		$this->_insert('sh_student', $_SESSION['studentInfo']);


		//get the latest insert from the sh_student
		$shStudentTable = $this->multiple_where('sh_student', $_SESSION['studentInfo']);
		foreach ($shStudentTable->result() as $row) {
			$latestShStudentId = $row->account_id;
		}

		//student populates class section
		$classSection['sh_section_id'] = $_SESSION['studentInfo']['section_id'];
		$classSection['year_level'] = $_SESSION['studentInfo']['year_level_id'];
		$classSection['sh_student_id'] = $latestShStudentId;
		$this->_insert('sh_class_section' ,$classSection);

		//sh_class preparation. dapat lahat ng subjects na meron yung section na yun
		//meron narin yung newly registered student.
		$shClassTable = $this->get_where('sh_class', 'sh_section_id', $classSection['sh_section_id']);
		if (count($shClassTable->result_array()) != 0) {
			//meron ng class yung ibang students na meron sa section na yun.
			foreach ($shClassTable->result() as $row) {
				$duplicate['sh_faculty_id'] = $row->sh_faculty_id;
				$duplicate['sh_section_id'] = $row->sh_section_id;
				$duplicate['strand_id'] = $row->strand_id;
				$duplicate['track_id'] = $row->track_id;
				$duplicate['schedule'] = $row->schedule;
				$duplicate['semester'] = $row->semester;
				$duplicate['quarter'] = $row->quarter;
				$duplicate['sh_student_id'] = $latestShStudentId;

				$this->_insert('sh_class', $duplicate);
			}
		}

						//STUDENT CREDENTIALS PREPARATION
		
		$studCred['username'] = $_SESSION['studentInfo']['firstname'];
		
		$studPassword = rand(00000, 99999); //generate random password
		
		//prepare for message texting
		$studNumber = $parentData['mobile_number'];
		$studMessage = "username is: " . $studCred['username'] . " and your password is: $studPassword";
		$this->itexmo($studNumber, $studMessage);

		//encrypt the password
		$studCred['password'] = $this->passwordEncryptor($studPassword);
		
		$studCred['administration_id'] = 3;
		$studCred['academic_grade_id'] = 2;
		$studCred['account_id'] = $latestParentId;

		$this->_insert('credentials', $studCred);
		
		//perform page redirection and notifictaion
		$this->session->set_userdata('accountCreated', 1);
		redirect('shs/registerShsStudent');
	}
	
	function findParentId($parentData)
	{
		$parentTable = $this->Main_model->multiple_where('parent', $parentData);
		foreach ($parentTable->result() as $row) {
			$latestParentId = $row->account_id;
		}
		return $latestParentId;
	}

	function findJhsStudentId($studentInfo)
	{
		$studentTable = $this->Main_model->multiple_where('student_profile', $studentInfo);
		foreach ($studentTable->result() as $row) {
			$lastestStudentId = $row->account_id;
		}
		return $lastestStudentId;
	}

	function jhsParentDuplicationChecker($data, $yearLevelId, $sectionId)
	{
		//FAIL SAFE: PARENT DUPLICATION CHECKER
		$parentFirstname = str_replace(' ', '', $data['firstname']);
		$parentMiddlename = str_replace(' ', '', $data['middlename']);
		$parentLastname = str_replace(' ', '', $data['lastname']);
		$parentFullName = "$parentFirstname$parentMiddlename$parentLastname";

		// database comparison.
		$parentTable = $this->get('parent', 'account_id');
		foreach ($parentTable->result() as $row) {
			$firstname = $row->firstname;
			$middlename = $row->middlename;
			$lastname = $row->lastname;

			$parentDbFullName = "$firstname$middlename$lastname";

			//compare
			if ($parentFullName == $parentDbFullName) {
				
				$this->session->set_userdata('jhsParentDuplicate', 1);
				redirect("manage_user/registerParent?yearLevelId=$yearlevelId&sectionId=$sectionId");
			}
		}
	}

	function manageJhsParent($parentData, $yearLevelId, $sectionId)
	{
		
		// PARENT DUPLICATION CHECKER
		$this->jhsParentDuplicationChecker($parentData, $yearLevelId, $sectionId);

		$this->_insert('parent', $parentData); //insertion of post data into the parent table
		$latestParentId = $this->findParentId($parentData);

		//prepare assoc array for credentials table
		$cred['username'] = $parentData['firstname'][0] . $parentData['lastname'];
		
		$password = rand(00000, 99999); //generate random password
		
		//prepare for message texting
		$number = $parentData['mobile_number'];
		$message = "username is: " . $cred['username'] . " and your password is: $password";
		if ($number != 00000000000) {
			$this->itexmo($number, $message);
		}

		//encrypt the password
		$cred['password'] = $this->passwordEncryptor($password);
		
		$cred['administration_id'] = 3;
		$cred['academic_grade_id'] = 0;
		$cred['account_id'] = $latestParentId;

		$this->_insert('credentials', $cred);

					//PERFORM: STUDENT REGISTRATION 
		$_SESSION['studentInfo']['parent_id'] = $latestParentId; // update the parent id of the current student
		
		//Insert into the sh_student
		$this->_insert('student_profile', $_SESSION['studentInfo']);

		//get the latest insert from the student_profile
		$latestJsStudent = $this->findJhsStudentId($_SESSION['studentInfo']);


						//STUDENT CREDENTIALS PREPARATION
		
		$studCred['username'] = $_SESSION['studentInfo']['firstname'][0] . $_SESSION['studentInfo']['lastname'];
		
		$studPassword = rand(00000, 99999); //generate random password
		
		//prepare for message texting
		$studNumber = $parentData['mobile_number'];
		$studMessage = "username is: " . $studCred['username'] . " and your password is: $studPassword";

		if ($studNumber != 00000000000) {
			$this->itexmo($studNumber, $studMessage);
		}

		//encrypt the password
		$studCred['password'] = $this->passwordEncryptor($studPassword);
		
		$studCred['administration_id'] = 2;
		$studCred['academic_grade_id'] = 1;
		$studCred['account_id'] = $latestJsStudent;

		$this->_insert('credentials', $studCred);

		//CLASS_SECTION PREPARATION 
		$cs['student_profile_id'] = $latestJsStudent;
		$cs['section_id'] = $_SESSION['studentInfo']['section_id'];
		$cs['school_year'] = $_SESSION['studentInfo']['school_grade_id'];


		$this->_insert('class_section', $cs);

		//CURRENT CLASS FINDER AND STUDENT INSERTORINATOR
		$this->checkIfTheSectionHasAClassAlready($_SESSION['studentInfo']['section_id'], $latestJsStudent);

		//get data for redirection
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');
		
		// perform page redirection and notifictaion
		$this->session->set_userdata('accountCreated', 1);
		echo "laskdjflaskj is: $yearLevelId";
		redirect("manage_user/register?yearLevelId=$yearLevelId&sectionId=$sectionId");
	}

	function checkIfTheSectionHasAClassAlready($sectionId, $student_profile_id)
	{
		//determine in the teacher load table
		$teacherLoadTable = $this->get_where('teacher_load', 'section_id', $sectionId);
		if (count($teacherLoadTable->result_array()) != 0) {
			//meron na siyang nagawa
			foreach ($teacherLoadTable->result() as $row) {
				$insertClass['subject_id'] = $row->subject_id;
				$insertClass['faculty_id'] = $row->faculty_account_id;
				$insertClass['class_sched'] = $row->schedule;
				$insertClass['student_profile_id'] = $student_profile_id; // given kasi naka create kana ng student
				$insertClass['section_id'] = $row->section_id;
				$insertClass['school_grade_id'] = $row->grade_level;
				$insertClass['school_year'] = $this->getAcademicYear();
				
				$this->_insert('class', $insertClass);
			}
		}
	}

	function shInsertIntoCredentials($username, $account_id)
	{
		$password = rand(00000, 99999);
		
		$credentials['username'] = $username;
		$credentials['password'] = $this->passwordEncryptor($password);
		$credentials['administration_id'] = 3;
		$credentials['academic_grade_id'] = 2; //shs nga eh 
		$credentials['account_id'] = $account_id;

		//insert into the credentials table
		$this->_insert('credentials', $credentials);
	}

	function redirectArrayEmpty($data, $url, $sessionName)
	{
		if (count($data->result_array()) == 0) {
			$this->session->set_userdata($sessionName, 1);
			redirect($url);
		}
	}

	function alertPromt($message, $sessionName)
	{
		if (isset($_SESSION[$sessionName])) {
			echo '<script>alert("' . $message . '");</script>';
			unset($_SESSION[$sessionName]);
		}
	}

	function getSubdevidedParentName($parentId)
	{
		$parentTable = $this->get_where('parent', 'account_id', $parentId);
		foreach ($parentTable->result() as $row) {
			$data['firstname'] = $row->firstname;
			$data['middlename'] = $row->middlename;
			$data['lastname'] = $row->lastname;
			
			return $data;
		}		
	}

	function getAllTheStudentsOfThatParent($parentId)
	{
		$shStudentTable = $this->get_where('sh_student', 'parent_id', $parentId);
		foreach ($shStudentTable->result() as $row) {
			$firstname = $row->firstname;
			$middlename = $row->middlename;
			$lastname = $row->lastname;

			$fullname = "$firstname $middlename $lastname";
			echo ucfirst($fullname) . " <br> <br>";
		}

	}

	function findId($table, $data, $columnWhere)// columnWhere == account_id etc
	{
		$table = $this->multiple_where($table, $data);
		foreach ($table->result() as $row) {
			$id = $row->$columnWhere;
		}
		return $id;
	}

	function determineIfTeacherIsParent($id)
	{
		$teacherTable = $this->Main_model->get_where('faculty', 'account_id', $id);
		foreach ($teacherTable->result() as $row) {
			$parentId = $row->parent_id;
		}

		if ($parentId != 0) {
			return true;
		}else{
			return false;
		}
	}

	function checkIfTheTeacherHasAChild()
	{
		$teacherId = $_SESSION['faculty_account_id'];
		//provide the parent id of the teacher. 

		$teacherTable = $this->get_where('faculty', 'account_id', $teacherId);
		foreach ($teacherTable->result() as $row) {
			$parentId = $row->parent_id;
		}

		$studentTable = $this->get_where('student_profile', 'parent_id', $parentId);
		$shStudentTable = $this->get_where('sh_student', 'parent_id', $parentId);

		if ((count($studentTable->result_array()) != 0) || (count($shStudentTable->result_array()) != 0)) {
			return true;
		}else{
			return false;
		}
	}

	function checkIfParentHasMoreThanOneChild()
	{
		$parentId = $_SESSION['parent_account_id'];

		$studentProfileTable = count($this->get_where('student_profile', 'parent_id', $parentId)->result_array());
		$shStudentTable = count($this->get_where('sh_student', 'parent_id', $parentId)->result_array());

		$childCount = $studentProfileTable + $shStudentTable;

		return $childCount;
	}

	function combineChildJhsShs()
	{
		$parentId = $_SESSION['parent_account_id'];
            $allStudents = array();

            $jhsStudentTable = $this->Main_model->get_where('student_profile', 'parent_id', $parentId);
            $shStudentTable = $this->Main_model->get_where('sh_student', 'parent_id', $parentId);

            //combine the students. 

            //extract the tables
            foreach ($jhsStudentTable->result() as $row) {
                $jhsAccountId = $row->account_id;
                $jhsFirstname = $row->firstname;
                $jhsMiddlename = $row->middlename;
                $jhsLastname = $row->lastname;

                $jhsFullName = "$jhsFirstname $jhsMiddlename $jhsLastname";

                $academic_grade_id = 1;

                $jhsData['account_id'] = $jhsAccountId;
                $jhsData['fullname'] = $jhsFullName;
				$jhsData['academic_grade_id'] = 1;
				$jhsData['school_grade_id'] = $row->school_grade_id;
				$jhsData['section_id']  = $row->section_id;

                array_push($allStudents, $jhsData);
            }

            foreach ($shStudentTable->result() as $row) {
                $shsAccountId = $row->account_id;
                $shsFirstname = $row->firstname;
                $shsMiddlename = $row->middlename;
                $shsLastname = $row->lastname;

                $shsFullName = "$jhsFirstname $jhsMiddlename $jhsLastname";

                $shsacademic_grade_id = 2;

                $shsData['account_id'] = $shsAccountId;
                $shsData['fullname'] = $shsFullName;
				$shsData['academic_grade_id'] = 2;
				$shsData['school_grade_id'] = $row->year_level_id;
				$shsData['section_id'] = $row->section_id;

                array_push($allStudents, $shsData);
			}
			
			return $allStudents;
	}

	function exclempetut($academicYear, $sectionId)
	{
		if ($academicYear == 1) {
			$sectionTable = $this->get_where('section', 'section_id', $sectionId);
			foreach ($sectionTable->result() as $row) {
				$sectionName = $row->section_name;
			}
		}else{
			$sectionTable = $this->get_where('sh_section', 'section_id', $sectionId);
			foreach ($sectionTable->result() as $row) {
				$sectionName = $row->section_name;
			}
		}

		return $sectionName;
	}

	function checkIfThereIsNoPrincipal()
	{
		$credentialsTable = $this->get('credentials', 'credentials_id');
		
		if (count($credentialsTable->result_array()) == 0) {
			return true; // there is a principal
		}else{
			return false; // there is a principal
		}
	}

	function registerPrincipalAndSecretary($secretaryData)
	{
		//set the date
		$time['time'] = date("Y/m/d");
		$this->_insert("time", $time);

		//set academic year. 
		$firstYear = date("Y");
		$secondYear = date("Y") + 1;
		$academicYear = "$firstYear-$secondYear";
		$year['time'] = $academicYear;
		$this->_insert("time", $year);

		$principalInfo = $_SESSION['principalInfo'];

		//isnert the principal's information to the faculty table
		$this->_insert('faculty', $principalInfo);

		$principalId = $this->findId('faculty', $principalInfo, 'account_id');
		
		//insert into credentials table 
		$pinCred['username'] = strtolower($principalInfo['firstname'][0].$principalInfo['lastname']);
		$password = rand(00000, 99999);
		$pinCred['password'] = $this->passwordEncryptor($password);

		//text the number
		$number = $principalInfo['mobile_number'];
		$message = "username is: " . strtolower($pinCred['username']) . " and password is: $password";
		$this->itexmo($number, $message);

		$pinCred['administration_id'] = 4;
		$pinCred['academic_grade_id'] = 0;
		$pinCred['account_id'] = $principalId;

		$this->_insert('credentials', $pinCred);

		//INSERTION OF THE SECRETARY
		//isnert the secretarie's information to the faculty table
		$this->_insert('faculty', $secretaryData);

		$secretaryId = $this->findId('faculty', $secretaryData, 'account_id');
		
		//insert into credentials table
		$secCred['username'] = strtolower($secretaryData['firstname'][0].$secretaryData['lastname']);
		$password = rand(00000, 99999);
		$secCred['password'] = $this->passwordEncryptor($password);

		//text the number
		$number = $secretaryData['mobile_number'];
		$message = "username is: " . strtolower($secCred['username']) . " and password is: $password";
		$this->itexmo($number, $message);

		$secCred['administration_id'] = 5;
		$secCred['academic_grade_id'] = 0;
		$secCred['account_id'] = $secretaryId;

		$this->_insert('credentials', $secCred);

		

		$this->session->set_userdata('principalCreated',1);
		redirect("login");
	}

	function secTeacherPrincipalRegister($secretaryData)
	{
		//set the date
		$time['time'] = date("Y/m/d");
		$this->_insert("time", $time);

		//set academic year. 
		$firstYear = date("Y");
		$secondYear = date("Y") + 1;
		$academicYear = "$firstYear-$secondYear";
		$year['time'] = $academicYear;
		$this->_insert("time", $year);

		$principalInfo = $_SESSION['principalInfo'];

		//isnert the principal's information to the faculty table
		$this->_insert('faculty', $principalInfo);

		$principalId = $this->findId('faculty', $principalInfo, 'account_id');
		
		//insert into credentials table
		$pinCred['username'] = strtolower($principalInfo['firstname'][0].$principalInfo['lastname']);
		$password = rand(00000, 99999);
		$pinCred['password'] = $this->passwordEncryptor($password);

		//text the number
		$number = $principalInfo['mobile_number'];
		$message = "username is: " . strtolower($pinCred['username']) . " and password is: $password";
		$this->itexmo($number, $message);

		$pinCred['administration_id'] = 4;
		$pinCred['academic_grade_id'] = 0;
		$pinCred['account_id'] = $principalId;

		$this->_insert('credentials', $pinCred);

		//INSERTION OF THE SECRETARY
		//isnert the secretarie's information to the faculty table
		$this->_insert('faculty', $secretaryData);

		$secretaryId = $this->findId('faculty', $secretaryData, 'account_id');
		
		//insert into credentials table
		$secCred['username'] = strtolower($secretaryData['firstname'][0].$secretaryData['lastname']);
		$password = rand(00000, 99999);
		$secCred['password'] = $this->passwordEncryptor($password);

		//text the number
		$number = $secretaryData['mobile_number'];
		$message = "username is: " . strtolower($secCred['username']) . " and password is: $password";
		$this->itexmo($number, $message);

		$secCred['administration_id'] = 1; // teacher muna siya tapos 
		$secCred['academic_grade_id'] = 1;
		$secCred['account_id'] = $secretaryId;

		$this->_insert('credentials', $secCred);

		

		$this->session->set_userdata('principalCreated',1);
		redirect("login");
	}

	function checkParentNoLeftChild($student_id)
	{	
		//extract the parent id from the student
		$studentTable = $this->get_where('student_profile', 'account_id', $student_id);
		foreach ($studentTable->result() as $row) {
			$parentId = $row->parent_id;
		}
		// find if there are remaning students of that particular parent. 
		$parentsStudentTable = $this->get_where('student_profile', 'parent_id', $parentId);
		if (count($parentsStudentTable->result_array()) == 1) {
			$this->_delete('parent', 'account_id', $parentId);
		}
		
	}

	function getAcademicGradeId()
	{
		$studentId = $_SESSION['student_account_id'];

		$credentialsTable = $this->get_where('credentials', 'account_id', $studentId);
		
		foreach ($credentialsTable->result() as $row) {
			return $row->academic_grade_id;
		}

	}

	function seeAllSessions()
	{
		echo "<pre>" . print_r($_SESSION, true) . "</pre>";
	}

	function getAdviserSectionJhs()
	{
		$facultyId = $_SESSION['faculty_account_id'];
		$adviserSectionTable = $this->get_where('adviser_section', 'faculty_account_id', $facultyId);
		foreach ($adviserSectionTable->result() as $row) {
			return $sectionId = $row->section_id;
		}
	}

	function getAllStudentsInTheSection()
	{
		$sectionId = $this->getAdviserSectionJhs();

		$allStudents = $this->get_where('class_section', 'section_id', $sectionId);

		return $allStudents;

	}

	function banner($upperText, $lowerText)
	{
		echo "	<center class='bg-warning p-3' style='word-wrap:break-word'>";
		echo "		<h1>$upperText</h1>";
		echo "		<hr width='50%' style='margin: 5px 5px'>";
		echo "		<h2>$lowerText</h2>";
		echo "	</center>";
		echo "<div style='margin-bottom:20px'></div>";
	}

	function getStudentNameForStudentGradesTable($studentId)
	{
		$studentTable = $this->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentTable->result() as $row) {
			$firstname = $row->firstname;
			$middlename = $row->middlename;
			$lastname = $row->lastname;
		}
		return "$lastname,$firstname$middlename";
	} 

	function uploadedUnUploaded($grade)
	{
		if ($grade == 0) {
			return "Unuploaded";
		}else{
			return $grade;
		}
	}

	function gradeStatus($final_grade)
	{
		if ($final_grade == 0) {
			return "undetermined";
		}elseif($final_grade < 75){
			return "Failed";
		}elseif($final_grade >= 75){
			return "Passed";
		}
	}

	function getJhsSection()
	{
		$studentId = $_SESSION['student_account_id'];
		$classSectionTable = $this->get_where('class_section', 'student_profile_id', $studentId);
		foreach ($classSectionTable->result() as $row) {
			$section = $row->section_id;
		}
		return $section;
	}

	function getYearLevelId()
	{
		$studentId = $_SESSION['student_account_id'];
		$studentProfileTable = $this->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentProfileTable->result() as $row) {
			$yearLevelId = $row->school_grade_id;
		}
		return $yearLevelId;
	}

	function getSectionFromAdviser()
	{
		$teacherId = $_SESSION['faculty_account_id'];

		$adviserTable = $this->Main_model->get_where('adviser_section', 'faculty_account_id', $teacherId);

		foreach ($adviserTable->result() as $row) {
			$sectionId = $row->section_id;
		}

		return $sectionId;
	}

	function getFailedStudents()
	{
		$teacherId = $_SESSION['faculty_account_id'];

		$sectionId = $this->getSectionFromAdviser();

		$where['section_id'] = $sectionId;
		$where['status'] = 0;
		$ssrTable = $this->multiple_where('student_section_reassignment', $where);

		return $ssrTable;
	}

	function getYearLevelOfAdviser()
	{
		$adviserId = $_SESSION['faculty_account_id'];
		$adviserSectionTable = $this->get_where('adviser_section', 'faculty_account_id', $adviserId);
		
		//extract the year level from section id
		foreach ($adviserSectionTable->result() as $row) {
			$sectionId = $row->section_id;
		}

		$sectionTable = $this->get_where('section', "section_id", $sectionId);
		foreach ($sectionTable->result() as $row) {
			$yearLevelId = $row->school_grade_id;
		}

		return $yearLevelId;
	}

	function thereAreTransferees()
	{
		$transfereeTable = $this->get('transferee', 'transferee_id');
		
		//count if there are transferees
		if (count($transfereeTable->result_array()) == 0) {
			return false;
		}else{
			return true;
		}
	}

	function removeProcessedStudents($student_table)
	{ 
		//get all of the students in the ssr table
		$ssrTable = $this->get('student_section_reassignment', "ssr_id");

		//convert student_table into an multidimensional array
		$student_table = $student_table->result_array();
		$iterator = 0;

		//for each element in the student table hahanapin niya kung may ka 
		//compare ba siya sa ssr table
		foreach ($student_table as $row) {
			$studentAccountId = $row['account_id'];

			//get the account id to match it later. 
			foreach ($ssrTable->result() as $row) {
				$ssrStudentAccountId = $row->student_profile_id;

				//pag nag match siya unset. 
				if ($studentAccountId == $ssrStudentAccountId) {
					unset($student_table[$iterator]);
				}
			}

			//kaya asa labas yung iterator plus kasi index ng student_table yung tatanggalin. 
			$iterator++;
		}

		return $student_table;
	}

	function noCheckedStudents($data, $redirectUrl)
	{
		if (count($data) == 0) {
			$this->session->set_userdata('noCheckedStudents', 1);
			redirect($redirectUrl);
		}
	}

	function noStudentsToBeAcquired() //question in tagalog: wala nabang student na ma aaquire
	{
		$yearLevelId = $this->getAdviserSchoolGradeId();
		$where['year_level_id'] = $yearLevelId - 1;
		$where['status'] = 1;
		$where['academic_grade_id'] = 1;
		
		$ssrTable = $this->multiple_where('student_section_reassignment', $where);

		if (count($ssrTable->result_array()) == 0) {
			//meron siyang nahanap
			return $ssrTable->result_array();
		}else{
			//wala siyang nahanap
			return false;
		}
		
		
	}

	function getAscending($table, $column)
	{
		$this->db->order_by($column, 'DESC');
		$query = $this->db->get($table);
		return $query;
	}

	function getCurrentSchoolYear()
	{
		$timeTable = $this->getAscending('time', 'id');
		foreach ($timeTable->result() as $row) {
			return $row->time;
		}
	}

	function academicYearSetter() // update the year
	{
		$firstDate = date("Y");
		$secondDate = date("Y") + 1;

		$currentYear = "$firstDate-$secondDate";

		//get the year in the database
		$timeTable = $this->get("time", "id");
		
		$iterator = 1;
		foreach ($timeTable->result() as $row) {
			$dbYear = $row->time;
			$timeId = $row->id;
		}

		//check if current year is the same with the database
		if ($currentYear != $dbYear) {
			$update['time'] = $currentYear;
			$this->_update('time', 'id', $timeId, $update);
		}
	}

	function getStrandIdAndTrackId($adviserSectionId)
	{
		$accountId = $_SESSION['faculty_account_id'];
		$shSectionTable = $this->get_where("sh_adviser", "faculty_id", $accountId);
		foreach ($shSectionTable->result() as $row) {
			$strandId = $row->strand_id;
		}

		//getTrackId
		$trackId = $this->getTrackIdFromStrandId($strandId);
		
		//store the variables
		$data['strandId'] = $strandId;
		$data['trackId'] = $trackId;

		return $data;
	}

	function getShsAdviserInformation() //sectionId, sectionName, yearLevelId, trackId, strandId
	{
		$teacherId = $_SESSION['faculty_account_id'];

		$where['faculty_id'] = $teacherId; 
		$adviserTable = $this->multiple_where('sh_adviser', $where);
		foreach ($adviserTable->result() as $row) {
			$yearLevel = $row->year_level;
			$strandId = $row->strand_id;
			$sectionId = $row->section_id;
		}
		
		//get track id
		$trackId = $this->getTrackIdFromStrandId($strandId);
		
		//store id
		$data['yearLevelId'] = $yearLevel;
		$data['trackId'] = $trackId;
		$data['strandId'] = $strandId;
		$data['sectionId'] = $sectionId;

		//store names
		$data['yearLevelName'] = $this->getYearLevelNameFromId($yearLevel);
		$data['trackName'] = $this->getTrackName($trackId);
		$data['strandName'] = $this->getStrandName($strandId);
		$data['sectionName'] = $this->getShsSectionNameFromId($sectionId);

		return $data;
	}	

	function getMobileNumber($table, $column, $id)
	{
		$table =   $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			$mobileNumber  = $row->mobile_number;
		}
		return $mobileNumber;
	}

	function getId($table, $column, $id, $rowId)
	{
		$table = $this->get_where($table, $column, $id);
		foreach ($table->result() as $row) {
			return $accountId = $row->$rowId;
		}
	}

	function turnicateTable($table, $columnIdName)
	{
		echo "table: $table <br>";
		$tables = $this->just_get_everything($table);
		foreach ($tables->result() as $row) {
			$id = $row->$columnIdName;
			$this->_delete($table, $columnIdName, $id);
		}
	}

	function ifSecTeacherSetUnsetIt()
	{
		if (isset($_SESSION['secretaryTeacher'])) {
			unset($_SESSION['secretaryTeacher']);
		}
	}

	function secretaryTeacherChecker()
	{
		$teacherId = $_SESSION['faculty_account_id'];

		//first case. secretary only
		$whereFirstCase['account_id'] = $teacherId;
		$whereFirstCase['administration_id'] = 5;
		
		$fisrtCaseTable = $this->multiple_where('credentials', $whereFirstCase);

		if (count($fisrtCaseTable->result_array()) != 0) {
			return 1; // secretary lang siya
		}else{
			//kapag hindi siya case 1 magiging case 2 siya

			//second case. secretary teacher
			$whereSecondCase['account_id'] = $teacherId;
			$whereSecondCase['sec_account'] = 1;
			
			$secondCaseTable = $this->multiple_where('faculty', $whereSecondCase);

			if (count($secondCaseTable->result_array()) != 0) {
				return 2;//secretary teacher siya
			}else{
				return false;
			}
		}
	}


	function GetPreviousSecretaryId()
	{
		$search1 = $this->get_where('credentials', 'administration_id', 5);
		$search2 = $this->get_where('faculty', 'sec_account', 1);

		if (count($search1->result_array()) != 0) {
			foreach ($search1->result() as $row) {
				return $accountId = $row->account_id;
			}
		}elseif (count($search2->result_array()) != 0) {
			foreach ($search2->result() as $row) {
				return $accountId = $row->account_id;
			}
		}
	}

	function showNormalArray($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function updateNewSecretary($newSecConfirm, $firstname, $middlename, $lastname, $mobileNumber, $teacherId)
	{
		//create new secretary (insert new record from input), 'will the new sec be a teacher?' if condition
		if ($newSecConfirm == true) {
			//new secretary will be a teacher; yes ; perform new secretary insertion

			//faculty table insertion
			$newSecFaculty['sec_account'] = 1;
			$this->_update('faculty', 'account_id', $teacherId, $newSecFaculty);

			
			$newSecCred['administration_id'] = 1; // jhs teacher muna
			$this->Main_model->_update('credentials', 'account_id', $teacherId, $newSecCred);

			// notify and redirect
			$this->session->set_userdata('newSecReg', 1);
			redirect("manage_user_accounts/manage_account");

		}else{
			//new secretary will NOT be a teacher; no ; perform new secretary insertion
			//faculty table insertion
			$newSecFaculty['sec_account'] = 0;
			$this->_update('faculty', 'account_id', $teacherId, $newSecFaculty);


			$newSecCred['administration_id'] = 5; // jhs teacher muna
			$this->Main_model->_update('credentials', 'account_id', $teacherId, $newSecCred);

			// notify and redirect
			$this->session->set_userdata('newSecReg', 1);
			redirect("manage_user_accounts/manage_account");
			
		}	
	}

	function assignNewSecretary($firstname, $middlename, $lastname, $mobileNumber, $teacherConfirm, $newSecConfirm, $teacherId)
	{		
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

					//manage new secretary
					$this->updateNewSecretary($newSecConfirm, $firstname, $middlename, $lastname, $mobileNumber, $teacherId);


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

					//manage new secretary
					$this->updateNewSecretary($newSecConfirm, $firstname, $middlename, $lastname, $mobileNumber, $teacherId);

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

					//manage new secretary
					$this->updateNewSecretary($newSecConfirm, $firstname, $middlename, $lastname, $mobileNumber, $teacherId);

				}else{

					//"Previous sec will NOT become a teacher"; previous secretary will RESIGN;
					$previousSecretary = $this->Main_model->getId('credentials', 'administration_id', 5, 'account_id');

					//delete the previous secretary since he will not be a teacher nor a secretary anymore
					$this->Main_model->_delete('faculty', 'account_id', $previousSecretary);
					$this->Main_model->_delete('credentials', 'account_id', $previousSecretary);

					//manage new secretary
					$this->updateNewSecretary($newSecConfirm, $firstname, $middlename, $lastname, $mobileNumber, $teacherId);
					
				}
			}
	}

	function checkIfFacultyParent()
	{
		$parentId = $_SESSION['parent_account_id'];
		$facultyTable = $this->get_where('faculty', 'parent_id', $parentId);
		if (count($facultyTable->result_array()) != 0) {
			//faculty parent siya.
			return true;
		}else{
			//hindi siya faculty parent. 
			return false;
		}
	}

	function checkIfSchoolGradeHasStudents($schoolGradeId)
	{
		$table = $this->get_where('student_profile', 'school_grade_id', $schoolGradeId);
		if (count($table->result_array()) != 0) {
			//meron siyang nahanap
			return true;
		}else{
			//wala siyang nahanap
			return false;
		}
	}

	function getPassword($accountId)
	{
		$table = $this->get_where('credentials', 'account_id', $accountId)->result_array();
		return $table[0]['password'];
	}

	function makePasswordsPotpot($potpotPassword)
	{
		$table = $this->get('credentials', 'account_id');
		foreach ($table->result() as $row) {
			$update['password'] = $potpotPassword;
			$this->_update('credentials', 'credentials_id', $row->credentials_id, $update);
		}
	}

	function removeAlreadyAquiredSubjects($uiSubjectTable)
	{
		$index = 0;
		$uiSubjectTable = $uiSubjectTable->result_array();
		// echo $uiSubjectTable[0];
		// die;
		
		foreach ($uiSubjectTable as $row) {
			$uiSubject = $row['subject_id'];
			
			//hahanapin mo siya isa isa
			$teacherLoadTable = $this->get_where('teacher_load', 'subject_id', $uiSubject);
			if (count($teacherLoadTable->result_array()) != 0) {
				//may nakakuha na sa subject na ito sa tacher load table
				unset($uiSubjectTable[$index]);
			}

			$index+= 1;
		}

		return $uiSubjectTable;
	}

	function getYearLevelFromTeacherLoad($teacherLoadId)
	{
		$table = $this->get_where('teacher_load', 'teacher_load_id', $teacherLoadId);
		foreach ($table->result() as $row) {
			return $row->grade_level;
		}
	}

	function removeCurrentYearLevel($yearLevel, $school_grade_table)
	{
		$index = 0;
		$table = $school_grade_table->result_array();

		foreach ($table as $row) {
			$yearLevelId = $row['school_grade_id'];

			if ($yearLevelId == $yearLevel) {
				unset($table[$index]);
				
			}

			$index+= 1;
		}

		return $table;
	}

	function checkIfShStudentIsActive($studentId)
	{
		$table = $this->get_where('sh_student', 'account_id', $studentId);
		foreach ($table->result() as $row) {
			$status = $row->status;
		}
		
		if ($status == 1) {
			return true;
		}else{
			return false;
		}
	}

	function getSubjectDataFromShTeacherLoad($array)
	{
		$table = $this->multiple_where('sh_teacher_load', $array);
		foreach ($table->result() as $row) {
			$data['trackId'] = $row->track_id;
			$data['strandId'] = $row->strand_id;
			$data['yearLevelId'] = $row->year_level;
			$data['subjectId']  = $row->sh_subject_id;
			$data['sectionId'] = $row->sh_section_id;
			$data['schedule'] = $row->schedule;
			$data['semester'] = $row->semester;
			$data['quarter'] = $row->quarter;
			$data['facultyAccountId'] = $row->faculty_account_id;
			$data['school_year'] = $row->school_year;
		}

		return $data;
	}

	function getCustomClassName($customClassId)
	{
		$table = $this->get_where('custom_class', 'id', $customClassId);
		foreach ($table->result() as $row) {
			return $row->name;
		}
	}

	function getCustomClassSubjectName($customClassId)
	{
		$table = $this->get_where('custom_class', 'id', $customClassId);
		foreach ($table->result() as $row) {
			$subjectId = $row->sh_subject_id;
		}

		$subjectName = $this->getShSubjectNameFromId($subjectId);
		return $subjectName;
	}

	function getCustomClassIdFromGroupId($customClassGroupId)
	{
		$table = $this->get_where('custom_class_group', 'id', $customClassGroupId);
		foreach ($table->result() as $row) {
			return $row->custom_class_id;
		}
	}

	function getStudentNameFromCustomClassGroup($classGroupId)
	{
		$table = $this->get_where('custom_class_group', 'id', $classGroupId);
		foreach ($table->result() as $row) {
			$studentId = $row->sh_student_id;
		}

		$studentName = $this->getFullName('sh_student', 'account_id', $studentId);

		return $studentName;
	}


} //class end
