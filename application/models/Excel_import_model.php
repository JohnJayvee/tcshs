<?php
class Excel_import_model extends CI_Model
{
	function select()
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('tbl_customer');
		return $query;
	}

	function insert($data)
	{

		foreach ($data as $key => $value) {
			$data[$key]['student_name'] = str_replace(' ', '', $data[$key]['student_name']);
		}


		$this->db->insert_batch('student_grades', $data);
	}

	function insertParentBatch($data)
	{

		foreach ($data as $key => $value) {
			$data[$key]['firstname'] = str_replace(' ', '', $data[$key]['firstname']);
			$data[$key]['middlename'] = str_replace(' ', '', $data[$key]['middlename']);
			$data[$key]['lastname'] = str_replace(' ', '', $data[$key]['lastname']);
			$data[$key]['status'] = str_replace(' ', '', $data[$key]['status']);
			$data[$key]['mobile_number'] = str_replace(' ', '', $data[$key]['mobile_number']);
		}


		$this->db->insert_batch('parent', $data);
	}

	function insertFacultyBatch($data)
	{

		foreach ($data as $key => $value) {
			$data[$key]['firstname'] = str_replace(' ', '', $data[$key]['firstname']);
			$data[$key]['middlename'] = str_replace(' ', '', $data[$key]['middlename']);
			$data[$key]['lastname'] = str_replace(' ', '', $data[$key]['lastname']);
			$data[$key]['status'] = str_replace(' ', '', $data[$key]['status']);
			$data[$key]['mobile_number'] = str_replace(' ', '', $data[$key]['mobile_number']);
		}


		$this->db->insert_batch('faculty', $data);
	}

	function studentFilterWhiteSpace($data)
	{

		foreach ($data as $key => $value) {
			$data[$key]['firstname'] = str_replace(' ', '', $data[$key]['firstname']);
			$data[$key]['middlename'] = str_replace(' ', '', $data[$key]['middlename']);
			$data[$key]['lastname'] = str_replace(' ', '', $data[$key]['lastname']);
			$data[$key]['parent_id'] = str_replace(' ', '', $data[$key]['parent_id']);
			$data[$key]['school_grade_id'] = str_replace(' ', '', $data[$key]['school_grade_id']);
			$data[$key]['section_id'] = str_replace(' ', '', $data[$key]['section_id']);
			$data[$key]['mobile_number'] = str_replace(' ', '', $data[$key]['mobile_number']);
		}
		return $data;
	}

	function studentFilterWhiteSpaceShs($data) //for shs
	{

		foreach ($data as $key => $value) {
			$data[$key]['firstname'] = str_replace(' ', '', $data[$key]['firstname']);
			$data[$key]['middlename'] = str_replace(' ', '', $data[$key]['middlename']);
			$data[$key]['lastname'] = str_replace(' ', '', $data[$key]['lastname']);
			$data[$key]['parent_id'] = str_replace(' ', '', $data[$key]['parent_id']);
			$data[$key]['year_level_id'] = str_replace(' ', '', $data[$key]['year_level_id']);
			$data[$key]['section_id'] = str_replace(' ', '', $data[$key]['section_id']);
			$data[$key]['mobile_number'] = str_replace(' ', '', $data[$key]['mobile_number']);
		}
		return $data;
	}

	function studentGradeFilterWhiteSpaceNames($data)
	{

		foreach ($data as $key => $value) {
			$data[$key]['student_name'] = str_replace(' ', '', $data[$key]['student_name']);
		}
		return $data;
	}

	function findSectionId($sectionName)
	{
		$sectionTable = $this->Main_model->get('section', 'section_id');
		foreach ($sectionTable->result_array() as $row) {
			$section_id = $row['section_id'];
			$section_name = $row['section_name'];
			$section_name = str_replace(' ', '', $section_name);
			if (strtolower($section_name) == strtolower($sectionName)) {
				return $section_id;
			}
		}
	}

	function findSchoolGradeId($schoolGradeName)
	{
		$schoolGradeTable = $this->Main_model->get('school_grade', 'name');
		foreach ($schoolGradeTable->result_array() as $row) {
			$school_grade_id = $row['school_grade_id'];
			$name = $row['name'];
			$name = str_replace(' ', '', $name);
			if (strtolower($name) == strtolower($schoolGradeName)) {
				return $school_grade_id;
			}
		}
	}

	function removeEmptyArrays($array)
	{
		$i = 0;
		foreach ($array as $key => $value) {
			if ($value['student_name'] == null) {
				unset($array[$i]);
			}
			$i++;
		}

		return $array;
	}

	function studentNameAuthenticator($array, $url)
	{
		//remove empty arrays
		$emptiedOutArray = $this->removeEmptyArrays($array);

		//filter the data
		$filteredArray = $this->studentGradeFilterWhiteSpaceNames($emptiedOutArray);

		//loop manager
		$firstLoop = 0;
		$secondLoop = 0;

		//firstloop
		foreach ($filteredArray as $row) {
			$studentName = $row['student_name'];
			$studentName = strtolower($studentName);
			//get the students in the database
			$studentProfileTable = $this->Main_model->get('student_profile', 'account_id');

			//manage triggers
			$trig1 = 0; //checker kung merong kapareho
			$trig2 = 0; // ito yung counter
			$studentTableCount = count($studentProfileTable->result_array());

			//second loop
			foreach ($studentProfileTable->result() as $row) {
				$firstname = $row->firstname;
				$middlename = $row->middlename;
				$lastname = $row->lastname;
				$dbFullName = "$lastname,$firstname$middlename";
				$trig2++;

				//kapag may nakita siyang kapareho sa db
				if (strtolower($studentName) == strtolower($dbFullName)) {
					$trig1 = $trig1 + 1;
				}

				//checker if completed all of the rows in the db.
				if ($trig2 == $studentTableCount) {
					$trig2 = 0;

					if ($trig1 == 0) {
						echo "trig1 <b>LABAS</b> is: $trig1 <br>";
						$this->session->set_userdata('studentNotExist', $studentName);
						redirect($url);
					} else {
						$trig1 = 0; //refreshed
					}
				}
			} // end of second loop
		} // end of first loop
	} //end of function

}
