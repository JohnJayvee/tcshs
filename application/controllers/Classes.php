<?php
class Classes extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model');
		$this->Main_model->accessGranted();
	}



	function fetch()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			echo $this->autocomplete_model->fetch_data($this->uri->segment(3));
		} else {
			redirect('main_controller/login');
		}
	}

	function add_subject()
	{ 
		$this->Main_model->alertPromt('Subject deleted', "subjectDeleted");
		$permission = $this->Main_model->access_granted();
		$yearLevelId = $this->uri->segment(3);
		if ($permission == 1) {

			
			$this->form_validation->set_rules('subject', 'Subject', 'required');

			if ($this->form_validation->run()) {

				$data['subject_name'] = $this->input->post('subject');
				$data['school_grade_id'] = $this->input->post('yearLevelId');
				$yearLevelId = $data['school_grade_id'];
				$this->session->set_userdata('subjectCreated', 1);
				$this->Main_model->_insert('subject', $data);
				redirect('classes/add_subject/' . $yearLevelId);
			}

			$data['subject_table'] = $this->Main_model->get_where('subject', 'school_grade_id', $yearLevelId);
			$yearLevelTable = $this->Main_model->get_where('school_grade', 'school_grade_id', $yearLevelId);

			foreach ($yearLevelTable->result_array() as $row) {
				$yearLevelName = $row['name'];
			}

			$data['yearLevelName'] = $yearLevelName;
			$data['yearLevelId'] = $yearLevelId;

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('classes/add_subject', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function delete_subject()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$subject_id = $this->uri->segment(3);
			$classifier = $this->uri->segment(4);


			$data['subject_table'] = $this->Main_model->get_where('subject', 'subject_id', $subject_id);

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/confirm_delete', $data);
			$this->load->view('includes/main_page/admin_cms/footer');

			//confirmation niya yung classifier na yan
			if ($classifier == 1) {
				//populate g10_subject_repository
				$subjectTable = $this->Main_model->get_where('subject', 'subject_id', $subject_id);
				foreach ($subjectTable->result() as $row) {
					$insert['subject_id'] = $row->subject_id;
					$insert['subject_name'] = $row->subject_name;
					$insert['school_grade_id'] = $row->school_grade_id;
				}
				$this->Main_model->_insert('g10_subject_repository', $insert);

				$yearLevelId = $this->input->get('yearLevelId');
				$this->Main_model->_delete('subject', 'subject_id', $subject_id);
				
				$this->session->set_userdata('subjectDeleted', 1);
				redirect('classes/add_subject/' . $yearLevelId);
			}
		} else {
			redirect('main_controller/login');
		}
	}



	//dito na papasok kapag merong junior highschool
	function selectYearLevel()
	{
		$data['schoolGradeTable'] = $this->Main_model->just_get_everything("school_grade");
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('classes/selectYearLevel', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}



	function DeleteYearGrade()
	{
		$schoolGradeId = $this->uri->segment(3);
		$schoolYearTable = $this->Main_model->get_where('school_grade', 'school_grade_id', $schoolGradeId);
		foreach ($schoolYearTable->result_array() as $row) {
			$scholGradeId = $row['school_grade_id'];
			$name = $row['name'];
		}
		$data['schoolGradeId'] = $schoolGradeId;
		$data['name'] = $name;

		if (isset($_GET['delete'])) {


			//populate the g10_year_level_repository
			$repo['school_grade_id'] = $schoolGradeId;
			$repo['name'] = $name;

			//insert into repository
			$this->Main_model->_insert('grade_10_year_level_repository', $repo);

			//also delete the sections that have that school year id
			$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $schoolGradeId);
			foreach ($sectionTable->result() as $row) {
				$this->Main_model->_delete('section', 'section_id', $row->section_id);
			}

			$id = $this->input->get('delete');
			$this->Main_model->_delete('school_grade', 'school_grade_id', $id);
			$this->session->set_userdata('yearDeleted', 1);
			redirect('classes/selectYearLevel');
		}

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/deleteYear', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function add_section()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {
			$yearLevelId = $this->input->get('yearLevelId');
			$this->form_validation->set_rules('section', 'Section', 'required');

			if ($this->form_validation->run()) {

				$data['section_name'] = ucfirst($this->input->post('section'));
				$data['school_year'] = $this->Main_model->getAcademicYear();
				$examine['section_name'] = $this->input->post('section');
				$data['school_grade_id'] = $this->input->post('YearLevelId');

				$section_table = $this->Main_model->multiple_where('section', $examine);

				foreach ($section_table->result_array() as $row) {
					$section_name = $row['section_name'];
				}

				if (isset($section_name)) {
					$this->session->set_userdata('sameSection', 1);
					redirect("classes/add_section?yearLevelId=" . $this->input->post('YearLevelId'));
				} else {
					$this->Main_model->_insert('section', $data);
					$this->session->set_userdata('sectionCreated', 1);
					redirect("classes/add_section?yearLevelId=" . $this->input->post('YearLevelId'));
				}
			}

			$data['section_table'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
			$yearLevelTable = $this->Main_model->get_where('school_grade', 'school_grade_id', $yearLevelId);
			$sectionLevel = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
			foreach ($yearLevelTable->result_array() as $row) {
				$yearLevelName = $row['name'];
			}
			$data['yearLevelName'] = $yearLevelName;
			$data['yearLevelId'] = $yearLevelId;
			$data['yearLevelTableCount'] = count($sectionLevel->result_array());

			$this->load->view('includes/main_page/admin_cms/secretaryNav');
			$this->load->view('classes/add_section', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function delete_section()
	{
		$permission = $this->Main_model->access_granted();



		$section_id = $this->uri->segment(3);
		$classifier = $this->uri->segment(4);
		$yearLevel = $this->input->get('yearLevel');
		$data['section_table'] = $this->Main_model->get_where('section', 'section_id', $section_id);

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/confirm_delete_section', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		if ($classifier == 1) {

			//get the section table
			$section_table = $this->Main_model->get_where('section', 'section_id', $section_id);
			foreach ($section_table->result() as $row) {
				$section_id = $row->section_id;
				$section_name = $row->section_name;
				$school_year = $row->school_year;
				$school_grade_id = $row->school_grade_id;
			}

			//populate grade10_section_repository
			$repo['section_id'] = $section_id;
			$repo['section_name'] = $section_name;
			$repo['school_year'] = $school_year;
			$repo['school_grade_id'] = $school_grade_id;

			//insert repository
			$this->Main_model->_insert('g10_section_repository', $repo);

			//manage notification 
			$this->session->set_userdata('sectionDelete', 1);

			$this->Main_model->_delete('section', 'section_id', $section_id);
			redirect("classes/add_section/" . $yearLevel);
		}
	}

	function selectYearSubject()
	{
		$data['schoolYearTable'] = $this->Main_model->get_where('school_grade', 'academic_grade_id', 1);
		$this->load->view('includes/main_page/admin_cms/secretaryNav');
		$this->load->view('classes/selectYearSubject', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	//dito na yung pang select mo para sa manage classes
	function selectYearSubjectClasses() //you will select the year level
	{
		$data['schoolYearTable'] = $this->Main_model->get('school_grade', 'school_grade_id');

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/selectYearSubjectClasses', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function selectSectionClasses() //you will select the SECTION
	{
		$yearlevelId = $this->input->get('yearLevelId');

		$data['sectionTable'] = $this->Main_model->get_where('section', 'school_grade_id', $yearlevelId);
		$data['yearLevelId'] = $yearlevelId;
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearlevelId);

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/selectSectionClasses', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function realtimeClasses()
	{
		if (isset($_POST['yearLevelId'])) {
			//define variables
			$yearLevelId = $this->input->post('yearLevelId');
			$sectionId = $this->input->post('sectionId');

			$where['school_grade_id'] = $yearLevelId;
			$where['section_id'] = $sectionId;
			$classTable = $this->Main_model->multiple_where('class', $where);

			//construct table


			foreach ($classTable->result_array() as $row) {
				$class_id = $row['class_id'];
				$subject_id = $row['subject_id'];
				$faculty_id = $row['faculty_id'];
				$class_sched = $row['class_sched'];
				$student_profile_id = $row['student_profile_id'];
				$section_id = $row['section_id'];
				$school_grade_id = $row['school_grade_id'];

				echo "<tr>";
				echo 	"<td>";
				echo 		$this->Main_model->grade10SubjectRepositoryManager($subject_id);
				echo 	"</td>";

				echo 	"<td>";
				echo 		$this->Main_model->facultyRepository($faculty_id);
				echo 	"</td>";

				echo 	"<td>";
				echo 		strtoupper($class_sched);
				echo 	"</td>";

				echo 	"<td>";
				echo 		$this->Main_model->g10StudentRepositoryManager($student_profile_id);
				echo 	"</td>";
				echo "</tr>";
			}
		} //isset
	}


	function manage_classes()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {
			$yearlevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			//send yearLevelid etc..
			$data['yearLevelId'] = $yearlevelId;
			$data['sectionId'] = $sectionId;


			//send names
			$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearlevelId);
			$data['sectionName'] =  $this->Main_model->getSectionNameFromId($sectionId);

			$where['school_grade_id'] = $yearlevelId;
			$where['section_id'] = $sectionId;
			$data['classTable'] = $this->Main_model->multiple_where('class', $where);

			$data['subjectTable'] = $this->Main_model->get_where('subject', 'school_grade_id', $yearlevelId);


			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/manage_classes', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function filterClassWithSubject()
    {   
        
        if (isset($_POST['subjectId'])) {
            $subjectId = $this->input->post('subjectId');
			echo "subjectId: $subjectId";
			
            $where['subject_id'] = $subjectId;
            $where['section_id'] = $this->input->post('sectiionId');
            $where['school_grade_id'] = $this->input->post('yearLevel');
			$classTable = $this->Main_model->multiple_where('class', $where);
			
            if (count($classTable->result_array()) == 0) {
                echo "<td><h6>There are no records for that subject</h6></td>";
            }else{
                foreach ($classTable->result() as $row) {
                    echo "<tr>";
                    echo "    <td>" .$this->Main_model->getSubjectNameFromId($row->subject_id). "</td>";
                    echo "    <td>" .$this->Main_model->getFullName('faculty', 'account_id', $row->faculty_id). "</td>";
                    echo "    <td>" .$this->Main_model->g10StudentRepositoryManager($row->student_profile_id). "</td>";
                    echo "    <td>" .$row->class_sched. "</td>";
                    echo "</tr>";
                }
            }
        }
    }

	function classManagementFilterStudent()
	{	
		if (isset($_POST['subjectId'])) {

			$subjectId = $this->input->post('subjectId');
			$facultyAccoutnId = $_SESSION['faculty_account_id'];
			
			$where['subject_id'] = $subjectId;
			$where['faculty_id'] = $facultyAccoutnId;

			$classTable = $this->Main_model->multiple_where('class', $where);
			
			foreach ($classTable->result() as $row) {
				echo 	"<tr>";
				echo 	"	<td>".$this->Main_model->getYearLevelNameFromId($row->school_grade_id)."</td>";
				echo 	"	<td>".$this->Main_model->grade10SectionRepositoryManager($row->section_id)."</td>";
				echo 	"	<td>".$row->class_sched."</td>";
				echo 	"	<td>".$this->Main_model->grade10SubjectRepositoryManager($row->subject_id)."</td>";
				echo 	"	<td>".$this->Main_model->g10StudentRepositoryManager($row->student_profile_id)."</td>";
				echo 	"</tr>";
			}
		}
	}

	function personalSubjects()
	{
		$currentSchoolYear = $this->Main_model->getCurrentSchoolYear();
		$accountId = $_SESSION['faculty_account_id'];

		$where['faculty_account_id'] = $accountId;
		$where['school_year'] = $currentSchoolYear;
		$data['teacherLoadTable'] = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $accountId);
	
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/personalSubjects', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function sortBySubjectsPs()
    {
		$accountId = $_SESSION['faculty_account_id'];
		$currentSchoolYear = $this->Main_model->getCurrentSchoolYear();
        if (isset($_POST['subjectId'])) {
            $subjectId = $this->input->post('subjectId');

            $where['faculty_account_id'] = $accountId;
			$where['subject_id'] = $subjectId;
			$where['school_year'] = $currentSchoolYear;
			$teacherLoadTable = $this->Main_model->multiple_where('teacher_load', $where);
			
			if (count($teacherLoadTable->result_array()) != 0) {
				foreach ($teacherLoadTable->result() as $row) { 
					echo "<div class='card' style='width: 18rem;'> ";
					echo "    <div class='card-body'> ";
					echo "        <h5 class='card-title'>".$this->Main_model->getSubjectNameFromId($row->subject_id)."</h5> ";
					echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getSectionNameWithId($row->section_id) ." | ". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</h6> ";
					echo "<br>";
					$enter = base_url() . "shs/viewPesonalSubjects?subjectId=$row->subject_id&sectionId=$row->section_id&yearLevel=$row->grade_level";
					echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
					echo "    </div> ";
					echo "</div> ";
				}
			}else{
				//the user has selected nothing
				$loadTable = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $accountId);
				foreach ($loadTable->result() as $row) {
					echo "<div class='card' style='width: 18rem;'> ";
					echo "    <div class='card-body'> ";
					echo "        <h5 class='card-title'>".$this->Main_model->getSubjectNameFromId($row->subject_id)."</h5> ";
					echo "        <h6 class='card-subtitle mb-2 text-muted'>". $this->Main_model->getSectionNameWithId($row->section_id) ." | ". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</h6> ";
					echo "<br>";
					$enter = base_url() . "classes/viewPesonalSubjects?subjectId=$row->subject_id&sectionId=$row->section_id&yearLevel=$row->grade_level";
					echo "        <a href='". $enter ."'><button class='btn btn-primary col-md-12'><i class='fas fa-eye'></i>Enter</button></a> ";
					echo "    </div> ";
					echo "</div> ";
				}
			}
        }
	}
	
	function viewPesonalSubjects()
    {
        //collect id
        $accountId = $_SESSION['faculty_account_id'];
        $subjectId = $this->input->get('subjectId');
        $sectionId = $this->input->get('sectionId');
		$yearLevel = $this->input->get('yearLevel');
		
		//get current school year
		$currentSchoolYear = $this->Main_model->getCurrentSchoolYear();

        //get classes table
        $where['subject_id'] = $subjectId;
        $where['section_id'] = $sectionId;
		$where['school_grade_id'] = $yearLevel;
		$where['faculty_id'] = $accountId;
		$where['school_year'] = $currentSchoolYear;
        $data['ClassTable'] = $this->Main_model->multiple_where('class', $where);
        $data['subjectTable'] = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $accountId);
		
        //send names
        $data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevel);
        $data['sectionName'] = $this->Main_model->getSectionNameWithId($sectionId);
        $data['subjectName'] = $this->Main_model->getSubjectNameFromId($subjectId);

        //send id
        $data['subjectId'] = $subjectId;
        $data['sectionId'] = $sectionId;
        $data['yearLevelId'] = $yearLevel;

        $this->load->view('includes/main_page/admin_cms/shsNav');
		$this->load->view('classes/viewPesonalSubjects', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
    }

	function delete_class()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {



			$class_id = $this->uri->segment(3);
			$classifier = $this->uri->segment(4);

			$data['class_table'] = $this->Main_model->get_where('class', 'class_id', $class_id);

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/confirm_delete_class', $data);
			$this->load->view('includes/main_page/admin_cms/footer');

			if ($classifier == 1) {
				$this->Main_model->_delete('class', 'class_id', $class_id);
				redirect('classes/manage_classes');
			}
		} else {
			redirect('main_controller/login');
		}
	}

	function update_class()
	{

		$class_id = $this->uri->segment(3);


		$class_table = $this->Main_model->get_where('class', 'class_id', $class_id);
		foreach ($class_table->result_array() as $row) {
			$subject_id = $row['subject_id'];
			$faculty_id = $row['faculty_id'];
			$class_schedule = $row['class_sched'];
			$student_profile_id = $row['student_profile_id'];
			$section_id = $row['section_id'];
			$school_grade_id = $row['school_grade_id'];
		}

		$data['class_id'] = $class_id;
		$data['subject_id'] = $subject_id;
		$data['faculty_id'] = $faculty_id;
		$data['class_schedule'] = $class_schedule;
		$data['student_profile_id'] = $student_profile_id;
		$data['section_id'] = $section_id;
		$data['school_grade_id'] = $school_grade_id;


		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/edit_class', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	} //update class

	function update_class_proc()
	{
		if (isset($_POST['submit'])) {
			$class_id = $this->uri->segment(3);

			$data['subject_id'] = $this->input->post('subject');
			$data['faculty_id'] = $this->input->post('teacher');
			$data['class_sched'] = $this->input->post('class_schedule');
			$data['student_profile_id'] = $this->input->post('student');
			$data['section_id'] = $this->input->post('section');
			$data['school_grade_id'] = $this->input->post('school_grade');

			$this->Main_model->_update('class', 'class_id', $class_id, $data);

			redirect('classes/manage_classes');
		}
	}

	function update_section()
	{

		if (isset($_POST['submit'])) {
			$newSectionName = $this->input->post('newSectionName');
			$section_id = $this->input->get('update');

			$data['section_name'] = $newSectionName;
			$this->Main_model->_update('section', 'section_id', $section_id, $data);
			redirect('classes/add_section');
		} else {

			$section_id = $this->uri->segment(3);

			$section_table = $this->Main_model->get_where('section', 'section_id', $section_id);
			foreach ($section_table->result_array() as $row) {
				$section_name = $row['section_name'];
			}

			$data['section_name'] = $section_name;
			$data['section_id'] = $section_id;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/editSection', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function yearSelectionTeacherLoad()
	{
		$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'name');

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/yearSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function sectionSelectionTeacherLoad()
	{
		$yearLevelId = $this->input->get('yearLevelId');
		// echo "year level id: $yearLevelId";
		$data['sectionTable'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
		$data['yearLevelId'] = $yearLevelId;
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/sectionSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function subjectSelectionTeacherLoad()
	{
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');

		$data['subjectTable'] = $this->Main_model->get_where('subject', 'school_grade_id', $yearLevelId);

		//check if there are no subjects created
		if (count($data['subjectTable']->result_array()) == 0) {
			echo "<script>";
			echo "alert('ask the secretary to create subjects');";
			echo "</script>";
		}

		$data['yearLevelId'] = $yearLevelId;
		$data['sectionId'] = $sectionId;
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
		$data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/subjectSelectionTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function teacher_load()
	{
		if (isset($_GET['edit'])) {
			$teacher_id = $_SESSION['faculty_account_id'];
			$teacher_load_id = $this->input->get('edit');
			$data['subject_id'] = $this->input->post('subject');
			$data['grade_level'] = $this->input->post('school_year_grade');
			$data['schedule'] = $this->input->post('schedule');
			// $data['faculty_account_id'] = $this->input->post('teacher_id');
			$data['faculty_account_id'] = $teacher_id;
			$data['section_id'] = $this->input->post('section');

			//class update
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'teacher_load_id', $teacher_load_id);
			foreach ($teacherLoadTable->result() as $row) {
				$updateWhere['faculty_id'] = $row->faculty_account_id;
				$updateWhere['subject_id'] = $row->subject_id;
				$updateWhere['school_grade_id'] = $row->grade_level;
				$updateWhere['section_id'] = $row->section_id;
			}

			//update class
			$update['subject_id'] = $this->input->post('subject');
			$update['class_sched'] =  $this->input->post('schedule');
			$update['section_id'] = $this->input->post('section');
			$update['school_grade_id'] = $this->input->post('school_year_grade');

			$this->Main_model->_multi_update('class', $updateWhere, $update);

			$this->Main_model->_update('teacher_load', 'teacher_load_id', $teacher_load_id, $data);
			redirect('classes/viewPersonalTeacherLoad');
		}

		//DUPLICATION CHECKER
		$yearLevelId = $this->input->get('yearLevelId');
		$sectionId = $this->input->get('sectionId');
		$subjectId = $this->input->get('subjectId');
		$facultyId = $_SESSION['faculty_account_id'];

		$array['grade_level'] = $yearLevelId;
		$array['section_id'] = $sectionId;
		$array['subject_id'] = $subjectId;

		$teacherLoadTable = $this->Main_model->multiple_where('teacher_load', $array);

		$teacherLoadTableCount = count($teacherLoadTable->result_array());


		if ($teacherLoadTableCount != 0) {

			foreach ($teacherLoadTable->result() as $row) {
				$teacherId = $row->faculty_account_id;
			}
			$teacherName = $this->Main_model->getFullname('faculty', 'account_id', $teacherId);

			$this->session->set_userdata('loadExist', 1);
			redirect("classes/subjectSelectionTeacherLoad?yearLevelId=$yearLevelId&sectionId=$sectionId");
		}


		$this->form_validation->set_rules('schedule', 'Schedule', 'required');
		if ($this->form_validation->run()) {
			//para sa teacher load table.
			$data['subject_id'] = $this->input->get('subjectId');
			$data['schedule'] = $this->input->post('schedule');
			$data['grade_level'] = $this->input->get('yearLevelId');
			$data['faculty_account_id'] = $this->input->post('teacher');
			$data['section_id'] = $this->input->get('sectionId');
			$data['academic_year'] = $this->Main_model->getAcademicYear();

			$array['subject_id'] = $this->input->get('subjectId');
			$array['schedule'] = $this->input->post('schedule');
			$array['grade_level'] = $this->input->get('yearLevelId');
			$array['faculty_account_id'] = $this->input->post('teacher');
			$array['section_id'] = $this->input->get('sectionId');

			//CLASS CREATOR LOOPING FOR SECTIONS
			$class_section_table = $this->Main_model->get_where('class_section', 'section_id', $data['section_id']);



			foreach ($class_section_table->result_array() as $row) {
				$class_section_id = $row['class_section_id'];
				$student_profile_id = $row['student_profile_id'];

				$classData['subject_id'] = $data['subject_id'];
				$classData['faculty_id'] = $data['faculty_account_id'];
				$classData['class_sched'] = $data['schedule'];
				$classData['student_profile_id'] = $student_profile_id;
				$classData['section_id'] = $data['section_id'];
				$classData['school_grade_id'] = $data['grade_level'];
				$classData['school_year'] = $this->Main_model->getAcademicYear();

				$this->Main_model->_insert('class', $classData);
			}

			$this->Main_model->_insert('teacher_load', $data);
			$this->session->set_userdata('teacherLoad', 1);
			redirect("classes/yearSelectionTeacherLoad");
		}

		$credentials_table = $this->Main_model->get('credentials', 'credentials_id');

		foreach ($credentials_table->result_array() as $row) {
			$administration_id = $row['administration_id'];
			if ($administration_id == 4) {
				$data['principal_account_id'] = $row['account_id'];
			}
		}

		$teacher_id = $_SESSION['faculty_account_id'];
		$faculty_table = $this->Main_model->get_where('faculty', 'account_id', $teacher_id);
		foreach ($faculty_table->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
		}

		$data['teacher_fullname'] = "$firstname $middlename $lastname";
		$data['subject_table'] = $this->Main_model->get('subject', 'subject_id');
		$data['faculty_account_id'] = $_SESSION['faculty_account_id'];
		$data['section_table'] = $this->Main_model->get('section', 'section_id');
		$data['school_grade_table'] = $this->Main_model->get('school_grade', 'school_grade_id');

		$subject_table = $this->Main_model->just_get_everything('subject');
		foreach ($subject_table->result_array() as $row) {
			$subject_id = $row['subject_id'];
		}

		if (!isset($subject_id)) {
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/no_subjects_yet');
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');
			$subjectId = $this->input->get('subjectId');

			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;
			$data['subjectId'] = $subjectId;

			$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
			$data['sectionName'] = $this->Main_model->getSectionNameFromId($sectionId);
			$data['subjectName'] = $this->Main_model->getSubjectNameFromId($subjectId);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/assign_teacher_load', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function view_teacher_load()
	{
		$data['yearLevelId'] = $this->input->get('yearLevelId');
		$data['sectionId'] = $this->input->get('sectionId');
		$data['subjectId'] = $this->input->get('subjectId');
		$data['teacher_load_table'] = $this->Main_model->get('teacher_load', 'teacher_load_id');
		
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/view_teacher_load', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function personalLoad()
	{
		$faculty_id = $_SESSION['faculty_account_id'];
		$data['teacherpersonalLoad'] = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $faculty_id);

		$data['yearLevelId'] = $this->input->get('yearLevelId');
		$data['sectionId'] = $this->input->get('sectionId');
		$data['subjectId'] = $this->input->get('subjectId');
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/personalLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function edit_teacher_load()
	{
		$teacher_load_id = $this->uri->segment(3);

		$yearLevel = $this->Main_model->getYearLevelFromTeacherLoad($teacher_load_id);
		$data['teacher_load_id'] = $teacher_load_id;

		$data['teacher_load_table'] = $this->Main_model->get_where('teacher_load', 'teacher_load_id', $teacher_load_id);
		
		//kung gusto niyang mag palit ng year level dapat ilalagay na niya muna
		//para mag reset yung selection.
		$subject_table = $this->Main_model->get_where('subject', 'school_grade_id', $yearLevel); 
		$data['faculty_table'] = $this->Main_model->get_where('faculty', 'account_id', $_SESSION['faculty_account_id']);

		foreach ($data['faculty_table']->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
		}

		$data['teacher_fullname'] = "$firstname $middlename $lastname";
		$data['section_table'] = $this->Main_model->just_get_everything('section');
		$school_grade_table = $this->Main_model->get('school_grade', 'school_grade_id');
		
		//remove the year level that is currently in edit
		$data['school_grade_table'] = $this->Main_model->removeCurrentYearLevel($yearLevel, $school_grade_table);
	
		$subjectResult = $this->Main_model->removeAlreadyAquiredSubjects($subject_table);
		$data['subject_table'] = $subjectResult;
	
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/edit_assign_teacher_load', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function delete_teacher_load()
	{
		$teacher_load_id = $this->uri->segment(3);

		//perform delete validation;

		//get teacher name
		$teacherName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $_SESSION['faculty_account_id']);

		//get teacher load table 
		$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'teacher_load_id', $teacher_load_id);

		//extract data to be used for names
		foreach ($teacherLoadTable->result() as $row) {
			$subjectName = $this->Main_model->getSubjectNameFromId($row->subject_id);
			$schedule = $row->schedule;
			$sectionName = $this->Main_model->getSectionNameFromId($row->section_id);
			$yearLevelName = $this->Main_model->getYearLevelNameFromId($row->grade_level);
		}


		//send the data
		$data['teacherLoadId'] = $teacher_load_id;
		$data['teacherName'] = $teacherName;
		$data['teacherLoadTable'] = $teacherLoadTable;
		$data['subjectName'] = $subjectName;
		$data['schedule'] = $schedule;
		$data['sectionName'] = $sectionName;
		$data['yearLevelName'] = $yearLevelName;

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/delete_teacher_load', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

		//confirm delete
		if (isset($_GET['confirm'])) {

			//dapat pati yung sa class nag delete narin
			foreach ($teacherLoadTable->result() as $row) {
				$where['faculty_id'] = $row->faculty_account_id;
				$where['subject_id'] = $row->subject_id;
				$where['class_sched'] = $row->schedule;
				$where['section_id'] = $row->section_id;
				$where['school_grade_id'] = $row->grade_level;
			}

			$classTable = $this->Main_model->multiple_where('class', $where);

			//delete the classes that has been delete due to the teacher load delition
			foreach ($classTable->result() as $row) {
				$this->Main_model->_delete('class', 'class_id', $row->class_id);
			}

			$this->Main_model->_delete('teacher_load', 'teacher_load_id', $teacher_load_id);

			$this->session->set_userdata('deleteSuccess', 1);
			redirect('classes/viewPersonalTeacherLoad');
		}
	}

	function view_student_grades()
	{
		$permission = $this->Main_model->access_granted();

		if ($permission == 1) {

			$yearLevelId = $this->input->get('yearLevelId');
			$sectionId = $this->input->get('sectionId');

			$this->load->model('Main_model');


			if (isset($_GET['back'])) {

				$array['school_grade_id'] = $yearLevelId;
				$array['section_id'] = $sectionId;

				$data['table'] = $this->Main_model->multiple_where('student_profile', $array);
			} else {
				$array['school_grade_id'] = $yearLevelId;
				$array['section_id'] = $sectionId;
				$data['table'] = $this->Main_model->multiple_where('student_profile', $array);
				if (count($data['table']->result_array()) <= 0) {
					$this->session->set_userdata('SectionNoStudents', 1);
					redirect('classes/selectStudentSection');
				}
				$data['sectionId'] = $sectionId;
			}

			$data['yearLevelId'] = $yearLevelId;
			$data['sectionId'] = $sectionId;
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/view_student_grades', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {
			redirect('main_controller/login');
		}
	}

	function selectYearLevelStudentGrades()
	{
		$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/selectYearLevelStudentGrades', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function selectStudentSection()
	{
		$yearLevelId = $this->input->get('YearLevelId');

		$data['sectionTable'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);

		$data['yearLevelId'] = $yearLevelId;
		$data['yearLevelName'] = $this->Main_model->getYearLevelNameFromId($yearLevelId);
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/sections', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function confirmCallparent()
	{
		$studentId = $this->uri->segment(3);
		$sectionId = $this->uri->segment(4);

		//student table to be used in the navigation
		$studentTable = $this->Main_model->get_where('student_profile', 'account_id', $studentId);
		foreach ($studentTable->result() as $row) {
			$yearLevelId = $row->school_grade_id;
			$sectionId = $row->section_id;
		}

		//send the data
		$data['yearLevelId'] = $yearLevelId;
		$data['sectionId'] = $sectionId;
		$data['studentId'] = $studentId;

		//get the student name
		$data['studentFullName'] = $this->Main_model->getFullNameWithId('student_profile', 'account_id', $studentId);
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/confirmCallparent', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function activate_call_parent()
	{
		$student_id = $this->uri->segment(3);
		$sectionId = $this->uri->segment(4);

		$data['status'] = 1;
		$data['faculty_id'] = $_SESSION['faculty_account_id'];
		$data['student_profile_id'] = $student_id;
		$data['school_year'] = $this->Main_model->getAcademicYear();


		$array['faculty_id'] = $_SESSION['faculty_account_id'];
		$array['student_profile_id'] = $student_id;

		$call_parent_table = $this->Main_model->multiple_where('call_parent', $array);
		$call_parent_count = count($call_parent_table->result_array());
		// echo "call parent count = $call_parent_count";
		if ($call_parent_count > 0) {
			foreach ($call_parent_table->result_array() as $row) {
				$call_parent_id = $row['call_parent_id'];
			}
			$this->Main_model->_update('call_parent', 'call_parent_id', $call_parent_id, $data);
		} else {
			// echo "insert ka";

			$this->Main_model->_insert('call_parent', $data);
		}


		$student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
		foreach ($student_table->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
			$yearLevelId = $row['school_grade_id'];
			$sectionId = $row['section_id'];
			$parentId = $row['parent_id'];
		}
		$student_fullname = "$firstname $middlename $lastname";

		$this->session->set_userdata('call_parent', $student_fullname);

		//text the parent here: 
		//get the number of the parent
		$parentMobileNumber = $this->Main_model->getNumberOfParent($parentId);
		$parentName = $this->Main_model->getFullNameWithId('parent', 'account_id', $parentId);

		//get the name of the teacher
		$teacherId = $_SESSION['faculty_account_id'];
		$teacherName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $teacherId);
		$teacherMobileNumber = $this->Main_model->getTheNumber('faculty', 'account_id', $teacherId);

		//construct the message
		$message = "$parentName you are being called by $teacherName teacher number is $teacherMobileNumber";

		$this->Main_model->itexmo($parentMobileNumber, $message);


		echo strlen($message);

		redirect('classes/view_student_grades/' . $sectionId . "?yearLevelId=$yearLevelId&sectionId=$sectionId");
	}

	function deactivate_call_parent()
	{
		$student_id = $this->uri->segment(3);
		$sectionId = $this->uri->segment(4);


		$data['status'] = 0;

		$array['faculty_id'] = $_SESSION['faculty_account_id'];
		$array['student_profile_id'] = $student_id;

		$this->Main_model->_multi_update('call_parent', $array, $data);

		$student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
		foreach ($student_table->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
			$yearLevelId = $row['school_grade_id'];
			$sectionId = $row['section_id'];
			$parentId = $row['parent_id'];
		}
		$student_fullname = "$firstname $middlename $lastname";

		$this->session->set_userdata('uncall_parent', $student_fullname);

		//text algorithm starts here
		$parentNumber = $this->Main_model->getNumberOfParent($parentId);

		$teacherId = $_SESSION['faculty_account_id'];
		$teacherName = $this->Main_model->getFullNameWithId('faculty', 'account_id', $teacherId);

		//construct message
		$message = "Thank you for your cooperation, At your service $teacherName";

		//send message
		$this->Main_model->itexmo($parentNumber, $message);


		redirect('classes/view_student_grades/' . $sectionId . "?yearLevelId=$yearLevelId&sectionId=$sectionId");
	}

	function filterBySchoolYear()
	{
		if (isset($_POST['schoolYear'])) {
			$schoolYear = $this->input->post('schoolYear');
			$studentId = $this->input->post('studentId');
			
			// get the student's grades based on the given variables. 
			$where['school_year'] = $schoolYear;
			$where['student_name'] = $this->Main_model->getStudentNameForStudentGradesTable($studentId);
			$studentGrades = $this->Main_model->multiple_where('student_grades', $where);
			
			
			foreach ($studentGrades->result() as $row) {
				echo"	<tr>";
				echo"		<td>" . $this->Main_model->getSubjectNameFromId($row->subject_id) . "</td>";
				echo"		<td>" . $this->Main_model->getFullname('faculty', 'account_id', $row->faculty_id) . "</td>";
				echo"		<td>" . $this->Main_model->uploadedUnUploaded($row->quarter1) . "</td>";
				echo"		<td>" . $this->Main_model->uploadedUnUploaded($row->quarter2) . "</td>";
				echo"		<td>" . $this->Main_model->uploadedUnUploaded($row->quarter3) . "</td>";
				echo"		<td>" . $this->Main_model->uploadedUnUploaded($row->quarter4) . "</td>";
				echo"		<td>" . $this->Main_model->uploadedUnUploaded($row->final_grade) . "</td>";
				echo"		<td>" . $this->Main_model->getYearLevelNameFromId($row->school_year_grade) . "</td>";
				echo"		<td>" . $this->Main_model->gradeStatus($row->final_grade) . "</td>";
				echo"	</tr>";
			}
		}
	}

	function student_grades()
	{
		$student_id = $this->uri->segment(3);
		// $student_id = $_SESSION['student_account_id'];
		$student_table = $this->Main_model->get_where('student_profile', 'account_id', $student_id);
		foreach ($student_table->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
			$sectionId = $row['section_id'];
		}
		$student_search = "$lastname,$firstname$middlename";
		// echo $student_search;
		$data['student_grades_table'] = $this->Main_model->get_where('student_grades', 'student_name', $student_search);
		foreach ($data['student_grades_table']->result_array() as $row) {
			$q1 = $row['quarter1'];
			// $q2 = $row['quarter2'];
			// $q3 = $row['quarter3'];
			// $q4 = $row['quarter4'];
			// $final_grade = $row['final_grade'];
		}

		//malaman kung hindi pa nag uupload yung teacher ng grade nila. 
		if (!isset($q1)) {
			$data['yearLevelId'] = $this->input->get('yearLevelId');
			$data['sectionId'] = $this->input->get('sectionId');

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/no_grades_yet', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		} else {

			$data['sectionId'] = $sectionId;
			$data['yearLevelId'] = $this->input->get('yearLevelId');
			$data['studentId'] = $student_id;
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
			$fullName = $this->Main_model->getFullNameSliced('student_profile', 'account_id', $student_id);
			
			//prepare full name use capitalization
			$firstname = ucfirst($fullName['firstname']);
			$middlename = ucfirst($fullName['middlename']);
			$lastname = ucfirst($fullName['lastname']);
			
			$data['studentFullName'] = "$firstname $middlename $lastname";
			// $this->Main_model->array_show($data['student_grades_table']);
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('classes/faculty_view_student_grades', $data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}
	} //object end

	function student_sectioning()
	{
		$yearLevelId = $this->input->get('yearLevelId');
		$section_id = $this->input->get('sectionId');

		$section_table = $this->Main_model->get_where('section', 'section_id', $section_id);
		foreach ($section_table->result_array() as $row) {
			$section_name = $row['section_name'];
		}
		$data['sectionId'] = $section_id;
		$data['yearLevelId'] = $yearLevelId;
		$data['sectionName'] = $section_name;

		$data['class_section_table'] = $this->Main_model->get_where('class_section', 'section_id', $section_id);

		$data['sectionTableDropDown'] = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/student_section_list', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function studentMoveSection()
	{
		if (isset($_POST['submit'])) {
			$yearLevelId = $this->input->post('yearLevelId');
			$sectionId = $this->input->post('getSection');
			$selectedStudents = $this->input->post('students');
			$selectedSection = $this->input->post('moveSection');

			if (empty($selectedStudents)) {
				$this->session->set_userdata('noSelection', 1);
				redirect("classes/s tudent_sectioning?yearLevelId=$yearLevelId&sectionId=$sectionId");
			}

			foreach ($selectedStudents as $row) {
				$studentId = $row;
				$update['section_id'] = $selectedSection;
				//update class section 
				$this->Main_model->_update('class_section', 'student_profile_id', $studentId, $update);

				//update student profile 
				$this->Main_model->_update('student_profile', 'account_id', $studentId, $update);
			}

			redirect("classes/add_section?yearLevelId=$yearLevelId");
		}
	}

	function add_student_section()
	{
		$section_id = $this->uri->segment(3);

		$section_table = $this->Main_model->get_where('section', 'section_id', $section_id);
		foreach ($section_table->result_array() as $row) {
			$section_name = $row['section_name'];
		}

		$data['section_id'] = $section_id;
		$data['section_name'] = $section_name;
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/group_student_section', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	//yung walang kahit anong get values
	function viewPersonalTeacherLoad()
	{
		$teacherId = $_SESSION['faculty_account_id'];

		//get personal teacher load;
		$data['personalTeacherLoadTable'] = $this->Main_model->get_where('teacher_load', 'faculty_account_id', $teacherId);

		//teacher name
		$data['teacherName'] = $this->Main_model->getFullname('faculty', 'account_id', $teacherId);
		$data['yearLevelTable'] = $this->Main_model->get('school_grade', 'school_grade_id');

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/viewPersonalTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function getSectionFromYearLevel()
	{
		if (isset($_POST['yearLevelId'])) {
			$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $_POST['yearLevelId']);
			echo "<option value=''>Select student section </option>";
			foreach ($sectionTable->result() as $row) {
				echo "<option value='". $row->section_id ."'>". $row->section_name ."</option>";
			}
		}
	}

	function appendTableWithYearLevelPersonalLoad()
	{
		if (isset($_POST['yearLevelId'])) {
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'grade_level', $_POST['yearLevelId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "<tr>";
                
                echo "     <td>". $this->Main_model->getSubjectNameFromId($row->subject_id) ."</td>";
            
                echo "    <td>". $row->schedule ."</td>";
                echo "    <td>". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</td>";
                echo "    <td>". $this->Main_model->getSectionNameFromId($row->section_id) ."</td>";
                echo "    <td>";
            
                $edit = base_url() . "classes/edit_teacher_load/" . $row->teacher_load_id;
                $delete = base_url() . "classes/delete_teacher_load/" . $row->teacher_load_id;
               
                echo "        <a href='". $edit ."'><button class='btn btn-primary col-md-5'><i class='fas fa-edit'></i> &nbsp; Edit</button></a>";
                echo "        <a href='". $delete ."'><button class='btn btn-danger col-md-5'><i class='fas fa-trash'></i> &nbsp; Delete</button></a>";
                echo "    </td>";
                echo "</tr>";
			}
		}
	}

	function appendTableWithYearLevel()
	{
		if (isset($_POST['yearLevelId'])) {
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'grade_level', $_POST['yearLevelId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "	<tr>";
                
                echo "        <td> ". $this->Main_model->facultyRepository($row->faculty_account_id) ."</td>";
                
                echo "        <td>" . $this->Main_model->getSubjectNameFromId($row->subject_id) . "</td>";
            
                echo "        <td>". $row->schedule ."</td>";
                echo "        <td>". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</td>";
                echo "        <td>". $this->Main_model->getSectionNameFromId($row->section_id) ."</td>";
                echo "    </tr>";
			}
		}
	}

	function changeTableWithSectionIdPersonalLoad()
	{
		if (isset($_POST['sectionId'])) {
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'section_id', $_POST['sectionId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "<tr>";
                
                echo "     <td>". $this->Main_model->getSubjectNameFromId($row->subject_id) ."</td>";
            
                echo "    <td>". $row->schedule ."</td>";
                echo "    <td>". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</td>";
                echo "    <td>". $this->Main_model->getSectionNameFromId($row->section_id) ."</td>";
                echo "    <td>";
            
                $edit = base_url() . "classes/edit_teacher_load/" . $row->teacher_load_id;
                $delete = base_url() . "classes/delete_teacher_load/" . $row->teacher_load_id;
               
                echo "        <a href='". $edit ."'><button class='btn btn-primary col-md-5'><i class='fas fa-edit'></i> &nbsp; Edit</button></a>";
                echo "        <a href='". $delete ."'><button class='btn btn-danger col-md-5'><i class='fas fa-trash'></i> &nbsp; Delete</button></a>";
                echo "    </td>";
                echo "</tr>";
			}
		}
	}

	function changeTableWithSectionId()
	{
		if (isset($_POST['sectionId'])) {
			$teacherLoadTable = $this->Main_model->get_where('teacher_load', 'section_id', $_POST['sectionId']);
			
			foreach ($teacherLoadTable->result() as $row) {
				echo "	<tr>";
                
                echo "        <td> ". $this->Main_model->facultyRepository($row->faculty_account_id) ."</td>";
                
                echo "        <td>" . $this->Main_model->getSubjectNameFromId($row->subject_id) . "</td>";
            
                echo "        <td>". $row->schedule ."</td>";
                echo "        <td>". $this->Main_model->getYearLevelNameFromId($row->grade_level) ."</td>";
                echo "        <td>". $this->Main_model->getSectionNameFromId($row->section_id) ."</td>";
                echo "    </tr>";
			}
		}
	}

	function viewOtherTeacherLoad()
	{
		$yearLevelTable = $this->Main_model->get('school_grade', 'school_grade_id');
		$data['teacherName'] = $this->Main_model->getFullname('faculty', 'account_id', $_SESSION['faculty_account_id']);
		$data['teacherLoadTable'] = $this->Main_model->get('teacher_load', 'teacher_load_id');
		$data['yearLevelTable'] = $yearLevelTable;

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/viewOtherTeacherLoad', $data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	//for the dynamic dropdown
	function selectSection()
	{
		if (isset($_POST['gradeLevel'])) {
			$yearLevelId = $this->input->post('gradeLevel');
			$sectionTable = $this->Main_model->get_where('section', 'school_grade_id', $yearLevelId);
			echo "<option value=''>Select section</option>";
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
			$subjectTable = $this->Main_model->get_where('subject', 'school_grade_id', $yearLevelId);
			echo "<option value=''>Select subject</option>";
			foreach ($subjectTable->result() as $row) {
				echo "<option value=" . $row->subject_id . ">" . $row->subject_name . " </option>";
			}
		}
	}

	function editJhsSubject()
	{

		//get all of get data
		$subjectId = $this->input->get('subjectId');
		$yearLevelId = $this->input->get('yearLevelId');

		//get the name of the subject
		$subjectName  = $this->Main_model->getSubjectNameFromId($subjectId);
		
		//send the data
		$data['subjectName'] = $subjectName;
		$data['yearLevelId'] = $yearLevelId;

		//process
		if (isset($_POST['submit'])) {
			$subjectName = $this->input->post('subjectName');
			
			//update
			$update['subject_name'] = $subjectName; 
			$this->Main_model->_update('subject', 'subject_id', $subjectId, $update);
			$this->session->set_userdata('subjectUpdated', 1);
			redirect("classes/add_subject/$yearLevelId");
		}
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('classes/editJhsSubject', $data);
		$this->load->view('includes/main_page/admin_cms/footer');

	}
}//end of the class
