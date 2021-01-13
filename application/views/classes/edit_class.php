
<div style="margin-bottom: 40px"></div>

<h2 align="center">UPDATE CLASS</h2>

<div style="margin-bottom: 40px"></div>
<div class="container">

  <?php $form = base_url() . 'classes/update_class_proc/' . $class_id ?>
  <form action="<?= $form ?>" method="post">
     <div class="form-group">
       <label>Subject:</label>
        <select class="form-control" name="subject">
          <?php 
            $this->load->model('Main_model');
            $subject_table = $this->Main_model->get_where('subject','subject_id', $subject_id);
            $all_subject_table = $this->Main_model->just_get_everything('subject');
            foreach ($subject_table->result_array() as $row) {
              $current_subject_id = $row['subject_id'];
              $current_subject_name = $row['subject_name'];?>
              <option value="<?= $current_subject_id ?>"><?= $current_subject_name ?></option>
            <?php }?>

            <?php
            foreach ($all_subject_table->result_array() as $row) {
              $subject_id = $row['subject_id'];
              $subject_name = $row['subject_name'];?>
                <option value="<?= $subject_id ?>"><?= $subject_name ?></option>
            <?php } ?>
             
           
        </select>
     </div>

    <div class="form-group">
      <label>Teacher</label>
        <select name="teacher" class="form-control">
          <?php 
          $teacher_table = $this->Main_model->get_where('faculty','account_id', $faculty_id);
          $all_teacher_table = $this->Main_model->just_get_everything('faculty');
          foreach ($teacher_table->result_array() as $row) {
            $current_account_id = $row['account_id'];
            $current_firstname = $row['firstname'];
            $current_middlename = $row['middlename'];
            $current_lastname = $row['lastname'];
            $current_faculty_fullname = "$current_firstname $current_middlename $current_lastname ";?>
            <option value="<?= $current_account_id ?>"><?= $current_faculty_fullname ?></option>
          <?php } ?>

          <?php 
          foreach ($all_teacher_table->result_array() as $row) {
            $account_id = $row['account_id'];
            $firstname = $row['firstname'];
            $middlename = $row['middlename'];
            $lastname = $row['lastname'];
            $faculty_fullname = "$firstname $middlename $lastname ";?>
            <option value="<?= $account_id ?>"><?= $faculty_fullname ?></option>
          <?php } ?>

        </select>
    </div>

    <div class="form-group">
      <label>Class Schedule</label>
      <input type="text" name="class_schedule" class="form-control" value="<?= $class_schedule ?>">
    </div>

    <div class="form-group">
      <label>Student Name</label>
      <select name="student" class="form-control">
        <?php 
        $student_table = $this->Main_model->get_where('student_profile','account_id', $student_profile_id);
        $all_student_table = $this->Main_model->just_get_everything('student_profile');

        foreach ($student_table->result_array() as $row) {
          $current_student_account_id = $row['account_id'];
          $current_student_firstname =$row['firstname'];
          $current_student_middlename = $row['middlename'];
          $current_student_lastname = $row['lastname'];
          $current_student_status =$row['student_status'];
          $current_student_fullname = "$current_student_firstname $current_student_middlename $current_student_lastname";?>
          <option value="<?= $current_account_id ?>"><?= $current_student_fullname ?></option>
        <?php } ?>

        <?php 
        foreach ($all_student_table->result_array() as $row) {
          $student_account_id = $row['account_id'];
          $student_firstname =$row['firstname'];
          $student_middlename = $row['middlename'];
          $student_lastname = $row['lastname'];
          $student_status =$row['student_status'];
          $student_fullname = "$student_firstname $student_middlename $student_lastname";?>
          <option value="<?= $student_account_id?>" ><?= $student_fullname ?></option>
        <?php } ?>
         
         
      </select>
    </div>

    <div class="form-group">
      <label>Section</label>
        <select name="section" class="form-control">
          <?php 
          $section_table = $this->Main_model->get_where('section','section_id', $section_id);
          $all_section_table = $this->Main_model->just_get_everything('section');

          foreach ($section_table->result_array() as $row) {
            $current_section_id = $row['section_id'];
            $current_section_name = $row['section_name'];?>
            <option value="<?= $current_section_id?>"><?= $current_section_name ?></option>
          <?php } ?>

          <?php 
          foreach ($all_section_table->result_array() as $row) {
            $section_id = $row['section_id'];
            $section_name = $row['section_name'];?>
            <option value="<?= $section_id?>"><?= $section_name ?></option>
          <?php } ?>

           
        </select>
    </div>
    <div class="form-group">
      <label>Year Grade</label>
        <select name="school_grade" class="form-control">
          <?php 
          $current_school_grade_table = $this->Main_model->get_where('school_grade','school_grade_id', $school_grade_id);
          $school_grade_table = $this->Main_model->just_get_everything('school_grade');

          foreach ($current_school_grade_table->result_array() as $row) {
            $current_school_grade_id = $row['school_grade_id'];
            $current_name = $row['name'];?>
            <option value="<?= $current_school_grade_id?>"><?= $current_name ?></option>
          <?php } ?>

          <?php 
          foreach ($school_grade_table->result_array() as $row) {
            $school_grade_id = $row['school_grade_id'];
            $name = $row['name'];?>
            <option value="<?= $school_grade_id?>"><?= $name ?></option>
          <?php } ?>

           
        </select>
    </div><br>
    <button type="submit" class="btn btn-primary col-md-12" name="submit">Submit</button>
  </form>
  <?php $back = base_url() . 'classes/manage_classes' ?>
  <a href="<?= $back ?>">
    <button class="btn btn-info col-md-12">Back</button>
  </a>
</div>