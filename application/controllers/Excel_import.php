<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_import_model');
		$this->load->library('excel');
		$this->load->library('Main_model');
		$this->Main_model->accessGranted();


	}

	function index()
	{	
		$faculty_id = $_SESSION['faculty_account_id'];

		$teacher_load_table = $this->Main_model->get_where('teacher_load','faculty_account_id', $faculty_id);
		foreach ($teacher_load_table->result_array() as $row) {
			$teacher_load_id = $row['teacher_load_id'];
			$subject_id = $row['subject_id'];
			$grade_level = $row['grade_level'];
			$section_id = $row['section_id'];
			

		}


		
		$faculty_table = $this->Main_model->get_where('faculty','account_id', $faculty_id);
		foreach ($faculty_table->result_array() as $row) {
			$firstname = $row['firstname'];
			$middlename = $row['middlename'];
			$lastname = $row['lastname'];
		}

		$teacher_load_table = $this->Main_model->get_where('teacher_load','faculty_account_id', $faculty_id);
		
		$data['teacher_load_table'] = $teacher_load_table;
		foreach ($data['teacher_load_table']->result_array() as $row) {
			$teacher_load_id = $row['teacher_load_id'];
			$subject_id = $row['subject_id'];
			$grade_level = $row['grade_level'];
			$section_id = $row['section_id'];
			

		}

		//check if there is a student load
		if (!isset($teacher_load_id)) {
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('upload_grade/teacher_load_empty');
			$this->load->view('includes/main_page/admin_cms/footer');
		}else{

		
		$data['teacher_fullname'] = "$firstname $middlename $lastname";

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_grade/select_subject',$data);
		$this->load->view('includes/main_page/admin_cms/footer');
		}

		
// if you have clicked a button enter here__________>>>>>>>>
		if (isset($_POST['submit'])) {								

			// go back
			$teacher_load_id = $_GET['submit'];
			$subject = $this->input->get('subject');
			$section_id = $this->input->get('section');
			$grade_level = $this->input->get('grade_level');
			$faculty_id = $_SESSION['faculty_account_id'];
			$school_year = $this->input->post('school_year');
			$secondSchoolYear = $school_year + 1;
			$twoSchoolYear = "$school_year-$secondSchoolYear";
			
			
			$session['teacher_load_id_selection'] = $teacher_load_id;
			$session['subject_selection'] = $subject;
			$session['section_selection'] = $section_id;
			$session['school_year_grade_selection'] = $grade_level;
			$session['school_year_selection'] = $twoSchoolYear;
			
			if ($school_year == "") {
				$this->session->set_userdata('noYearGrade',1);
				redirect('excel_import');
			}else{
				$this->session->set_userdata($session);
				redirect('excel_import/upload_view');
			}

			

		}


	} //object end

	


	function upload_view()
	{
		$subject_id = $_SESSION['subject_selection'];
		$section_id = $_SESSION['section_selection'];
		$faculty_id = $_SESSION['faculty_account_id'];
		$grade_level_id = $_SESSION['school_year_grade_selection'];
		// $quarter = $_SESSION['quarter_selection'];
		
		

		$array['subject_id'] = $subject_id;
		$array['section_id'] = $section_id;
		$array['faculty_id'] = $faculty_id;

		$data['student_grades_table'] = $this->Main_model->multiple_where('student_grades', $array);

		

		$section_table = $this->Main_model->get_where('section','section_id', $section_id);
		foreach ($section_table->result_array() as $row) {
			$section_name = $row['section_name'];
		}


		$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
		foreach ($subject_table->result_array() as $row) {
			$subject_name = $row['subject_name'];
		}

		$grade_level_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level_id);
		foreach ($grade_level_table->result_array() as $row) {
			$grade_level_name = $row['name'];
		}
		$data['section_name'] = $section_name;
		$data['subject_name'] = $subject_name;
		$data['grade_level_name'] = $grade_level_name;
	
		$data['subject_id'] = $subject_id;
		$data['section_id'] = $section_id;
		$data['faculty_id'] = $faculty_id;
		$data['grade_level_id'] = $grade_level_id;
		

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_grade/excel_import',$data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}
	
	function fetch()
	{
		$data = $this->excel_import_model->select();
		$output = '
		<h3 align="center">Total Data - '.$data->num_rows().'</h3>
		<table class="table table-striped table-bordered">
			<tr>
				<th>Customer Name</th>
				<th>Address</th>
				<th>City</th>
				<th>Postal Code</th>
				<th>Country</th>
			</tr>
		';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td>'.$row->CustomerName.'</td>
				<td>'.$row->Address.'</td>
				<td>'.$row->City.'</td>
				<td>'.$row->PostalCode.'</td>
				<td>'.$row->Country.'</td>
			</tr>
			';
		}
		$output .= '</table>';
		// echo $output;
	}

	function view_uploaded_grades(){
		if (isset($_GET['quarter'])) {
			$quarter_level = $this->input->get('quarter');

			$subject_id = $this->input->get('subject_id');
			$section_id = $this->input->get('section_id');
			$faculty_id = $this->input->get('faculty_id');
			$grade_level_id = $this->input->get('grade_level');

			$array['subject_id'] = $subject_id;
			$array['section_id'] = $section_id;
			$array['faculty_id'] = $faculty_id;
			$array['school_year_grade'] = $grade_level_id;
			$array['school_year'] = $_SESSION['school_year_selection'];

			$data['grades_table'] = $this->Main_model->multiple_where('student_grades', $array);
			$data['quarter_level'] = $quarter_level;

			$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
			foreach ($subject_table->result_array() as $row) {
				$subject_name = $row['subject_name'];
			}

			$section_table = $this->Main_model->get_where('section','section_id', $section_id);
			foreach ($section_table->result_array() as $row) {
				$section_name = $row['section_name'];
			}

			$school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $grade_level_id);
			foreach ($school_grade_table->result_array() as $row) {
				$grade_level_name = $row['name'];
			}

			if ($quarter_level == 1) {
				$data['quarter_stats'] = 'First Quarter';
			}elseif ($quarter_level == 2) {
				$data['quarter_stats'] = 'Second Quarter';
			}elseif ($quarter_level == 3) {
				$data['quarter_stats'] = 'Third Quarter';
			}elseif ($quarter_level == 4) {
				$data['quarter_stats'] = 'Fourth Quarter';
			}elseif ($quarter_level == 5) {
				$data['quarter_stats'] = 'Final Quarter';
			}

			$data['subject_name'] = $subject_name;
			$data['section_name'] = $section_name;
			$data['grade_level_name'] = $grade_level_name;

			$data['subject_id'] = $this->input->get('subject_id');
			$data['section_id'] = $this->input->get('section_id');
			$data['faculty_id'] = $this->input->get('faculty_id');
			$data['grade_level_id'] = $this->input->get('grade_level');

			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('upload_grade/view_uploaded_grade',$data);
			$this->load->view('includes/main_page/admin_cms/footer');

		}


	}

	function edit_grade()
	{
		if (isset($_POST['submit'])) {
			$new_grade = $this->input->post('new_grade');
			$quarter_level = $this->input->post('quarter_level');
			$student_grades_id = $this->input->post('student_grades_id');

			if ($quarter_level == 1) {
				$data['quarter1'] = $new_grade;
			}elseif($quarter_level == 2) {
				$data['quarter2'] = $new_grade;
			}elseif($quarter_level == 3) {
				$data['quarter3'] = $new_grade;
			}elseif($quarter_level == 4) {
				$data['quarter4'] = $new_grade;
			}elseif($quarter_level == 5) {
				$data['final_grade'] = $new_grade;
			}

			$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			$this->session->set_userdata('update_grade','Update Success!');

			$subject_id = $this->input->get('subject_id');
			$section_id = $this->input->get('section_id');
			$faculty_id = $this->input->get('faculty_id');
			$grade_level_id = $this->input->get('grade_level');

			redirect('excel_import/view_uploaded_grades?subject_id=' . $subject_id . '&section_id=' . $section_id . '&faculty_id=' . $faculty_id . '&grade_level=' . $grade_level_id . '&quarter=' . $quarter_level); 

		}else{

		$data['subject_id'] = $this->input->get('subject_id');
		$data['section_id'] = $this->input->get('section_id');
		$data['faculty_id'] = $this->input->get('faculty_id');
		$data['grade_level_id'] = $this->input->get('grade_level');

		$student_grade_id = $this->uri->segment(3);
		$quarter_level = $this->uri->segment(4);


		$data['student_grade_table'] = $this->Main_model->get_where('student_grades','student_grades_id', $student_grade_id);
		foreach ($data['student_grade_table']->result_array() as $row) {
			$student_grades_id = $row['student_grades_id'];
			$student_name = $row['student_name'];
			$current_quarter1 = $row['quarter1'];
			$current_quarter2 = $row['quarter2'];
			$current_quarter3 = $row['quarter3'];
			$current_quarter4 = $row['quarter4'];
			$current_final_grade = $row['final_grade'];
		}

		if ($quarter_level == 1) {
			$data['current_quarter_grade'] = $current_quarter1;
		}elseif($quarter_level == 2) {
			$data['current_quarter_grade'] = $current_quarter2;
		}elseif($quarter_level == 3) {
			$data['current_quarter_grade'] = $current_quarter3;
		}elseif($quarter_level == 4) {
			$data['current_quarter_grade'] = $current_quarter4;
		}elseif($quarter_level == 5) {
			$data['current_quarter_grade'] = $final_grade;
		}
		$data['student_name'] = $student_name;
		$data['quarter_level'] = $quarter_level;
		$data['student_grades_id'] = $student_grades_id;

		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_grade/student_edit_grade',$data);
		$this->load->view('includes/main_page/admin_cms/footer');
		}
	}

	function import_success()
	{
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_grade/record_success');
		$this->load->view('includes/main_page/admin_cms/footer');
	}

	function import()
	{
		if ($_SESSION['quarter_selection'] == 1) {
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

		}elseif($_SESSION['quarter_selection'] == 2){
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
						

						$data[] = array(
							'student_name'		=>	ltrim($student_name, ' '),
							'quarter_grade'			=>	$quarter_grade
						);
					}
				}

				//remove empty data in the array
				$data = $this->excel_import_model->removeEmptyArrays($data);
				
				//perform student authenticator
				$url = base_url() . "excel_import/upload_view";
				$this->excel_import_model->studentNameAuthenticator($data, $url);
				
				
			
				$array['subject_id'] = $_SESSION['subject_selection'];
				$array['faculty_id'] = $_SESSION['faculty_account_id'];
				$array['section_id'] = $_SESSION['section_selection'];
				$grades_table = $this->Main_model->multiple_where('student_grades', $array);
				
				//just to get the quarter Grade
				foreach ($grades_table->result_array() as $row) {
					$student_grades_id = $row['student_grades_id'];

					foreach ($data as $row) {
						$quarter_grade = $row['quarter_grade'];
						$student_name = $row['student_name'];

						$update_data['quarter2'] = $quarter_grade;
						$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $update_data);
					}

				}
				$teacher_load_id = $_SESSION['teacher_load_id_selection'];
				$teacher_load_table = $this->Main_model->get_where('teacher_load','teacher_load_id', $teacher_load_id);
				foreach ($teacher_load_table->result_array() as $row) {
					$no_upload_grade = $row['no_upload_grade'];
				}
				redirect('excel_import/import_success');
				
				
			}
		}
		elseif ($_SESSION['quarter_selection'] == 3) {
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

						$data[] = array(
							'student_name'		=>	ltrim($student_name, ' '),
							'quarter_grade'			=>	$quarter_grade
						);
					}
				}

				//remove empty data in the array
				$data = $this->excel_import_model->removeEmptyArrays($data);

				//perform student authenticator
				$url = base_url() . "excel_import/upload_view";
				$this->excel_import_model->studentNameAuthenticator($data, $url);
				
				
			
				$array['subject_id'] = $_SESSION['subject_selection'];
				$array['faculty_id'] = $_SESSION['faculty_account_id'];
				$array['section_id'] = $_SESSION['section_selection'];
				$grades_table = $this->Main_model->multiple_where('student_grades', $array);
				

				//just to get the quarter Grade
				
				foreach ($grades_table->result_array() as $row) {
					$student_grades_id = $row['student_grades_id'];
					foreach ($data as $row) {
						$quarter_grade = $row['quarter_grade'];
						$student_name = $row['student_name'];

						$update_data['quarter3'] = $quarter_grade;
						$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $update_data);
					}

				}
				$teacher_load_id = $_SESSION['teacher_load_id_selection'];
				$teacher_load_table = $this->Main_model->get_where('teacher_load','teacher_load_id', $teacher_load_id);
				foreach ($teacher_load_table->result_array() as $row) {
					$no_upload_grade = $row['no_upload_grade'];
				}

				redirect('excel_import/import_success');
				
				
			}
		}elseif ($_SESSION['quarter_selection'] == 4) {
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

						$data[] = array(
							'student_name'		=>	ltrim($student_name, ' '),
							'quarter_grade'			=>	$quarter_grade
						);
					}
				}

				//remove empty data in the array
				$data = $this->excel_import_model->removeEmptyArrays($data);

				//perform student authenticator
				$url = base_url() . "excel_import/upload_view";
				$this->excel_import_model->studentNameAuthenticator($data, $url);
				
				
			
				$array['subject_id'] = $_SESSION['subject_selection'];
				$array['faculty_id'] = $_SESSION['faculty_account_id'];
				$array['section_id'] = $_SESSION['section_selection'];
				$grades_table = $this->Main_model->multiple_where('student_grades', $array);
				

				//just to get the quarter Grade
				
				foreach ($grades_table->result_array() as $row) {
					$student_grades_id = $row['student_grades_id'];
					foreach ($data as $row) {
						$quarter_grade = $row['quarter_grade'];
						$student_name = $row['student_name'];

						$update_data['quarter4'] = $quarter_grade;
						$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $update_data);
					}

				}
				$teacher_load_id = $_SESSION['teacher_load_id_selection'];
				$teacher_load_table = $this->Main_model->get_where('teacher_load','teacher_load_id', $teacher_load_id);
				foreach ($teacher_load_table->result_array() as $row) {
					$no_upload_grade = $row['no_upload_grade'];
				}

				redirect('excel_import/import_success');
				
				
			}
		}elseif ($_SESSION['quarter_selection'] == 5) {
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
						
						
						$data[] = array(
							'student_name'		=>	ltrim($student_name, ' '),
							'quarter_grade'			=>	$quarter_grade
						);
					}
				}

				//remove empty data in the array
				$data = $this->excel_import_model->removeEmptyArrays($data);

				//perform student authenticator
				$url = base_url() . "excel_import/upload_view";
				$this->excel_import_model->studentNameAuthenticator($data, $url);
				
				
			
				$array['subject_id'] = $_SESSION['subject_selection'];
				$array['faculty_id'] = $_SESSION['faculty_account_id'];
				$array['section_id'] = $_SESSION['section_selection'];
				$grades_table = $this->Main_model->multiple_where('student_grades', $array);
				

				// just to get the quarter Grades
				
				foreach ($grades_table->result_array() as $row) {
					$student_grades_id = $row['student_grades_id'];
					foreach ($data as $row) {
						$quarter_grade = $row['quarter_grade'];
						$student_name = $row['student_name'];

						$update_data['final_grade'] = $quarter_grade;
						$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $update_data);
					}

				}
				$teacher_load_id = $_SESSION['teacher_load_id_selection'];
				$teacher_load_table = $this->Main_model->get_where('teacher_load','teacher_load_id', $teacher_load_id);
				foreach ($teacher_load_table->result_array() as $row) {
					$no_upload_grade = $row['no_upload_grade'];
				}
				
				redirect('excel_import/import_success');
				
				
			}
		}

		
	} //end of import

	function pull_out_early()
	{
		if (isset($_GET['confirmPullOut'])) {
			
		$array['subject_id'] = $this->input->get('subject_id');
		$array['section_id'] = $this->input->get('section_id');
		$array['faculty_id'] = $this->input->get('faculty_id');
		$array['school_year_grade'] = $this->input->get('grade_level');



		$student_grades = $this->Main_model->multiple_where('student_grades', $array);


		// $quarter_level = $this->input->get('$quarter');
		$quarter_level = $_GET['quarter'];
		
		//heto na yung i uupdate mo 

		foreach ($student_grades->result_array() as $row) {
			$student_grades_id = $row['student_grades_id'];

			if ($quarter_level == 1) {
				$data['quarter1'] = 0;
				$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			}elseif($quarter_level == 2) {
				$data['quarter2'] = 0;
				$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			}elseif($quarter_level == 3) {
				$data['quarter3'] = 0;
				$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			}elseif($quarter_level == 4) {
				$data['quarter4'] = 0;
				$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			}elseif($quarter_level == 5) {
				$data['final_grade'] = 0;
				$this->Main_model->_update('student_grades', 'student_grades_id', $student_grades_id, $data);
			}

		}

		
		redirect('excel_import/upload_view');
		
		// redirect('excel_import/quarter_manager');



		}else{
			$data['subject_id'] = $this->input->get('subject_id');
			$data['section_id'] = $this->input->get('section_id');
			$data['faculty_id'] = $this->input->get('faculty_id');
			$data['school_year_grade'] = $this->input->get('school_year_grade');
			$data['quarter_level'] = $this->input->get('quarter_level');

			$subject_table = $this->Main_model->get_where('subject','subject_id', $data['subject_id']);
			$section_table = $this->Main_model->get_where('section','section_id', $data['section_id']);
			$faculty_table = $this->Main_model->get_where('faculty','account_id', $data['faculty_id']);
			$school_year_table = $this->Main_model->get_where('school_grade','school_grade_id', $data['school_year_grade']);

			foreach ($subject_table->result_array() as $row) {
				$subject_name = $row['subject_name'];
			}

			foreach ($section_table->result_array() as $row) {
				$section_name = $row['section_name'];
			}

			foreach ($faculty_table->result_array() as $row) {
				$firstname = $row['firstname'];
				$middlename = $row['middlename'];
				$lastname = $row['lastname'];
			}

			foreach ($school_year_table->result_array() as $row) {
				$grade_level_name = $row['name'];
			}

			$data['subject_name'] = $subject_name;
			$data['section_name'] = $section_name;
			$data['teacher_fullname'] = "$firstname $middlename $lastname";
			$data['grade_level'] = $grade_level_name;
			
			$this->load->view('includes/main_page/admin_cms/header');
			$this->load->view('upload_grade/confirm_pull_out',$data);
			$this->load->view('includes/main_page/admin_cms/footer');
		}


	}

	function uploadGrade()
	{
		$quarter_level = $this->uri->segment(3);
		$subject_selection = $_SESSION['subject_selection'];
		$section_selection = $_SESSION['section_selection'];
		$grade_level = $_SESSION['school_year_grade_selection'];

		//dapat meron naring school year na column
		$array['subject_id'] = $subject_selection;
		$array['section_id'] = $section_selection;
		$array['faculty_id'] = $_SESSION['faculty_account_id'];
		$array['school_year_grade'] = $grade_level;
		$array['school_year'] = $_SESSION['school_year_selection'];
		


		//grade exist checker
		$student_grades_table = $this->Main_model->multiple_where('student_grades', $array);

		foreach ($student_grades_table->result_array() as $row) {
			$q1 = $row['quarter1'];
			$q2 = $row['quarter2'];
			$q3 = $row['quarter3'];
			$q4 = $row['quarter4'];
			$final_grade = $row['final_grade'];
		}

		if ($quarter_level == 1) {
			if (isset($q1)) {
				if ($q1 > 0) {
					$this->session->set_userdata('gradeExist',1);	
				}
			}
		}
		elseif ($quarter_level == 2) {
			if (!empty($q2)) {
				if ($q2 > 0) {
					$this->session->set_userdata('gradeExist',1);
				}
			}
		}elseif ($quarter_level == 3) {
			if (!empty($q3)) {
				if ($q3 > 0) {
					$this->session->set_userdata('gradeExist',1);
				}
			}
		}elseif ($quarter_level == 4) {
			if (!empty($q4)) {
				if ($q4 > 0) {
					$this->session->set_userdata('gradeExist',1);
				}
			}
		}elseif ($quarter_level == 5) {
			if (!empty($final_grade)) {
				if ($final_grade > 0) {
					$this->session->set_userdata('gradeExist',1);
				}
			}
		}

		
		$subject_table = $this->Main_model->get_where('subject','subject_id', $subject_selection);
		foreach ($subject_table->result_array() as $row) {
			$subject_name = $row['subject_name'];
		}
		
		$section_table = $this->Main_model->get_where('section','section_id', $section_selection);
		foreach ($section_table->result_array() as $row) {
			$section_name = $row['section_name'];
		}

		$this->session->set_userdata('quarter_selection',$quarter_level);
 		$data['section_name'] = ucfirst($section_name);
		$data['subject_name'] = ucfirst($subject_name);
		$this->load->view('includes/main_page/admin_cms/header');
		$this->load->view('upload_grade/insertFile',$data);
		$this->load->view('includes/main_page/admin_cms/footer');
	}




} //class end

?>
